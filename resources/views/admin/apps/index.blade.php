@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                应用列表
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
                            <h3 class="box-title">应用列表</h3>
                            <div style="float:right;margin-right:30px">
                                <a href="/admin/apps/create" class="btn btn-block btn-success" role="button">添加应用</a>
                            </div>
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
                                        <th>应用名</th>
                                        <th>APP_KEY</th>
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>  
                                </thead>  
                                <tbody>
                                @foreach($apps as $val)
                                    <tr>
                                        <td>{{ $val->id }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->app_key }}</td>
                                        <td>{{ date('Y-m-d H:i:s',$val->create_time) }}</td>
                                        <td>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="/admin/version?app_id={{ $val->id }}" class="btn btn-block btn-primary" role="button">查看版本列表</a>
                                            </div>
                                        </div>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="/admin/apps/{{ $val->id }}/edit" class="btn btn-block btn-primary" role="button">{{ __('bookStore.edit') }}</a>
                                            </div>
                                        </div>
                                        <div style="float:left;margin-right:15px">
                                            <form action="/admin/apps/{{ $val->id }}" method="post">
                                                {{ method_field('DELETE') }}
                                                <input type="submit" name="del" class="btn btn-block btn-danger" value="{{ __('articles.delete') }}" onclick="return confirm('确定?');" />
                                            </form>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                                </tbody>  
                            </table>
                            {{ $apps->links() }}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 

@stop