@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                新闻列表
                <small>comics list</small>
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
                            <h3 class="box-title">新闻列表</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            @if (session('error'))
                                <div class="alert alert-error">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('status-success'))
                                <div class="alert alert-success">
                                    {{ session('status-success') }}
                                </div>
                            @endif
                            <table class="table table-striped">  
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>标题</th>
                                        <th>特色图片</th>
                                        <th>分享赠币</th>
                                        <th>创建时间(GMT)</th>
                                        <th>操作</th>
                                    </tr>  
                                </thead>  
                                <tbody>
                                @foreach($articles as $val)
                                    <tr>
                                        <td>{{ $val->id }}</td>
                                        <td>{{ $val->title }}</td>
                                        <td><img src="{{ $val->pic_listpage }}" width="50px;"></td>
                                        <td>
                                            @if($val->is_open_mine == 1)
                                                <font style="color:red;">已开启</font>
                                            @else
                                                <font>未开启</font>
                                            @endif
                                        </td>
                                        <td>{{ $val->post_date_gmt }}</td>
                                        <td>
                                            <div style="float:left">
                                                <div style="float:left;margin-right:15px">
                                                    <a href="/admin/news/{{ $val->id }}/edit" class="btn btn-block btn-primary" role="button">赠币设置</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>  
                            </table>
                            {{ $articles->links() }}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 

@stop