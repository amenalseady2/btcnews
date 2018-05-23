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
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('userList.edit') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="/admin/user/list/{{ $info->user_id }}">
            {{ method_field('PUT') }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail1" class="col-sm-2 control-label">{{ __('userList.nickName') }}</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nickname" id="inputEmail1" placeholder="{{ __('userList.nickName') }}" value="{{ $info->nickname }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail2" class="col-sm-2 control-label">{{ __('userList.coin') }}</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="coin" id="inputEmail2" placeholder="{{ __('userList.coin') }}" value="{{ $info->coin }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">{{ __('userList.experience') }}</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="experience" id="inputPassword3" placeholder="{{ __('userList.experience') }}" value="{{ $info->experience }}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button onclick="javascript:history.go(-1);" class="btn btn-default">{{ __('userList.return') }}</button>
                <button type="submit" class="btn btn-info pull-right">{{ __('userList.submit') }}</button>
              </div>
              <!-- /.box-footer -->
            </form>

                        <div class="box-footer clearfix">
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 
@stop

