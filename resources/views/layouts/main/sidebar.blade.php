<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Beranda</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('letter-type.index') }}">
                    <i class="bi bi-card-list"></i>
                    <span>Jenis Surat</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('faculties.index') }}">
                    <i class="bi bi-building"></i>
                    <span>Fakultas</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('departments.index') }}">
                    <i class="bi bi-calendar4-range"></i>
                    <span>Jurusan</span>
                </a>
            </li>
        @endif
        <!-- End Letter Type Nav -->
        @if (Auth::user()->role !== 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Pesan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('incoming-letter.index') }}">
                            <i class="bi bi-circle"></i><span>Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('outgoing-letter.index') }}">
                            <i class="bi bi-circle"></i><span>Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif


        <!-- End Components Nav -->
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Arsip </span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('archive-incoming-letter.index') }}">
                            <i class="bi bi-circle"></i><span>Surat Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('archive-outgoing-letter.index') }}">
                            <i class="bi bi-circle"></i><span>Surat Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-report" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-earmark"></i><span>Report </span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-report" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('report.archive-incoming') }}">
                            <i class="bi bi-circle"></i><span>Surat Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('report.archive-outgoing') }}">
                            <i class="bi bi-circle"></i><span>Surat Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- End Forms Nav -->
        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Users</span>
                </a>
            </li>
        @endif

        <!-- End Users Page Nav -->


        {{-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="tables-general.html">
                        <i class="bi bi-circle"></i><span>General Tables</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="charts-chartjs.html">
                        <i class="bi bi-circle"></i><span>Chart.js</span>
                    </a>
                </li>
                <li>
                    <a href="charts-apexcharts.html">
                        <i class="bi bi-circle"></i><span>ApexCharts</span>
                    </a>
                </li>
                <li>
                    <a href="charts-echarts.html">
                        <i class="bi bi-circle"></i><span>ECharts</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Charts Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="icons-bootstrap.html">
                        <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-remix.html">
                        <i class="bi bi-circle"></i><span>Remix Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-boxicons.html">
                        <i class="bi bi-circle"></i><span>Boxicons</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Icons Nav --> --}}

        {{-- <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->



        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav --> --}}

    </ul>

</aside>
