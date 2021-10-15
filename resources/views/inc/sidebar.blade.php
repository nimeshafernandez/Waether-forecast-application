<div class="sidebar-theme">
    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image">
                <img src="https://images.unsplash.com/photo-1562742862-512efda35b5b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=874&q=80" alt="">
            </figure>
            <div class="user-info">
                <img src="https://images.unsplash.com/photo-1601987794680-cdfc2183d121?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=436&q=80" alt="avatar">
                <h6 class="">{{Auth::user()->name}}</h6>
                <p class="">{{Auth::user()->getRoleNames()[0]}}</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            @can('POS')
            <li class="menu {{ $page_category === 'pos' ? 'active' : '' }}">
                <a href="{{route('pos.index')}}" aria-expanded="{{ $page_category === 'pos' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                </a>
            </li>
            @endcan

            <li class="menu {{ $page_category === 'dashboard' ? 'active' : '' }}">
                <a href="{{route('home')}}" aria-expanded="{{ $page_category === 'dashboard' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            @if(auth()->user()->can('product_management_create') || auth()->user()->can('product_management_view') )
            <li class="menu {{ $page_category === 'products' ? 'active' : '' }}">
                <a href="#submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>

                        <span>ToDo Management</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $page_category === 'products' ? 'show' : '' }}"
                    id="submenu" data-parent="#accordionExample">
                    @can('product_management_create')
                    <li class="{{ $page_name === 'add_products' ? 'active' : '' }}">
                        <a href="{{route('product.create')}}"> Add ToDo </a>
                    </li>
                    @endcan
                    @can('product_management_view')
                    <li class="{{ $page_name === 'view_products' ? 'active' : '' }}">
                        <a href="{{route('product.index')}}"> View ToDo </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif

            @if(auth()->user()->can('product_management_create') || auth()->user()->can('product_management_view') )
            <li class="menu {{ $page_category === 'stocks' ? 'active' : '' }}">

            </li>
            @endif

            @if(auth()->user()->can('user_management_create') || auth()->user()->can('user_management_view') )
            <li class="menu {{ $page_category === 'users' ? 'active' : '' }}">
                <a href="#submenu2" data-toggle="collapse"
                    aria-expanded="{{ $page_category === 'users' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-airplay">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                        <span>User Management</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $page_category === 'users' ? 'show' : '' }}" id="submenu2"
                    data-parent="#accordionExample">
                    @can('user_management_create')
                    <li class="{{ $page_name === 'create_new_user' ? 'active' : '' }}">
                        <a href="{{route('user.create')}}"> Add New User </a>
                    </li>
                    @endcan
                    @can('user_management_view')
                    <li class="{{ $page_name === 'view_users' ? 'active' : '' }}">
                        <a href="{{route('user.index')}}"> View Users </a>
                    </li>
                    @endcan
                    @if(auth()->user()->can('user_management_update') && auth()->user()->can('user_management_view') &&
                    auth()->user()->can('user_management_create') )
                    <li class="{{ $page_name === 'view_roles' ? 'active' : '' }}">
                        <a href="{{route('roles.index')}}"> Role Permission</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if(auth()->user()->can('customer_management_create') || auth()->user()->can('customer_management_view') )



            @endif


        </ul>

    </nav>

</div>
