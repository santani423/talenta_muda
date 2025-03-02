@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-essay"
            style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Soal</a>
        <div class="layout-px-spacing">
            <form action="{{ url('/guru/ujian_essay/' . $ujian->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5>Edit Tes Pilihan Essay</h5>
                                <div class="row mt-2">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="nama">Nama Tes / Quiz</label>
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
                                            <input type="number" name="b_jam" class="form-control"
                                                value="{{ $ujian->jam }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> Menit</label>
                                            <input type="number" name="b_menit" class="form-control"
                                                value="{{ $ujian->menit }}" required>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="custom-control-input" id="customCheck1" name="acak"
                                    value="1" {{ $ujian->acak ? 'checked' : '' }}>
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
                            @php
                                $jawaban_no = 1;
                            @endphp
                            <div id="soal_essay">
                                @foreach ($ujian->detailessay as $key => $detailessay)
                                    <input type="hidden" name="essayId[]" value="{{ $detailessay->id }}">
                                    <div class="isi_soal" data-soal-id="soal-{{ $key + 1 }}">
                                        <div class="form-group">
                                            <label for="">Soal No. {{ $key + 1 }}</label>
                                            <textarea name="soal[]" cols="30" rows="2" class="form-control" wrap="hard" required>{{ $detailessay->soal }}</textarea>
                                        </div>
                                        <button type="button" class="btn btn-secondary tambah-jawaban">Tambah Jawaban</button>
                                        <div class="jawaban-container mt-2">
                                            @foreach ($detailessay->jawabanEssay as $jawabanEssay)
                                                <div class="form-group" data-jawaban-id="soal-{{ $key + 1 }}-jawaban-{{ $loop->index + 1 }}">
                                                    <label for="">Jawaban No. {{ $loop->index + 1 }}</label>
                                                    <textarea class="form-control" name="jawaban[soal-{{ $key + 1 }}-jawaban-{{ $loop->index + 1 }}]" cols="30" rows="2" wrap="hard">{{ $jawabanEssay->jawaban }}</textarea>
                                                    <label for="">Nilai</label>
                                                    <input type="number" class="form-control" name="nilai[soal-{{ $key + 1 }}-jawaban-{{ $loop->index + 1 }}]" value="{{ $jawabanEssay->nilai }}">
                                                    <a href="javascript:void(0);" class="btn btn-danger hapus-jawaban">Hapus Jawaban</a>
                                                </div>
                                                @php
                                                    $jawaban_no++;
                                                @endphp
                                            @endforeach
                                        </div>
                                        <a href="javascript:void(0);" class="btn btn-danger hapus-pg">Hapus</a>
                                        <hr>
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

    <div class="modal fade" id="bank_soal" tabindex="-1" role="dialog" aria-labelledby="bank_soalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ url('/guru/essay_bank_soal') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bank_soalLabel">Import Bank Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nama Tes / Quiz</label>
                                    <input type="text" name="b_nama_ujian" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Mapel</label>
                                    <select class="form-control" name="b_mapel" id="b_mapel" required>
                                        <option value="">Pilih</option>
                                        @foreach ($guru_mapel as $gm)
                                            <option value="{{ $gm->mapel->id }}">{{ $gm->mapel->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <select class="form-control" name="b_kelas" id="b_kelas" required>
                                        <option value="">Pilih</option>
                                        @foreach ($guru_kelas as $gk)
                                            <option value="{{ $gk->kelas->id }}">{{ $gk->kelas->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Waktu Jam</label>
                                    <input type="number" name="b_jam" class="form-control" value="0" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Waktu Menit</label>
                                    <input type="number" name="b_menit" class="form-control" value="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2" style="max-height: 300px;">
                            <div class="col-lg-12">
                                <div class="table-responsive mt-3" style="overflow-x: scroll;">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Total Soal</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bank_soal as $bs)
                                                @if ($bs->jenis == 1)
                                                    <tr>
                                                        <td>{{ $bs->nama }}</td>
                                                        <td>{{ $bs->total_soal }}</td>
                                                        <td>
                                                            <div class="n-chk">
                                                                <label class="new-control new-radio radio-classic-primary">
                                                                    <input type="radio" class="new-control-input"
                                                                        name="kode_bank" value="{{ $bs->kode }}"
                                                                        required>
                                                                    <span class="new-control-indicator"></span>Pilih
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" value="reset" class="btn" data-dismiss="modal"><i
                                class="flaticon-cancel-12"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
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
            var no_soal = {{ $ujian->detailessay->count() + 1 }};
            var no_jawaban = {{ $jawaban_no }};
            $('.tambah-essay').click(function() {
                const soalId = 'soal-' + no_soal;
                const essay = `
                    <div class="isi_soal mt-2" data-soal-id="` + soalId + `">
                        <div class="form-group">
                            <label for="">Soal No. ` + no_soal + `</label><br>
                            <textarea class="form-control" name="soal[]" cols="30" rows="5" wrap="hard"></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary tambah-jawaban">Tambah Jawaban</button>
                        <div class="jawaban-container mt-2"></div>
                        <a href="javascript:void(0);" class="btn btn-danger hapus-pg">Hapus</a>
                        <hr>
                    </div>
                `;

                $('#soal_essay').append(essay);
                no_soal++;
            });
            $("#soal_essay").on("click",".isi_soal .hapus-pg",function(){$(this).parents(".isi_soal").remove(),--no_soal});
            $("#soal_essay").on("click", ".tambah-jawaban", function() {
                const soalId = $(this).closest('.isi_soal').data('soal-id');
                const jawabanId = soalId + '-jawaban-' + no_jawaban;
                const jawaban = `
                    <div class="form-group" data-jawaban-id="` + jawabanId + `">
                        <label for="">Jawaban No. ` + no_jawaban + `</label>
                        <textarea class="form-control" name="jawaban[` + jawabanId + `]" cols="30" rows="2" wrap="hard"></textarea>
                        <label for="">Nilai</label>
                        <input type="number" class="form-control" name="nilai[` + jawabanId + `]" value="0">
                        <a href="javascript:void(0);" class="btn btn-danger hapus-jawaban">Hapus Jawaban</a>
                    </div>
                `;
                $(this).siblings('.jawaban-container').append(jawaban);
                no_jawaban++;
            });
            $("#soal_essay").on("click", ".hapus-jawaban", function() {
                $(this).parent().remove();
                no_jawaban--;
            });
        })
    </script>

    {!! session('pesan') !!}
@endsection
