@extends('template.mainUjian')
@section('content')
    <style>
        .answer-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* Jarak antar elemen */
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .answer-item {
            flex: 0 0 calc(50% - 10px);
            /* 2 kolom */
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .answer-item label {
            cursor: pointer;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div class="row layout-top-spacing">
        <div class="col-12 layout-spacing"> <!-- Ubah menjadi col-12 agar card mengambil seluruh lebar layar -->
            {{-- <div class="widget shadow p-3 w-100"> <!-- Tambahkan w-100 untuk memastikan lebar card penuh --> --}}
            @if ($mergeUjian)
                <!-- Tambahkan banner -->
                {{-- <div class="banner">
                        <img src="{{ asset($mergeUjian->instruksi_ujian) }}" alt="Banner" style="width: 100%; height: auto;">
                    </div> --}}

                <div class="container-fluid mt-4" id="instruksi" style="height: 100vh;">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-md-12 mb-2">
                            <div class="card text-white shadow h-100"
                                style="background: linear-gradient(to bottom, #1e3c72, #2a5298); border: none;">
                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                    <!-- Menampilkan instruksi -->
                                    @foreach ($IntruksiUjian as $index => $intr)
                                        <div class="instruksi" id="instruksi-{{ $index }}"
                                            style="{{ $index != 0 ? 'display:none;' : '' }}">
                                            <h2 class="card-title"
                                                style="color: yellow; font-size: 40px; font-weight: bold;">
                                                {{ $intr->label }}
                                            </h2>
                                            <p class="card-text" style="color: white; font-size: 30px; font-weight: bold;">
                                                {!! $intr->intruksi !!}
                                            </p>

                                            <div class="d-grid gap-2 col-6 mx-auto">

                                                @if ($index < count($IntruksiUjian) - 1)
                                                    <button class="btn btn-warning"
                                                        onclick="showNextInstruksi({{ $index }})">Next</button>
                                                @else
                                                    @if (count($simulasiPg) > 0 || count($simulasiVisual) > 0 || count($simulasiEssay) > 0 || count($simulasiKuesioner) > 0)
                                                        <button class="btn btn-warning"
                                                            onclick="showExampleQuestions()">Contoh
                                                            Soal</button>
                                                    @else
                                                        @if ($mergeUjian->jenis_ujian == 0)
                                                            <a href="{{ url('siswa/ujian/' . $ujian) }}"
                                                                class="btn btn-warning">Mulai Ujian </a>
                                                        @elseif($mergeUjian->jenis_ujian == 1)
                                                            <button class="btn btn-warning" onclick="ujianEsay()">Mulai
                                                                Ujian </button>
                                                            <div id="countdown-essay"
                                                                style="color: yellow; font-weight: bold; font-size: 20px; margin-top: 10px; display: none;">
                                                            </div>
                                                            <!-- Modal Countdown Essay -->
                                                            <div id="countdownEssayModal" class="modal"
                                                                style="display: none; position: fixed; z-index: 9999; background: rgba(0,0,0,0.7); top: 0; left: 0; width: 100%; height: 100%;">
                                                                <div
                                                                    style="background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: 20% auto; text-align: center;">
                                                                    {{-- <h4> selesai!</h4> --}}
                                                                    <p id="countdownEssayText">Halaman akan dialihkan dalam
                                                                        <span id="countdownEssaySeconds">5</span> detik...
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function ujianEsay() {
                                                                    // Kirim data bahwa simulasi selesai
                                                                    fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                                                                            method: "POST",
                                                                            headers: {
                                                                                "Content-Type": "application/json",
                                                                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                            },
                                                                            body: JSON.stringify({
                                                                                kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                                                                                time: new Date()
                                                                            })
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            console.log('Simulasi selesai:', data);
                                                                        })
                                                                        .catch(error => {
                                                                            console.error('Error:', error);
                                                                        });

                                                                    // Tampilkan modal countdown
                                                                    const modal = document.getElementById('countdownEssayModal');
                                                                    const countdownText = document.getElementById('countdownEssayText');
                                                                    const countdownSeconds = document.getElementById('countdownEssaySeconds');

                                                                    modal.style.display = 'block';

                                                                    let countdown = 5;
                                                                    countdownSeconds.textContent = countdown;

                                                                    const interval = setInterval(() => {
                                                                        countdown--;
                                                                        countdownSeconds.textContent = countdown;
                                                                        if (countdown <= 0) {
                                                                            clearInterval(interval);
                                                                            window.location.href = "{{ url('siswa/ujian_essay/' . $ujian) }}";
                                                                        }
                                                                    }, 1000);
                                                                }
                                                            </script>
                                                            {{-- <a href="{{ url('siswa/ujian_essay/' . $ujian) }}"
                                                                ></a> --}}
                                                        @elseif($mergeUjian->jenis_ujian == 2)
                                                            {{-- <a href="{{ url('siswa/ujian_kuesioner/' . $ujian) }}"
                                                                class="btn btn-warning">Mulai Ujian 3</a> --}}
                                                            <button class="btn btn-warning" onclick="ujianEsay()">Mulai
                                                                Ujian </button>
                                                            <div id="countdown-essay"
                                                                style="color: yellow; font-weight: bold; font-size: 20px; margin-top: 10px; display: none;">
                                                            </div>
                                                            <!-- Modal Countdown Essay -->
                                                            <div id="countdownEssayModal" class="modal"
                                                                style="display: none; position: fixed; z-index: 9999; background: rgba(0,0,0,0.7); top: 0; left: 0; width: 100%; height: 100%;">
                                                                <div
                                                                    style="background: #fff; padding: 20px 30px; border-radius: 10px; max-width: 400px; margin: 20% auto; text-align: center;">
                                                                    {{-- <h4>Simulasi selesai!</h4> --}}
                                                                    <p id="countdownEssayText">Halaman akan dialihkan dalam
                                                                        <span id="countdownEssaySeconds">5</span> detik...
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function ujianEsay() {
                                                                    // Kirim data ke server bahwa simulasi selesai
                                                                    fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                                                                            method: "POST",
                                                                            headers: {
                                                                                "Content-Type": "application/json",
                                                                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                            },
                                                                            body: JSON.stringify({
                                                                                kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                                                                                time: new Date()
                                                                            })
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            console.log('Simulasi selesai:', data);
                                                                        })
                                                                        .catch(error => {
                                                                            console.error('Error:', error);
                                                                        });

                                                                    // Tampilkan modal countdown
                                                                    const modal = document.getElementById('countdownEssayModal');
                                                                    const countdownText = document.getElementById('countdownEssayText');
                                                                    const countdownSeconds = document.getElementById('countdownEssaySeconds');

                                                                    modal.style.display = 'block';

                                                                    let countdown = 5;
                                                                    countdownSeconds.textContent = countdown;

                                                                    const interval = setInterval(() => {
                                                                        countdown--;
                                                                        countdownSeconds.textContent = countdown;

                                                                        if (countdown <= 0) {
                                                                            clearInterval(interval);
                                                                            window.location.href = "{{ url('siswa/ujian_kuesioner/' . $ujian) }}";
                                                                        }
                                                                    }, 1000);
                                                                }
                                                            </script>
                                                        @elseif($mergeUjian->jenis_ujian == 3)
                                                            <a href="{{ url('siswa/ujian_visual/' . $ujian) }}"
                                                                class="btn btn-warning">Mulai Ujian </a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function showNextInstruksi(currentIndex) {
                        document.getElementById('instruksi-' + currentIndex).style.display = 'none';
                        document.getElementById('instruksi-' + (currentIndex + 1)).style.display = 'block';
                    }

                    function showExampleQuestions() {
                        document.querySelectorAll('.instruksi').forEach(el => el.style.display = 'none');
                        document.querySelectorAll('.question').forEach(el => el.style.display = 'none');
                        document.getElementById('instruksi').style.display = 'none';
                        document.getElementById('showExampleQuestions').style.display = 'block';
                        document.getElementById('soalDemoSoal0').style.display = 'block';
                    }
                </script>


                {{-- {{dd($simulasiPg)}} --}}

                <!-- Tambahkan tombol Next di bawah banner -->
                <div class="container-fluid mt-3" id="showExampleQuestions" style="display: none;">
                    @if ($mergeUjian->jenis_ujian == 0)
                        <div class="col-lg-12">
                            <form id="examwizard-question" action="{{ url('/siswa/ujian') }}" method="POST">
                                @csrf

                                <div class="widget shadow p-2">

                                    <div>
                                        @php
                                            $no = 1;
                                            $soal_hidden = '';

                                        @endphp
                                        @foreach ($simulasiPg as $keySG => $itemSG)
                                            <div class="question {{ $soal_hidden }} question-{{ $no }}"
                                                id="soalDemoSoal{{ $keySG }}" data-question="{{ $no }}"
                                                style="{{ $keySG != 0 ? 'display:none;' : '' }}">
                                                <div class="widget-heading pl-2 pt-2"
                                                    style="border-bottom: 1px solid #e0e6ed;">
                                                    <div class="">
                                                        <h6 class="" style="font-weight: bold">Contoh Soal 

                                                        </h6>
                                                    </div>
                                                </div>

                                                <div class="widget p-3 mt-3">
                                                    <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed;">
                                                        <h6 class="question-title color-green"
                                                            style="word-wrap: break-word">
                                                            <center>
                                                                <img src="{{ url($itemSG->soal) }}" class="img-fluid"
                                                                    style="width: auto; height: 35vh;">
                                                            </center>

                                                        </h6>
                                                    </div>
                                                    <div class="widget-content mt-3" style="position: relative;">
                                                        <div class="alert alert-danger hidden"></div>
                                                        <div class="timer-check hidden"
                                                            style="position: absolute; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.5);">
                                                            <h5
                                                                style="display: flex; justify-content: center; align-items: center; margin-top: 60px;">
                                                                <span class="badge badge-danger">Waktu Habis!</span>
                                                            </h5>
                                                        </div>



                                                        <div class="green-radio color-green">
                                                            <div class="row answer-list">
                                                                <div
                                                                    class="@if ($mergeUjian->kode == 'part2') col @else col-md-4 @endif">
                                                                    <li class="answer-number d-flex align-items-center">
                                                                        <input type="radio"
                                                                            name="{{ $keySG }}simulasi_ujian"
                                                                            value="a"
                                                                            id="{{ $keySG }}soal{{ $no }}-A" />
                                                                        <label
                                                                            for="{{ $keySG }}soal{{ $no }}-A"
                                                                            class="d-flex align-items-center ml-2">
                                                                            <span>A </span>
                                                                            <img src="{{ url($itemSG->pg_1) }}"
                                                                                alt=""
                                                                                style="width: auto; height: 15vh; margin-left: 10px;">
                                                                        </label>
                                                                    </li>
                                                                </div>
                                                                <div
                                                                    class="@if ($mergeUjian->kode == 'part2') col @else col-md-4 @endif">
                                                                    <li class="answer-number d-flex align-items-center">
                                                                        <input type="radio"
                                                                            name="{{ $keySG }}simulasi_ujian"
                                                                            value="b"
                                                                            id="{{ $keySG }}soal{{ $no }}-B" />
                                                                        <label
                                                                            for="{{ $keySG }}soal{{ $no }}-B"
                                                                            class="d-flex align-items-center ml-2">
                                                                            <span>B</span>
                                                                            <img src="{{ url($itemSG->pg_2) }}"
                                                                                alt=""
                                                                                style="width: auto; height: 15vh; margin-left: 10px;">
                                                                        </label>
                                                                    </li>
                                                                </div>
                                                                <div
                                                                    class="@if ($mergeUjian->kode == 'part2') col @else col-md-4 @endif">
                                                                    <li class="answer-number d-flex align-items-center">
                                                                        <input type="radio"
                                                                            name="{{ $keySG }}simulasi_ujian"
                                                                            value="c"
                                                                            id="{{ $keySG }}soal{{ $no }}-C" />
                                                                        <label
                                                                            for="{{ $keySG }}soal{{ $no }}-C"
                                                                            class="d-flex align-items-center ml-2">
                                                                            <span>C</span>
                                                                            <img src="{{ url($itemSG->pg_3) }}"
                                                                                alt=""
                                                                                style="width: auto; height: 15vh; margin-left: 10px;">
                                                                        </label>
                                                                    </li>
                                                                </div>
                                                                <div
                                                                    class="@if ($mergeUjian->kode == 'part2') col @else col-md-4 @endif">
                                                                    <li class="answer-number d-flex align-items-center">
                                                                        <input type="radio"
                                                                            name="{{ $keySG }}simulasi_ujian"
                                                                            value="d"
                                                                            id="{{ $keySG }}soal{{ $no }}-D" />
                                                                        <label
                                                                            for="{{ $keySG }}soal{{ $no }}-D"
                                                                            class="d-flex align-items-center ml-2">
                                                                            <span>D</span>
                                                                            <img src="{{ url($itemSG->pg_4) }}"
                                                                                alt=""
                                                                                style="width: auto; height: 15vh; margin-left: 10px;">
                                                                        </label>
                                                                    </li>
                                                                </div>
                                                                <div
                                                                    class="@if ($mergeUjian->kode == 'part2') col @else col-md-4 @endif">
                                                                    <li class="answer-number d-flex align-items-center">
                                                                        <input type="radio"
                                                                            name="{{ $keySG }}simulasi_ujian"
                                                                            value="e"
                                                                            id="{{ $keySG }}soal{{ $no }}-E" />
                                                                        <label
                                                                            for="{{ $keySG }}soal{{ $no }}-E"
                                                                            class="d-flex align-items-center ml-2">
                                                                            <span>E</span>
                                                                            <img src="{{ url($itemSG->pg_5) }}"
                                                                                alt=""
                                                                                style="width: auto; height: 15vh; margin-left: 10px;">
                                                                        </label>
                                                                    </li>
                                                                </div>
                                                                @if ($itemSG->pg_6)
                                                                    <div
                                                                        class="@if ($mergeUjian->kode == 'part2') col @else col-md-4 @endif">
                                                                        <li
                                                                            class="answer-number d-flex align-items-center">
                                                                            <input type="radio"
                                                                                name="{{ $keySG }}simulasi_ujian"
                                                                                value="f"
                                                                                id="{{ $keySG }}soal{{ $no }}-F" />
                                                                            <label
                                                                                for="{{ $keySG }}soal{{ $no }}-F"
                                                                                class="d-flex align-items-center ml-2">
                                                                                <span>F</span>
                                                                                <img src="{{ url($itemSG->pg_6) }}"
                                                                                    alt=""
                                                                                    style="width: auto; height: 15vh; margin-left: 10px;">
                                                                            </label>
                                                                        </li>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="checkAnswer({{ $keySG }},{{ $no }}, '{{ $itemSG->jawaban }}',{{ count($simulasiPg) }})">Submit
                                                                <div id="jam"></div>
                                                            </button>
                                                            <p id="{{ $keySG }}result-{{ $no }}"
                                                                style="font-weight: bold; color: red;"></p>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                        @php
                                            $soal_hidden = 'hidden';
                                            $no++;
                                        @endphp

                                    </div>
                                    <!-- SOAL -->

                                    <!-- END SOAL -->
                                </div>
                            </form>



                        </div>

                        <!-- Modal Countdown -->
                        <div class="modal" id="countdownModal" tabindex="-1"
                            style="display: none; background: rgba(0,0,0,0.7); position: fixed; top: 0; left:0; width:100%; height:100%; z-index: 1050;">
                            <div
                                style="margin: 20% auto; background: white; padding: 20px; max-width: 400px; text-align: center; border-radius: 10px;">
                                <h4>Simulasi selesai!</h4>
                                <p id="countdownText">Halaman akan dialihkan dalam <span id="countdownSeconds">5</span>
                                    detik...</p>
                            </div>
                        </div>


                        <script>
                            function checkAnswer(keySG, questionNumber, correctAnswer, totalSoal) {
                                const radios = document.getElementsByName(keySG + 'simulasi_ujian');
                                let selectedValue = null;

                                for (const radio of radios) {
                                    if (radio.checked) {
                                        selectedValue = radio.value;
                                        break;
                                    }
                                }

                                const resultElement = document.getElementById(keySG + `result-${questionNumber}`);

                                if (selectedValue) {
                                    if (selectedValue.toLowerCase() === correctAnswer.toLowerCase()) {
                                        resultElement.textContent = 'Jawaban Anda Benar!';
                                        resultElement.style.color = 'green';

                                        let nextQuestion = keySG + 1;

                                        if (nextQuestion == totalSoal) {
                                            // Simulasi selesai
                                            fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                                                    method: "POST",
                                                    headers: {
                                                        "Content-Type": "application/json",
                                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                            'content')
                                                    },
                                                    body: JSON.stringify({
                                                        kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                                                        time: new Date()
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log('Simulasi selesai:', data);
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                });

                                            // Tampilkan modal
                                            const modal = document.getElementById('countdownModal');
                                            const countdownText = document.getElementById('countdownText');
                                            const countdownSeconds = document.getElementById('countdownSeconds');
                                            modal.style.display = 'block';

                                            let countdown = 5;
                                            countdownSeconds.textContent = countdown;

                                            const interval = setInterval(() => {
                                                countdown--;
                                                countdownSeconds.textContent = countdown;
                                                if (countdown <= 0) {
                                                    clearInterval(interval);
                                                    window.location.href = "{{ url('siswa/ujian/' . $ujian) }}";
                                                }
                                            }, 1000);
                                        } else {
                                            setTimeout(() => {
                                                for (let index = 0; index < totalSoal; index++) {
                                                    document.getElementById('soalDemoSoal' + index).style.display = "none";
                                                }
                                                document.getElementById('soalDemoSoal' + nextQuestion).style.display = "block";
                                            }, 1000);
                                        }
                                    } else {
                                        resultElement.textContent = 'Jawaban Anda Salah! Jawaban yang benar adalah ' + correctAnswer
                                            .toUpperCase();
                                        resultElement.style.color = 'red';
                                    }
                                } else {
                                    resultElement.textContent = 'Silakan pilih jawaban terlebih dahulu.';
                                    resultElement.style.color = 'orange';
                                }
                            }
                        </script>
                    @elseif($mergeUjian->jenis_ujian == 1)
                        @foreach ($simulasiEssay as $keySG => $sv)
                            <div class="question " id="soalDemoSoal{{ $keySG }}">
                                <div class="widget p-3 mt-3">
                                    <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                        <div class="">
                                            <h6 class="" style="font-weight: bold">Contoh Soal 
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="widget-content mt-3" style="position: relative;">
                                        <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed;">
                                            <h6 class="question-title color-green" style="word-wrap: break-word">
                                                {!! $sv->soal !!}
                                            </h6>
                                        </div>
                                        <div class="timer-check hidden"
                                            style="position: absolute; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.5);">
                                            <h5
                                                style="display: flex; justify-content: center; align-items: center; margin-top: 60px;">
                                                <span class="badge badge-danger">Waktu Habis!</span>
                                            </h5>
                                        </div>
                                        <div class="row"></div>
                                        <div class="green-radio color-green">
                                            <input type="text" name="{{ $keySG }}simulasi_ujian"
                                                class="form-control">
                                            <button type="button" class="btn btn-primary mt-2"
                                                onclick="checkJawabanEssay({{ count($simulasiEssay) }},{{ $keySG }},1, ['{{ $sv->jawaban }}'])">Submit
                                            </button>
                                            <p id="{{ $keySG }}result-1" style="font-weight: bold; color: red;">
                                            </p>
                                            <p id="{{ $keySG }}validation-1"
                                                style="font-weight: bold; color: orange;">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function checkJawabanEssay(count, keySG, no, correctAnswers) {
                                    const input = document.querySelector(`input[name='${keySG}simulasi_ujian']`);
                                    const resultElement = document.getElementById(`${keySG}result-1`);
                                    const validationElement = document.getElementById(`${keySG}validation-1`);
                                    // alert(correctAnswers);
                                    if (!input.value.trim()) {
                                        validationElement.innerText = "Jawaban tidak boleh kosong.";
                                        return;
                                    } else {
                                        validationElement.innerText = "";
                                    }

                                    if (correctAnswers.map(answer => answer.toLowerCase()).includes(input.value.toLowerCase())) {
                                        resultElement.innerText = "Jawaban Benar!";
                                        resultElement.style.color = "green";
                                        if (keySG == count - 1) {
                                            fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                                                    method: "POST",
                                                    headers: {
                                                        "Content-Type": "application/json",
                                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                            'content')
                                                    },
                                                    body: JSON.stringify({
                                                        kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                                                        time: new Date()
                                                    })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log('Simulasi selesai:', data);
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                });

                                            let countdown = 5;
                                            resultElement.textContent = `Simulasi selesai! Halaman akan dialihkan dalam ${countdown} detik...`
                                                .toUpperCase();
                                            resultElement.style.color = 'green';
                                            const interval = setInterval(() => {
                                                countdown--;
                                                resultElement.textContent =
                                                    `Simulasi selesai! Halaman akan dialihkan dalam ${countdown} detik...`.toUpperCase();
                                                if (countdown === 0) {
                                                    clearInterval(interval);
                                                    // alert("Waktu sekarang: " + new Date().toLocaleString());
                                                    // window.location.href = "{{ url('siswa/ujian_visual/' . $ujian) }}";
                                                    window.location.href = "{{ url('siswa/ujian_essay/' . $ujian) }}";
                                                }
                                            }, 1000);
                                        } else {
                                            setTimeout(() => {
                                                document.getElementById('soalDemoSoal' + keySG).style.display = "none";
                                                document.getElementById('soalDemoSoal' + (keySG + 1)).style.display = "block";
                                            }, 1000);
                                        }
                                    } else {
                                        resultElement.innerText = "Jawaban Salah. Jawaban yang benar adalah " + correctAnswers.join(' dan ');
                                        resultElement.style.color = "red";
                                    }
                                }
                            </script>
                        @endforeach
                        <script>
                            function checkAnswers(count, keySG, no, correctAnswers) {
                                // Ambil semua checkbox yang dipilih untuk pertanyaan ini
                                const selected = document.querySelectorAll(`input[name='${keySG}simulasi_ujian[]']:checked`);
                                console.log(selected);

                                // Ambil nilai dari checkbox yang dipilih
                                const selectedValues = Array.from(selected).map(input => input.value);

                                // Cek apakah jumlah jawaban yang dipilih adalah 2
                                if (selectedValues.length !== 2) {
                                    const resultElement = document.getElementById(`${keySG}result-${no}`);
                                    resultElement.innerText = "Anda harus memilih 2 jawaban.";
                                    resultElement.style.color = "red";
                                    return;
                                }

                                // console.log(selectedValues);
                                // Cek apakah kedua jawaban sesuai dengan kunci jawaban
                                const isCorrect = correctAnswers.every(answer => selectedValues.includes(answer));
                                const resultElement = document.getElementById(`${keySG}result-${no}`);

                                if (isCorrect) {
                                    resultElement.innerText = "Jawaban Benar!";
                                    resultElement.style.color = "green";
                                    if (keySG == count - 1) {
                                        fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                        'content')
                                                },
                                                body: JSON.stringify({
                                                    kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                                                    time: new Date()
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                console.log('Simulasi selesai:', data);
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                            });
                                        resultElement.textContent = 'Simulasi selesai!'
                                            .toUpperCase();
                                        resultElement.style.color = 'green';
                                        setTimeout(() => {
                                            window.location.href = "{{ url('siswa/ujian_visual/' . $ujian) }}";
                                        }, 1000);

                                    } else {
                                        setTimeout(() => {
                                            document.getElementById('soalDemoSoal' + keySG).style.display = "none";
                                            document.getElementById('soalDemoSoal' + (keySG + 1)).style.display = "block";
                                        }, 1000);
                                    }

                                } else {
                                    resultElement.innerText = "Jawaban Salah. Jawaban yang benar adalah " + correctAnswers.join(' dan ');
                                    resultElement.style.color = "red";
                                }
                            }
                        </script>
                    @elseif($mergeUjian->jenis_ujian == 3)
                        @foreach ($simulasiVisual as $keySG => $sv)
                            <div class="question " id="soalDemoSoal{{ $keySG }}"
                                style="{{ $keySG != 0 ? 'display:none;' : '' }}">
                                <div class="widget p-3 mt-3">
                                    <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                        <div class="">
                                            <h6 class="" style="font-weight: bold">Contoh Soal 
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="widget-content mt-3" style="position: relative;">
                                        <div class="alert alert-danger hidden"></div>
                                        <div class="timer-check hidden"
                                            style="position: absolute; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.5);">
                                            <h5
                                                style="display: flex; justify-content: center; align-items: center; margin-top: 60px;">
                                                <span class="badge badge-danger">Waktu Habis!</span>
                                            </h5>
                                        </div>
                                        <div class="row"></div>
                                        <div class="green-radio color-green">
                                            <ol type="A" class="answer-list">
                                                @foreach (range(1, 5) as $i)
                                                    <li class="answer-item">
                                                        <input type="checkbox" name="{{ $keySG }}simulasi_ujian[]"
                                                            value="{{ chr(64 + $i) }}"
                                                            id="{{ $keySG }}soal1-{{ chr(64 + $i) }}" />

                                                        <label for="{{ $keySG }}soal1-{{ chr(64 + $i) }}"
                                                            class="answer-text">
                                                            {{ chr(64 + $i) }}.
                                                            <span>
                                                                <img src="{{ url($sv->{'pg_' . $i}) }}" width="40%"
                                                                    alt="">
                                                            </span>
                                                        </label>

                                                    </li>
                                                @endforeach
                                            </ol>
                                            <button type="button" class="btn btn-primary"
                                                onclick="checkAnswers({{ count($simulasiVisual) }},{{ $keySG }},1, ['{{ $sv->jawaban_1 }}', '{{ $sv->jawaban_2 }}'])">Submit
                                            </button>
                                            <p id="{{ $keySG }}result-1" style="font-weight: bold; color: red;">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Modal Countdown -->
                        <div class="modal" id="countdownModal"
                            style="display: none; position: fixed; z-index: 9999; background: rgba(0,0,0,0.7); top: 0; left: 0; width: 100%; height: 100%;">
                            <div
                                style="background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: 20% auto; text-align: center;">
                                <h4>Simulasi selesai!</h4>
                                <p id="countdownText">Halaman akan dialihkan dalam <span id="countdownSeconds">5</span>
                                    detik...</p>
                            </div>
                        </div>

                        <script>
                            function checkAnswers(count, keySG, no, correctAnswers) {
                                const selected = document.querySelectorAll(`input[name='${keySG}simulasi_ujian[]']:checked`);
                                const selectedValues = Array.from(selected).map(input => input.value);
                                const resultElement = document.getElementById(`${keySG}result-${no}`);

                                if (selectedValues.length !== 2) {
                                    resultElement.innerText = "Anda harus memilih 2 jawaban.";
                                    resultElement.style.color = "red";
                                    return;
                                }

                                const isCorrect = correctAnswers.every(answer => selectedValues.includes(answer));

                                if (isCorrect) {
                                    resultElement.innerText = "Jawaban Benar!";
                                    resultElement.style.color = "green";

                                    if (keySG == count - 1) {
                                        // Simulasi selesai - kirim data ke server
                                        fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                        'content')
                                                },
                                                body: JSON.stringify({
                                                    kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                                                    time: new Date()
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                console.log('Simulasi selesai:', data);
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                            });

                                        // Tampilkan modal countdown
                                        const modal = document.getElementById('countdownModal');
                                        const countdownSeconds = document.getElementById('countdownSeconds');
                                        modal.style.display = 'block';

                                        let countdown = 5;
                                        countdownSeconds.textContent = countdown;

                                        const interval = setInterval(() => {
                                            countdown--;
                                            countdownSeconds.textContent = countdown;
                                            if (countdown === 0) {
                                                clearInterval(interval);
                                                window.location.href = "{{ url('siswa/ujian_visual/' . $ujian) }}";
                                            }
                                        }, 1000);

                                    } else {
                                        // Pindah ke soal berikutnya setelah 1 detik
                                        setTimeout(() => {
                                            document.getElementById('soalDemoSoal' + keySG).style.display = "none";
                                            document.getElementById('soalDemoSoal' + (keySG + 1)).style.display = "block";
                                        }, 1000);
                                    }

                                } else {
                                    resultElement.innerText = "Jawaban Salah. Jawaban yang benar adalah " + correctAnswers.join(' dan ');
                                    resultElement.style.color = "red";
                                }
                            }
                        </script>
                    @endif

                </div>
            @else
                {{-- <h1 class="text-center">Selesai</h1>
                <div class="text-center">

                    <a href="{{ url('/siswa') }}" class="btn btn-primary">Dashboard</a>
                </div> --}}
            @endif
            {{-- </div> --}}
        </div>
    </div>
    <!--  END CONTENT AREA  -->
@endsection
