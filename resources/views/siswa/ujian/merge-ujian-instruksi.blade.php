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

                <div class="container-fluid mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-12 mb-2">
                            <div class="card text-white shadow h-100"
                                style="background: linear-gradient(to bottom, #1e3c72, #2a5298); border: none;">
                                <div class="card-body text-center d-flex flex-column justify-content-center">
                                    <!-- Menampilkan instruksi -->
                                    @foreach ($IntruksiUjian as $intr)
                                        <h2 class="card-title" style="color: yellow; font-size: 40px; font-weight: bold;">
                                            {{ $intr->label }}
                                        </h2>
                                        <p class="card-text" style="color: white; font-size: 30px; font-weight: bold;">
                                            {!! $intr->intruksi !!}
                                        </p>
                                    @endforeach

                                    <!-- Tombol Next berdasarkan jenis ujian -->
                                    @if ($mergeUjian->jenis_ujian == 1)
                                        <a href="{{ url('siswa/ujian_essay/' . $ujian) }}"
                                            class="btn btn-warning mt-3 btn-next">
                                            Next
                                        </a>
                                    @elseif($mergeUjian->jenis_ujian == 2)
                                        <a href="{{ url('siswa/ujian_kuesioner/' . $ujian) }}"
                                            class="btn btn-warning mt-3 btn-next">
                                            Next
                                        </a>
                                    @else
                                        @if (empty($IntruksiUjian) && !in_array($mergeUjian->jenis_ujian, [1, 2, 3]))
                                            <div class="card text-white shadow mt-3 h-100"
                                                style="background: linear-gradient(to bottom, #1e3c72, #2a5298); border: none;">
                                                <div
                                                    class="card-body text-center d-flex flex-column justify-content-center">
                                                    <h1 class="card-title"
                                                        style="color: yellow; font-size: 40px; font-weight: bold;">
                                                        Selamat!
                                                    </h1>
                                                    <h3 class="card-title"
                                                        style="color: yellow; font-size: 40px; font-weight: bold;">
                                                        TERIMA KASIH
                                                    </h3>
                                                    <p class="text-white-75 mb-5">Anda telah menyelesaikan test ini!
                                                    </p>
                                                    <a href="{{ url('/siswa') }}" class="btn btn-warning btn-next">
                                                        Dashboard
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Tambahkan tombol Next di bawah banner -->
                <div class="container-fluid mt-3">
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
                                                id="soalDemoSoal{{$keySG}}" data-question="{{ $no }}"
                                                style="{{ $keySG != 0 ? 'display:none;' : '' }}">
                                                <div class="widget-heading pl-2 pt-2"
                                                    style="border-bottom: 1px solid #e0e6ed;">
                                                    <div class="">
                                                        <h6 class="" style="font-weight: bold">Demo Soal
                                                            soalDemoSoal{{ $keySG }}
                                                        </h6>
                                                    </div>
                                                </div>

                                                <div class="widget p-3 mt-3">
                                                    <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed;">
                                                        <h6 class="question-title color-green"
                                                            style="word-wrap: break-word">
                                                            <center>
                                                                <img src="{{ url($itemSG->soal) }}" class="img-fluid"
                                                                    width="50%">
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
                                                            <ol type="A" class="answer-list">
                                                                <li class="answer-item">
                                                                    <input type="radio" data-alternatetype="radio"
                                                                        name="{{ $keySG }}simulasi_ujian"
                                                                        value="a"
                                                                        id="{{ $keySG }}soal{{ $no }}-A"
                                                                        data-pg_siswa=""
                                                                        data-noSoal="{{ $no }}" />
                                                                    <label
                                                                        for="{{ $keySG }}soal{{ $no }}-A"
                                                                        class="answer-text">
                                                                        A.<span><img src="{{ url($itemSG->pg_1) }}"
                                                                                width="100" alt=""></span>
                                                                    </label>
                                                                </li>
                                                                <li class="answer-item">
                                                                    <input type="radio" data-alternatetype="radio"
                                                                        name="{{ $keySG }}simulasi_ujian"
                                                                        value="b"
                                                                        id="{{ $keySG }}soal{{ $no }}-B"
                                                                        data-pg_siswa=""
                                                                        data-noSoal="{{ $no }}" />
                                                                    <label
                                                                        for="{{ $keySG }}soal{{ $no }}-B"
                                                                        class="answer-text">
                                                                        B. <span><img src="{{ url($itemSG->pg_2) }}"
                                                                                width="100" alt=""></span>
                                                                    </label>
                                                                </li>
                                                                <li class="answer-item">
                                                                    <input type="radio" data-alternatetype="radio"
                                                                        name="{{ $keySG }}simulasi_ujian"
                                                                        value="c"
                                                                        id="{{ $keySG }}soal{{ $no }}-C"
                                                                        data-pg_siswa=""
                                                                        data-noSoal="{{ $no }}" />
                                                                    <label
                                                                        for="{{ $keySG }}soal{{ $no }}-C"
                                                                        class="answer-text">
                                                                        C. <span><img src="{{ url($itemSG->pg_3) }}"
                                                                                width="100" alt=""></span>
                                                                    </label>
                                                                </li>
                                                                <li class="answer-item">
                                                                    <input type="radio" data-alternatetype="radio"
                                                                        name="{{ $keySG }}simulasi_ujian"
                                                                        value="d"
                                                                        id="{{ $keySG }}soal{{ $no }}-D"
                                                                        data-pg_siswa=""
                                                                        data-noSoal="{{ $no }}" />
                                                                    <label
                                                                        for="{{ $keySG }}soal{{ $no }}-D"
                                                                        class="answer-text">
                                                                        D. <span><img src="{{ url($itemSG->pg_4) }}"
                                                                                width="100" alt=""></span>
                                                                    </label>
                                                                </li>
                                                                <li class="answer-item">
                                                                    <input type="radio" data-alternatetype="radio"
                                                                        name="{{ $keySG }}simulasi_ujian"
                                                                        value="e"
                                                                        id="{{ $keySG }}soal{{ $no }}-E"
                                                                        data-pg_siswa=""
                                                                        data-noSoal="{{ $no }}" />
                                                                    <label
                                                                        for="{{ $keySG }}soal{{ $no }}-E"
                                                                        class="answer-text">
                                                                        E. <span><img src="{{ url($itemSG->pg_5) }}"
                                                                                width="100" alt=""></span>
                                                                    </label>
                                                                </li>
                                                                @if($itemSG->pg_6)
                                                                <li class="answer-item">
                                                                    <input type="radio" data-alternatetype="radio"
                                                                        name="{{ $keySG }}simulasi_ujian"
                                                                        value="f"
                                                                        id="{{ $keySG }}soal{{ $no }}-F"
                                                                        data-pg_siswa=""
                                                                        data-noSoal="{{ $no }}" />
                                                                    <label
                                                                        for="{{ $keySG }}soal{{ $no }}-F"
                                                                        class="answer-text">
                                                                        F. <span><img src="{{ url($itemSG->pg_6) }}"
                                                                                width="100" alt=""></span>
                                                                    </label>
                                                                </li>
                                                                @endif
                                                            </ol>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="checkAnswer({{ $keySG }},{{ $no }}, '{{ $itemSG->jawaban }}',{{ count($simulasiPg) }})">Submit</button>
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



                        <script>
                            function checkAnswer(keySG, questionNumber, correctAnswer, totalSoal) {
                                console.log(keySG, questionNumber, correctAnswer, totalSoal);

                                // Mendapatkan semua input radio berdasarkan nama
                                const radios = document.getElementsByName(keySG + 'simulasi_ujian');
                                let selectedValue = null;

                                // Iterasi untuk menemukan pilihan yang dipilih
                                for (const radio of radios) {
                                    if (radio.checked) {
                                        selectedValue = radio.value;
                                        break;
                                    }
                                }

                                // Memeriksa jawaban
                                const resultElement = document.getElementById(keySG + `result-${questionNumber}`);
                                if (selectedValue) {
                                    if (selectedValue.toLowerCase() === correctAnswer.toLowerCase()) {
                                        resultElement.textContent = 'Jawaban Anda Benar!';
                                        resultElement.style.color = 'green';

                                 
                                        let nextQuestion = keySG + 1;


                                        if (nextQuestion == totalSoal) {
                                            resultElement.textContent = 'Simulasi selesai!'
                                                .toUpperCase();
                                            resultElement.style.color = 'green';
                                            setTimeout(() => {
                                                window.location.href = "{{ url('siswa/ujian/' . $ujian) }}";
                                            }, 1000);

                                        } else {
                                            resultElement.textContent = 'Jawaban Anda Benar!'
                                                .toUpperCase();
                                            resultElement.style.color = 'green';
                                            setTimeout(() => {

                                                for (let index = 0; index < totalSoal; index++) { 
                                                    console.log('soalDemoSoal' + index);
                                                    
                                                    document.getElementById('soalDemoSoal' + index).style.display = "none";
                                                }
 
                                                document.getElementById('soalDemoSoal'+nextQuestion).style.display = "block";
                                            }, 1000);

                                        }
                                        // window.location.href = "{{ url('siswa/ujian/' . $ujian) }}";
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
                    @elseif($mergeUjian->jenis_ujian == 3)
                        @foreach ($simulasiVisual as $keySG => $sv)
                            <div class="question " id="soalDemoSoal{{ $keySG }}"
                                style="{{ $keySG != 0 ? 'display:none;' : '' }}">
                                <div class="widget p-3 mt-3">
                                    <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                        <div class="">
                                            <h6 class="" style="font-weight: bold">Demo Soal
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
                                                                <img src="{{ url($sv->{'pg_' . $i}) }}" width="100"
                                                                    alt="">
                                                            </span>
                                                        </label>

                                                    </li>
                                                @endforeach
                                            </ol>
                                            <button type="button" class="btn btn-primary"
                                                onclick="checkAnswers({{ count($simulasiVisual) }},{{ $keySG }},1, ['{{ $sv->jawaban_1 }}', '{{ $sv->jawaban_2 }}'])">Submit</button>
                                            <p id="{{ $keySG }}result-1" style="font-weight: bold; color: red;">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
