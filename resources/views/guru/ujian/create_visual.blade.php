@extends('template.main')

@section('content')
    @include('template.navbar.guru')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5>Tes Pilihan Visual</h5>
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
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="acak"
                                            value="1">
                                        <label class="custom-control-label" for="customCheck1">Acak Soal Peserta</label>
                                    </div>
                                </div>
                            </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            let soalCount = 0;

            function generateSoal() {
                soalCount++;
                const soalHtml = `
                    <div class="card soal-item mb-4" data-soal-id="${soalCount}">
                        <div class="card-header">
                            <h4>Soal ${soalCount}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Gambar Soal dan Pilihan Jawaban</label>
                                ${Array.from({ length: 5 }, (_, i) => `
                                    <div class="form-group">
                                        <label>Gambar Pilihan ${String.fromCharCode(65 + i)}</label>
                                        <input type="file" name="gambar_pilihan_${soalCount}_${i + 1}" class="form-control" required accept="image/*" onchange="previewImage(event, ${soalCount}, ${i + 1})">
                                        <div class="image-preview" id="preview_${soalCount}_${i + 1}"></div>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="form-group">
                                <label for="jawaban_benar_${soalCount}">Pilihan Benar 1</label>
                                <select class="form-control" name="jawaban_benar_${soalCount}" id="jawaban_benar_${soalCount}" required>
                                    <option value="">Pilih</option>
                                    ${Array.from({ length: 5 }, (_, i) => `<option value="${String.fromCharCode(65 + i)}">Pilihan ${String.fromCharCode(65 + i)}</option>`).join('')}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jawaban_benar_2${soalCount}">Pilihan Benar 2</label>
                                <select class="form-control" name="jawaban_benar_2${soalCount}" id="jawaban_benar_2${soalCount}" required>
                                    <option value="">Pilih</option>
                                    ${Array.from({ length: 5 }, (_, i) => `<option value="${String.fromCharCode(65 + i)}">Pilihan ${String.fromCharCode(65 + i)}</option>`).join('')}
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger remove-soal" onclick="removeSoal(${soalCount})">Hapus Soal</button>
                        </div>
                    </div>
                `;
                document.getElementById("soal-container").insertAdjacentHTML("beforeend", soalHtml);
            }

            document.getElementById("tambah-soal").addEventListener("click", generateSoal);

            window.removeSoal = function(soalId) {
                const soalItem = document.querySelector(`.soal-item[data-soal-id="${soalId}"]`);
                soalItem.remove();
                soalCount--;
            };

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

                    for (let i = 1; i <= 5; i++) {
                        const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                        if (!fileInput || fileInput.files.length === 0) {
                            alert(`Gambar pilihan ${String.fromCharCode(65 + i - 1)} pada Soal ${soalId} harus diisi.`);
                            return false;
                        }
                    }

                    const correctAnswer1 = soal.querySelector(`[name="jawaban_benar_${soalId}"]`);
                    const correctAnswer2 = soal.querySelector(`[name="jawaban_benar_2${soalId}"]`);
                    if (!correctAnswer1 || correctAnswer1.value === "" || !correctAnswer2 || correctAnswer2.value === "") {
                        alert(`Dua pilihan benar pada Soal ${soalId} harus diisi.`);
                        return false;
                    }
                }

                return true;
            }

            document.getElementById("submit-all").addEventListener("click", async function() {
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

                    formData.append("nama_ujian", document.getElementById("nama").value.trim());
                    formData.append("mapel", document.getElementById("mapel").value);
                    formData.append("kelas", document.getElementById("kelas").value);
                    formData.append("kode", document.getElementById("kode").value);
                    formData.append("jam", document.getElementById("jam").value);
                    formData.append("menit", document.getElementById("menit").value);

                    for (let i = 1; i <= 5; i++) {
                        const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                        formData.append(`gambar_pilihan_${i}`, fileInput.files[0]);
                    }

                    const correctAnswer1 = soal.querySelector(`[name="jawaban_benar_${soalId}"]`).value;
                    const correctAnswer2 = soal.querySelector(`[name="jawaban_benar_2${soalId}"]`).value;
                    formData.append("jawaban_benar", correctAnswer1);
                    formData.append("jawaban_benar_2", correctAnswer2);

                    const response = await fetch("{{url('upload-soal')}}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    });

                    if (response.ok) {
                        uploadedCount++;
                        const progressPercentage = Math.round((uploadedCount / totalSoal) * 100);
                        document.getElementById("progress-bar").style.width = `${progressPercentage}%`;
                        document.getElementById("progress-bar").innerText = `${progressPercentage}%`;
                    } else {
                        document.getElementById("upload-status").innerText += `Gagal mengunggah soal ${soalId}\n`;
                    }
                }

                if (uploadedCount === totalSoal) {
                    document.getElementById("upload-status").innerText = "Semua soal berhasil diunggah.";
                    window.location.replace("{{ url('/guru/ujian_visual') }}"+"/"+document.getElementById("kode").value);
                } else {
                    document.getElementById("upload-status").innerText += "Pengunggahan selesai dengan beberapa kegagalan.";
                }
            });
        });

        function previewImage(event, soalId, pilihanId) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`preview_${soalId}_${pilihanId}`).innerHTML = `<img src="${e.target.result}" class="img-thumbnail" width="150">`;
            };
            reader.readAsDataURL(file);
        }
    </script>
@endsection
