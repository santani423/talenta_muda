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
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-lg-12">
            <form id="examwizard-question" action="{{ url('/siswa/ujian_kuesioner') }}" method="POST">
                @csrf
                <input type="hidden" name="kode" value="{{ $ujian->kode }}">
                <input type="hidden" name="kode_merge_ujian" value="{{ $kode_merge_ujian }}">
                <div class="widget shadow p-2">
                    <div class="d-flex float-right hidden">
                        <div class="badge badge-primary" style="font-size: 18px; font-weight: bold;">
                            <span data-feather="clock"></span> <span class="jam_ujin_skearan">00:00:00</span>
                        </div>
                    </div>
                    <div>
                        @php
                            $no = 1;
                            $noSoal = 1;
                            $soal_hidden = '';
                        @endphp
                        @foreach ($detail_siswa as $kuisoner)
                            <div class="question {{ $soal_hidden }} question-{{ $no }}"
                                data-question="{{ $no }}">
                                <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                    <h6 style="font-weight: bold">Soal No. <span class="badge badge-primary no-soal"
                                            style="font-size: 1rem">{{ $no }}</span></h6>
                                </div>

                                <div class="widget p-3 mt-3">
                                    <div class="widget-heading"
                                        style="border-bottom: 1px solid #e0e6ed; max-width: 100%; overflow-x: auto;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Pernyataan</th>
                                                    <th scope="col"  colspan="2">Pilihan Anda</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 
                                                @foreach ($kuisoner as $ku)
                                                    <tr>
                                                        <th scope="row">{{ $noSoal }}</th>
                                                        <td>{!! $ku['soal'] !!} </td>
                                                        <td>
                                                            <div class="row">
                                                                @foreach ($ku['detail_jawaban_kuisoner'] as $djk)
                                                                    <div class="col-md-2 mr-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="jawaban_{{ $ku['id'] }}"
                                                                                id="jawaban_{{ $noSoal }}_{{ $loop->index }}"
                                                                                value="{{ $djk['id'] }}">
                                                                            <label class="form-check-label"
                                                                                for="jawaban_{{ $noSoal }}_{{ $loop->index }}">
                                                                                {{ $djk['kode'] }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $noSoal++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="widget-content mt-3">
                                        <div class="alert alert-danger hidden"></div>
                                        <div class="green-checkbox color-green">

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
                            <div>
                                Nomor Soal
                            </div>
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
            var totalOfQuestion = $('#totalOfQuestion').val();
            var interval;

            function startTimer(endDate, display) {
                // Convert end date to a timestamp
                const targetTime = new Date(endDate).getTime();

                const interval = setInterval(() => {
                    const currentTime = new Date().getTime();
                    const timeLeft = targetTime - currentTime;

                    if (timeLeft > 0) {
                        // Calculate hours, minutes, and seconds remaining
                        const hours = String(Math.floor((timeLeft / (1000 * 60 * 60)) % 24)).padStart(2,
                            '0');
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
                // Assign PHP variable to JavaScript variable and start the countdown
                const endDate = "{{ $waktu_ujian->waktu_berakhir }}"; // Output example: "2024-12-06 14:04"
                const display = $('.jam_ujin_skearan');
                startTimer(endDate, display);
            });

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
                var checkedBoxes = $(this).closest('.question').find('.answer-checkbox:checked');
                if (checkedBoxes.length > 2) {
                    $(this).prop('checked', false);
                    alert("Anda hanya dapat memilih maksimal dua jawaban.");
                }
            });

            showQuestion(currentQuestionNumber);
        });
    </script>
@endsection
