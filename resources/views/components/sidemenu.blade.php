<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENUS</li>
            <li class="{{ request()->is('dashboard*') ? 'active menu-open' : '' }} treeview">
                <a href="#">
                    <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard">
                            <span> Comparison Report</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('dashboard/members-report') ? 'active' : '' }}">
                        <a href="/dashboard/members-report">
                            <span> Church Report</span>
                        </a>
                    </li>
                </ul>
            </li>

            @can('view', App\Webhook::class)
                <li class="{{ request()->is('webhooks*') ? 'active' : '' }}">
                    <a href="/webhooks">
                        <i class="fa fa-broadcast-tower"></i> <span>Webhooks</span>
                    </a>
                </li>
            @endcan


            @can('view', App\Role::class)
                <li class="{{ request()->is('roles*') || request()->is('settings*') ? 'active menu-open' : '' }} treeview">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>Settings</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ request()->is('roles*') ? 'active' : '' }}">
                            <a href="/roles">
                                <i class="fa fa-user-astronaut"></i> <span> Roles and Permission</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                            <a href="/settings">
                                <i class="fa fa-wrench"></i> <span> Configurations</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('view', App\User::class)
                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                    <a href="/users">
                        <i class="fa fa-user"></i> <span>Users</span>
                    </a>
                </li>
            @endcan

            @can('view', App\Report::class)
                <li class="{{ request()->is('reports*') || request()->is('categories*') ? 'active menu-open' : '' }} treeview">
                    <a href="#">
                        <i class="fa fa-chart-bar"></i> <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                            <a href="/reports">
                                <i class="fa fa-chart-pie"></i> <span> Manage Reports</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('categories*') ? 'active' : '' }}">
                            <a href="/categories">
                                <i class="fa fa-tags"></i> <span> Categories</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('view', App\Church::class)
                <li class="{{ request()->is('churches*') ? 'active' : '' }}">
                    <a href="/churches">
                        <i class="fa fa-church"></i> <span>Churches</span>
                    </a>
                </li>
            @endcan
            @can('view', App\Survey::class)
                <li class="{{ request()->is('surveys*') ? 'active' : '' }}">
                    <a href="/surveys">
                        <i class="fa fa-list-ul"></i> <span>Surveys</span>
                    </a>
                </li>
            @endcan
            @can('view', App\Question::class)
                <li class="{{ request()->is('questions*') ? 'active' : '' }}">
                    <a href="/questions">
                        <i class="fa fa-question"></i> <span>Questions</span>
                    </a>
                </li>
            @endcan
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
