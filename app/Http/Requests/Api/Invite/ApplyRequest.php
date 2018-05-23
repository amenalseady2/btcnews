<?php

namespace App\Http\Requests\Api\Invite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Invite;
use Passport;

class ApplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function getValidatorInstance()
    {
        $validatorInstance = parent::getValidatorInstance();
        $validatorInstance->addExtension('verifyInvitationCode', function($attribute, $value, $parameters, $validator) {
       
            $inviter = Invite::getUserPassportIdByInvitationCode($value);
            $userPassport = Passport::getPassportById($inviter);
            if($userPassport){
                return true;
            }else{
                return false;
            }

        });

        $validatorInstance->addExtension('verifyInviterCreatedAt', function($attribute, $value, $parameters, $validator) {
       
            $inviter = Invite::getUserPassportIdByInvitationCode($value);
            $inviterPassport = Passport::getPassportById($inviter);
            $userPassport = Passport::user();

            if($userPassport && $inviterPassport){

                $inviterCreatedAt = strtotime($inviterPassport->created_at->toDateTimeString());
                $userCreatedAt = strtotime($userPassport->created_at->toDateTimeString());
                if( $userCreatedAt > $inviterCreatedAt){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        });

        $validatorInstance->addExtension('verifyInvitee', function($attribute, $value, $parameters, $validator) {
            $passport = Passport::user();
            $invitee = $passport->id;
            return Invite::verifyUniqueInvitee($invitee);
        });

        $validatorInstance->addExtension('verifyExcludeOneself', function($attribute, $value, $parameters, $validator) {
            $invitee = Invite::getUserPassportIdByInvitationCode($value);
            $passport = Passport::user();
            $inviter = $passport->id;
            return Invite::verifyExcludeOneself($inviter,$invitee);
        });


        return $validatorInstance;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'code' => 'required|string|verifyInvitationCode|verifyExcludeOneself|verifyInvitee|verifyInviterCreatedAt',
            'code' => 'required|string',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }

}