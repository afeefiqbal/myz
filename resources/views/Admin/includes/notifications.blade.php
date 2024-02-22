<li class="nav-item dropdown">
    <a class="btn btn-xs btn-info mt-2" id="reload-application">Reload Page</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        @if(Helper::loggedUserType()=="admin")
            <a href="{{url(Helper::sitePrefix().'administration/profile')}}" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> Profile
            </a>
        @else
            <a href="{{url(Helper::sitePrefix().'/profile')}}" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> Profile
            </a>
        @endif
        <div class="dropdown-divider"></div>
        <a href="{{url(Helper::sitePrefix().'logout')}}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Logout
        </a>
    </div>
</li>
