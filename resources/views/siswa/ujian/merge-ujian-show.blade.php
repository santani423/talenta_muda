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
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- BEGIN CONTENT AREA -->
    <div class="layout-px-spacing">

        <!-- TIMER -->
        <div class="d-flex timer-fixed hidden">
            <div class="badge badge-primary" style="font-size: 18px; font-weight: bold;">
                <span data-feather="clock"></span> <span class="jam_ujin_skearan">00:00:00</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form id="examwizard-question" action="{{ url('/siswa/ujian') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kode" value="{{ $ujian->kode }}">
                    <input type="hidden" name="kode_merge_ujian" value="{{ $kode_merge_ujian }}">
                    <div class="widget shadow p-2">
                        <div>
                            @php
                                $no = 1;
                                $soal_hidden = '';
                            @endphp
                            @foreach ($pg_siswa as $soal)
                                <div class="question {{ $soal_hidden }} question-{{ $no }}"
                                    data-question="{{ $no }}">
                                    <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                        <h6 style="font-weight: bold">Soal No. <span class="badge badge-primary no-soal"
                                                style="font-size: 1rem">{{ $no }}</span></h6>
                                    </div>

                                    <div class="widget p-3 mt-3">
                                        <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed;">
                                            <h6 class="question-title color-green text-center"
                                                style="word-wrap: break-word">
                                                <img src="{{ url($soal->detailujian->soal) }}" alt=""
                                                    style="width: 70Wh; height: 30vh;">
                                            </h6>
                                        </div>

                                        <div class="widget-content mt-3">
                                            <div class="alert alert-danger hidden"></div>
                                            <div class="green-radio color-green">
                                                <ol type="A" style="color: #000; margin-left: -20px; list-style-type: none;">
                                                    <div class="row">
                                                        @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                                                            <div class="@if ($ujian->kode == 'part2') col @else col-md-6 @endif">
                                                                <li class="answer-number d-flex align-items-center">
                                                                    <input type="radio"
                                                                        name="pilihan-{{ $soal->detailujian->id }}"
                                                                        value="{{ $opt }}" id="soal{{ $no }}-{{ $opt }}" />
                                                                    <label for="soal{{ $no }}-{{ $opt }}"
                                                                        class="d-flex align-items-center ml-2">
                                                                        <span>{{ strtoupper($opt) }}</span>
                                                                        <img src="{{ url($soal->detailujian->{'pg_' . (array_search($opt, ['a', 'b', 'c', 'd', 'e']) + 1)}) }}"
                                                                            alt=""
                                                                            style="width: auto; height: 20vh; margin-left: 10px;">
                                                                    </label>
                                                                </li>
                                                            </div>
                                                        @endforeach

                                                        @if (!empty($soal->detailujian->pg_6) && $soal->detailujian->pg_6 != 'f')
                                                            <div class="@if ($ujian->kode == 'part2') col @else col-md-6 @endif">
                                                                <li class="answer-number d-flex align-items-center">
                                                                    <input type="radio"
                                                                        name="pilihan-{{ $soal->detailujian->id }}"
                                                                        value="f" id="soal{{ $no }}-f" />
                                                                    <label for="soal{{ $no }}-f"
                                                                        class="d-flex align-items-center ml-2">
                                                                        <span>F </span>
                                                                        <img src="{{ url($soal->detailujian->pg_6) }}"
                                                                            alt=""
                                                                            style="width: auto; height: 20vh; margin-left: 10px;">
                                                                    </label>
                                                                </li>
                                                            </div>
                                                        @endif
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
                        <input type="hidden" value="{{ $ujian->detailujian->count() }}" id="totalOfQuestion"
                            name="totalOfQuestion" />
                        <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                    </div>
                </form>

                <!-- Exams Footer -->
                <div class="row">
                    <div class="col-lg-12 exams-footer">
                        <div class="row pb-3">
                            <div class="col-sm-1 back-to-prev-question-wrapper text-center mt-3">
                                <a href="javascript:void(0);" id="back-to-prev-question"
                                    class="btn btn-primary disabled">
                                    Back
                                </a>
                            </div>

                            <div class="col-sm-2 footer-question-number-wrapper text-center mt-3">
                                <div>
                                    <span id="current-question-number-label">1</span>
                                    <span>Dari <b>{{ $ujian->detailujian->count() }}</b></span>
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

    </div>

    {!! session('pesan') !!}
    @include('error.ew-s-p')

    <script>
        $(document).ready(function() {
            var currentQuestionNumber = 1;
            var totalOfQuestion = $('#totalOfQuestion').val();

            function startTimer(endDate, display) {
                const targetTime = new Date(endDate).getTime();

                const interval = setInterval(() => {
                    const currentTime = new Date().getTime();
                    const timeLeft = targetTime - currentTime;

                    if (timeLeft > 0) {
                        $('.jam_ujin_skearan').closest('.timer-fixed').removeClass('hidden');

                        const hours = String(Math.floor((timeLeft / (1000 * 60 * 60)) % 24)).padStart(2, '0');
                        const minutes = String(Math.floor((timeLeft / (1000 * 60)) % 60)).padStart(2, '0');
                        const seconds = String(Math.floor((timeLeft / 1000) % 60)).padStart(2, '0');

                        display.text(`${hours}:${minutes}:${seconds}`);
                    } else {
                        clearInterval(interval);
                        display.text("00:00:00");
                        alert("Waktu Ujian Habis");
                        $('#examwizard-question').submit();
                    }
                }, 1000);
            }

            $(function() {
                const endDate = "{{ $waktu_ujian->waktu_berakhir }}";
                const display = $('.jam_ujin_skearan');
                startTimer(endDate, display);
            });

            $('#go-to-next-question-pg').on('click', function() {
                if (currentQuestionNumber < totalOfQuestion) {
                    currentQuestionNumber++;
                    showQuestion(currentQuestionNumber);
                } else {
                    saveAnswer(currentQuestionNumber);
                    $('#examwizard-question').submit();
                }
            });

            $('#back-to-prev-question').on('click', function() {
                if (currentQuestionNumber > 1) {
                    currentQuestionNumber--;
                    showQuestion(currentQuestionNumber);
                }
            });

            function showQuestion(questionNumber) {
                $('.question').addClass('hidden');
                $('.question-' + questionNumber).removeClass('hidden');
                $('#current-question-number-label').text(questionNumber);
                $('#back-to-prev-question').toggleClass('disabled', questionNumber === 1);
            }

            function saveAnswer(questionNumber) {
                var textareaId = $('.question-' + questionNumber + ' textarea').data('essay_siswa');
                var answer = $('.question-' + questionNumber + ' textarea').val();

                $.ajax({
                    url: '{{ url('/siswa/ujian_essay/saveAnswer') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        answer: answer,
                        id_essay: textareaId
                    },
                    success: function(response) {
                        console.log('Answer saved:', response);
                    }
                });
            }

            showQuestion(currentQuestionNumber);
        });
    </script>
@endsection
