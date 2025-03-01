@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">

        <form action="{{ url('/guru/ujian_intruksi/create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $kode }}" name="kode">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5 class="">Instruksi</h5>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div id="intruksi">
                            @if (count($intruksi) > 0)
                                @foreach ($intruksi as $key => $in)
                                    @php
                                        $no = $key + 1;
                                    @endphp
                                    <div id="label">
                                        <div class="isi_label">
                                            <div class="form-group">
                                                <label for="">Label {{ $no }}</label>
                                                <input name="label[]" type="text" value="{{ $in->label }}"
                                                    class="form-control">
                                                <input name="id[]" value="{{ $in->id }}" type="hidden"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="isi_intruksi mt-2">
                                        <div class="form-group">
                                            <label for="">Instruksi {{ $no }}</label>
                                            <textarea name="intruksi[]" cols="30" rows="20" class="form-control summernote" wrap="hard" required>{{ $in->intruksi }}</textarea>
                                        </div>
                                        <button type="button" class="btn btn-danger hapus-intruksi mt-2">Hapus</button>
                                    </div>
                                @endforeach
                            @else
                                <!-- Default form instruksi jika $intruksi kosong -->
                                <div id="label">
                                    <div class="isi_label">
                                        <div class="form-group">
                                            <label for="">Label</label>
                                            <input name="label[]" type="text" class="form-control">
                                            <input name="id[]" value="" type="hidden" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="isi_intruksi mt-2">
                                    <div class="form-group">
                                        <label for="">Instruksi </label>
                                        <textarea name="intruksi[]" cols="30" rows="2" class="form-control summernote" wrap="hard" required></textarea>
                                    </div>
                                    <button type="button" class="btn btn-danger hapus-intruksi mt-2">Hapus</button>
                                </div>
                            @endif
                        </div>

                        <div class="mt-2">
                            <button type="button" class="btn btn-success tambah-intruksi">Tambah Instruksi</button>
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

    <!--  END CONTENT AREA  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200
            });

            // Hitung jumlah instruksi awal
            let no_intruksi = $('#intruksi > #label').length;
            if (no_intruksi < 1) {
                no_intruksi = 1; // Default menjadi 1 jika tidak ada instruksi
            }

            // Event untuk menambah instruksi baru
            $('.tambah-intruksi').click(function() {
                var no = no_intruksi + 1;
                const intruksiBaru = `
            <div id="label">
                <div class="isi_label">
                    <div class="form-group">
                        <label for="">Label ${no}</label>
                        <input name="label[]" type="text" class="form-control"> 
                        <input name="id[]" value="" type="hidden" class="form-control"> 
                    </div>
                </div>
            </div>
            <div class="isi_intruksi mt-2">
                <div class="form-group">
                    <label for="">Instruksi ${no}</label>
                    <textarea name="intruksi[]" cols="30" rows="2" class="form-control summernote" wrap="hard" required></textarea>
                </div>
                <button type="button" class="btn btn-danger hapus-intruksi mt-2">Hapus</button>
            </div>
        `;

                $('#intruksi').append(intruksiBaru);
                $('.summernote').summernote({
                    height: 200
                });
                no_intruksi++;
            });

            // Event untuk menghapus elemen instruksi
            $('#intruksi').on('click', '.hapus-intruksi', function() {
                $(this).closest('.isi_intruksi').prev('#label').remove();
                $(this).closest('.isi_intruksi').remove();
                no_intruksi--;
            });
        });
    </script>

    {!! session('pesan') !!}
@endsection
