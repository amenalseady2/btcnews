@extends('admin/layout')

    @section('content')
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                用户列表
                <small>User List</small>
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
                            <h3 class="box-title">用户列表</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>id</th>
                                    <th>昵称</th>
                                    <th>头像</th>
                                    <th>手机号</th>
                                    <th>金额</th>
                                    <th>绑定交易所</th>
                                    <th>创建时间</th>
                                </tr>
                                @foreach($row as $userInfo)
                                <tr>
                                    <td>
                                    	{{ $userInfo->id }}
                                    </td>
                                    <td>
                                        {{ $userInfo->nickname }}
                                    </td>
                                    <td>
                                       <img src="{{ $userInfo->pic }}" width="40px;">
                                    </td>
                                    <td>
                                        {{ $userInfo->area }} / {{ $userInfo->phone }}
                                    </td>
                                    <td>
                                        {{ $userInfo->money }}
                                    </td>
                                    <td>
                                        @if($userInfo->is_band_exchange == 1)
                                            已绑定
                                        @else
                                            未绑定
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('Y-m-d H:i:s',$userInfo->create_time) }}
                                    </td>
                                </tr>
                    			@endforeach
                            </table>
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                        {{ $row->links() }}
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 
@stop

