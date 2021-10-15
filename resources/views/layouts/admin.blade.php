<!DOCTYPE html>
<html lang="en">

@include('inc.header')
@yield('css')

<body class="sidebar-noneoverflow">

    <!--  BEGIN NAVBAR  -->
    @include('inc.navbar')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div id="sidebar-wrapper" class="sidebar-wrapper">
            @include('inc.sidebar')
        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">


                <!-- CONTENT AREA -->
                <div id="app">
                    @yield('content')
                </div>

                <!-- CONTENT AREA -->

            </div>
            @include('inc.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->
    <script>
        @auth
          window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
        @else
          window.Permissions = [];
        @endauth
    </script>
    @include('inc.scripts')
    @yield('js')


</body>

</html>