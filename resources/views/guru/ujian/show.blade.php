@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5 class="">{{ $ujian->nama }}</h5>
                          
                            <table class="mt-2">
                                <tr>
                                    <th>Batch</th>
                                    <th>: {{ $ujian->kelas->nama_kelas }}</th>
                                </tr>
                                <tr>
                                    <th>Psikotes</th>
                                    <th>: {{ $ujian->mapel->nama_mapel }}</th>
                                </tr>
                                <tr>
                                    <th>Jumlah Soal</th>
                                    <th>: {{ $ujian->detailujian->count() }} Soal</th>
                                </tr>
                                <tr>
                                    <th>Waktu Tes</th>
                                    <th>: {{ $ujian->jam }} Jam {{ $ujian->menit }} Menit</th>
                                </tr>

                            </table>
                            <!-- Button trigger modal -->
                            <a href="{{ url('/guru/ujian_simulator/create', $ujian->id) }}" class="btn btn-primary mt-2">
                                Buat simulator Tes pilihan ganda
                            </a>
                            <a href="{{ url('/guru/ujian_intruksi/create', $ujian->id) }}" class="btn btn-primary mt-2">
                                Buat Intruksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- soal ujian & jawaban --}}
            <div id="toggleAccordion" class="shadow">
                <div class="card">
                    <div class="card-header bg-white" id="...">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="" data-toggle="collapse" data-target="#defaultAccordionOne"
                                aria-expanded="true" aria-controls="defaultAccordionOne" style="cursor: pointer;">
                                Soal Tes & Jawaban (Klik untuk lihat & tutup)
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionOne" class="collapse show" aria-labelledby="..."
                        data-parent="#toggleAccordion">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-9">
                                    <form id="examwizard-question" action="#" method="POST">
                                        <div class="widget shadow p-2">
                                            <div>
                                                @php
                                                    $no = 1;
                                                    $soal_hidden = '';
                                                @endphp
                                                @foreach ($ujian->detailujian as $soal)
                                                    <div class="question <?= $soal_hidden ?> question-{{ $no }}"
                                                        data-question="{{ $no }}">
                                                        <div class="widget-heading pl-2 pt-2"
                                                            style="border-bottom: 1px solid #e0e6ed;">
                                                            <div class="">
                                                                <h6 class="" style="font-weight: bold">Soal No. <span
                                                                        class="badge badge-primary no-soal">{{ $no }}</span>
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="widget p-3 mt-3">
                                                            <div class="widget-heading"
                                                                style="border-bottom: 1px solid #e0e6ed;">
                                                                <h6 class="question-title color-green text-center"
                                                                    style="word-wrap: break-word">

                                                                    <img src="{{ url($soal->soal) }}" class="img-fluid"
                                                                        width="50%">
                                                                </h6>
                                                            </div>
                                                            <div class="widget-content mt-3">
                                                                <div class="alert alert-danger hidden"></div>
                                                                <div class="green-radio color-green">
                                                                    <ol type="A"
                                                                        style="color: #000; margin-left: -20px;">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <li class="answer-number">
                                                                                    <label
                                                                                        for="answer-{{ $soal->id }}-{{ substr($soal->pg_1, 0, 1) }}"
                                                                                        class="answer-text"
                                                                                        style="color: #000;">
                                                                                        <span></span>
                                                                                        <img src="{{ url($soal->pg_1) }}"
                                                                                            class="img-fluid"
                                                                                            width="25%">
                                                                                    </label>
                                                                                </li>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <li class="answer-number">
                                                                                    <label
                                                                                        for="answer-{{ $soal->id }}-{{ substr($soal->pg_2, 0, 1) }}"
                                                                                        class="answer-text"
                                                                                        style="color: #000;">
                                                                                        <span></span>
                                                                                        <img src="{{ url($soal->pg_2) }}"
                                                                                        class="img-fluid"
                                                                                        width="25%">
                                                                                    </label>
                                                                                </li>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <li class="answer-number">
                                                                                    <label
                                                                                        for="answer-{{ $soal->id }}-{{ substr($soal->pg_3, 0, 1) }}"
                                                                                        class="answer-text"
                                                                                        style="color: #000;">
                                                                                        <span></span>
                                                                                        <img src="{{ url($soal->pg_3) }}"
                                                                                        class="img-fluid"
                                                                                        width="25%">
                                                                                    </label>
                                                                                </li>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <li class="answer-number">
                                                                                    <label
                                                                                        for="answer-{{ $soal->id }}-{{ substr($soal->pg_4, 0, 1) }}"
                                                                                        class="answer-text"
                                                                                        style="color: #000;">
                                                                                        <span></span>
                                                                                        <img src="{{ url($soal->pg_4) }}"
                                                                                            class="img-fluid"
                                                                                            width="25%">
                                                                                    </label>
                                                                                </li>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <li class="answer-number">
                                                                                    <label
                                                                                        for="answer-{{ $soal->id }}-{{ substr($soal->pg_5, 0, 1) }}"
                                                                                        class="answer-text"
                                                                                        style="color: #000;">
                                                                                        <span></span>
                                                                                        <img src="{{ url($soal->pg_5) }}"
                                                                                            class="img-fluid"
                                                                                            width="25%">
                                                                                    </label>
                                                                                </li>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <li class="answer-number">
                                                                                    <label
                                                                                        for="answer-{{ $soal->id }}-{{ substr($soal->pg_6, 0, 1) }}"
                                                                                        class="answer-text"
                                                                                        style="color: #000;">
                                                                                        <span></span>
                                                                                        <img src="{{ url($soal->pg_6) }}"
                                                                                            class="img-fluid"
                                                                                            width="25%">
                                                                                    </label>
                                                                                </li>
                                                                            </div>
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
                                            <!-- SOAL -->

                                            <input type="hidden" value="1" id="currentQuestionNumber"
                                                name="currentQuestionNumber" />
                                            <input type="hidden" value="{{ $ujian->detailujian->count() }}"
                                                id="totalOfQuestion" name="totalOfQuestion" />
                                            <input type="hidden" value="[]" id="markedQuestion"
                                                name="markedQuestions" />
                                            <!-- END SOAL -->
                                        </div>
                                    </form>

                                </div>

                                <div class="col-lg-3" id="quick-access-section" class="table-responsive">
                                    <div class="widget shadow p-3">
                                        <div class="widget-content">
                                            <table class="table text-center table-hover">
                                                <thead class="question-response-header">
                                                    <tr>
                                                        <th class="text-center">No. Soal</th>
                                                        <th class="text-center">Jawaban</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($ujian->detailujian as $soal)
                                                        <tr class="question-response-rows"
                                                            data-question="{{ $no }}" style="cursor: pointer;">
                                                            <td style="font-weight: bold;">{{ $no }}</td>
                                                            <td class="question-response-rows-value">{{ $soal->jawaban }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <div class="text-nowrap text-center">
                                                <a href="javascript:void(0)" class="btn btn-success"
                                                    id="quick-access-prev">
                                                    &laquo;
                                                </a>
                                                <span class="alert alert-info" id="quick-access-info"></span>
                                                <a href="javascript:void(0)" class="btn btn-success"
                                                    id="quick-access-next">&raquo;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Exmas Footer - Multi Step Pages Footer -->
                            <div class="row mt-3">
                                <div class="col-lg-12 exams-footer p-3">
                                    <div class="row">
                                        <div class="col-sm-1 back-to-prev-question-wrapper text-center">
                                            <a href="javascript:void(0);" id="back-to-prev-question"
                                                class="btn btn-success disabled">
                                                Back
                                            </a>
                                        </div>
                                        <div class="col-sm-2 footer-question-number-wrapper text-center">
                                            <div>
                                                <span id="current-question-number-label">1</span>
                                                <span>Dari <b>{{ $ujian->detailujian->count() }}</b></span>
                                            </div>
                                            <div>
                                                Nomor Soal
                                            </div>
                                        </div>
                                        <div class="col-sm-1 go-to-next-question-wrapper text-center">
                                            <a href="javascript:void(0);" id="go-to-next-question"
                                                class="btn btn-success">
                                                Next
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


           


            <a href="{{ url('/guru/ujian') }}" class="btn btn-danger btn-sm mt-3"><span
                    data-feather="arrow-left-circle"></span> kembali</a>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    {!! session('pesan') !!}
    @include('error.ew-t-p')
    <script>
        $('.reset-ujian').on('click', function(e) {
            var href = $(this).attr('href');
            e.preventDefault();
            swal({
                title: 'Reset Tes Peserta?',
                text: "Tes Peserta berikut akan di Reset. Pastikan Peserta tidak sedang berada di dalam menu Tes!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'tidak',
                confirmButtonText: 'ya, reset',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    document.location.href = href;
                }
            });
        });
        $('.reset-ujian-siswa').on('click', function(e) {
            var href = $(this).attr('href');
            e.preventDefault();
            swal({
                title: 'Reset Tes Semua Peserta?',
                text: "Tes semua Peserta akan di Reset. Pastikan Peserta tidak sedang berada di dalam menu Tes!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'tidak',
                confirmButtonText: 'ya, reset',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    document.location.href = href;
                }
            });
        });
    </script>
@endsection
