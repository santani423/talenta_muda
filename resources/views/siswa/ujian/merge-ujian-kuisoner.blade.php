@extends('template.mainUjian')
@section('content')
    <style>
        .btn-white {
            background: #cacaca;
            color: #fff;
        }

        .hidden {
            display: none !important;
        }

        #fixed-timer {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 9999;
            background-color: #d9534f; /* Diubah ke merah agar memberikan kesan kritis saat waktu mau habis */
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            display: none;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fixed Countdown Timer -->
    <div id="fixed-timer">
        <span data-feather="clock"></span> <span class="jam_ujin_skearan">00:00:00</span>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form id="examwizard-question" action="{{ url('/siswa/ujian_kuesioner') }}" method="POST">
                @csrf
                <input type="hidden" name="kode" value="{{ $ujian->kode }}">
                <input type="hidden" name="kode_merge_ujian" value="{{ $kode_merge_ujian }}">
                <div class="widget shadow p-2">

                    <div>
                        @php
                            $no = 1;
                            $noSoal = 1;
                            $soal_hidden = '';
                        @endphp
                        @foreach ($detail_siswa as $kuisoner)
                            <div class="question {{ $soal_hidden }} question-{{ $no }}" data-question="{{ $no }}">
                                <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                    <h6 style="font-weight: bold">Soal No. <span class="badge badge-primary no-soal" style="font-size: 1rem">{{ $no }}</span></h6>
                                </div>

                                <div class="widget p-3 mt-3">
                                    <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed; max-width: 100%; overflow-x: auto;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Pernyataan</th>
                                                    <th scope="col" colspan="2">Pilihan Anda</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kuisoner as $ku)
                                                    <tr>
                                                        <th scope="row">{{ $noSoal }}</th>
                                                        <td>{!! $ku['soal'] !!}</td>
                                                        <td>
                                                            <div class="row">
                                                                @foreach ($ku['detail_jawaban_kuisoner'] as $djk)
                                                                    <div class="col-md-2 mr-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="jawaban_{{ $ku['id'] }}"
                                                                                id="jawaban_{{ $noSoal }}_{{ $loop->index }}"
                                                                                value="{{ $djk['id'] }}">
                                                                            <label class="form-check-label" for="jawaban_{{ $noSoal }}_{{ $loop->index }}">
                                                                                {{ $djk['kode'] }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php $noSoal++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @php
                                $soal_hidden = 'hidden';
                                $no++;
                            @endphp
                        @endforeach
                    </div>

                    <input type="hidden" value="1" id="currentQuestionNumber" name="currentQuestionNumber" />
                    <input type="hidden" value="{{ count($detail_siswa) }}" id="totalOfQuestion" name="totalOfQuestion" />
                    <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12 exams-footer">
                    <div class="row pb-3">
                        <div class="col-sm-1 back-to-prev-question-pg-wrapper text-center mt-3">
                            <a href="javascript:void(0);" id="back-to-prev-question-pg" class="btn btn-primary disabled">
                                Back
                            </a>
                        </div>
                        <div class="col-sm-2 footer-question-number-wrapper text-center mt-3">
                            <div>
                                <span id="current-question-number-label">1</span>
                                <span>Dari <b>{{ count($detail_siswa) }}</b></span>
                            </div>
                            <div>Nomor Soal</div>
                        </div>
                        <div class="col-sm-1 go-to-next-question-pg-wrapper text-center mt-3">
                            <a href="javascript:void(0);" id="go-to-next-question-pg" class="btn btn-primary">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var currentQuestionNumber = 1;
            var totalOfQuestion = parseInt($('#totalOfQuestion').val()) || 1;

            // ==========================================
            // LOGIKA TIMER (MUNCUL 10 DETIK TERAKHIR)
            // ==========================================
            function startTimer(endDate, display) {
                const endDateUTCString = endDate; 
                console.log('1. Waktu Berakhir (Format UTC untuk JS):', endDateUTCString);

                const targetTime = new Date(endDateUTCString).getTime();
                console.log('2. Target Waktu (Objek Date Lokal):', new Date(endDateUTCString));
                
                let currentTime = new Date().getTime();
                let timeLeft = targetTime - currentTime;
                
                if (timeLeft <= 0) {
                    display.text("00:00:00");
                    alert("Waktu Ujian Habis");
                    $('#examwizard-question').submit();
                    return; 
                }

                const interval = setInterval(() => {
                    currentTime = new Date().getTime();
                    timeLeft = targetTime - currentTime;

                    if (timeLeft > 0) {
                        // KUNCI UTAMA: Hanya tampilkan (.fadeIn) di 10 detik terakhir (10000 ms)
                        if (timeLeft <= 10000) {
                            $('#fixed-timer').fadeIn();
                        } else {
                            $('#fixed-timer').fadeOut();
                        }

                        const totalSeconds = Math.floor(timeLeft / 1000);
                        const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                        const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                        const seconds = String(Math.floor(totalSeconds % 60)).padStart(2, '0');

                        display.text(`${hours}:${minutes}:${seconds}`);
                        
                    } else {
                        clearInterval(interval);
                        display.text("00:00:00");
                        alert("Waktu Ujian Habis");
                        $('#examwizard-question').submit();
                    }
                }, 1000);
            }

            // ==========================================
            // SYNC TIMER DENGAN SERVER VIA FETCH
            // ==========================================
            fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    kode_ujian: "{{ $mergeUjian->kode_ujian }}"
                })
            })
            .then(response => response.json())
            .then(data => {
                const batasWaktu = data?.waktu_berakhir || data?.request?.time;
                if (batasWaktu) {
                    const display = $('.jam_ujin_skearan');
                    startTimer(batasWaktu, display);
                }
            })
            .catch(error => {
                console.error('Error Sync Timer:', error);
            });

            // ==========================================
            // NAVIGASI TOMBOL NEXT DAN BACK
            // ==========================================
            $('#go-to-next-question-pg').on('click', function(e) {
                e.preventDefault();
                if (currentQuestionNumber < totalOfQuestion) {
                    currentQuestionNumber++;
                    showQuestion(currentQuestionNumber);
                } else {
                    $('#examwizard-question').submit();
                }
            });

            $('#back-to-prev-question-pg').on('click', function(e) {
                e.preventDefault();
                if (currentQuestionNumber > 1) {
                    currentQuestionNumber--;
                    showQuestion(currentQuestionNumber);
                }
            });

            function showQuestion(questionNumber) {
                $('.question').addClass('hidden');
                $('.question-' + questionNumber).removeClass('hidden');
                $('#current-question-number-label').text(questionNumber);
                $('#currentQuestionNumber').val(questionNumber);

                // Mengunci tombol back secara sistem & visual jika berada di nomor 1
                if (questionNumber === 1) {
                    $('#back-to-prev-question-pg').addClass('disabled').css('pointer-events', 'none');
                } else {
                    $('#back-to-prev-question-pg').removeClass('disabled').css('pointer-events', 'auto');
                }
            }

            // ==========================================
            // VALIDASI CHEKBOX MAKSIMAL 2 PILIHAN
            // ==========================================
            $('.answer-checkbox').on('change', function() {
                var checkedBoxes = $(this).closest('.question').find('.answer-checkbox:checked');
                if (checkedBoxes.length > 2) {
                    $(this).prop('checked', false);
                    alert("Anda hanya dapat memilih maksimal dua jawaban.");
                }
            });

            // Inisialisasi tampilan pertama
            showQuestion(currentQuestionNumber);
        });
    </script>
@endsection