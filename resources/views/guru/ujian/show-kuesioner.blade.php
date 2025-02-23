@extends('template.main')
@section('content')
    @include('template.navbar.guru')


    <style>
        .btn-white {
            background: #cacaca;
            color: #fff;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h6 class="text-center">{{ $ujian->nama }}</h6>
                            Nama Peserta : {{ $siswa->nama_siswa }}
                        </div>

                        <div class="widget-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="examwizard-question" action="javascript:void(0);" method="POST">
                                        @csrf
                                        <input type="hidden" name="kode" value="{{ $ujian->kode }}">
                                        <div class="widget shadow p-2">
                                            <div>
                                                @php
                                                    $no = 1;
                                                    $noSoal = 1;
                                                    $soal_hidden = '';
                                                @endphp
                                                @foreach ($detail_siswa as $kuisoner)
                                               
                                                    <div class="question {{ $soal_hidden }} question-{{ $no }}"
                                                        data-question="{{ $no }}">
                                                        <div class="widget-heading pl-2 pt-2"
                                                            style="border-bottom: 1px solid #e0e6ed;">
                                                            <div class="">
                                                                <h6 class="" style="font-weight: bold">Soal No. <span
                                                                        class="badge badge-primary no-soal"
                                                                        style="font-size: 1rem">{{ $no }}</span>
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="widget p-3 mt-3">
                                                            <div class="widget-heading"
                                                                style="border-bottom: 1px solid #e0e6ed; max-width: 100%; overflow-x: auto;">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">No</th>
                                                                            <th scope="col">Pernyataan</th>
                                                                            <th scope="col" colspan="2">Pilihan Anda
                                                                            </th>
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
                                                                                                @if($djk['kode'] == $ku['kode'])  {{$ku['kode']}}   @endif
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
                                            <!-- SOAL -->

                                            <input type="hidden" value="1" id="currentQuestionNumber"
                                                name="currentQuestionNumber" />
                                            <input type="hidden" value="{{ count($detail_siswa) }}" id="totalOfQuestion"
                                                name="totalOfQuestion" />
                                            <input type="hidden" value="[]" id="markedQuestion"
                                                name="markedQuestions" />
                                            <!-- END SOAL -->
                                        </div>
                                    </form>

                                    <!-- Exmas Footer - Multi Step Pages Footer -->
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
                                                        <span>Dari <b>{{ count($detail_siswa) }}</b></span>
                                                    </div>
                                                    <div>
                                                        Nomor Soal
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 go-to-next-question-wrapper text-center mt-3">
                                                    <a href="javascript:void(0);" id="go-to-next-question"
                                                        class="btn btn-primary">
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
                </div>
            </div>

            <a href="{{ url('/guru/ujian_essay/' . $ujian->kode) }}" class="btn btn-danger btn-sm mt-3"><span
                    data-feather="arrow-left-circle"></span> kembali</a>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    {!! session('pesan') !!}
    @include('error.ew-t-e-s')
@endsection
