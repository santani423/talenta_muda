@extends('template.main')

@section('content')
    @include('template.navbar.guru')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            @if (count($simulasiPg) > 0)
                @if ($simulasiPg[0])
                    <div class="row layout-top-spacing">
                        <div class="col-lg-12 layout-spacing">
                            <div class="widget shadow p-3">
                                <div class="widget-heading">
                                    <h5>Sempel Gunakan Ujian Pilihan Ganda</h5>

                                    <img src="{{ url($simulasiPg[0]['soal']) }}" class="card-img-top" alt="Soal Image"
                                        style="width: 80%; height: auto;">
                                    <div class="card-body">
                                        {{-- <h5 class="card-title">Kode: {{ $simulasiPg[0]['kode'] }}</h5> --}}
                                        <p class="card-text">Pilihan Ganda:</p>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">PG 1: <img
                                                    src="{{ asset(explode(' ', $simulasiPg[0]['pg_1'])[1]) }}"
                                                    alt="Pilihan 1" style="width: 10%; height: auto;"></li>
                                            <li class="list-group-item">PG 2: <img
                                                    src="{{ asset(explode(' ', $simulasiPg[0]['pg_2'])[1]) }}"
                                                    alt="Pilihan 2" style="width: 10%; height: auto;"></li>
                                            <li class="list-group-item">PG 3: <img
                                                    src="{{ asset(explode(' ', $simulasiPg[0]['pg_3'])[1]) }}"
                                                    alt="Pilihan 3" style="width: 10%; height: auto;"></li>
                                            <li class="list-group-item">PG 4: <img
                                                    src="{{ asset(explode(' ', $simulasiPg[0]['pg_4'])[1]) }}"
                                                    alt="Pilihan 4" style="width: 10%; height: auto;"></li>
                                            <li class="list-group-item">PG 5: <img
                                                    src="{{ asset(explode(' ', $simulasiPg[0]['pg_5'])[1]) }}"
                                                    alt="Pilihan 5" style="width: 10%; height: auto;"></li>
                                            <li class="list-group-item">PG 6: <img
                                                    src="{{ asset(explode(' ', $simulasiPg[0]['pg_6'])[1]) }}"
                                                    alt="Pilihan 6" style="width: 10%; height: auto;"></li>
                                        </ul>
                                        <p class="mt-2">Jawaban Benar: {{ $simulasiPg[0]['jawaban'] }}</p>
                                        <p class="text-muted">Dibuat pada: {{ $simulasiPg[0]['created_at'] }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endif

           
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5>Sempel Gunakan Ujian Pilihan Ganda</h5>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ url('/guru/ujian_simulator/create/copy', $ujianData->id) }}" method="post">
                                @csrf
                                <div class="row mt-2">
                                    <input type="hidden" id="kode" value="{{ $kode }}">
                                    @foreach ($detailPg as $index => $dp)
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group text-center">
                                                <img src="{{ url($dp->soal) }}" alt="" class="img-fluid mb-2">
                                                <div>
                                                    <input type="radio" name="soal_choice"
                                                        id="soal_{{ $index }}" value="{{ $dp->id }}">
                                                    <label for="soal_{{ $index }}">Pilih</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button id="tambah-soal" class="btn btn-primary mt-3">Tambah Soal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Upload Soal</h2>
            <form id="form-upload-soal">
                <div id="soal-container">
                    <!-- Tempat untuk soal dinamis -->
                </div>

                <button type="button" id="submit-all" class="btn btn-success mt-3">Upload Semua Soal</button>
            </form>

            <div class="progress mt-4">
                <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
            <div id="upload-status" class="mt-2"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let soalCount = 0;
            generateSoal()
            // Fungsi untuk menambah soal dinamis
            function generateSoal() {
                soalCount++;
                const soalHtml = `
        <div class="card soal-item mb-4" data-soal-id="${soalCount}">
            <div class="card-header">
                <h4>Soal </h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="pertanyaan_${soalCount}">Pertanyaan (Gambar)</label>
                    <input 
                        type="file" 
                        name="pertanyaan_${soalCount}" 
                        class="form-control" 
                        required 
                        accept="image/*" 
                        onchange="previewQuestionImage(event, ${soalCount})"
                    >
                    <div class="image-preview" id="preview_question_${soalCount}"></div>
                </div>
                <div class="form-group">
                    <label>Gambar Soal dan Pilihan Jawaban</label>
                    ${Array.from({ length: 6 }, (_, i) => `<div class = "form-group" >
                    <label
                for = "gambar_pilihan_${soalCount}_${i + 1}" > Gambar Pilihan $ {
                    String.fromCharCode(65 + i)
                } < /label> <
                input
                type = "file"
                name = "gambar_pilihan_${soalCount}_${i + 1}"
                id = "gambar_pilihan_${soalCount}_${i + 1}"
                class = "form-control"
                required
                accept = "image/*"
                onchange = "previewImage(event, ${soalCount}, ${i + 1})" >
                    <div class = "image-preview"
                id = "preview_${soalCount}_${i + 1}" > < /div> <
                    /div>
                `).join('')}
                </div>
                <div class="form-group">
                    <label for="jawaban_benar_${soalCount}">Pilihan Benar</label>
                    <select 
                        class="form-control" 
                        name="jawaban_benar_${soalCount}" 
                        id="jawaban_benar_${soalCount}" 
                        required
                    >
                        <option value="">Pilih</option>
                        ${Array.from({ length: 6 }, (_, i) => ` <
                option value = "${String.fromCharCode(65 + i)}" > Pilihan $ {
                    String.fromCharCode(65 + i)
                } < /option>
                `).join('')}
                    </select>
                </div>
            </div>
        </div>
    `;
                document.getElementById("soal-container").insertAdjacentHTML("beforeend", soalHtml);
            }


            document.getElementById("tambah-soal").addEventListener("click", generateSoal);

            // Fungsi untuk menghapus soal
            window.removeSoal = function(soalId) {
                const soalItem = document.querySelector(`.soal-item[data-soal-id="${soalId}"]`);
                soalItem.remove();
                soalCount--;
            };

            // Fungsi untuk validasi formulir
            function validateForm() {
                const namaUjian = document.getElementById("nama").value.trim();
                const mapel = document.getElementById("mapel").value;
                const kelas = document.getElementById("kelas").value;
                const jam = document.getElementById("jam").value;
                const menit = document.getElementById("menit").value;
                const soalItems = document.querySelectorAll(".soal-item");

                if (!namaUjian || !mapel || !kelas || !jam || !menit) {
                    alert("Semua bidang utama harus diisi.");
                    return false;
                }

                for (const soal of soalItems) {
                    const soalId = soal.getAttribute("data-soal-id");
                    const questionFile = soal.querySelector(`[name="pertanyaan_${soalId}"]`);
                    if (!questionFile || questionFile.files.length === 0) {
                        alert(`Pertanyaan gambar pada Soal ${soalId} harus diisi.`);
                        return false;
                    }

                    for (let i = 1; i <= 6; i++) {
                        const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                        if (!fileInput || fileInput.files.length === 0) {
                            alert(
                                `Gambar pilihan ${String.fromCharCode(65 + i - 1)} pada Soal ${soalId} harus diisi.`
                                );
                            return false;
                        }
                    }

                    const correctAnswer = soal.querySelector(`[name="jawaban_benar_${soalId}"]`);
                    if (!correctAnswer || correctAnswer.value === "") {
                        alert(`Pilihan benar pada Soal ${soalId} harus diisi.`);
                        return false;
                    }
                }
                return true;
            }

            // Proses upload soal
            document.getElementById("submit-all").addEventListener("click", async function() {
                // if (!validateForm()) {
                //     return;
                // }

                const soalItems = document.querySelectorAll(".soal-item");
                const totalSoal = soalItems.length;

                let uploadedCount = 0;
                document.getElementById("progress-bar").style.width = "0%";
                document.getElementById("upload-status").innerText = "";

                for (const soal of soalItems) {
                    const soalId = soal.getAttribute("data-soal-id");
                    const formData = new FormData();

                    // Informasi tambahan untuk ujian

                    formData.append("kode", document.getElementById("kode").value);

                    // Gambar pertanyaan
                    const questionFile = soal.querySelector(`[name="pertanyaan_${soalId}"]`);
                    formData.append("pertanyaan", questionFile.files[0]);

                    // Gambar jawaban
                    for (let i = 1; i <= 6; i++) {
                        const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                        formData.append(`gambar_pilihan_${i}`, fileInput.files[0]);
                        // alert(77);
                    }

                    const correctAnswer = soal.querySelector(`[name="jawaban_benar_${soalId}"]`).value;
                    formData.append("jawaban_benar", correctAnswer);
                    try {
                        const response = await fetch("{{ url('/guru/ujian_simulator/create') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        if (!response.ok) {
                            throw new Error(`Gagal upload soal ${soalId}`);
                        }

                        uploadedCount++;
                        const progressPercent = Math.floor((uploadedCount / totalSoal) * 100);
                        document.getElementById("progress-bar").style.width = `${progressPercent}%`;
                        document.getElementById("progress-bar").innerText = `${progressPercent}%`;

                    } catch (error) {
                        document.getElementById("upload-status").innerHTML +=
                            `<p class="text-danger">${error.message}</p>`;
                    }
                }

                if (uploadedCount === totalSoal) {
                    document.getElementById("upload-status").innerHTML =
                        `<p class="text-success">Semua soal berhasil di-upload.</p>`;
                    // window.location.replace("{{ url('/guru/ujian') }}" + "/" + document.getElementById(
                    //     "kode").value);
                    window.location.reload();
                }
            });

            // Preview gambar pertanyaan
            window.previewQuestionImage = function(event, soalId) {
                const preview = document.getElementById(`preview_question_${soalId}`);
                preview.innerHTML =
                    `<img src="${URL.createObjectURL(event.target.files[0])}" class="img-thumbnail" style="max-width: 200px;">`;
            };

            // Preview gambar pilihan jawaban
            window.previewImage = function(event, soalId, pilihanId) {
                const preview = document.getElementById(`preview_${soalId}_${pilihanId}`);
                preview.innerHTML =
                    `<img src="${URL.createObjectURL(event.target.files[0])}" class="img-thumbnail" style="max-width: 200px;">`;
            };
        });
    </script>
@endsection
