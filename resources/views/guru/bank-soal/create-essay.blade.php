@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-essay"
            style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Soal</a>
        <div class="layout-px-spacing">
            <form action="{{ url('/guru/bank_soal_essay') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Bank Soal Ujian Essay</h5>
                                <div class="row mt-2">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Nama Ujian / Quiz</label>
                                            <input type="text" name="nama" class="form-control" required>
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
                                <h5 class="">Soal Ujian</h5>
                            </div>
                            <div id="soal_essay">
                                <div class="isi_soal">
                                    <div class="form-group">
                                        <label for="">Soal No. 1</label>
                                        <textarea name="soal[]" cols="30" rows="2" class="summernote" wrap="hard" required></textarea>
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
    <script>
        $(document).ready(function() {
            function uploadImage(e,o){var a=new FormData;a.append("image",e),$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},url:"{{ route('summernote_upload') }}",cache:!1,contentType:!1,processData:!1,data:a,type:"post",success:function(e){$(o).summernote("insertImage",e)},error:function(e){console.log(e)}})}function deleteImage(e){$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},data:{src:e},type:"post",url:"{{ route('summernote_delete') }}",cache:!1,success:function(e){console.log(e)}})}setInterval(()=>{$(".summernote").summernote({placeholder:"Hello stand alone ui",tabsize:2,height:120,toolbar:[["style",["style"]],["font",["bold","underline","clear"]],["color",["color"]],["para",["ul","ol","paragraph"]],["table",["table"]],["insert",["link","picture","video"]],["view",["fullscreen","help"]]],callbacks:{onImageUpload:function(e,o=this){uploadImage(e[0],o)},onMediaDelete:function(e){deleteImage(e[0].src)}}})},1e3);
            var no_soal = 2
            $('.tambah-essay').click(function() {
                const essay = `
                    <div class="isi_soal mt-2">
                        <div class="form-group">
                            <label for="">Soal No. ` + no_soal + `</label><br>
                            <textarea class="summernote" name="soal[]" cols="30" rows="5" wrap="hard"></textarea>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-danger hapus-essay">Hapus</a>
                    </div>
                `;

                $('#soal_essay').append(essay);
                no_soal++;
            });
            $("#soal_essay").on("click",".isi_soal a",function(){$(this).parents(".isi_soal").remove(),--no_soal});
        });
    </script>

    {!! session('pesan') !!}
@endsection
