@extends('template.main')

@section('content')
    @include('template.navbar.guru')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5>Edit Tes Pilihan Ganda</h5>
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
                                        <input type="number" name="b_jam" id="jam" class="form-control" value="{{ $ujian->jam }}"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for=""> Menit</label>
                                        <input type="number" name="b_menit"  id="menit" class="form-control" value="{{ $ujian->menit }}"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="acak"
                                            value="1" {{ $ujian->acak ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheck1">Acak Soal Peserta</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Edit Soal</h2>
            <form id="form-upload-soal" enctype="multipart/form-data">
                <div id="soal-container">
                    @foreach ($ujian->detailujian as $index => $soal)
                        <input type="hidden" name="detail_ujian_id_{{ $index + 1 }}"
                            id="detail_ujian_id_{{ $index + 1 }}" value="{{ $soal->id }}">
                        <div class="card soal-item mb-4" data-soal-id="{{ $index + 1 }}">
                            <div class="card-header">
                                <h4>Soal {{ $index + 1 }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="pertanyaan_{{ $index + 1 }}">Pertanyaan (Gambar)</label>
                                    <input type="file" name="pertanyaan_{{ $index + 1 }}" class="form-control"
                                        accept="image/*" onchange="previewQuestionImage(event, {{ $index + 1 }})">
                                    <div class="image-preview" id="preview_question_{{ $index + 1 }}">
                                        <img src="{{ url($soal->soal) }}" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Gambar Soal dan Pilihan Jawaban</label>
                                    @foreach ($soalPilihan as $i => $pilihan)
                                        <div class="form-group">
                                            <label>Gambar Pilihan {{ chr(65 + $i) }}</label>
                                            <input type="file"
                                                name="gambar_pilihan_{{ $index + 1 }}_{{ $i + 1 }}"
                                                class="form-control" accept="image/*"
                                                onchange="previewImage(event, {{ $index + 1 }}, {{ $i + 1 }})">
                                            <div class="image-preview"
                                                id="preview_{{ $index + 1 }}_{{ $i + 1 }}">
                                                <img src="{{ url(substr($soal->{$pilihan['image_path']}, 3)) }}"
                                                    class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="jawaban_benar_{{ $index + 1 }}">Pilihan Benar</label>
                                    <select class="form-control" name="jawaban_benar_{{ $index + 1 }}"
                                        id="jawaban_benar_{{ $index + 1 }}" required>
                                        <option value="">Pilih </option>
                                        @foreach (range('A', 'F') as $option)
                                            <option value="{{ $option }}"
                                                {{ $soal->jawaban == $option ? 'selected' : '' }}>Pilihan
                                                {{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="tambah-soal" class="btn btn-primary mt-3">Tambah Soal</button>
                <button type="button" id="submit-all" class="btn btn-success mt-3">Simpan Perubahan</button>
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
            let soalCount = {{ json_encode(count($ujian->detailujian )) }};
    
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
        })
        function previewQuestionImage(event, soalId) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById(`preview_question_${soalId}`).innerHTML =
                    `<img src="${reader.result}" class="img-thumbnail" style="max-width: 200px;">`;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewImage(event, soalId, pilihanId) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById(`preview_${soalId}_${pilihanId}`).innerHTML =
                    `<img src="${reader.result}" class="img-thumbnail" style="max-width: 200px;">`;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById("submit-all").addEventListener("click", async function() {
            if (!validateForm()) {
                return;
            }

            const soalItems = document.querySelectorAll(".soal-item");
            const totalSoal = soalItems.length;
            let uploadedCount = 0;

            for (const soal of soalItems) {
                const soalId = soal.getAttribute("data-soal-id");

                // Collect data
                const namaUjian = document.getElementById("nama").value.trim();
                const mapel = document.getElementById("mapel").value;
                const kelas = document.getElementById("kelas").value;
                const kode = document.getElementById("kode").value;
                const jam = document.getElementById("jam").value;
                const menit = document.getElementById("menit").value;

                const jsonData = {
                    id_ujian: `{{ $ujian->id }}`,
                    nama_ujian: namaUjian,
                    mapel: mapel,
                    kelas: kelas,
                    kode: kode,
                    jam: jam,
                    menit: menit,
                    pertanyaan: null,
                    jawaban_benar: null,
                    detailUjianId: null,
                    gambar_pilihan: [] // Initialize as an empty array to hold each option object
                };

                // Set question image if available
                const questionFile = soal.querySelector(`[name="pertanyaan_${soalId}"]`);
                if (questionFile && questionFile.files.length > 0) {
                    jsonData.pertanyaan = await readFileAsDataURL(questionFile.files[0]);
                }

                // Set correct answer
                const correctAnswer = soal.querySelector(`[name="jawaban_benar_${soalId}"]`).value;
                jsonData.jawaban_benar = correctAnswer;

                // Set detailUjianId (soal_id)
                const detailUjianIdInput = document.getElementById(`detail_ujian_id_${soalId}`).value.trim();;
                console.log('detailUjianIdInput.value', detailUjianIdInput);


                jsonData.detailUjianId = detailUjianIdInput;


                // Loop through each option (A-F) and add to gambar_pilihan array
                for (let i = 1; i <= 6; i++) {
                    const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                    if (fileInput && fileInput.files.length > 0) {
                        const imgData = await readFileAsDataURL(fileInput.files[0]);

                        // Push the formatted object with namegambar and imgData to gambar_pilihan
                        jsonData.gambar_pilihan.push({
                            namegambar: String.fromCharCode(64 + i), // Convert 1-6 to A-F
                            imgData: imgData
                        });
                    }
                }

                try {
                    const response = await fetch("{{ url('/guru/ujian/update/' . $ujian->id) }}", {
                        method: "PUT",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(jsonData)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error("Gagal memperbarui soal: " + (errorData.message || response
                            .statusText));
                    }

                    uploadedCount++;
                    updateProgress(uploadedCount, totalSoal);
                } catch (error) {
                    document.getElementById("upload-status").innerText = "Gagal memperbarui beberapa soal: " +
                        error.message;
                    console.error('Error:', error);
                }
            }
        });

        function validateForm() {
            // Implement validation logic to ensure all required fields are filled out
            const namaUjian = document.getElementById("nama").value.trim();
            const mapel = document.getElementById("mapel").value;
            const kelas = document.getElementById("kelas").value;

            if (!namaUjian || !mapel || !kelas) {
                alert("Nama ujian, mapel, dan kelas harus diisi.");
                return false;
            }

            const soalItems = document.querySelectorAll(".soal-item");
            for (const soal of soalItems) {
                const soalId = soal.getAttribute("data-soal-id");
                const detailUjianIdInput = soal.querySelector(`[name="detailUjianId_${soalId}"]`);
                if (!detailUjianIdInput || !detailUjianIdInput.value) {
                    alert(`Detail Ujian ID untuk soal ${soalId} tidak ditemukan.`);
                    return false;
                }
            }

            return true;
        }


        function readFileAsDataURL(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = (error) => reject(error);
                reader.readAsDataURL(file);
            });
        }

        function updateProgress(uploadedCount, totalSoal) {
            const progressBar = document.getElementById("progress-bar");
            const percentage = (uploadedCount / totalSoal) * 100;
            progressBar.style.width = `${percentage}%`;
            progressBar.setAttribute("aria-valuenow", percentage);
            progressBar.innerText = `${Math.round(percentage)}%`;

            if (uploadedCount === totalSoal) {
                
                window.location.replace("{{ url('/guru/ujian') }}" + "/" + document.getElementById("kode").value);
            }
        }

        function validateForm() {
            // Implement validation logic
            return true;
        }
    </script>
@endsection
