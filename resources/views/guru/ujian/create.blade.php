@extends('template.main')

@section('content')
    @include('template.navbar.guru')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5>Tes Pilihan Ganda</h5>
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nama">Nama Tes / Quiz</label>
                                        <input type="text" name="nama" id="nama" class="form-control" required>
                                    </div>
                                </div>
                                <input type="hidden" id="kode" value="{{ $kode }}">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="mapel">Psikotes</label>
                                        <select class="form-control" name="mapel" id="mapel" required>
                                            <option value="">Pilih</option>
                                            @foreach ($guru_mapel as $gm)
                                                <option value="{{ $gm->mapel->id }}">{{ $gm->mapel->nama_mapel }}</option>
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
                                                <option value="{{ $gk->kelas->id }}">{{ $gk->kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="jam">Jam</label>
                                        <input type="number" name="jam" id="jam" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="menit">Menit</label>
                                        <input type="number" name="menit" id="menit" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="acak"
                                            value="1">
                                        <label class="custom-control-label" for="customCheck1">Acak Soal Peserta</label>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <h2>Upload Soal</h2>
            <form id="form-upload-soal">
                <div id="soal-container">
                    <!-- Tempat untuk soal dinamis -->
                </div>
                <button type="button" id="tambah-soal" class="btn btn-primary mt-3">Tambah Soal</button>
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
        document.addEventListener("DOMContentLoaded", function () {
            let soalCount = 0;
    
            // Fungsi untuk menambah soal dinamis
            function generateSoal() {
                soalCount++;
                const soalHtml = `
                    <div class="card soal-item mb-4" data-soal-id="${soalCount}">
                        <div class="card-header">
                            <h4>Soal ${soalCount}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="pertanyaan_${soalCount}">Pertanyaan (Gambar)</label>
                                <input type="file" name="pertanyaan_${soalCount}" class="form-control" required accept="image/*" onchange="previewQuestionImage(event, ${soalCount})">
                                <div class="image-preview" id="preview_question_${soalCount}"></div>
                            </div>
                            <div class="form-group">
                                <label>Gambar Soal dan Pilihan Jawaban</label>
                                ${Array.from({ length: 6 }, (_, i) => `
                                    <div class="form-group">
                                        <label>Gambar Pilihan ${String.fromCharCode(65 + i)}</label>
                                        <input type="file" name="gambar_pilihan_${soalCount}_${i + 1}" class="form-control" required accept="image/*" onchange="previewImage(event, ${soalCount}, ${i + 1})">
                                        <div class="image-preview" id="preview_${soalCount}_${i + 1}"></div>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="form-group">
                                <label for="jawaban_benar_${soalCount}">Pilihan Benar</label>
                                <select class="form-control" name="jawaban_benar_${soalCount}" id="jawaban_benar_${soalCount}" required>
                                    <option value="">Pilih</option>
                                    ${Array.from({ length: 6 }, (_, i) => `
                                        <option value="${String.fromCharCode(65 + i)}">Pilihan ${String.fromCharCode(65 + i)}</option>
                                    `).join('')}
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger remove-soal" onclick="removeSoal(${soalCount})">Hapus Soal</button>
                        </div>
                    </div>
                `;
                document.getElementById("soal-container").insertAdjacentHTML("beforeend", soalHtml);
            }
    
            document.getElementById("tambah-soal").addEventListener("click", generateSoal);
    
            // Fungsi untuk menghapus soal
            window.removeSoal = function (soalId) {
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
                            alert(`Gambar pilihan ${String.fromCharCode(65 + i - 1)} pada Soal ${soalId} harus diisi.`);
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
            document.getElementById("submit-all").addEventListener("click", async function () {
                if (!validateForm()) {
                    return;
                }
    
                const soalItems = document.querySelectorAll(".soal-item");
                const totalSoal = soalItems.length;
    
                let uploadedCount = 0;
                document.getElementById("progress-bar").style.width = "0%";
                document.getElementById("upload-status").innerText = "";
    
                for (const soal of soalItems) {
                    const soalId = soal.getAttribute("data-soal-id");
                    const formData = new FormData();
    
                    // Informasi tambahan untuk ujian
                    formData.append("nama_ujian", document.getElementById("nama").value.trim());
                    formData.append("mapel", document.getElementById("mapel").value);
                    formData.append("kelas", document.getElementById("kelas").value);
                    formData.append("kode", document.getElementById("kode").value);
                    formData.append("jam", document.getElementById("jam").value);
                    formData.append("menit", document.getElementById("menit").value);
    
                    // Gambar pertanyaan
                    const questionFile = soal.querySelector(`[name="pertanyaan_${soalId}"]`);
                    formData.append("pertanyaan", questionFile.files[0]);
    
                    // Gambar jawaban
                    for (let i = 1; i <= 6; i++) {
                        const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                        formData.append(`gambar_pilihan_${i}`, fileInput.files[0]);
                    }
    
                    const correctAnswer = soal.querySelector(`[name="jawaban_benar_${soalId}"]`).value;
                    formData.append("jawaban_benar", correctAnswer);
    
                    try {
                        const response = await fetch("{{ url('/guru/ujian') }}", {
                            method: "POST",
                            body: formData,
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        }); 
                        
                        if (!response.ok) {
                            throw new Error(`Gagal upload soal ${soalId}`);
                        }
                        console.log("public function store(Req",response);
                        
    
                        uploadedCount++;
                        const progressPercent = Math.floor((uploadedCount / totalSoal) * 100);
                        document.getElementById("progress-bar").style.width = `${progressPercent}%`;
                        document.getElementById("progress-bar").innerText = `${progressPercent}%`;
    
                    } catch (error) {
                        document.getElementById("upload-status").innerHTML += `<p class="text-danger">${error.message}</p>`;
                    }
                }
    
                if (uploadedCount === totalSoal) {
                    document.getElementById("upload-status").innerHTML =
                        `<p class="text-success">Semua soal berhasil di-upload.</p>`;
                    window.location.replace("{{ url('/guru/ujian') }}" + "/" + document.getElementById("kode").value);
                }
            });
    
            // Preview gambar pertanyaan
            window.previewQuestionImage = function (event, soalId) {
                const preview = document.getElementById(`preview_question_${soalId}`);
                preview.innerHTML = `<img src="${URL.createObjectURL(event.target.files[0])}" class="img-thumbnail" style="max-width: 200px;">`;
            };
    
            // Preview gambar pilihan jawaban
            window.previewImage = function (event, soalId, pilihanId) {
                const preview = document.getElementById(`preview_${soalId}_${pilihanId}`);
                preview.innerHTML = `<img src="${URL.createObjectURL(event.target.files[0])}" class="img-thumbnail" style="max-width: 200px;">`;
            };
        });
    </script>
    
@endsection
