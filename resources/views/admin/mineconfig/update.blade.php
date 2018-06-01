@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    挖矿设置
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
                                <h3 class="box-title">挖矿设置</h3>
                            </div><!-- /.box-header -->
                            @if (session('status-error'))
                                <div class="alert alert-error">
                                    {{ session('status-error') }}
                                </div>
                            @endif
                            @if (session('status-success'))
                                <div class="alert alert-success">
                                    {{ session('status-success') }}
                                </div>
                            @endif
                            @inject('parameterPersenter','App\Presenters\Contracts\ConsoleParameterPersenterInterface')
                            <form class="form-horizontal" action="/admin/mineConfig/update" method="post" id="bookForm" >
                                
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>邀请人赠币</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="give_coin_p" class="form-control" id="give_coin_p" placeholder="" value="{{ $config->give_coin_p}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>被邀请人赠币</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="give_coin_s" class="form-control" id="give_coin_s" placeholder="" value="{{ $config->give_coin_s}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>最多赠币次数</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="max_give_coin" class="form-control" id="max_give_coin" placeholder="" value="{{ $config->max_give_coin}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>最大挖矿时间(秒)</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="max_mine_time" class="form-control" id="max_mine_time" placeholder="" value="{{ $config->max_mine_time}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>最小挖矿时间(秒)</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="min_mine_time" class="form-control" id="min_mine_time" placeholder="" value="{{ $config->min_mine_time}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>最大挖矿金额</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="max_mine_coin" class="form-control" id="max_mine_coin" placeholder="" value="{{ $config->max_mine_coin}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
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