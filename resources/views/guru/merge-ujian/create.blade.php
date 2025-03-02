@extends('template.main')
@section('content')
@include('template.navbar.guru')

<meta name="csrf-token" content="{{ csrf_token() }}">
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <a href="javascript:void(0);" class="btn btn-primary tambah-pg"
        style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Tes</a>
    <div class="layout-px-spacing">
        <form action="{{ url('/guru/merge_ujian') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kelas_id" value="{{$kelas->id}}">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5 class="">Merge Ujian</h5>
                            
                        </div>
                        <div class="row mt-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Nama Ujian / Quiz</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Batch</label>
                                       <input type="text" value="{{$kelas->nama_kelas}}" class="form-control" disabled>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Waktu Jam</label>
                                        <input type="number" name="jam" class="form-control" value="0"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Waktu Menit</label>
                                        <input type="number" name="menit" class="form-control" value="0"
                                            required>
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
                            <div class="isi_soal">
                                {{-- <div class="form-group">
                                    <label for="">Banner</label>
                                    <input type="file" name="banner[]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Intruksi</label>
                                    <input type="file" name="instruksi_ujian[]" class="form-control">
                                </div> --}}
                                <div class="form-group">
                                    <label for="">Tes</label>
                                    <select name="ujian_id[]" id="" class="form-control">
                                        @foreach($ujian as $uj)
                                        <option value="{{$uj->id}}">{{$uj->nama}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div>
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

<!-- MODAL -->
<!-- Modal Tambah -->
<div class="modal fade" id="excel_ujian" tabindex="-1" role="dialog" aria-labelledby="excel_ujianLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ url('/guru/bank_pg_excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="excel_ujianLabel">Import Soal via Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nama Tes / Quiz</label>
                                <input type="text" name="e_nama" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">File Excel</label><br>
                                <input type="file" name="excel" accept=".xls, .xlsx" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Template</label><br>
                            <a href="{{ url('/summernote/unduh') }}/template-bank_soal-pg-excel.xlsx" class="btn btn-success"
                                target="_blank">Download Template</a>
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
        var no_soal = 2;
        $('.tambah-pg').click(function() {
            const pg = `
                    <div class="isi_soal">
                    <hr>
                              
                                <div class="form-group">
                                    <label for="">Tes</label>
                                    <select name="ujian_id[]" id="" class="form-control">
                                        @foreach($ujian as $uj)
                                        <option value="{{$uj->id}}">{{$uj->nama}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div>
                `;

            $('#soal_pg').append(pg);
            no_soal++;
        });
        $("#soal_pg").on("click", ".isi_soal a", function() {
            $(this).parents(".isi_soal").remove(), --no_soal
        });
    })
</script>

{!! session('pesan') !!}
@endsection