@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('userList.userManage') }}
                <small>User Manage</small>
            </h1>
            <!-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Simple</li>
            </ol> -->
        </section>
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ __('userList.userList') }}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                  
                            <table class="table table-hover">
                                <tr>
                                    <th>{{ __('userList.userId') }}</th>
                                    <th>{{ __('userList.deviceId') }}</th>
                                    <th>{{ __('userList.createdtime') }}</th>
                                    <th>{{ __('userList.updatedtime') }}</th>
                                    <th>{{ __('userList.more') }}</th>
                                </tr>
                                @foreach($list as $row)
                                <tr id="Userinfo_{{ $row->id }}">
                                    <td>
                                    	{{ $row->id }}
                                    </td>
                                    <td>
                                    	{{ $row->device_id }}
                                    </td>
                                    <td>
                                        {{ $row->created_at }}
                                    </td>
                                    <td>
                                        {{ $row->updated_at }}
                                    </td>
                                    <td>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="/admin/user/list/{{ $row->id }}/edit" class="btn btn-block btn-primary" role="button">{{ __('userList.edit') }}</a>
                                            </div>
                                            @if($row->status == 0)
                                            <div style="float:left;margin-right:15px">
                                                <a href="javascript:destroyUser({{ $row->id }})" class="btn btn-block btn-danger UserinfoBTN_{{ $row->id }}" role="button">{{ __('userList.forbidden') }}</a>
                                            </div>
                                            @else
                                            <div style="float:left;margin-right:15px">
                                                <a href="javascript:destroyUser({{ $row->id }})" class="btn btn-block btn-info UserinfoBTN_{{ $row->id }}" role="button">{{ __('userList.abled') }}</a>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                    			@endforeach
                            </table>
                        </div><!-- /.box-body -->

                        <div class="box-footer clearfix">
                        {{ $list->render() }}
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 
@stop

