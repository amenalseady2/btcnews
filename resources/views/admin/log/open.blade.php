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
                            <h3 class="box-title">{{ __('operationLog.UseropenLog') }}</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                  
                            <table class="table table-hover">
                                <tr>
                                    <th>{{ __('operationLog.userId') }}</th>
                                    <th>{{ __('operationLog.bookId') }}</th>
<!--                                     <th>书籍名字</th>
                                    <th>书籍封面</th>
                                    <th>书籍描述</th> -->
                                    <th>{{ __('operationLog.openDatetime') }}</th>
                                </tr>
                                @foreach ($logopen as $open)
                                <tr id="Userinfo_">
                                    <td>
                                    	{{ $open->user_passport_id }}
                                    </td>
                                    <td>
                                    	{{ $open->book_id }}
                                    </td>
     <!--                                <td>
                                        {{ substr($open->book_name,0,100) }}
                                    </td>
                                    
                                    <td>
                                        <img src="{{ $open->book_image }}" style="width:30px;height:30px;border:1px solid #ccc;">
                                    </td>
                                    <td>
                                        {{ substr($open->book_description,0,100) }}
                                    </td> -->
                                    <td>
                                        {{ $open->created_at }}
                                    </td>
                                  
                                </tr>
                    	        @endforeach
                            </table>
                        </div><!-- /.box-body -->

                        <div class="box-footer clearfix">
                            {{ $logopen->render() }}
                        </div>
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper --> 
@stop

