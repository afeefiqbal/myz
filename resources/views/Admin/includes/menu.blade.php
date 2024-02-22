<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{url(Helper::sitePrefix().'dashboard')}}" class="brand-link">
        {!! Helper::printImage(@$siteInformation, 'logo','logo_webp','logo_attribute','brand-image','width: 201px') !!}
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>
    <div class="sidebar">
      
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url(Helper::sitePrefix().'dashboard')}}"
                       class="nav-link {{ (Request::segment(2)=='dashboard' && Request::segment(1)=='admin')?'active':'' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @include('Admin.includes.menus.'.Helper::loggedUserType().'_menu');
            </ul>
        </nav>
    </div>
</aside>
