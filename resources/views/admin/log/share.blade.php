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
                            <h3 class="box-title">{{ __('operationLog.UsershareLog') }}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                  
                            <table class="table table-hover">
                                <tr>
                                    <th>{{ __('operationLog.userId') }}</th>
                                    <th>{{ __('operationLog.bookId') }}</th>
<!--                                     <th>书籍名字</th>
                                    <th>书籍封面</th>
                                    <th>书籍描述</th> 
                                    <th>分享链接</th> -->
                                    <th>{{ __('operationLog.shareTerrace') }}</th>
                                    <th>{{ __('operationLog.shareDatetime') }}</th>
                                </tr>
                                @foreach ($logshare as $share)
                                <tr id="Userinfo_">
                                    <td>
                                    	{{ $share->user_passport_id }}
                                    </td>
                                    <td>
                                    	{{ $share->book_id }}
                                    </td>
<!--                                     <td>
                                        {{ substr($share->book_name,0,100) }}
                                    </td>
                                    
                                    <td>
                                       <img src="{{ $share->book_image }}" style="width:30px;height:30px;border:1px solid #ccc;">
                                    </td> 
                                    <td>
                                        {{ $share->book_description }}
                                    </td> 
                                    <td>
                                        {{ $share->share_local }}
                                    </td> -->
                                    <td>
                                        @if ($share->share_type == 1)
                                            facebook
                                        @elseif ($share->share_type == 2)
                                            google
                                        @else
                                            twitter
                                        @endif
                                    </td>
                                    <td>
                                        {{ $share->created_at }}
                                    </td>
                                    
                                </tr>
                    	        @endforeach
                            </table>
                        </div><!-- /.box-body -->

                        <div class="box-footer clearfix">
                            {{ $logshare->render() }}
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 
@stop

