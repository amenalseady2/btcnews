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
            <?php
                $apps = DB::table('apps')->get();
            ?>
            <li @if( $sidebarPresenter->getModuleName() == 'apps' || $sidebarPresenter->getModuleName() == 'version') class="active" @endif>
                <a href="/admin/apps">
                    <i class="fa fa-gears"></i> <span>版本设置</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                
                <ul class="treeview-menu">
                    <li @if($sidebarPresenter->getPlate() == 'apps') class="active" @endif><a href="/admin/apps"><i class="fa fa-circle-o">应用列表</i></a></li>
                    @foreach($apps as $val)
                        <li @if($sidebarPresenter->getPlate() == 'version' && isset($_GET['app_id']) && $_GET['app_id'] == $val->id) class="active" @endif><a href="/admin/version?app_id={{$val->id}}">&nbsp;&nbsp;|->&nbsp;{{$val->name}}</i></a></li>
                    @endforeach
                </ul>
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