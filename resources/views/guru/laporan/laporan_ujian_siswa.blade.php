@extends('template.main')
@section('title', 'Laporan Ujian Siswa')

@section('content')
    @include('template.navbar.guru')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3" style="min-height: 500px;">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="widget-heading">
                                    <h5 class="">Laporan Ujian Peserta</h5>
                                </div>
                                {{-- <div id="chart_div" style="width: 100%; height: 500px;">
                                    <canvas id="pointStyleChart" width="400" height="300"></canvas>
                                </div> --}}


                                <form action="{{ url('guru/laporan_ujian_siswa') }}" method="GET" class="mt-3 d-flex"
                                    role="search">
                                    <input type="text" name="search" class="form-control me-2"
                                        placeholder="Search by name" value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                                <div class="mt-3">
                                    <p>Total Data: <span id="totalData">{{ count($MergeUjianSiswa) }}</span></p>
                                </div>
                                <div class="table-responsive mt-3" style="overflow-x: scroll;">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Tempat Lahir</th>
                                                {{-- <th>Total Soal</th> --}}
                                                {{-- <th>Opsi</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($MergeUjianSiswa as $key => $bs)
                                                <tr>
                                                    <td>{{ $key + $currentPage + 1 }}</td>
                                                    <td>
                                                        {{ $bs->nama_siswa ?? ($bs->nama_siswa_visual ?? ($bs->nama_siswa_essay ?? ($bs->nama_siswa_kuesioner ?? 'Nama siswa tidak tersedia'))) }}
                                                    </td>
                                                    {{-- <td>
                                                        {{ $bs->tempat_lahir_pg ?? 'Tempat lahir siswa tidak tersedia' }}
                                                    </td> --}}
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#exampleModal"
                                                            onclick="printPDF(
                                                        '{{ $bs->id ?? ($bs->id_siswa_visual ?? ($bs->id_siswa_essay ?? ($bs->id_siswa_kuesioner ?? ''))) }}',
                                                        '{{ $bs->nama_siswa ?? 'Nama siswa tidak tersedia' }}',
                                                        '{{ $bs->tempat_lahir ?? 'Tempat lahir siswa tidak tersedia' }}',
                                                        '{{ $bs->tanggal_lahir ?? 'Tanggal Lahir siswa tidak tersedia' }}',
                                                        '{{ $bs->gender ?? 'Tanggal Lahir siswa tidak tersedia' }}')">
                                                            Hasil Tes
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example" class="d-flex justify-content-end">
                                        <ul class="pagination">
                                            <!-- Pagination items will be added here by JavaScript -->
                                        </ul>
                                    </nav>
                                    <nav aria-label="Navigasi Halaman Laporan Ujian Siswa">
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($MergeUjianSiswa->onFirstPage())
                                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $MergeUjianSiswa->previousPageUrl() }}">Previous</a></li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @for ($i = 1; $i <= $MergeUjianSiswa->lastPage(); $i++)
                                                <li
                                                    class="page-item {{ $MergeUjianSiswa->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $MergeUjianSiswa->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            {{-- Next Page Link --}}
                                            @if ($MergeUjianSiswa->hasMorePages())
                                                <li class="page-item"><a class="page-link"
                                                        href="{{ $MergeUjianSiswa->nextPageUrl() }}">Next</a></li>
                                            @else
                                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                                            @endif
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <img src="{{ url('/assets/img') }}/bank-soal.svg" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hail Tes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="pdf-content-review"></div>

                    <div class="form-group mt-4">
                        <textarea class="form-control" id="formKomentar" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="printNilaiSiswa()">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // const ctx = document.getElementById('pointStyleChart').getContext('2d');
        const pointStyleChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Nilai Siswa',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    pointStyle: 'rectRot',
                    pointRadius: 8,
                    pointBorderColor: 'rgb(75, 192, 192)',
                    pointBackgroundColor: 'rgb(255, 99, 132)'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
  <script>
    // Inisialisasi Chart.js
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
          label: 'Penjualan',
          data: [12, 19, 3, 5, 2],
          backgroundColor: 'rgba(75, 192, 192, 0.7)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: false,
        maintainAspectRatio: false
      }
    });

    // Fungsi cetak PDF
    async function printPDF() {
      const chartElement = document.getElementById('chart-container');

      // Render canvas ke gambar
      const canvas = await html2canvas(chartElement, {
        backgroundColor: "#ffffff"
      });

      const imageData = canvas.toDataURL("image/png");

      // Gunakan jsPDF versi UMD
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF({
        orientation: 'landscape',
        unit: 'mm',
        format: 'a4'
      });

      // Tambahkan gambar ke PDF (disesuaikan ukurannya)
      const imgProps = pdf.getImageProperties(imageData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.addImage(imageData, 'PNG', 0, 10, pdfWidth, pdfHeight);
      pdf.save('laporan-penjualan.pdf');
    }
  </script>
    <!-- MODAL -->
    <script>
        let itemPrint = '';
        let namaPeserta = '';

        function usia(tanggal_lahir) {
            const today = new Date();
            const birthDate = new Date(tanggal_lahir);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }


        function printPDF(studentId, studentName, tempat_lahir, tanggal_lahir, gender) {
            const element = document.createElement('div');
            element.style.padding = '20px';
            namaPeserta = studentName ?? 'Nama siswa tidak tersedia';
            element.innerHTML = `
            <h5 style="color: black;" class="text-center">HASIL TEST TALENTA MUDA</h5> 
            <div class="container-fluid" style="color: black;"> 
            <table>
            <tr>
            <td><h6 style="margin:2px; color: black;">Nama</h6></td>
            <td><h6 style="margin:2px; color: black;">:</h6></td>
            <td><h6 style="margin:2px; color: black;" >${studentName}</h6></td>
            </tr>  
            <tr>
            <td><h6 style="margin:2px; color: black;">Tempat Tanggal Lahir</h6></td>
            <td><h6 style="margin:2px; color: black;">:</h6></td>
            <td><h6 style="margin:2px; color: black;" >${tempat_lahir} , ${tanggal_lahir}</h6></td>
            </tr>  
            <tr>
            <td><h6 style="margin:2px; color: black;">Jenis Kelamin</h6></td>
            <td><h6 style="margin:2px; color: black;">:</h6></td>
            <td><h6 style="margin:2px; color: black;" >${gender}</h6></td>
            </tr>  
            <tr>
            <td><h6 style="margin:2px; color: black;">Usia</h6></td>
            <td><h6 style="margin:2px; color: black;">:</h6></td>
            <td><h6 style="margin:2px; color: black;" >${usia(tanggal_lahir)} tahun</h6></td>
            </tr>  
            </table>
            <div id="pdf-content">
          
            </div>
            </div>
            `;
            document.getElementById('pdf-content-review').innerHTML = `<div class="spinner-border text-primary" role="status">
    <span class="sr-only">Loading...</span>
    </div>`;
            let htmlContent = ``;
            Promise.all([
                fetchStudentData(studentId, 'part1_1', 0),
                fetchStudentData(studentId, 'part1_2', 3),
                fetchStudentData(studentId, 'part1_3', 0),
                fetchStudentData(studentId, 'part1_4', 0),
                fetchStudentData(studentId, 'part2', 0),
                fetchStudentData(studentId, 'part3', 1),
                fetchStudentData(studentId, 'part4', 1),
                fetchStudentData(studentId, 'part5_1', 2),
                fetchStudentData(studentId, 'part5_2', 2),
                fetchStudentData(studentId, 'part5_3', 2),
            ]).then(async results => {

                let jumlahKolom = 0;
                let jumlahKolom2 = 0;
                results.forEach((data) => {
                    if (data.typeUjian != 2) {
                        jumlahKolom = data.siswa.length > jumlahKolom ? data.siswa.length : jumlahKolom;
                    }
                    if (data.typeUjian == 2) {
                        jumlahKolom2 = data.siswa.length > jumlahKolom ? data.siswa.length :
                            jumlahKolom;
                    }
                });

                htmlContent =
                    `<div class="table-responsive"><table border="1" style="width:100%; color: black;">`;

                htmlContent += `<tr>`;

                results.forEach((data) => {
                    if (data.typeUjian != 2) {
                        htmlContent += `<td><p style="margin:8px; color: black;">${data.type}</p></td>`;
                    }
                });
                htmlContent += `</tr>`;

                for (let i = 0; i < jumlahKolom; i++) {
                    htmlContent += `<tr>`;
                    results.forEach((data) => {
                        if (data.typeUjian != 2) {
                            let jawaban = (data?.siswa[i]?.jawaban ?? '-').toLowerCase();
                            let kunci_jawaban = (data?.siswa[i]?.kunci_jawaban ?? '-').toLowerCase();
                            let jawaban_essay = data?.siswa[i]?.jawaban_essay?.jawaban_essay?.length ??
                                0;

                            htmlContent +=
                                `<td style="width: auto;">
                        <p style="margin:2px; text-align:left; color: black;">
                            ${i + 1 < 10 ? '0' : ''}${i + 1} . ${jawaban}  
                            ${ data?.siswa[i]?.jawaban_essay?.type_kunci_jawaban != 'text' && data?.siswa[i]?.nilai != '-' &&  data?.siswa[i]?.nilai != 'undefined'  && data?.siswa[i]?.nilai != '-' &&  data?.siswa[i]?.nilai != null ? data?.siswa[i]?.nilai == '1' ? '✔' : '✘' :''}
                        </p>
                    </td>`;
                        }
                    });
                    htmlContent += `</tr>`;
                }

                htmlContent += `<tr>`;
                let nilaiTscore = 0;
                results.forEach((data) => {
                    if (data.typeUjian != 2) {
                        htmlContent +=
                            `<td><p style="margin:10px; color: black;">${data.nilai+(data?.niaiTambah ?? 0)}</p></td>`;
                    }
                    if (data.codeUjian == 'part1_1' || data.codeUjian == 'part1_2' || data.codeUjian ==
                        'part1_3' || data.codeUjian == 'part1_4') {
                        nilaiTscore = parseInt(data?.nilai ?? 0) + parseInt(nilaiTscore ?? 0);
                    }
                });
                htmlContent += `</tr>`;
                htmlContent += `</table>
                <p style="margin:10px; color: black;" id="skorIq">Skor IQ :  </p> 
                <p style="margin:10px; color: black;" id="kualifikasiIq">Kualifikasi IQ:  </p>
                </div>`;

                // Tunggu tScoreData resolve sebelum menampilkan/print
                try {
                    let tScoreResponse = await tScore(nilaiTscore, tanggal_lahir);
                    const skorIq = tScoreResponse?.kalenderScore?.nilai ?? '-';
                    const kualifikasiIq = tScoreResponse?.klasifikasi?.klasifikasi ?? '-';
                    // Replace placeholder in htmlContent
                    htmlContent = htmlContent.replace('id="skorIq">Skor IQ :  </p>',
                        `id="skorIq">Skor IQ : ${skorIq}</p>`);
                    htmlContent = htmlContent.replace('id="kualifikasiIq">Kualifikasi IQ:  </p>',
                        `id="kualifikasiIq">Kualifikasi IQ: ${kualifikasiIq}</p>`);
                } catch (error) {
                    htmlContent = htmlContent.replace('id="skorIq">Skor IQ :  </p>',
                        `id="skorIq">Skor IQ : -</p>`);
                    htmlContent = htmlContent.replace('id="kualifikasiIq">Kualifikasi IQ:  </p>',
                        `id="kualifikasiIq">Kualifikasi IQ: -</p>`);
                }


                results.forEach((data) => {
                    if (data.typeUjian == 2) {
                        htmlContent += `
                <div class="mt-4"  style="page-break-before: always;"> 
                <p class="mt-4" style="color: black;">${data?.ujian?.nama}  </p></p>`;

                        let noKusoner = 0;
                        htmlContent +=
                            `<div class="table-responsive"><table border="1" style="width:100%; color: black;">`;
                        for (let index = 0; index < 20; index++) {
                            htmlContent += `<tr>`;
                            noKusoner = index + 1;
                            data.siswa.forEach((kuisoner, ndx) => {
                                htmlContent +=
                                    `<td style="text-align: left; width: 500px;"><p style="margin:10px; font-size: 10px; color: black;">${noKusoner}.${kuisoner?.kuisoner[noKusoner-1]?.detail_jawaban_kuisoner[0]?.kode ?? '-'}</p></td>`;
                                noKusoner = noKusoner + 20;
                            });
                            htmlContent += `</tr>`;
                        }

                        htmlContent += `</table></div>`;
                        htmlContent += `   <div class="row mt-3">`;

                        if (data.facet.some(facet => facet?.totalScore != 0)) {
                            data.facet.forEach((facet, ndxFacet) => {
                                htmlContent +=
                                    `     <div class="col-md-6" style="color: black;">${facet?.domain}: ${facet?.totalScore}</div>`;
                            });
                        }
                        htmlContent += `   </div>`;
                        htmlContent += `   <div class="row mt-3">`;

                        if (data?.sekala?.average_scores?.some(sekala => sekala?.average_score != 0)) {
                            if (data?.skorNilai) {
                                let total_score5_1 = 0;
                                data?.sekala?.average_scores?.forEach((sekala, ndxsekala) => {
                                    htmlContent +=
                                        `    <div class="col-md-6" style="color: black;">${sekala?.keterangan} : ${sekala?.total_score}</div>`;
                                    total_score5_1 += sekala?.total_score;
                                });
                                htmlContent +=
                                    `<div class="col-md-12 mt-5" style="color: black; text-align: center; font-weight: bold;">Skor  : ${total_score5_1}</div>`;
                            } else {
                                data?.sekala?.average_scores?.forEach((sekala, ndxsekala) => {
                                    htmlContent +=
                                        `    <div class="col-md-6" style="color: black;">${sekala?.keterangan} : ${sekala?.total_score}</div>`;
                                });
                                htmlContent +=
                                    `   
                        <div class="col-md-12 mt-2" style="color: black; text-align: center; font-weight: bold;">Skor Dark Triad Personality   : ${data?.sekala?.total_average_score}</div>`;
                            }
                        } else {
                            if (data?.skorNilai) {
                                console.log('skornilai51', data?.sekala);

                                htmlContent +=
                                    `<div class="col-md-12 mt-5" style="color: black; text-align: center; font-weight: bold;">Skor  : ${data?.kuisonersBenarSalah?.totalNilai}</div>`;
                            }
                        }
                        htmlContent += `   </div>`;
                        htmlContent += `    </div>`; // penutup div yang kurang
                        // Tambahkan chart untuk facet ini
                        const chartId = `facetChart_${data?.ujian?.kode}_${Math.random().toString(36).substr(2, 9)}`;
                        // htmlContent += `<div class="mt-4"><canvas id="${chartId}" width="600" height="300"></canvas></div>`;

                        // Data chart: gunakan facet?.labels dan facet?.nilai jika tersedia, fallback ke dummy data
                        setTimeout(() => {
                            const chartElem = document.getElementById(chartId);
                            if (chartElem) {
                                new Chart(chartElem.getContext('2d'), {
                                    type: 'bar',
                                    data: {
                                        labels: data?.facet?.[0]?.labels || ['A', 'B', 'C', 'D'],
                                        datasets: [{
                                            label: 'Nilai Facet',
                                            data: data?.facet?.[0]?.nilai || [10, 20, 30, 40],
                                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: false,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            }
                        }, 200);
                        results.forEach((subData) => {
                            console.log('facetfacetwertyui', subData?.ujian?.kode);

                            if (subData.typeUjian == 2 && data?.ujian?.kode == "part5_1") {
                                if (subData.facet.some(facet => facet?.totalScore != 0)) {
                                    subData.facet.forEach((facet, ndxFacet) => {
                                        //   ID unik untuk setiap chart
                                        const canvasId = `pointStyleChart_${ndxFacet}`;
                                        console.log('subDatafacet', facet?.subdomain);

                                        htmlContent += `
     <div class="mt-4" style="page-break-before: always;">
         <p class="mt-4" style="color: black;">${subData?.ujian?.nama} - ${facet?.domain} </p>
         <canvas id="${canvasId}"  ></canvas> 
     </div>
 `;

                                        htmlContent += `<table border="1">
    <thead></thead>`;
                                        Object.values(facet?.subdomain).forEach(f => {
                                            htmlContent += `
        <tr>
            <th colspan="6" style="text-align:left">Deskripsi Facet: ${f.deskripsi_facet} | Total Score: ${f.total_score}</th>
        </tr>
    `;

                                            //                                         htmlContent += `
                                        //     <tr>
                                        //         <th>Deskripsi Facet</th>
                                        //         <th>Total Score</th>
                                        //         <th>Facet Code</th>
                                        //         <th>Jawaban Kode</th>
                                        //         <th>Kuesioner Item</th>
                                        //         <th>Score</th>
                                        //     </tr>
                                        // `;

                                            //                                         f.items.forEach(item => {
                                            //                                             htmlContent += `
                                        //         <tr>
                                        //             <td>${item.deskripsi_facet}</td>
                                        //             <td>${f.total_score}</td>
                                        //             <td>${item.facet_code}</td>
                                        //             <td>${item.jawaban_kode}</td>
                                        //             <td>${item.kuisoner_item}</td>
                                        //             <td>${item.score}</td>
                                        //         </tr>
                                        //     `;
                                            //                                         });
                                        });

                                        htmlContent += `<tbody id="your-table-body-id"></tbody>
</table>`;

                                        // Pastikan script Chart.js dijalankan setelah elemen dimasukkan ke DOM
                                        setTimeout(() => {
                                                //  const ctx = document.getElementById(
                                                //      canvasId)?.getContext('2d');
                                                if (ctx) {
                                                    new Chart(ctx, {
                                                        type: 'line',
                                                        data: {
                                                            labels: facet
                                                                ?.labels ||
                                                                ['Senin',
                                                                    'Selasa',
                                                                    'Rabu',
                                                                    'Kamis',
                                                                    'Jumat',
                                                                    'Sabtu',
                                                                    'Minggu'
                                                                ],
                                                            datasets: [{
                                                                label: 'Nilai Siswa',
                                                                data: facet
                                                                    ?.nilai ||
                                                                    [65, 59,
                                                                        80,
                                                                        81,
                                                                        56,
                                                                        55,
                                                                        40
                                                                    ],
                                                                fill: false,
                                                                borderColor: 'rgb(75, 192, 192)',
                                                                tension: 0.1,
                                                                pointStyle: 'rectRot',
                                                                pointRadius: 8,
                                                                pointBorderColor: 'rgb(75, 192, 192)',
                                                                pointBackgroundColor: 'rgb(255, 99, 132)'
                                                            }]
                                                        },
                                                        options: {
                                                            plugins: {
                                                                legend: {
                                                                    display: true
                                                                }
                                                            },
                                                            scales: {
                                                                y: {
                                                                    beginAtZero: true
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            },
                                            100
                                        ); // beri jeda agar canvas sudah tersedia di DOM
                                    });

                                }
                            }

                        });
                    }
                    //  facet

                });

                itemPrint = element.innerHTML + htmlContent;
                modalReview(element.innerHTML + htmlContent);
            }).catch(error => {
                console.error('Error fetching student data:', error);
                element.querySelector('#pdf-content').innerHTML = '<p style="color: red;">Failed to load data.</p>';
                html2pdf().from(element).save(`Hasil_Test_${studentName}.pdf`);
            });


        }

        function modalReview(htmlContent) {

            const element = document.getElementById('pdf-content-review');
            element.innerHTML = htmlContent;
        }

        function fetchStudentData(studentId, kdUjian, typeUjian) {
            switch (typeUjian) {
                case 0:
                    return pg(studentId, kdUjian, typeUjian);
                case 1:
                    return essay(studentId, kdUjian, typeUjian);
                case 2:
                    return kuisoner(studentId, kdUjian, typeUjian);
                case 3:
                    return visual(studentId, kdUjian);
                default:
                    return Promise.reject('Invalid typeUjian');
            }
        }

        function pg(studentId, kdUjian, typeUjian) {
            const nilaiSiswa = {
                type: kdUjian,
                codeUjian: kdUjian,
                siswa: [],
                nilai: 0,
                typeUjian: typeUjian,
                niaiTambah: 0,
            };

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/siswa/pg/${studentId}/${kdUjian}`,
                    type: 'GET',
                    success: function(data, status, xhr) {
                        if (xhr.status === 200) {
                            data.data.forEach(element => {
                                nilaiSiswa.nilai += parseInt(element.nilai);
                                nilaiSiswa.siswa.push({
                                    jawaban: element?.jawaban,
                                    kunci_jawaban: element?.detailujian?.jawaban,
                                    nilai: element?.nilai
                                });
                                console.log('elementujian', element?.ujian);

                                nilaiSiswa.type = element?.ujian?.nama_ujian;
                                nilaiSiswa.niaiTambah = element?.ujian?.nilai_tambahan;
                            });
                            resolve(nilaiSiswa);
                        } else {
                            reject('Failed to fetch data');
                        }
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        function tScore(nilaiTscore, tanggal_lahir) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/tscore',
                    type: 'GET',
                    data: {
                        nilai: nilaiTscore,
                        tanggal_lahir: tanggal_lahir
                    },
                    success: function(response) {
                        // Pastikan data dikembalikan dalam format yang diharapkan
                        if (response) {
                            resolve(response);
                        } else {
                            reject(new Error("Response kosong atau tidak valid"));
                        }
                    },
                    error: function(xhr, status, error) {
                        reject(new Error(`Gagal mengambil data: ${error}`));
                    }
                });
            });
        }


        function kuisoner(studentId, kdUjian, typeUjian) {
            const nilaiSiswa = {
                type: kdUjian,
                codeUjian: kdUjian,
                siswa: [],
                kuisoner: [],
                facet: [],
                kuisonersBenarSalah: [],
                sekala: [],
                ujian: [],
                nilai: 0,
                skorNilai: false,
                typeUjian: typeUjian,
                niaiTambah: 0,
            };

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/siswa/kuisoner/${studentId}/${kdUjian}`,
                    type: 'GET',
                    success: function(data, status, xhr) {
                        if (xhr.status === 200) {
                            let kuisoner = data?.data?.kuisoner;
                            let facet = data?.data?.facet;
                            let sekala = data?.data?.sekala;
                            let kuisonersBenarSalah = data?.data?.kuisonersBenarSalah;
                            let ujian = data?.data?.ujian;
                            let skorNilai = data?.data?.skorNilai;
                            console.log('ujianujianujian', ujian);

                            kuisoner.forEach(element => {
                                nilaiSiswa.nilai += parseInt(element?.nilai);
                                nilaiSiswa.siswa.push({
                                    kuisoner: element,
                                    facet: facet,
                                    jawaban: element?.jawaban,
                                    nilai: element?.nilai
                                });

                            });
                            nilaiSiswa.facet = facet;
                            nilaiSiswa.skorNilai = skorNilai;
                            nilaiSiswa.sekala = sekala;
                            nilaiSiswa.ujian = ujian;
                            nilaiSiswa.kuisonersBenarSalah = kuisonersBenarSalah;
                            resolve(nilaiSiswa);
                        }
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        function essay(studentId, kdUjian, typeUjian) {
            const nilaiSiswa = {
                type: kdUjian,
                codeUjian: kdUjian,
                siswa: [],
                nilai: 0,
                typeUjian: typeUjian,
                niaiTambah: 0,
                jawaban_essay: 0,
            };

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/siswa/essay/${studentId}/${kdUjian}`,
                    type: 'GET',
                    success: function(data, status, xhr) {
                        if (xhr.status === 200) {
                            console.log('elementujian1234', data.data.ujian.nilai_tambahan);
                            data.data.essay.forEach(element => {

                                nilaiSiswa.nilai += parseInt(element.nilai);
                                nilaiSiswa.siswa.push({
                                    jawaban: element?.jawaban,
                                    nilai: element?.nilai,
                                    jawaban_essay: element?.detailessay,
                                    nilai_essay: element?.nilai,
                                });
                                nilaiSiswa.type = element?.ujian?.nama_ujian;
                                nilaiSiswa.niaiTambah = data.data.ujian.nilai_tambahan;
                            });
                            resolve(nilaiSiswa);
                        } else {
                            reject('Failed to fetch data');
                        }
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        function visual(studentId, kdUjian) {
            const nilaiSiswa = {
                type: kdUjian,
                codeUjian: kdUjian,
                siswa: [],
                nilai: 0,
                typeUjian: 3
            };

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/siswa/visual/${studentId}/${kdUjian}`,
                    type: 'GET',
                    success: function(data, status, xhr) {
                        if (xhr.status === 200) {
                            data.data.forEach(element => {
                                nilaiSiswa.nilai += parseInt(element.nilai);
                                nilaiSiswa.siswa.push({
                                    jawaban: element?.jawaban_1 + '-' + element
                                        ?.jawaban_2,
                                    nilai: element.nilai
                                });
                                nilaiSiswa.type = element?.ujian?.nama_ujian;
                            });
                            resolve(nilaiSiswa);
                        } else {
                            reject('Failed to fetch data');
                        }
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }


        function printNilaiSiswa() {
            // Ambil komentar dari textarea
            var komentar = document.getElementById('formKomentar').value;
            const element = document.createElement('div');
            element.innerHTML = itemPrint;
            element.style.padding = '20px';
            element.innerHTML += `
            <div style="margin-top: 20px; color: black;">
                <strong>Komentar:</strong>
                <p>${komentar || 'Tidak ada komentar'}</p>
            </div>
        `;

            html2pdf().from(element).save(`Hasil_Test_${namaPeserta}.pdf`);
        }
    </script>
    <script>
        const itemsPerPage = 10;
        let currentPage = 1;
        let data = @json($MergeUjianSiswa);

        function renderTable(data) {
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedData = data.slice(start, end);

            paginatedData.forEach((bs, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${start + index + 1}</td>
                    <td>${bs.nama_siswa_pg ?? (bs.nama_siswa_visual ?? (bs.nama_siswa_essay ?? (bs.nama_siswa_kuesioner ?? 'Nama siswa tidak tersedia')))}</td>
                    <td>${bs.tempat_lahir_pg ?? 'Tempat lahir siswa tidak tersedia'}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModal"
                            onclick="printPDF(
                        '${bs.id_siswa_pg ?? (bs.id_siswa_visual ?? (bs.id_siswa_essay ?? (bs.id_siswa_kuesioner ?? '')))}',
                        '${bs.nama_siswa_pg ?? 'Nama siswa tidak tersedia'}',
                        '${bs.tempat_lahir_pg ?? 'Tempat lahir siswa tidak tersedia'}',
                        '${bs.tanggal_lahir_pg ?? 'Tanggal Lahir siswa tidak tersedia'}',
                        '${bs.gender_pg ?? 'Tanggal Lahir siswa tidak tersedia'}')">
                            Hasil Tes
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function renderPagination(data) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const pageCount = Math.ceil(data.length / itemsPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const pageItem = document.createElement('li');
                pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
                pageItem.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>`;
                pagination.appendChild(pageItem);
            }
        }

        function goToPage(page) {
            currentPage = page;
            renderTable(data);
            renderPagination(data);
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const filteredData = data.filter(bs =>
                (bs.nama_siswa_pg ?? bs.nama_siswa_visual ?? bs.nama_siswa_essay ?? bs.nama_siswa_kuesioner ??
                    '').toLowerCase().includes(searchTerm)
            );
            currentPage = 1;
            renderTable(filteredData);
            renderPagination(filteredData);
            document.getElementById('totalData').innerText = filteredData.length;
        });

        // Initial render
        renderTable(data);
        renderPagination(data);
    </script>
    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    {!! session('pesan') !!}
@endsection
