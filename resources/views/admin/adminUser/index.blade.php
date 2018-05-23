@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('adminUser.admin') }}
                <small>Admin List</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Simple</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ __('adminUser.adminList') }}</h3>
                            <div style="float:right;margin-right:30px">
                                <a href="/admin/administrators/user/create" class="btn btn-block btn-success" role="button">{{ __('adminUser.create') }}</a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                  
                            <table class="table table-hover">
                                <tr>
                                    <th>{{ __('adminUser.adminID') }}</th>
                                    <th>{{ __('adminUser.email') }}</th>
                                    <th>{{ __('adminUser.pass') }}</th>
                                    <th>{{ __('adminUser.createDate') }}</th>
                                    <th>{{ __('adminUser.operation') }}</th>
                                </tr>
                                @foreach ($adminUserPaginate as $adminUser)
                                <tr id="Userinfo_">
                                    <td>
                                        {{ $adminUser->id }}
                                    </td>
                                    <td>
                                        {{ $adminUser->email }}
                                    </td>
                                    <td>
                                        ******
                                    </td>
                                    <td>
                                        {{ $adminUser->created_at }}
                                    </td>
                                    <td>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="/admin/administrators/user/{{ $adminUser->id }}/edit" class="btn btn-block btn-primary" role="button">{{ __('adminUser.update') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                           {{ $adminUserPaginate->render() }}
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 

@stop

