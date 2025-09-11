@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            @if ($kelas->status == 'aktif')
                <span class="badge bg-success">Aktif</span>
                <form action="{{ route('kelas.toggleStatus', $kelas->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-danger mt-2">Nonaktifkan</button>
                </form>
            @else
                <span class="badge bg-secondary">Nonaktif</span>
                <form action="{{ route('kelas.toggleStatus', $kelas->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-success mt-2">Aktifkan</button>
                </form>
            @endif
            <form action="{{ url('/guru/merge_ujian', $merge->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Edit Merge Tes</h5>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Nama Tes / Quiz</label>
                                        <input type="text" name="nama" class="form-control" required
                                            value="{{ $merge->nama }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Batch</label>
                                        <input type="text" value="{{ $kelas->nama_kelas }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Waktu Jam</label>
                                        <input type="number" name="jam" class="form-control"
                                            value="{{ $merge->jam }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Waktu Menit</label>
                                        <input type="number" name="menit" class="form-control"
                                            value="{{ $merge->menit }}" required>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Soal Tes</h5>
                            </div>
                            <div id="soal_pg">
                                @foreach ($relasi_merge_ujian as $rmg)
                                    <input type="hidden" name="idRelasiMergeUjian[]" value="{{ $rmg->id }}">
                                    <div class="isi_soal">
                                        {{-- <div class="form-group">
                                            <label for="">Banner</label>
                                            <input type="file" name="banner[]" class="form-control" onchange="previewImage(this, 'bannerPreview{{ $loop->index }}')">
                                            @if ($rmg->banner)
                                                <img src="{{ url($rmg->banner) }}" class="img-fluid"
                                                    width="50%">
                                            @endif
                                            <img id="bannerPreview{{ $loop->index }}" class="img-fluid mt-2" style="display: none;" width="50%">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Instruksi</label>
                                            <input type="file" name="instruksi_ujian[]" class="form-control" onchange="previewImage(this, 'instruksiPreview{{ $loop->index }}')">
                                            @if ($rmg->instruksi_ujian)
                                                <img src="{{ url($rmg->instruksi_ujian) }}" class="img-fluid"
                                                    width="50%">
                                            @endif
                                            <img id="instruksiPreview{{ $loop->index }}" class="img-fluid mt-2" style="display: none;" width="50%">
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="">Tes</label>
                                            <select name="ujian_id[]" id="" class="form-control">
                                                @foreach ($ujian as $uj)
                                                    <option value="{{ $uj->id }}"
                                                        {{ $uj->kode == $rmg->kode_ujian ? 'selected' : '' }}>
                                                        {{ $uj->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @include('template.footer')
    </div>

    {!! session('pesan') !!}

    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Show the image
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none'; // Hide if no file
            }
        }
    </script>
@endsection
