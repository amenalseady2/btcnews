@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('operationLog.UseroperateLog') }}
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
                            <h3 class="box-title">{{ __('operationLog.UsercollectLog') }}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                  
                            <table class="table table-hover">
                                <tr>
                                    <th>{{ __('operationLog.userId') }}</th>
                                    <th>{{ __('operationLog.bookId') }}</th>
                                    <th>{{ __('operationLog.collectDatetime') }}</th>
                                    <th>{{ __('operationLog.UsercollectLog') }}</th>
                                    <th>{{ __('operationLog.UsercollectLog') }}</th>

                                </tr>
                    
                                <tr id="Userinfo_">
                                    <td>
                                    	
                                    </td>
                                    <td>
                                    	
                                    </td>
                                    <td>
                                 
                                    </td>
                                    <td>
                                  
                                    </td>
                                    <td>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="" class="btn btn-block btn-primary" role="button">修改</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                    	
                            </table>
                        </div><!-- /.box-body -->

                        <div class="box-footer clearfix">
                    
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 
@stop

