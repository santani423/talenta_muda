@extends('template.main')
@section('content')
    @include('template.navbar.siswa')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-spacing">
                <!-- Content -->
                <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                    <div class="user-profile layout-spacing">
                        <div class="widget-content widget-content-area">
                            <div class="d-flex justify-content-between">
                                <h3 class="">My Profile</h3>
                                <a href="javascript:void(0);" class="mt-2 edit-profile">
                                    <span data-feather="edit-3"></span>
                                </a>
                            </div>
                            <div class="text-center user-info">
                                <img src="{{ asset('assets/user-profile/' . $siswa->avatar) }}" class="img-user" alt="avatar" style="width: 125px; height: 125px;">
                                <p class="">{{ $siswa->nama_siswa }}</p>
                            </div>
                            <div class="user-info-list" style="margin-top: -10px;">
                                <div class="text-center">
                                    <p>Peserta</p>
                                    <ul class="contacts-block list-unstyled" style="margin-top: -5px;">
                                        <li class="contacts-block__item">
                                            <span data-feather="calendar"></span>
                                            <br>
                                            {{ $siswa->created_at->diffForHumans() }}
                                        </li>
                                        <li class="contacts-block__item">
                                            <span data-feather="mail"></span>
                                            <br>
                                            {{ $siswa->email }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">

                    <div class="skills layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Update Profile</h3>
                            <form action="{{ url("/siswa/edit_profile/" . $siswa->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" value="{{ $siswa->email }}" class="form-control" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Foto</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="avatar" id="customFile" accept=".jpg, .png, .jpeg" onchange="previewImg()">
                                        <input type="hidden" name="gambar_lama" value="{{ $siswa->avatar }}">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Save</button>
                            </form>
                        </div>
                    </div>

                    <div class="skills layout-spacing">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Password</h3>
                            <form action="{{ url("/siswa/edit_password/" . $siswa->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">New Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    {!! session('pesan') !!}

    <script>
        function previewImg(){var e=document.querySelector("#customFile");const t=document.querySelector(".custom-file-label"),o=document.querySelector(".img-user");t.textContent=e.files[0].name;const n=new FileReader;n.readAsDataURL(e.files[0]),n.onload=function(e){o.src=e.target.result}}
    </script>
@endsection