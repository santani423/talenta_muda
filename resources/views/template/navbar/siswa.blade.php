<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image" style="background: #fafafa"></figure>
            <div class="user-info">
                <img src="{{ asset('assets/user-profile/' . $siswa->avatar) }}" alt="avatar" class="bg-white">
                <h6 class="">{{ $siswa->nama_siswa }}</h6>
                <p class="">Peserta</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ ($menu['menu'] == 'dashboard') ? 'active' : ''; }}">
                <a href="{{ url("/siswa") }}" aria-expanded="{{ ($menu['expanded'] == 'dashboard') ? 'true' : 'false'; }}" class="dropdown-toggle">
                    <div class="">
                        <span data-feather="airplay"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <!-- <li class="menu menu-heading">
                <div class="heading">
                    <span data-feather="minus"></span>
                    <span>siswa MENU</span>
                </div>
            </li>
            <li class="menu {{ ($menu['menu'] == 'materi') ? 'active' : ''; }}">
                <a href="{{ url("/siswa/materi") }}" aria-expanded="{{ ($menu['expanded'] == 'materi') ? 'true' : 'false'; }}" class="dropdown-toggle">
                    <div class="">
                        <span data-feather="book-open"></span>
                        <span>Materi</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ ($menu['menu'] == 'tugas') ? 'active' : ''; }}">
                <a href="{{ url("/siswa/tugas") }}" aria-expanded="{{ ($menu['expanded'] == 'tugas') ? 'true' : 'false'; }}" class="dropdown-toggle">
                    <div class="">
                        <span data-feather="book"></span>
                        <span>Tugas</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ ($menu['menu'] == 'ujian') ? 'active' : ''; }}">
                <a href="{{ url("/siswa/ujian") }}" aria-expanded="{{ ($menu['expanded'] == 'ujian') ? 'true' : 'false'; }}" class="dropdown-toggle">
                    <div class="">
                        <span data-feather="cast"></span>
                        <span>Tes</span>
                    </div>
                </a>
            </li> -->
            <li class="menu menu-heading">
                <div class="heading">
                    <span data-feather="minus"></span>
                    <span>USER MENU</span>
                </div>
            </li>
            <li class="menu {{ ($menu['menu'] == 'profile') ? 'active' : ''; }}">
                <a href="{{ url("/siswa/profile") }}" aria-expanded="{{ ($menu['expanded'] == 'profile') ? 'true' : 'false'; }}" class="dropdown-toggle">
                    <div class="">
                        <span data-feather="user"></span>
                        <span>Profile</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="{{ url("/logout") }}" aria-expanded="false" class="dropdown-toggle logout">
                    <div class="">
                        <span data-feather="log-out"></span>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->