@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                   Version Config
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
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Version Config</h3>
                            </div><!-- /.box-header -->
                            @if (session('status-success'))
                                <div class="alert alert-success">
                                    {{ session('status-success') }}
                                </div>
                            @endif
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            <form class="form-horizontal" action="/admin/version" method="post" id="bookForm" >
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>目标版本号</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="version_id" class="form-control" id="version_id" placeholder="版本号" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">更新控制</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <select name="status" id="status" class="form-control">
                                            <option value="0">不更新</option>
                                            <option value="1">选择更新</option>
                                            <option value="2">强制更新</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="app_id" value="{{$appId}}">
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                        <div class="box-footer">
                                            <button type="button" onclick="buttionSubmit('bookForm',this)" class="btn btn-primary">{{ __('bookIndex.submit') }}</button>
                                        </div>
                                    </div>
                                </div> 
                            </form>

                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div>   <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

    @stop