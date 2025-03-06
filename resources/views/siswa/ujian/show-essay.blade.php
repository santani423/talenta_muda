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
    <div>
        <div class="layout-px-spacing">
            <div class="row">
                <div class="col-lg-12">
                    <form id="examwizard-question" action="{{ url('/siswa/ujian_essay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode" value="{{ $ujian->kode }}">
                        <input type="hidden" name="kode_merge_ujian" value="{{ $kode_merge_ujian }}">
                        <div class="widget shadow p-2">
                            <div class="d-flex float-right hidden">
                                <div class="badge badge-primary " style="font-size: 18px; font-weight: bold;">
                                    <span data-feather="clock"></span> | <span class="jam_ujin_skearan">00:00:00</span>
                                </div>
                            </div>
                            <div>
                                @php
                                    $no = 1;
                                    $soal_hidden = '';
                                @endphp
                                @foreach ($essay_siswa as $key => $soal)
                                    <div class="question {{ $soal_hidden }} question-{{ $no }}" data-question="{{ $no }}">
                                        <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                            <div class="">
                                                <h6 style="font-weight: bold">Soal No  . <span class="badge badge-primary no-soal" style="font-size: 1rem">{{ $no }}</span></h6>
                                            </div>
                                        </div>

                                        <div class="widget p-3 mt-3">
                                            <div class="widget-heading" style="border-bottom: 1px solid #e0e6ed;">
                                                <h6 class="question-title color-green" style="word-wrap: break-word">
                                                    {!! $soal->soal !!}
                                                </h6>
                                            </div>
                                            <div class="widget-content mt-3" style="position: relative;">
                                                <div class="alert alert-danger hidden"></div>
                                                @if ($soal->type_kunci_jawaban == 'number')
                                                    <input type="number" step="0.01" name="jawaban-{{ $soal->id }}" id="soal{{ $no }}-{{ $soal->id }}" data-essay_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" class="form-control" placeholder="tuliskan jawaban..." @if($soal->jawaban !== null) value="{{ $soal->jawaban }}" @endif>
                                                    <div class="alert alert-danger hidden" id="validation-{{ $soal->id }}">Input harus berupa bilangan bulat atau pecahan dengan maksimal 2 angka di belakang koma.</div>
                                                    <script>
                                                        document.getElementById('soal{{ $no }}-{{ $soal->id }}').addEventListener('input', function (e) {
                                                            var value = e.target.value;
                                                            var regex = /^\d+(\.\d{0,2})?$/;
                                                            var validationMessage = document.getElementById('validation-{{ $soal->id }}');
                                                            if (!regex.test(value)) {
                                                                validationMessage.classList.remove('hidden');
                                                            } else {
                                                                validationMessage.classList.add('hidden');
                                                            }
                                                        });
                                                    </script>
                                                @else
                                                    
                                                <div class="green-radio color-green">
                                                    <textarea name="jawaban-{{ $soal->id }}" id="soal{{ $no }}-{{ $soal->id }}" data-essay_siswa="{{ $soal->id }}" data-noSoal="{{ $no }}" class="form-control" placeholder="tuliskan jawaban...">@if($soal->jawaban !== null) {{ $soal->jawaban }} @endif</textarea>
                                                </div>
                                                @endif
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
                            <input type="hidden" value="{{ $essay_siswa->count() }}" id="totalOfQuestion" name="totalOfQuestion" />
                            <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                        </div>
                    </form>

                    <!-- Exam Footer -->
                    <div class="row">
                        <div class="col-lg-12 exams-footer text-center">
                            <div class="row pb-3">
                                <div class="col-sm-1 back-to-prev-question-wrapper text-center mt-3">
                                    <a href="javascript:void(0);" id="back-to-prev-question-essay" class="btn btn-primary">Back</a>
                                </div>

                                <div class="col-sm-2 footer-question-number-wrapper text-center mt-3">
                                    <div>
                                        <span id="current-question-number-label">1</span>
                                        <span>Dari <b>{{ $essay_siswa->count() }}</b></span>
                                    </div>
                                    <div>Nomor Soal</div>
                                </div>
                                <div class="col-sm-1 go-to-next-question-essay-wrapper text-center mt-3">
                                    <a href="javascript:void(0);" id="go-to-next-question-essay" class="btn btn-primary">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    {!! session('pesan') !!}
    @include('error.ew-s-e')
@endsection

@section('script')
<script>
    $(document).ready(function () {
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
            // Assign PHP variable to JavaScript variable and start the countdown
            const endDate = "{{ $waktu_ujian->waktu_berakhir }}"; // Output example: "2024-12-06 14:04"
            const display = $('.jam_ujin_skearan');
            startTimer(endDate, display);
        });

        $('#go-to-next-question-essay').on('click', function () {
            if (currentQuestionNumber < totalOfQuestion) {
                currentQuestionNumber++;
                showQuestion(currentQuestionNumber);
            } else {
                saveAnswer(currentQuestionNumber);
                $('#examwizard-question').submit();
                 
            }
        });

        $('#back-to-prev-question-essay').on('click', function () {
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
            // $('#go-to-next-question-essay').toggleClass('disabled', questionNumber === totalOfQuestion);
        }

        function saveAnswer(questionNumber) {
            var textareaId = $('.question-' + questionNumber + ' textarea').data('essay_siswa');
            var answer = $('.question-' + questionNumber + ' textarea').val();

            $.ajax({
                url: '{{ url("/siswa/ujian_essay/saveAnswer") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    answer: answer,
                    id_essay: textareaId
                },
                success: function (response) {
                    console.log('Answer saved:', response);
                }
            });
        }

        showQuestion(currentQuestionNumber);
    });
</script>
@endsection
