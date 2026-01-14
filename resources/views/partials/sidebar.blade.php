<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- MENU UTAMA --}}
                <div class="sb-sidenav-menu-heading">Menu Utama</div>

                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>

                {{-- MASTER --}}
                <div class="sb-sidenav-menu-heading">Master</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                   data-bs-target="#collapseMaster" aria-expanded="false"
                   aria-controls="collapseMaster">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    Master
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseMaster"
                     data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('pelatihan.index') }}">
                            Master Pelatihan
                        </a>
                    </nav>
                </div>

                {{-- KELAS --}}
                <div class="sb-sidenav-menu-heading">Kelas</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                   data-bs-target="#collapseKelas" aria-expanded="false"
                   aria-controls="collapseKelas">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    Kelas
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseKelas"
                     data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">
                            Kelas Kepemimpinan
                        </a>
                        <a class="nav-link" href="#">
                            Kelas Fungsional
                        </a>
                    </nav>
                </div>

                {{-- DAFTAR PANTAU --}}
                <div class="sb-sidenav-menu-heading">Daftar Pantau</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                   data-bs-target="#collapsePantau" aria-expanded="false"
                   aria-controls="collapsePantau">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    Daftar Pantau
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapsePantau"
                     data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">
                            Kepemimpinan
                        </a>
                        <a class="nav-link" href="#">
                            Fungsional
                        </a>
                    </nav>
                </div>

                {{-- MONITORING --}}
                <div class="sb-sidenav-menu-heading">Monitoring</div>

                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    Monitoring
                </a>

            </div>
        </div>

    </nav>
</div>
