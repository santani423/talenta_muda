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

        .timer-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background-color: #d9534f; /* Warna merah mencolok untuk fase kritis 10 detik terakhir */
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            display: none; /* Default disembunyikan total */
        }

        .timer-fixed.show {
            display: block !important; /* Hanya muncul ketika class .show ditambahkan */
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TIMER -->
    <div class="d-flex timer-fixed hidden" id="countdown-timer">
        <div class="badge badge-danger" style="font-size: 18px; font-weight: bold; background: none; border: none;">
            <span data-feather="clock"></span> <span class="jam_ujin_skearan">00:00:00</span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form id="examwizard-question" action="{{ url('/siswa/ujian_visual') }}" method="POST">
                @csrf
                <input type="hidden" name="kode" value="{{ $ujian->kode_ujian }}">
                <input type="hidden" name="kode_merge_ujian" value="{{ $kode_merge_ujian }}">
                <div class="widget shadow p-2">

                    <div>
                        @php
                            $no = 1;
                            $soal_hidden = '';
                        @endphp
                        @foreach ($visual_siswa as $i => $soal)
                            <div class="question {{ $soal_hidden }} question-{{ $no }}"
                                data-question="{{ $no }}">
                                <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                    <h6 style="font-weight: bold">Soal No. <span class="badge badge-primary no-soal"
                                            style="font-size: 1rem">{{ $no }}</span></h6>
                                </div>

                                <div class="widget p-3 mt-3">
                                    <div class="widget-heading"
                                        style="border-bottom: 1px solid #e0e6ed; max-width: 100%; overflow-x: auto;">
                                        <h6 class="question-title color-green" style="white-space: nowrap;">
                                            {{-- {!! $soal->detailVisual->soal !!} --}}
                                        </h6>
                                    </div>

                                    <div class="widget-content mt-3">
                                        <div class="alert alert-danger hidden"></div>
                                        <div class="green-checkbox color-green">
                                            <ol type="A" style="color: #000; margin-left: -20px; list-style-type: none;">
                                                <div class="row">
                                                    @for ($j = 1; $j <= 5; $j++)
                                                        @php
                                                            $pg = 'pg_' . $j;
                                                            $checked = in_array($soal->jawaban, [
                                                                $soal->detailVisual->$pg,
                                                            ])
                                                                ? 'checked'
                                                                : '';
                                                        @endphp
                                                        <div class="col-md-6 col-lg-6 answer-number mt-2">
                                                            <input type="checkbox"
                                                                name="pilihan-{{ $soal->detailVisual->id }}[]"
                                                                value="{{ chr(64 + $j) }}"
                                                                id="soal{{ $no }}-{{ $j }}"
                                                                {{ $checked }} class="answer-checkbox" />
                                                            <label
                                                                for="soal{{ $no }}-{{ $j }}"
                                                                style="cursor: pointer;" class="ml-2">
                                                                <b>{{ chr(64 + $j) }}.</b>
                                                                <img src="{{ url($soal->detailVisual->$pg) }}"
                                                                    alt="Option {{ chr(64 + $j) }}" width="40%"
                                                                    class="img-fluid ml-2">
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </ol>
                                        </div>
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
                    <input type="hidden" value="{{ $visual_siswa->count() }}" id="totalOfQuestion"
                        name="totalOfQuestion" />
                    <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12 exams-footer">
                    <div class="row pb-3">
                        <div class="col-sm-1 back-to-prev-question-pg-wrapper text-center mt-3">
                            <a href="javascript:void(0);" id="back-to-prev-question-pg"
                                class="btn btn-primary disabled" style="pointer-events: none;">Back</a>
                        </div>

                        <div class="col-sm-2 footer-question-number-wrapper text-center mt-3">
                            <div>
                                <span id="current-question-number-label">1</span>
                                <span>Dari <b>{{ $visual_siswa->count() }}</b></span>
                            </div>
                            <div>Nomor Soal</div>
                        </div>

                        <div class="col-sm-1 go-to-next-question-pg-wrapper text-center mt-3">
                            <a href="javascript:void(0);" id="go-to-next-question-pg" class="btn btn-primary">Next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let currentQuestionNumber = 1;
            let totalOfQuestion = parseInt($('#totalOfQuestion').val()) || 1;

            // ==========================================
            // LOGIK TIMER UTAMA
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
                        // KUNCI UTAMA: Hanya tampilkan (.addClass('show')) jika sisa waktu <= 10 detik (10000 ms)
                        if (timeLeft <= 10000) {
                            $('#countdown-timer').addClass('show');
                        } else {
                            $('#countdown-timer').removeClass('show'); // Pastikan tetap tersembunyi jika di atas 10 detik
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
            // FETCH SINKRONISASI TIMER KE SERVER
            // ==========================================
            fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                    time: (() => {
                        const now = new Date();
                        const offset = now.getTimezoneOffset() * 60000; 
                        const localISOTime = new Date(now.getTime() - offset).toISOString().slice(0, -1);
                        return localISOTime;
                    })()
                })
            })
            .then(response => response.json())
            .then(data => {
                const batasWaktu = data.waktu_berakhir || (data.request && data.waktu_berakhir);
                if (batasWaktu) {
                    const display = $('.jam_ujin_skearan');
                    startTimer(batasWaktu, display);
                } else {
                    useFallbackTimer();
                }
            })
            .catch(error => {
                console.error('Error Sync Timer:', error);
                useFallbackTimer();
            });

            function useFallbackTimer() {
                const endDateFallback = "{{ $waktu_ujian->waktu_berakhir ?? '' }}";
                if (endDateFallback) {
                    const display = $('.jam_ujin_skearan');
                    startTimer(endDateFallback, display);
                }
            }

            // ==========================================
            // KONTROL NAVIGASI TOMBOL (ANTI-MACET)
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
                if (questionNumber < 1) questionNumber = 1;
                if (questionNumber > totalOfQuestion) questionNumber = totalOfQuestion;
                currentQuestionNumber = questionNumber;

                $('.question').addClass('hidden');
                $('.question-' + questionNumber).removeClass('hidden');
                
                $('#current-question-number-label').text(questionNumber);
                $('#currentQuestionNumber').val(questionNumber);
                
                if (questionNumber === 1) {
                    $('#back-to-prev-question-pg').addClass('disabled').css('pointer-events', 'none');
                } else {
                    $('#back-to-prev-question-pg').removeClass('disabled').css('pointer-events', 'auto');
                }
            }

            // ==========================================
            // BATASAN CHEKBOX JAWABAN (MAKSIMAL 2)
            // ==========================================
            $('.answer-checkbox').on('change', function() {
                const checkedBoxes = $(this).closest('.question').find('.answer-checkbox:checked');
                if (checkedBoxes.length > 2) {
                    $(this).prop('checked', false);
                    alert("Anda hanya dapat memilih maksimal dua jawaban.");
                }
            });

            showQuestion(currentQuestionNumber);
        });
    </script>
@endsection