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
                                <div class="mt-3">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Search by name">
                                </div>
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
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($MergeUjianSiswa as $key => $bs)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>
                                                        {{ $bs->nama_siswa_pg ?? ($bs->nama_siswa_visual ?? ($bs->nama_siswa_essay ?? ($bs->nama_siswa_kuesioner ?? 'Nama siswa tidak tersedia'))) }}
                                                    </td>
                                                    {{-- <td>
                                                        {{ $bs->tempat_lahir_pg ?? 'Tempat lahir siswa tidak tersedia' }}
                                                    </td> --}}
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#exampleModal"
                                                            onclick="printPDF(
                                                        '{{ $bs->id_siswa_pg ?? ($bs->id_siswa_visual ?? ($bs->id_siswa_essay ?? ($bs->id_siswa_kuesioner ?? ''))) }}',
                                                        '{{ $bs->nama_siswa_pg ?? 'Nama siswa tidak tersedia' }}',
                                                        '{{ $bs->tempat_lahir_pg ?? 'Tempat lahir siswa tidak tersedia' }}',
                                                        '{{ $bs->tanggal_lahir_pg ?? 'Tanggal Lahir siswa tidak tersedia' }}',
                                                        '{{ $bs->gender_pg ?? 'Tanggal Lahir siswa tidak tersedia' }}')">
                                                            Hasil Tes
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example" class="d-flex justify-content-end">
                                        <ul class="pagination" id="pagination">
                                            <!-- Pagination items will be added here by JavaScript -->
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
                        <textarea class="form-control"  id="formKomentar" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="printNilaiSiswa()">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <script>
        let itemPrint = '';

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
            ]).then(results => {

                let jumlahKolom = 0;
                let jumlahKolom2 = 0;
                results.forEach((data) => {
                    if (data.typeUjian != 2) {
                        jumlahKolom = data.siswa.length > jumlahKolom ? data.siswa.length : jumlahKolom;
                    }
                    if (data.typeUjian == 2) {
                        jumlahKolom2 = data.siswa.length > jumlahKolom ? data.siswa.length : jumlahKolom;
                    }
                });

                htmlContent = `<div class="table-responsive"><table border="1" style="width:100%; color: black;">`;

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
                            console.log('data.siswa', data.siswa[i]);

                            let jawaban = (data?.siswa[i]?.jawaban ?? '-').toLowerCase();
                            let kunci_jawaban = (data?.siswa[i]?.kunci_jawaban ?? '-').toLowerCase();
                            let jawaban_essay = data?.siswa[i]?.jawaban_essay?.jawaban_essay.length ?? 0;
                            // let jawaban_essay =  0;

                            // console.log(`jawaban_essayqwertyui ${data.type}`, data?.siswa[i]?.nilai);

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
                results.forEach((data) => {
                    if (data.typeUjian != 2) {
                        console.log('dataertyuio', data);

                        htmlContent +=
                            `<td><p style="margin:10px; color: black;">${data.nilai+(data?.niaiTambah ?? 0)}</p></td>`;
                    }
                });
                htmlContent += `</tr>`;

                htmlContent += `</table></div>`;
                // ----------------------------------------------------------------------------------------------------------------

                results.forEach((data) => {
                    if (data.typeUjian == 2) {
                        console.log('data.jenis_jawaban_kuesioner_id', data?.ujian
                            ?.jenis_jawaban_kuesioner_id);


                        htmlContent += `
                <div class="mt-4"  style="page-break-before: always;"> 
                <p class="mt-4" style="color: black;">${data?.ujian?.nama}</p></p>`;

                        let noKusoner = 0;
                        htmlContent +=
                            `<div class="table-responsive"><table border="1" style="width:100%; color: black;">`;
                        for (let index = 0; index < 20; index++) {
                            htmlContent += `<tr>`;
                            noKusoner = index + 1;
                            data.siswa.forEach((kuisoner, ndx) => {
                                console.log("cek kuisoner", kuisoner?.kuisoner[noKusoner - 1]);
                                htmlContent +=
                                    `<td style="text-align: left; width: 500px;"><p style="margin:10px; font-size: 10px; color: black;">${noKusoner}.${kuisoner?.kuisoner[noKusoner-1]?.detail_jawaban_kuisoner[0]?.kode ?? '-'}</p></td>`;
                                noKusoner = noKusoner + 20;
                            });
                            htmlContent += `</tr>`;
                        }

                        htmlContent += `</table></div>`;
                        htmlContent += `   <div class="row mt-3">`;
                        console.log('data.facet', data);

                        if (data.facet.some(facet => facet?.totalScore != 0)) {
                            data.facet.forEach((facet, ndxFacet) => {

                                htmlContent +=
                                    `     <div class="col-md-6" style="color: black;">${facet?.domain}: ${facet?.totalScore}</div>`;

                            });
                        }
                        htmlContent += `   </div>`;
                        htmlContent += `   <div class="row mt-3">`;
                        console.log('data.sekaladata?.sekala?.total_average_score', data?.skorNilai);

                        if (data?.sekala?.average_scores?.some(sekala => sekala?.average_score != 0)) {


                            if (data?.skorNilai) {

                                htmlContent +=
                                    `<div class="col-md-12 mt-5" style="color: black; text-align: center; font-weight: bold;">Skor  : ${data?.kuisonersBenarSalah?.totalNilai}</div>`;

                            } else {
                                data?.sekala?.average_scores?.forEach((sekala, ndxsekala) => {

                                    htmlContent +=
                                        `    <div class="col-md-6" style="color: black;">${sekala?.keterangan} : ${sekala?.average_score}</div>`;

                                });
                                htmlContent +=
                                    `   
                        <div class="col-md-12 mt-2" style="color: black; text-align: center; font-weight: bold;">Skor Dark Triad Personality   : ${data?.sekala?.total_average_score}</div>`;

                            }
                        } else {
                            if (data?.skorNilai) {

                                htmlContent +=
                                    `<div class="col-md-12 mt-5" style="color: black; text-align: center; font-weight: bold;">Skor  : ${data?.kuisonersBenarSalah?.totalNilai}</div>`;

                            }
                        }
                        htmlContent += `   </div>`;
                        htmlContent += `    </div>`; // penutup div yang kurang
                    }


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

        function kuisoner(studentId, kdUjian, typeUjian) {
            const nilaiSiswa = {
                type: kdUjian,
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

            html2pdf().from(element).save(`Hasil_Test_.pdf`);
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
