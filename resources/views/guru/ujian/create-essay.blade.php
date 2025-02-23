@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-essay"
            style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Soal</a>
        <div class="layout-px-spacing">
            <form action="{{ url('/guru/ujian_essay') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type_kunci_jawaban" value="{{$type_kunci_jawaban}}"  >
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Ujian Essay</h5>
                                <div class="row mt-2">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Nama Ujian</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Psikotes</label>
                                            <select class="form-control" name="mapel" id="mapel" required>
                                                <option value="">Pilih</option>
                                                @foreach ($guru_mapel as $gm)
                                                    <option value="{{ $gm->mapel->id }}">{{ $gm->mapel->nama_mapel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Batch</label>
                                            <select class="form-control" name="kelas" id="kelas" required>
                                                <option value="">Pilih</option>
                                                @foreach ($guru_kelas as $gk)
                                                    <option value="{{ $gk->kelas->id }}">{{ $gk->kelas->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Jam</label>
                                            <input type="number" name="jam" class="form-control" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Menit</label>
                                            <input type="number" name="menit" class="form-control" value="0" required>
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
                                <!-- Contoh Soal Pertama -->
                                <div class="isi_soal" data-soal-id="soal-1">
                                    <div class="form-group">
                                        <label for="">Soal No. 1</label>
                                        <textarea name="soal[]" cols="30" rows="2" class="form-control" wrap="hard" required></textarea>
                                    </div>
                                    <div class="jawaban-container mt-2">
                                        @for ($i = 1; $i <= $jumlah_kunci_jawaban; $i++)
                                            <div class="form-group" data-jawaban-id="soal-1-jawaban-{{ $i }}">
                                                <label for="">Jawaban No. {{ $i }}</label>
                                                @if ($type_kunci_jawaban == 'text')
                                                    <textarea class="form-control" name="jawaban[soal-1-jawaban-{{ $i }}]" cols="30" rows="2"
                                                        wrap="hard"></textarea>
                                                    @error('jawaban.soal-1-jawaban-{{ $i }}')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    <input type="text"
                                                        class="form-control @error('jawaban.soal-1-jawaban-{{ $i }}') is-invalid @enderror"
                                                        name="jawaban[soal-1-jawaban-{{ $i }}]" value="0"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^(\d*\.?\d{0,2}).*$/g, '$1')"
                                                        title="Hanya angka bulat atau pecahan dengan maksimal 2 angka di belakang koma">
                                                    @error('jawaban.soal-1-jawaban-{{ $i }}')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                @endif
                                                <label for="">Nilai</label>
                                                <input type="number" class="form-control nilai-input"
                                                    name="nilai[soal-1-jawaban-{{ $i }}]" value="0"
                                                    max="10000" required>
                                                <div class="invalid-feedback">
                                                    Nilai harus diisi dan tidak boleh lebih dari 10000.
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <hr>
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

    <!-- Modal Bank Soal -->
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
                                    <label for="">Nama Ujian / Quiz</label>
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
            var no_soal = 2;
            var jumlah_kunci_jawaban = {{ $jumlah_kunci_jawaban }};
            var type_kunci_jawaban = "{{ $type_kunci_jawaban }}"; // Ambil dari Blade template

            // Fungsi untuk membuat elemen jawaban
            function buatElemenJawaban(soalId, i) {
                let jawabanHtml = `
                    <div class="form-group" data-jawaban-id="${soalId}-jawaban-${i}">
                        <label for="">Jawaban No. ${i}</label>`;

                if (type_kunci_jawaban == 'text') {
                    jawabanHtml += `<textarea class="form-control" name="jawaban[${soalId}-jawaban-${i}]" cols="30" rows="2" wrap="hard"></textarea>`;
                } else {
                    jawabanHtml += `<input type="text" class="form-control" name="jawaban[${soalId}-jawaban-${i}]" value="0"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1').replace(/^(\\d*\\.?\\d{0,2}).*$/g, '$1')"
                                       title="Hanya angka bulat atau pecahan dengan maksimal 2 angka di belakang koma">`;
                }

                jawabanHtml += `<label for="">Nilai</label>
                        <input type="number" class="form-control nilai-input" name="nilai[${soalId}-jawaban-${i}]" value="0" max="10000" required>
                        <div class="invalid-feedback">Nilai harus diisi dan tidak boleh lebih dari 10000.</div>
                    </div>`;
                return jawabanHtml;
            }

            // Event handler untuk tombol "Tambah Soal"
            $('.tambah-essay').click(function() {
                const soalId = 'soal-' + no_soal;
                let jawabanHtml = '';

                for (let i = 1; i <= jumlah_kunci_jawaban; i++) {
                    jawabanHtml += buatElemenJawaban(soalId, i);
                }

                const essay = `
                    <div class="isi_soal mt-2" data-soal-id="${soalId}">
                        <div class="form-group">
                            <label for="">Soal No. ${no_soal}</label><br>
                            <textarea class="form-control" name="soal[]" cols="30" rows="5" wrap="hard" required></textarea>
                        </div>
                        <div class="jawaban-container mt-2">${jawabanHtml}</div>
                        <hr>
                    </div>`;

                $('#soal_essay').append(essay);
                no_soal++;
            });

            // Event handler untuk validasi nilai (hanya contoh, perlu penyesuaian)
            $(document).on('input', '.nilai-input', function() {
                const value = parseInt($(this).val());
                if (value > 10000) {
                    $(this).val(10000); // Batasi nilai
                }
            });
        });
    </script>

    {!! session('pesan') !!}
@endsection