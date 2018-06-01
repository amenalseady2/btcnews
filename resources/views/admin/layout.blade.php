<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>BTCNEWS - ADMIN</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="/framework/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="/framework/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris charts -->
    <link href="/framework/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- Select2 -->
    <link href="/framework/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/framework/AdminLTE/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="/framework/AdminLTE/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/framework/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <!-- daterange picker -->
    <link rel="stylesheet" href="/framework/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/framework/plugins/datepicker/datepicker3.css">
    <!-- editor -->
    <link rel="stylesheet" href="/framework/wangEditor-2.1.22/dist/css/wangEditor.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <a href="/admin/administrators/user" class="logo"><b>BTCNEWS</b></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">Language</span>
                </a>
                <ul class="dropdown-menu">

                  <li class="user-body">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <a href="javascript:setLang('cn')">中文</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="javascript:setLang('ar')">العربية</a>
                        </div>
                        <div class="col-xs-4 text-center">
                        </div>
                    </div>
                  <!-- /.row -->
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    </div>
                    <div class="pull-right">
                      <a href="/admin/index" class="btn btn-default btn-flat">Logout</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      
      <!-- Left side column. contains the logo and sidebar -->
      @include('admin/sidebar')
      <!-- Right side column. Contains the navbar and content of the page -->
      @yield('content')

    </div><!-- ./wrapper -->

    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=5cc5beb3d82a11d3b7da28fa3941fe15"></script>
    <!-- jQuery 2.1.3 -->
    <script src="/framework/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="http://www.veryhuo.com/uploads/Common/js/jQuery.md5.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="/framework/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="/framework/plugins/select2/select2.full.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/framework/plugins/fastclick/fastclick.min.js'></script>
    <!-- Morris.js charts -->
    <script src="/framework/raphael/raphael-min.js"></script>
    <script src="/framework/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- jQuery Knob -->
    <script src="/framework/plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="/framework/AdminLTE/js/app.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="/framework/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="/framework/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="/framework/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="/framework/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="/framework/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="/framework/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="/framework/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="/framework/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="/framework/plugins/select2/select2.full.min.js" type="text/javascript"></script>
    <!-- bootstrap datepicker -->
    <script src="/framework/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Editor -->
    <script type="text/javascript" src="/framework/wangEditor-2.1.22/dist/js/wangEditor.js"></script>

    <!-- TOKEN -->
    <script type="text/javascript">
      var _token = "<?php echo csrf_token(); ?>";
    </script>
    <!-- js common -->

    <script type="text/javascript">

        $(function () {
            $(".knob").knob({});
        });

        function setLang(lang)
        {

            var url = '/admin/lang/set';

            $.ajax( {  
                url:url,
                data:{
                   'lang':lang
                },  
                type:'post',  
                dataType:'json',  
                success:function(response) {  
                    alert("ok");
                    window.location.reload();
                },  
                error : function() {  
                   alert("exception");  
                }  
            });
        }

    </script>

    <script src="/js/admin/common.js" type="text/javascript"></script>

    @inject('sidebarPresenter','App\Presenters\Contracts\ConsoleSidebarPersenterInterface')
    @if($sidebarPresenter->getPageMark() == 'book.book.create' || $sidebarPresenter->getPageMark() == 'book.book.edit') 
        <script src="/js/admin/book/revise.js" type="text/javascript"></script>
    @endif

    @if($sidebarPresenter->getPageMark() == 'book.book.index') 
        <script src="/js/admin/book/index.js" type="text/javascript"></script>
    @endif

 
    @if($sidebarPresenter->getPageMark() == 'user.info.index') 
        <script src="/js/admin/userInfo/index.js" type="text/javascript"></script>
    @endif


    @if($sidebarPresenter->getPageMark() == 'user.list.index') 
        <script src="/js/admin/userlist/index.js" type="text/javascript"></script>
    @endif

    @if($sidebarPresenter->getPageMark() == 'search.keywordLog.index') 
        <script src="/js/admin/searchKeywordLog/index.js" type="text/javascript"></script>
    @endif

  </body>
</html>
