<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Admin\AdminUser\StoreRequest;
use App\Http\Requests\Admin\AdminUser\UpdateRequest;
use Admin;


class AdminUserController extends BaseController
{
	public function index()
	{
		$adminUserPaginate = Admin::getAdminUserPaginate();
		$data = [];
		$data['adminUserPaginate'] = $adminUserPaginate;
		
		
		return view('admin/adminUser/index',$data);
	}

	public function create()
	{
		$data = array();
		$data['type'] = 'create';
		return view('admin/adminUser/revise',$data);
	}

	public function store(StoreRequest $storeRequest)
	{
		$email    = $storeRequest->input('email');
		$password = $storeRequest->input('password');
		$adminUser = Admin::storeAdminUser($email,$password);
		return redirect('admin/administrators/user')->withInput()->with('reviseStatus',true);
	}

	public function edit($id)
	{
		$adminUser = Admin::getAdminUserById($id);
		if(Admin::getSessionUserEmail() != 'admin@admin.com' && Admin::getSessionUserEmail() != $adminUser->email)
        {
            exit('Permission denied');
        }
		$data = array();
		$data['type'] = 'update';
		$data['adminUser'] = $adminUser;
		return view('admin/adminUser/revise',$data);
	}

	public function update(UpdateRequest $updateRequest,$id)
	{
		$updateData = [];
		$email    	= $updateRequest->input('email');
		$password 	= $updateRequest->input('password');
		$adminUser = Admin::updateAdminUser($id,$email,$password);
		return redirect('admin/administrators/user/'.$adminUser->id.'/edit')->withInput()->with('reviseStatus',true);
	}

}
