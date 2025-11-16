@extends('template.mainUjian')
@section('content')
    <style>
        .btn-white {
            background: #cacaca;
            color: #fff;
        }

        .hidden {
            display: none;
        }

        .timer-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background-color: #1b55e2;
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            display: none;
        }

        .timer-fixed.show {
            display: block;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TIMER -->
    <div class="d-flex timer-fixed" id="countdown-timer">
        <div class="badge badge-primary" style="font-size: 18px; font-weight: bold;">
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
                                            <ol type="A" style="color: #000; margin-left: -20px;">
                                                <div class="row">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @php
                                                            $pg = 'pg_' . $i;
                                                            $checked = in_array($soal->jawaban, [
                                                                $soal->detailVisual->$pg,
                                                            ])
                                                                ? 'checked'
                                                                : '';
                                                        @endphp
                                                        <div class="col-md-6 col-lg-6 answer-number">
                                                            <input type="checkbox"
                                                                name="pilihan-{{ $soal->detailVisual->id }}[]"
                                                                value="{{ chr(64 + $i) }}"
                                                                id="soal{{ $no }}-{{ $soal->detailVisual->$pg }}"
                                                                {{ $checked }} class="answer-checkbox" />
                                                            <label
                                                                for="soal{{ $no }}-{{ $soal->detailVisual->$pg }}"
                                                                style="cursor: pointer;">
                                                                {{ chr(64 + $i) }}
                                                                <img src="{{ url($soal->detailVisual->$pg) }}"
                                                                    alt="Option {{ chr(64 + $i) }}" width="40%"
                                                                    class="img-fluid">
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
                                class="btn btn-primary disabled">Back</a>
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
            let totalOfQuestion = $('#totalOfQuestion').val();

            function startTimer(endDate, display) {
                const targetTime = new Date(endDate).getTime();
                const timerElement = $('#countdown-timer');

                // Pastikan timer tersembunyi di awal
                timerElement.hide();

                const interval = setInterval(() => {
                    const currentTime = new Date().getTime();
                    const timeLeft = targetTime - currentTime;

                    if (timeLeft > 0) {
                        const totalSeconds = Math.floor(timeLeft / 1000);
                        const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                        const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                        const seconds = String(totalSeconds % 60).padStart(2, '0');
                        display.text(`${hours}:${minutes}:${seconds}`);

                        // Tampilkan timer hanya jika waktu tersisa <= 30 detik
                        if (totalSeconds <= 30) {
                            timerElement.show();
                        } else {
                            timerElement.hide();
                        }
                    } else {
                        clearInterval(interval);
                        display.text("00:00:00");
                        timerElement.show();
                        $('#examwizard-question').submit();
                    }
                }, 1000);
            }
            fetch("{{ url('siswa/ujian/simulasi-finish') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        kode_ujian: "{{ $mergeUjian->kode_ujian }}",
                        time: new Date().toISOString()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data?.request?.time) {
                        // Ambil batas waktu ujian dari response API (format ISO 8601)
                        const batasWaktu = data.waktu_berakhir;
                        const display = $('.jam_ujin_skearan');
                        startTimer(batasWaktu, display);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            // const endDate = "{{ $waktu_ujian->waktu_berakhir }}";
            // const display = $('.jam_ujin_skearan');
            // startTimer(endDate, display);

            $('#go-to-next-question-pg').on('click', function() {
                if (currentQuestionNumber < totalOfQuestion) {
                    currentQuestionNumber++;
                    showQuestion(currentQuestionNumber);
                } else {
                    $('#examwizard-question').submit();
                }
            });

            $('#back-to-prev-question-pg').on('click', function() {
                if (currentQuestionNumber > 1) {
                    currentQuestionNumber--;
                    showQuestion(currentQuestionNumber);
                }
            });

            function showQuestion(questionNumber) {
                $('.question').addClass('hidden');
                $('.question-' + questionNumber).removeClass('hidden');
                $('#current-question-number-label').text(questionNumber);
                $('#back-to-prev-question-pg').toggleClass('disabled', questionNumber === 1);
            }

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
