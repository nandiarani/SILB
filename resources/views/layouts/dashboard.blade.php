<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')

    {{-- icon --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('../assets/image/favicon.png')}}">

    {{-- Style --}}
    <link href="{{asset('../assets/node_modules/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('../assets/node_modules/morrisjs/morris.css')}}" rel="stylesheet">
    <link href="{{asset('../assets/node_modules/c3-master/c3.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/stylelite.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/dashboard1.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors/default.css')}}" id="theme" rel="stylesheet">

    {{-- script --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

</head>

<body class="fix-header fix-sidebar card-no-border">
    @yield('preloader')
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <img src="{{asset('assets/image/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                        <img src="{{asset('assets/image/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        <img src="{{asset('assets/image/logo-text.png')}}" alt="homepage" class="dark-logo" />
                        <img src="{{asset('assets/image/logo-light-text.png')}}" class="light-logo"
                            alt="homepage" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    {{--  search  --}}
                    <ul class="navbar-nav mr-auto">
                        {{--  <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                href="javascript:void(0)"><i class="fa fa-bars"></i></a> </li>
                        <li class="nav-item hidden-xs-down search-box"> <a
                                class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i
                                    class="fa fa-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a
                                    class="srh-btn"><i class="fa fa-times"></i></a></form>
                        </li>  --}}
                    </ul>
                    {{--  profile  --}}
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
                                href="#profile-dropdown" data-toggle="dropdown" data-target="#profile-dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="hidden-md-down">{{ Auth::user()->username }}</span>
                                <span style="padding-left:10px;">
                                    <i class="fa fa-caret-down"></i>
                                </span>
                            </a>
                            <div class="panel-collapse collapse" id="profile-dropdown">
                                <ul class="navbar-nav dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="#" style="font-size:15px;">
                                            {{ __('Profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();" style="font-size:15px;">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        {{-- SIDE BAR START HERE --}}
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="/home" aria-expanded="false">
                                <span><img src="{{asset('assets/icon/research.png')}}" style="height:33px;width:33px;"
                                        alt=""></span>
                                <span class="hide-menu" style="padding-left:10px;">Dashboard</span>
                            </a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{route('penjualan.index')}}" aria-expanded="false">
                                <span><img src="{{asset('assets/icon/sell.png')}}" style="height:33px;width:33px;"
                                        alt=""></span>
                                <span class="hide-menu" style="padding-left:10px;">Penjualan Ikan</span>
                            </a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{route('pengeluaran.index')}}" aria-expanded="false">
                                <span><img src="{{asset('assets/icon/buy.png')}}" style="height:33px;width:33px;"
                                        alt=""></span>
                                <span class="hide-menu" style="padding-left:10px;">Pengeluaran</span>
                            </a>
                        </li>
                        @if (Auth::user()->role==='owner')
                        <li> <a class="waves-effect waves-dark" href="{{ route('jenis_pengeluaran.index') }}"
                            aria-expanded="false">
                            <span><img src="{{asset('assets/icon/bookmark.png')}}" style="height:33px;width:33px;"
                                    alt=""></span>
                            <span class="hide-menu" style="padding-left:10px;">Jenis Pengeluaran</span>
                        </a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{route('tarif.index')}}" aria-expanded="false">
                                <span><img src="{{asset('assets/icon/investment.png')}}" style="height:33px;width:33px;"
                                        alt=""></span>
                                <span class="hide-menu" style="padding-left:10px;">Atur Harga Ikan</span>
                            </a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{ route('modal.index') }}" aria-expanded="false">
                                <span><img src="{{asset('assets/icon/modal.png')}}" style="height:33px;width:33px;"
                                        alt=""></span>
                                <span class="hide-menu" style="padding-left:10px;">Modal</span>
                            </a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{route('pegawai.index')}}" aria-expanded="false">
                                <span><img src="{{asset('assets/icon/users.png')}}" style="height:33px;width:33px;"
                                        alt=""></span>
                                <span class="hide-menu" style="padding-left:10px;">Pegawai</span>
                            </a>
                        </li>
                        @endif
                </nav>
            </div>

        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('breadcrumb')
                {{-- CONTENT HERE --}}
                @yield('contents')
                {{-- CONTENT END --}}
                {{-- FOOTER START --}}
                <footer class="footer"> © 2018 Adminwrap by wrappixel.com </footer>
                {{-- FOOTER END --}}
            </div>
        </div>
        {{-- JQUERY AND JS HERE --}}
        <script src="{{asset('../assets/node_modules/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('../assets/node_modules/jquery/jquery.mask.js')}}"></script>
        <script src="{{asset('../assets/node_modules/bootstrap/js/popper.min.js')}}"></script>
        <script src="{{asset('../assets/node_modules/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('js/sidebarmenu.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>
        <script src="{{asset('../assets/node_modules/raphael/raphael-min.js')}}"></script>
        <script src="{{asset('../assets/node_modules/morrisjs/morris.min.js')}}"></script>
        <script src="{{asset('../assets/node_modules/d3/d3.min.js')}}"></script>
        <script src="{{asset('../assets/node_modules/c3-master/c3.min.js')}}"></script>
        <script src="{{asset('js/dashboard1.js')}}"></script>
        @yield('js')
</body>

</html>
