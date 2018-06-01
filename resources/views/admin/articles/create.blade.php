@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    添加应用
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
                                <h3 class="box-title">添加应用</h3>
                            </div><!-- /.box-header -->
                            @if (session('status-success'))
                                <div class="alert alert-success">
                                    {{ session('status-success') }}
                                </div>
                            @endif
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            <form class="form-horizontal" action="/admin/apps" method="post" id="bookForm" >
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>应用名</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="应用名" value="">
                                    </div>
                                </div>
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