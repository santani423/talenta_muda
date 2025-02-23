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
                            <div class="row">

                                <div class="col-md-8">
                                    <table class="table table-striped">
                                        <tbody>

                                            
                                            <tr>
                                                <th scope="row">Nama</th>
                                                <td>{{ $siswa->nama_siswa }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Jenis Kelamin</th>
                                                <td>{{ $siswa->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>{{ $siswa->email }}</td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            {{-- Ujian Peserta & nilai --}}
            <div id="iconsAccordion" class="accordion-icons shadow mt-3">
                <div class="card">
                    <div class="card-header bg-white" id="...">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="" data-toggle="collapse" data-target="#iconAccordionOne"
                                aria-expanded="true" aria-controls="iconAccordionOne" style="cursor: pointer;">
                                Ujian Pilihan Ganda
                            </div>
                        </section>
                    </div>

                    <div id="iconAccordionOne" class="collapse show" aria-labelledby="..." data-parent="#iconsAccordion">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget p-3 shadow">


                                        <div class="widget-content pt-3">

                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered text-nowrap">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Benar</th>
                                                            <th>Salah</th>
                                                            <th>Tidak Dijawab</th>
                                                            <th>Nilai</th>
                                                            <!-- <th>opsi</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasilPg as $s)
                                                            <tr class="text-center">
                                                                <td>{{ $s['jumlah_benar'] }}</td>
                                                                <td>{{ $s['jumlah_salah'] }}</td>
                                                                <td>{{ $s['jumlah_tidak_jawab'] }}</td>
                                                                <td>{{ $s['nilai'] }}</td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Ujian Peserta & nilai --}}
            <div id="iconsAccordion" class="accordion-icons shadow mt-3">
                <div class="card">
                    <div class="card-header bg-white" id="...">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="" data-toggle="collapse" data-target="#iconAccordionOne"
                                aria-expanded="true" aria-controls="iconAccordionOne" style="cursor: pointer;">
                                Ujian Visual
                            </div>
                        </section>
                    </div>

                    <div id="iconAccordionOne" class="collapse show" aria-labelledby="..." data-parent="#iconsAccordion">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget p-3 shadow">

                                        <div class="widget-content pt-3">

                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered text-nowrap">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Benar</th>
                                                            <th>Salah</th>
                                                            <th>Tidak Dijawab</th>
                                                            <th>Nilai</th>
                                                            <!-- <th>opsi</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasilPg as $s)
                                                            <tr class="text-center">
                                                                <td>{{ $s['jumlah_benar'] }}</td>
                                                                <td>{{ $s['jumlah_salah'] }}</td>
                                                                <td>{{ $s['jumlah_tidak_jawab'] }}</td>
                                                                <td>{{ $s['nilai'] }}</td>
                                                                <!-- <td>
                                                                            
                                                                        </td> -->

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div id="iconsAccordion" class="accordion-icons shadow mt-3">
                <div class="card">
                    <div class="card-header bg-white" id="...">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="" data-toggle="collapse" data-target="#iconAccordionOne"
                                aria-expanded="true" aria-controls="iconAccordionOne" style="cursor: pointer;">
                                Ujian Esay
                            </div>
                        </section>
                    </div>

                    <div id="iconAccordionOne" class="collapse show" aria-labelledby="..." data-parent="#iconsAccordion">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget p-3 shadow">


                                        <div class="widget-content pt-3">

                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered text-nowrap">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Soal Dijawab</th>
                                                            <th>Tidak dijawab</th>
                                                            <th>Total Nilai</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasilEsay as $s)
                                                            @php
                                                                $soalDijawab = 0;
                                                                $tidakDijawab = 0;
                                                            @endphp

                                                            <tr class="text-center">
                                                                <!-- Check if the key exists and is not null -->
                                                                <td>{{ isset($s['jumlah_dijawab']) ? $s['jumlah_dijawab'] : '0' }}
                                                                </td>
                                                                <td>{{ isset($s['jumlah_tidak_dijawab']) ? $s['jumlah_tidak_dijawab'] : '0' }}
                                                                </td>
                                                                <td>{{ isset($s['total_nilai']) ? $s['total_nilai'] : '0' }}
                                                                </td>

                                                                
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            {{-- Ujian siswa & nilai --}}
            <div id="iconsAccordion" class="accordion-icons shadow mt-3">
                <div class="card">
                    <div class="card-header bg-white" id="...">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="" data-toggle="collapse" data-target="#iconAccordionOne"
                                aria-expanded="true" aria-controls="iconAccordionOne" style="cursor: pointer;">
                                Kuisoner
                            </div>
                        </section>
                    </div>

                    <div id="iconAccordionOne" class="collapse show" aria-labelledby="..."
                        data-parent="#iconsAccordion">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget p-3 shadow">


                                        <div class="widget-content pt-3">

                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered text-nowrap">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Pilihan Peserta</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hasilKuisoner as $s)
                                                        <tr class="text-center">
                                                            @php
                                                                $soalDijawab = 0;
                                                                $tidakDijawab = 0;
                                                            @endphp
                                                    
                                                            <td>
                                                                @if (!empty($s['detail_Kuisunoer']) && is_array($s['detail_Kuisunoer']))
                                                                    @foreach ($s['detail_Kuisunoer'] as $detail_Kuisunoer)
                                                                        <p><span>{{ $detail_Kuisunoer['kode'] }}</span>:{{ $detail_Kuisunoer['count'] }}</p>
                                                                    @endforeach
                                                                @else
                                                                    <p>No data available</p> <!-- You can replace this with any message or a default value -->
                                                                @endif
                                                            </td>
                                                    
                                                           
                                                        </tr>
                                                    @endforeach
                                                    
                                                    </tbody>
                                                </table>
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
                title: 'Reset Ujian Peserta?',
                text: "Ujian Peserta berikut akan di Reset. Pastikan Peserta tidak sedang berada di dalam menu ujian!",
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
                title: 'Reset Ujian Semua Peserta?',
                text: "Ujian semua Peserta akan di Reset. Pastikan Peserta tidak sedang berada di dalam menu ujian!",
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
