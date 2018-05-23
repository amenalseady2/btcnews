@extends('admin/layout')

    @section('content')

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                   Version Info Edit
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
                            <form class="form-horizontal" action="/admin/versions/versionUpdate" method="post" id="bookForm" >
                                <input type="hidden" name="app_id" value="{{$appId}}">
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>版本号</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="version_id" class="form-control" id="version_id" placeholder="版本号" value="{{ $row->version_id}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>包名</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="包名" value="{{ $row->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">下载链接</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="url" class="form-control" id="url" placeholder="下载链接" value="{{ $row->url}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>版本描述</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <link rel="stylesheet" type="text/css" href="/simditor/styles/simditor.css" />
                                        <script type="text/javascript" src="/simditor/scripts/jquery.min.js"></script>
                                        <script type="text/javascript" src="/simditor/scripts/module.js"></script>
                                        <script type="text/javascript" src="/simditor/scripts/hotkeys.js"></script>
                                        <script type="text/javascript" src="/simditor/scripts/uploader.js"></script>
                                        <script type="text/javascript" src="/simditor/scripts/simditor.js"></script>
                                        <textarea id="editor" name="info" placeholder="" autofocus>{{ $row->info}}</textarea>   
                                    </div>
                                </div>
                                    <script type="text/javascript">  
                                       $(function(){  
                                        toolbar = [ 'title', 'bold','color', 'ol', 'ul', 'link', ];  
                                        var editor = new Simditor( {  
                                            textarea : $('#editor'),  
                                            placeholder : '',  
                                            toolbar : toolbar,  //工具栏  
                                            defaultImage : 'simditor-2.0.1/images/image.png', //编辑器插入图片时使用的默认图片  
                                            upload : {  
                                                url : '/admin/iamgeUpload', //文件上传的接口地址  
                                                params: {'is_Article':'1'}, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交  
                                                fileKey: 'uploadFile', //服务器端获取文件数据的参数名  
                                                connectionCount: 3,  
                                                leaveConfirm: 'uploading..'
                                            }   
                                        });  
                                       })  
                                    </script>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>MD5校验值</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="check_md5" class="form-control" id="check_md5" placeholder="包名" value="{{ $row->check_md5}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label"><span style="color: red;">*</span>文件大小(byte)</label>
                                    <div class="col-sm-4 col-md-3 col-lg-4">
                                        <input type="text" name="size" class="form-control" id="size" placeholder="文件大小" value="{{ $row->size}}" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inpuTitle" class="col-sm-2 control-label">下载渠道</label>
                                    <div class="col-sm-4 col-md-3 ">
                                        <select name="path" id="path" class="form-control">
                                            <option value="1" @if ( $row->path == 1 ) SELECTED  @endif >谷歌</option>
                                            <option value="2" @if ( $row->path == 2 ) SELECTED  @endif >CDN</option>
                                        </select>
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