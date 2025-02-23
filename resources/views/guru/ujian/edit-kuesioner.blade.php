@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-essay"
            style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Soal</a>
        <div class="layout-px-spacing">
            <form action="{{ url('/guru/ujian_kuesioner/'.$ujian->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5>Edit Ujian Pilihan Visual</h5>
                                <div class="row mt-2">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="nama">Nama Ujian / Quiz</label>
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                value="{{ $ujian->nama }}" required>
                                        </div>
                                    </div>
                                    <input type="hidden" id="kode" value="{{ $ujian->kode }}">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mapel">Psikotes</label>
                                            <select class="form-control" name="mapel" id="mapel" required>
                                                <option value="">Pilih</option>
                                                @foreach ($guru_mapel as $gm)
                                                    <option value="{{ $gm->mapel->id }}"
                                                        {{ $ujian->mapel_id == $gm->mapel->id ? 'selected' : '' }}>
                                                        {{ $gm->mapel->nama_mapel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="kelas">Batch</label>
                                            <select class="form-control" name="kelas" id="kelas" required>
                                                <option value="">Pilih</option>
                                                @foreach ($guru_kelas as $gk)
                                                    <option value="{{ $gk->kelas->id }}"
                                                        {{ $ujian->kelas_id == $gk->kelas->id ? 'selected' : '' }}>
                                                        {{ $gk->kelas->nama_kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> Jam</label>
                                            <input type="number" name="b_jam" class="form-control" value="{{ $ujian->jam }}"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> Menit</label>
                                            <input type="number" name="b_menit" class="form-control" value="{{ $ujian->menit }}"  required>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Soal Kuesioner</h5>
                            </div>
                            <div id="soal_essay">
                                @foreach($ujian->detailKuisoner as $key =>$detailKuisoner)
                                <input type="hidden" name="kusonerId[]" value="{{$detailKuisoner->id}}">
                                <div class="isi_soal">
                                    <div class="form-group">
                                        <label for="">Kuesioner No. {{++$key}}</label>
                                        <textarea name="kusioner[]" cols="30" rows="2" class="form-control" wrap="hard" required>{!!$detailKuisoner->soal!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jenis Jawaban Kuisoner. {{$key}}</label>
                                        <select name="jenis_kuesoner[]" id="" class="form-control">
                                            @foreach ($jenis_kuesioner as $jk)
                                                <option value="{{ $jk->id }}"  {{ $jk->id == $detailKuisoner->jenis_jawaban_kuesioner_id? 'selected' : '' }}>{{ $jk->nama_kuesioner }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
 

    <!--  END CONTENT AREA  -->
    <script>
        $(document).ready(function() {
            function uploadImage(e, o) {
                var a = new FormData;
                a.append("image", e), $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    url: "{{ route('summernote_upload') }}",
                    cache: !1,
                    contentType: !1,
                    processData: !1,
                    data: a,
                    type: "post",
                    success: function(e) {
                        $(o).summernote("insertImage", e)
                    },
                    error: function(e) {
                        console.log(e)
                    }
                })
            }

            function deleteImage(e) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        src: e
                    },
                    type: "post",
                    url: "{{ route('summernote_delete') }}",
                    cache: !1,
                    success: function(e) {
                        console.log(e)
                    }
                })
            }
            setInterval(() => {
                $(".summernote").summernote({
                    placeholder: "Hello stand alone ui",
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ["style", ["style"]],
                        ["font", ["bold", "underline", "clear"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["table", ["table"]],
                        ["insert", ["link", "picture", "video"]],
                        ["view", ["fullscreen", "help"]]
                    ],
                    callbacks: {
                        onImageUpload: function(e, o = this) {
                            uploadImage(e[0], o)
                        },
                        onMediaDelete: function(e) {
                            deleteImage(e[0].src)
                        }
                    }
                })
            }, 1e3);
            let no_soal = {{ json_encode(count($ujian->detailKuisoner )) }};
            $('.tambah-essay').click(function() {
                no_soal++;
                const essay = `
                 <input type="hidden" name="kusonerId[]" value=" ">
                    <div class="isi_soal mt-2">
                        <div class="form-group">
                            <label for="">Kuesioner No. ` + no_soal + `</label><br>
                            <textarea class="form-control" name="kusioner[]" cols="30" rows="5" wrap="hard"></textarea>
                        </div>
                                    <div class="form-group">
                                        <label for="">Jenis Jawaban Kuisoner No. ` + no_soal + `</label>
                                        <select name="jenis_kuesoner[]" id="" class="form-control">
                                            @foreach ($jenis_kuesioner as $jk)
                                                <option value="{{ $jk->id }}">{{ $jk->nama_kuesioner }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                        <a href="javascript:void(0);" class="btn btn-danger hapus-pg">Hapus</a>
                    </div>
                `;

                $('#soal_essay').append(essay);
                no_soal++;
            });
            $("#soal_essay").on("click", ".isi_soal a", function() {
                $(this).parents(".isi_soal").remove(), --no_soal
            });

        })
    </script>

    {!! session('pesan') !!}
@endsection
