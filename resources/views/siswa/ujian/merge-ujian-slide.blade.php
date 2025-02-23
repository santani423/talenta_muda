@extends('template.mainUjian')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div class="row layout-top-spacing">
        <div class="col-12 layout-spacing"> <!-- Ubah menjadi col-12 agar card mengambil seluruh lebar layar -->
            <div class="widget shadow p-3 w-100" style="background: linear-gradient(to bottom, #1e3c72, #2a5298); border: none;"> <!-- Tambahkan w-100 untuk memastikan lebar card penuh -->
                @if ($mergeUjian)
                    <!-- Tambahkan banner -->
                    <div class="banner">
                        <img src="{{ asset($mergeUjian->banner) }}" alt="Banner" style="width: 100%; height: auto;">
                    </div>

                    <!-- Tambahkan tombol Next di bawah banner -->
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ url('siswa/instruksi/' . $ujian) }}" class="btn btn-primary">Next</a>
                        {{-- @if ($mergeUjian->instruksi_ujian)
                        @else
                            @if ($mergeUjian->jenis_ujian == 0)
                                <a href="{{ url('siswa/ujian/' . $ujian) }}" class="btn btn-primary">Next</a>
                            @elseif($mergeUjian->jenis_ujian == 1)
                                <a href="{{ url('siswa/ujian_essay/' . $ujian) }}" class="btn btn-primary">Next</a>
                            @elseif($mergeUjian->jenis_ujian == 2)
                                <a href="{{ url('siswa/ujian_kuesioner/' . $ujian) }}" class="btn btn-primary">Next</a>
                            @elseif($mergeUjian->jenis_ujian == 3)
                                <a href="{{ url('siswa/ujian_visual/' . $ujian) }}" class="btn btn-primary">Next</a>
                            @endif
                        @endif --}}

                    </div>
                @else
                    <h1 class="text-center"  style="color: white; font-size: 40px; font-weight: bold;">Selesai</h1>
                    <div class="text-center">

                        <a href="{{ url('/siswa') }}" class="btn btn-success">Dashboard</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->

@endsection
