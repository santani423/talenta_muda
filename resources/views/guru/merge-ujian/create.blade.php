@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-pg"
            style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Tes</a>
        <div class="layout-px-spacing">
            <form id="form-merge-ujian" action="{{ url('/guru/merge_ujian') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
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
                                        <input type="text" value="{{ $kelas->nama_kelas }}" class="form-control"
                                            disabled>
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
                                <h5 class="">Soal Tes</h5>
                            </div>
                            <div id="soal_pg">
                                <div class="isi_soal">
                                    <div class="form-group">
                                        <label for="">Tes</label>
                                        <select name="ujian_id[]" class="form-control">
                                            @foreach ($ujian as $uj)
                                                <option value="{{ $uj->id }}">{{ $uj->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary" id="btn-submit">
                                    <span class="btn-text">Submit</span>
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                </button>
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
            // tombol tambah Tes
            $('.tambah-pg').click(function() {
                const pg = `
                    <div class="isi_soal">
                        <hr>
                        <div class="form-group">
                            <label for="">Tes</label>
                            <select name="ujian_id[]" class="form-control">
                                @foreach ($ujian as $uj)
                                    <option value="{{ $uj->id }}">{{ $uj->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `;
                $('#soal_pg').append(pg);
            });

            // submit pakai JSON AJAX + spinner
            $("#form-merge-ujian").on("submit", function(e) {
                e.preventDefault();

                let $btn = $("#btn-submit");
                let $btnText = $btn.find(".btn-text");
                let $spinner = $btn.find(".spinner-border");

                // set loading state
                $btn.prop("disabled", true);
                $btnText.text("Saving...");
                $spinner.removeClass("d-none");

                let formData = {
                    _token: $("meta[name='csrf-token']").attr("content"),
                    kelas_id: $("input[name='kelas_id']").val(),
                    nama: $("input[name='nama']").val(),
                    ujian_id: $("select[name='ujian_id[]']")
                        .map(function() {
                            return $(this).val();
                        })
                        .get()
                };

                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(formData),
                    success: function(res) {
                        if (res?.data?.relasi_merge_ujian) {
                            let ajaxCalls = [];

                            res.data.relasi_merge_ujian.forEach(rmu => {
                                console.log('relasi_merge_ujian item:', rmu);

                                let call = $.ajax({
                                    url: "/api/guru/merge_ujian/relasi_merge_ujian", // ganti sesuai route kamu
                                    type: "POST",
                                    data: rmu
                                }).done(function(resp) {
                                    console.log("Proses relasi sukses:", resp?.data);
                                }).fail(function(xhr) {
                                    console.error("Proses relasi gagal:", xhr.responseJSON?.message);
                                });

                                ajaxCalls.push(call);
                            });

                            // tunggu semua ajax selesai
                            $.when.apply($, ajaxCalls).done(function() {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: res.message
                                }).then(() => {
                                   window.location.href = "/guru/merge_ujian";
                                });
                            }).always(function() {
                                // reset button setelah semua selesai
                                $btn.prop("disabled", false);
                                $btnText.text("Submit");
                                $spinner.addClass("d-none");
                            });

                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: res.message
                            }).then(() => {
                                location.reload();
                            });

                            // reset kalau tidak ada relasi
                            $btn.prop("disabled", false);
                            $btnText.text("Submit");
                            $spinner.addClass("d-none");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: xhr.responseJSON?.message || "Terjadi kesalahan"
                        });
                        $btn.prop("disabled", false);
                        $btnText.text("Submit");
                        $spinner.addClass("d-none");
                    }
                });
            });
        });
    </script>

    {!! session('pesan') !!}
@endsection
