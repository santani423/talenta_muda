@extends('template.main')

@section('content')
    @include('template.navbar.guru')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
              @if (count($detailVisual) > 0 && count($simulasiVisual) > 0 )
            @if($detailVisual[0])
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5>Sempel Gunakan Ujian Pilihan Ganda</h5>
                             
                          
                                <div class="card-body">
                                    {{-- <h5 class="card-title">Kode: {{ $detailVisual[0]['kode'] }}</h5> --}}
                                    <p class="card-text">Pilihan Ganda:</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">PG 1: <img src="{{ asset(explode(' ', $simulasiVisual[0]['pg_1'])[1]) }}" alt="Pilihan 1" style="width: 10%; height: auto;"></li>
                                        <li class="list-group-item">PG 2: <img src="{{ asset(explode(' ', $simulasiVisual[0]['pg_2'])[1]) }}" alt="Pilihan 2" style="width: 10%; height: auto;"></li>
                                        <li class="list-group-item">PG 3: <img src="{{ asset(explode(' ', $simulasiVisual[0]['pg_3'])[1]) }}" alt="Pilihan 3" style="width: 10%; height: auto;"></li>
                                        <li class="list-group-item">PG 4: <img src="{{ asset(explode(' ', $simulasiVisual[0]['pg_4'])[1]) }}" alt="Pilihan 4" style="width: 10%; height: auto;"></li>
                                        <li class="list-group-item">PG 5: <img src="{{ asset(explode(' ', $simulasiVisual[0]['pg_5'])[1]) }}" alt="Pilihan 5" style="width: 10%; height: auto;"></li>
                                         
                                    </ul>
                                    <p class="mt-2">Jawaban Benar: {{ $simulasiVisual[0]['jawaban_1'] }} - {{ $simulasiVisual[0]['jawaban_2'] }} </p>
                                    <p class="text-muted">Dibuat pada: {{ $simulasiVisual[0]['created_at'] }}</p>
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
                            <h5>Ujian Pilihan Visual</h5>
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
                            <form action="{{ url('/guru/ujian_simulator/visual/create/copy', $ujianData->id) }}" method="post">
                                @csrf
                                <div class="row mt-2">
                                    <input type="hidden" id="kode" value="{{ $kode }}">
                                    @foreach ($detailVisual as $index => $dp)
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group text-center">
                                              
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal{{$dp->id}}">
                                                    Lihat Soal Visual
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{$dp->id}}" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModal{{$dp->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModal{{$dp->id}}Label">Modal title
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row"> 
                                                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                                                       A <img src="{{ asset(explode(' ', $dp['pg_1'])[1]) }}" class="card-img-top" alt="Soal Image"  style="width: 80%; height: auto;">
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                                                       B <img src="{{ asset(explode(' ', $dp['pg_2'])[1]) }}" class="card-img-top" alt="Soal Image"  style="width: 80%; height: auto;">
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                                                       C <img src="{{ asset(explode(' ', $dp['pg_3'])[1]) }}" class="card-img-top" alt="Soal Image"  style="width: 80%; height: auto;">
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                                                       D <img src="{{ asset(explode(' ', $dp['pg_4'])[1]) }}" class="card-img-top" alt="Soal Image"  style="width: 80%; height: auto;">
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                                                       E <img src="{{ asset(explode(' ', $dp['pg_5'])[1]) }}" class="card-img-top" alt="Soal Image"  style="width: 80%; height: auto;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3">{{$dp['jawaban_1']}} -
                                                 {{$dp['jawaban_2']}}</p>
                                                {{-- <p></p> --}}
                                                <div class="mt-3">
                                                    <input type="radio" name="soal_choice" id="soal_{{ $index }}"
                                                        value="{{ $dp->id }}">
                                                    <label for="soal_{{ $index }}">Pilih</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button id="tambah-soal" class="btn btn-primary mt-3">Modif Simulator</button>
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
            let soalCount = 0;  generateSoal();

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
              

                const soalItems = document.querySelectorAll(".soal-item");
                const totalSoal = soalItems.length;

                let uploadedCount = 0;
                document.getElementById("progress-bar").style.width = "0%";
                document.getElementById("upload-status").innerText = "";

                for (const soal of soalItems) {
                    const soalId = soal.getAttribute("data-soal-id");
                    const formData = new FormData();

                     
                    formData.append("kode", document.getElementById("kode").value); 

                    for (let i = 1; i <= 5; i++) {
                        const fileInput = soal.querySelector(`[name="gambar_pilihan_${soalId}_${i}"]`);
                        formData.append(`gambar_pilihan_${i}`, fileInput.files[0]);
                    }

                    const correctAnswer1 = soal.querySelector(`[name="jawaban_benar_${soalId}"]`).value;
                    const correctAnswer2 = soal.querySelector(`[name="jawaban_benar_2${soalId}"]`).value;
                    formData.append("jawaban_benar", correctAnswer1);
                    formData.append("jawaban_benar_2", correctAnswer2);

                    const response = await fetch("{{url('upload-soal-visual')}}", {
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
                    // window.location.replace("{{ url('/guru/ujian_visual') }}"+"/"+document.getElementById("kode").value);
                    window.location.reload();
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
