<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <!-- HEADING -->
                <div class="sb-sidenav-menu-heading">Menu Utama</div>

                <!-- DASHBOARD -->
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>

                <!-- MASTER -->
                <div class="sb-sidenav-menu-heading">Master Data</div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                   data-bs-target="#collapseMaster" aria-expanded="false">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    Master
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseMaster" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">
                            Master Pelatihan Kepemimpinan
                        </a>
                        <a class="nav-link" href="#">
                            Master Pelatihan Fungsional
                        </a>
                    </nav>
                </div>

                <!-- KELAS -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                   data-bs-target="#collapseKelas" aria-expanded="false">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    Kelas
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseKelas" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Kelas Kepemimpinan</a>
                        <a class="nav-link" href="#">Kelas Fungsional</a>
                    </nav>
                </div>

                <!-- DAFTAR PANTAU -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                   data-bs-target="#collapsePantau" aria-expanded="false">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-list-check"></i>
                    </div>
                    Daftar Pantau
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapsePantau" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Pantau Kepemimpinan</a>
                        <a class="nav-link" href="#">Pantau Fungsional</a>
                    </nav>
                </div>

                <!-- MONITORING -->
                <div class="sb-sidenav-menu-heading">Monitoring</div>

                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    Monitoring
                </a>

            </div>
        </div>

        <!-- FOOTER SIDEBAR -->
        <div class="sb-sidenav-footer">
            <div class="small">Login sebagai:</div>
            Admin
        </div>
    </nav>
</div>
