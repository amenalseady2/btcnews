@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    赠币设置
                    <small>mine config</small>
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
                                <h3 class="box-title">赠币设置</h3>
                            </div><!-- /.box-header -->
                            @if (session('status-error'))
                                <div class="alert alert-error">
                                    {{ session('status-error') }}
                                </div>
                            @endif
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            <form class="form-horizontal" action="/admin/news/{{ $row->id}}" method="post" id="bookForm" >
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>是否赠币</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <select name="is_open_mine" id="is_open_mine" class="form-control">
                                            <option value="0" @if($row->is_open_mine == 0) SELECTED @endif>未开启</option>
                                            <option value="1" @if($row->is_open_mine == 1) SELECTED @endif>开启赠币</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>赠币总额</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="mine_price" class="form-control" id="mine_price" placeholder="" value="{{ $row->mine_price}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>可得币次数</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="mine_num" class="form-control" id="mine_num" placeholder="" value="{{ $row->mine_num}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
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