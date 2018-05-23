@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">
        <?php
            function getAppName($appId)
            {
                $row = DB::table('apps')->where('id',$appId)->pluck('name');
                if(isset($row[0]))
                {
                    return $row[0];
                }else{
                    return '';
                }
            }
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                应用：{{ getAppName($appId) }} 的版本列表
                <small>version list</small>
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
                            <h3 class="box-title">应用：{{ getAppName($appId) }} 的版本列表</h3>
                            <div style="float:right;margin-right:30px">
                                <a href="/admin/versions/versionEdit?app_id={{$appId}}" class="btn btn-block btn-info" role="button">版本信息设置</a>
                            </div>
                            <div style="float:right;margin-right:30px">
                                <a href="/admin/version/create?app_id={{$appId}}" class="btn btn-block btn-success" role="button">添加版本</a>
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
                                        <th>目标版本号</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>  
                                </thead>  
                                <tbody>
                                @foreach($row as $val)
                                    <tr>
                                        <td>{{ $val->id }}</td>
                                        <td>{{ $val->version_id }}</td>
                                        <td>
                                            @if($val->status == 2)
                                                强制更新
                                            @endif
                                            @if($val->status == 1)
                                                选择更新
                                            @endif
                                            @if($val->status == 0)
                                                不更新
                                            @endif
                                        </td>
                                        <td>
                                        <div style="float:left">
                                            <div style="float:left;margin-right:15px">
                                                <a href="/admin/version/{{ $val->id }}/edit?app_id={{$appId}}" class="btn btn-block btn-primary" role="button">{{ __('bookStore.edit') }}</a>
                                            </div>
                                        </div>
                                        <div style="float:left;margin-right:15px">
                                            <form action="/admin/version/{{ $val->id }}?app_id={{$appId}}" method="post">
                                                {{ method_field('DELETE') }}
                                                <input type="submit" name="del" class="btn btn-block btn-danger" value="{{ __('articles.delete') }}" onclick="return confirm('确定?');" />
                                            </form>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                                </tbody>  
                            </table>
                            {{ $row->appends(['app_id' => $appId])->links() }}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 

@stop