<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Accueil</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ request()->is('exhibitors*') ? 'active' : '' }}">
                <a href="{{ route('exhibitors') }}">
                    <span class="pcoded-micon"><i class="ti-view-list-alt"></i><b>E</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Nos exposants</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>

        @auth
            @if(Auth::user()->role == 'admin')
                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Administration</div>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <span class="pcoded-micon"><i class="ti-dashboard"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Tableau de bord</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            @endif

            @if(Auth::user()->role == 'contractor_approved')
                <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Entrepreneur</div>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="{{ request()->is('entrepreneur/dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('entrepreneur.dashboard') }}">
                            <span class="pcoded-micon"><i class="ti-dashboard"></i><b>D</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Tableau de bord</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->is('entrepreneur/products*') ? 'active' : '' }}">
                        <a href="{{ route('entrepreneur.products') }}">
                            <span class="pcoded-micon"><i class="ti-package"></i><b>P</b></span>
                            <span class="pcoded-mtext" data-i18n="nav.dash.main">Mes Produits</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            @endif
        @endauth
    </div>
</nav>
