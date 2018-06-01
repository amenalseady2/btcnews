@inject('sidebarPresenter','App\Presenters\Contracts\ConsoleSidebarPersenterInterface')
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">{{ __('sideBar.functionList') }}</li>
            <li @if($sidebarPresenter->getModuleName() == 'administrators') class="active" @endif >
                <a href="/admin/administrators/user">
                    <i class="fa fa-github"></i> <span>{{ __('sideBar.adminManage') }}</span>
                </a>
            </li>
            <li @if( $sidebarPresenter->getModuleName() == 'news') class="active" @endif>
                <a href="/admin/news">
                    <i class="fa fa-newspaper-o"></i> <span>新闻列表</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                
                <ul class="treeview-menu">
                    <li @if($sidebarPresenter->getPlate() == 'news') class="active" @endif><a href="/admin/news"><i class="fa fa-circle-o">新闻列表</i></a></li>
                </ul>
            </li>
            <li  @if( $sidebarPresenter->getModuleName() == 'users') class="active" @endif>
                <a href="/admin/users">
                    <i class="fa fa-user"></i> <span>用户列表</span>
                </a>
            </li>
            <li  @if( $sidebarPresenter->getModuleName() == 'mineConfig') class="active" @endif>
                <a href="/admin/mineConfig">
                    <i class="fa fa-gears"></i> <span>挖矿设置</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="/log-viewer">
                    <i class="fa fa-opera"></i> <span>{{ __('sideBar.logManage')}}</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>