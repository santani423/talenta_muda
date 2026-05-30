@extends('template.main')
@section('title', 'Laporan Ujian Siswa')

@section('content')
    @include('template.navbar.guru')
    <style>
        .spinner-cell {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #ccc;
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            vertical-align: middle;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .chart-wrap { margin: 16px 0; }
        .chart-wrap canvas { max-width: 100%; }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3" style="min-height: 500px;">
                        <div class="widget-heading">
                            <h5>Laporan Ujian Peserta</h5>
                        </div>

                        {{-- Filter Form --}}
                        <div class="row g-2 mt-3" id="filterForm">
                            <div class="col-md-4">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search by name">
                            </div>
                            <div class="col-md-4">
                                <select id="batchSelect" class="form-control">
                                    <option value="">-- Pilih Batch --</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex gap-2">
                                <input type="number" id="limitInput" class="form-control" value="10" min="1" placeholder="Jumlah Data">
                                <button class="btn btn-primary" onclick="applyFilter()">Search</button>
                            </div>
                        </div>

                        <div class="table-responsive mt-3" style="overflow-x: scroll;">
                            <button id="downloadBtn" class="btn btn-success mb-2" onclick="downloadExcel()">
                                Download Excel
                            </button>

                            <table id="datatable-table" class="table text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Hasil Ujian</th>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Sex</th>
                                        <th>Usia</th>
                                        <th>IQ CFIT</th>
                                        <th>Score IQ</th>
                                        <th>Norma</th>
                                        <th>MR</th>
                                        <th>Norma</th>
                                        <th>ARTH</th>
                                        <th>Norma</th>
                                        <th>SIM</th>
                                        <th>Norma</th>
                                        <th>5.1. NEUROTICISM</th>
                                        <th></th>
                                        <th>EXTRAVERSION</th>
                                        <th></th>
                                        <th>OPENESS TO EXPERIENCE</th>
                                        <th></th>
                                        <th>AGREEABLENESS</th>
                                        <th></th>
                                        <th>CONSCIENTIOUSNESS</th>
                                        <th></th>
                                        <th>Anxiety</th>
                                        <th>Angry Hostility</th>
                                        <th>Depression</th>
                                        <th>Self Consciouseness</th>
                                        <th>Impulsiveness</th>
                                        <th>Vulnerability</th>
                                        <th>Warmth</th>
                                        <th>Gregariousness</th>
                                        <th>Assertiveness</th>
                                        <th>Activity</th>
                                        <th>Excitement Seeking</th>
                                        <th>Positive Emotions</th>
                                        <th>Fantasy</th>
                                        <th>Aesthetic</th>
                                        <th>Feelings</th>
                                        <th>Actions</th>
                                        <th>Ideas</th>
                                        <th>Values</th>
                                        <th>Trust</th>
                                        <th>Straightforwardness</th>
                                        <th>Altruism</th>
                                        <th>Compliance</th>
                                        <th>Modesty</th>
                                        <th>Tender-mindedness</th>
                                        <th>Competence</th>
                                        <th>Order</th>
                                        <th>Dutifulness</th>
                                        <th>Achievement Striving</th>
                                        <th>Self-discipline</th>
                                        <th>Deliberation</th>
                                        <th>5.2. Crudelia</th>
                                        <th>Egoism</th>
                                        <th>Machiavellianism</th>
                                        <th>Narcissism</th>
                                        <th>Frustalia</th>
                                        <th>Greed</th>
                                        <th>Moral Disengagement</th>
                                        <th>Psychological Entitlement</th>
                                        <th>Psychopathy</th>
                                        <th>Sadism</th>
                                        <th>Self Centeredness</th>
                                        <th>Spitefulness</th>
                                        <th>5.3. College Maladjustment (Mt)</th>
                                        <th>Lie Scale (L)</th>
                                        <th>Neg Treatment Indicator (TRT)</th>
                                        <th>Lack of self motivation (TRT1)</th>
                                        <th>Lack of self disclosure (TRT2)</th>
                                        <th>CATATAN</th>
                                        <th>REKOMENDASI</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr><td colspan="72" class="text-center">
                                        <span class="spinner-cell"></span> Memuat data...
                                    </td></tr>
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <nav>
                                <ul class="pagination justify-content-end" id="pagination"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('template.footer')
    </div>

    {{-- Modal Hasil Tes --}}
    <div class="modal fade" id="modalHasilTes" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hasil Tes</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" style="max-height:80vh;overflow-y:auto;">
                    <div id="modalBodyContent"></div>
                    <div class="form-group mt-4">
                        <textarea class="form-control" id="formKomentar" rows="5" placeholder="Komentar..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printNilaiSiswa()">Print PDF</button>
                </div>
            </div>
        </div>
    </div>

    @if($show_chart)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
    const SHOW_CHART = @json($show_chart);
    // ─── State ────────────────────────────────────────────────────────────────
    let state = { search: '', batch: '', limit: 10, page: 1 };
    let currentPrintPayload = null;
    let currentPrintName    = '';
    let modalChartInstances = {};

    // ─── Boot ─────────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadBatch();
        loadSiswa();
        document.getElementById('searchInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') applyFilter();
        });
    });

    // ─── Batch (kelas) dropdown ───────────────────────────────────────────────
    async function loadBatch() {
        const res  = await fetch('/api/laporan/batch');
        const json = await res.json();
        const sel  = document.getElementById('batchSelect');
        json.data.forEach(k => {
            const opt = document.createElement('option');
            opt.value       = k.id;
            opt.textContent = k.nama_kelas;
            sel.appendChild(opt);
        });
    }

    // ─── Load list siswa ──────────────────────────────────────────────────────
    async function loadSiswa() {
        document.getElementById('tableBody').innerHTML =
            `<tr><td colspan="72" class="text-center"><span class="spinner-cell"></span> Memuat data...</td></tr>`;

        const params = new URLSearchParams({
            search: state.search,
            batch:  state.batch,
            limit:  state.limit,
            page:   state.page,
        });

        const res  = await fetch(`/api/laporan/siswa?${params}`);
        const json = await res.json();

        renderTable(json.data, json.meta);
        renderPagination(json.meta);

        json.data.forEach(siswa => loadNilaiSiswa(siswa.id));
    }

    // ─── Render tabel ─────────────────────────────────────────────────────────
    function renderTable(rows, meta) {
        const tbody = document.getElementById('tableBody');
        if (!rows.length) {
            tbody.innerHTML = `<tr><td colspan="72" class="text-center text-muted">Tidak ada data</td></tr>`;
            return;
        }

        const offset = (meta.current_page - 1) * meta.per_page;
        tbody.innerHTML = rows.map((s, i) => {
            const id   = s.id;
            const nama = s.nama_siswa ?? '-';
            const spin = `<span class="spinner-cell"></span>`;
            return `
            <tr id="row-${id}">
                <td>
                    <button class="btn btn-primary btn-sm"
                        data-toggle="modal" data-target="#modalHasilTes"
                        onclick="openModalHasil(${id}, '${esc(nama)}', '${esc(s.tempat_lahir)}', '${esc(s.tanggal_lahir)}', '${esc(s.gender)}')">
                        Hasil Tes
                    </button>
                </td>
                <td>${offset + i + 1}</td>
                <td>${nama}</td>
                <td>${s.tanggal_lahir ?? '-'}</td>
                <td>${s.gender ?? '-'}</td>
                <td>${s.umur ?? '-'}</td>
                <td id="nilaiIQ-${id}">${spin}</td>
                <td id="scoreIQ-${id}">${spin}</td>
                <td id="norma-${id}">${spin}</td>
                <td id="MR-${id}">${spin}</td>
                <td></td>
                <td id="ARTd-${id}">${spin}</td>
                <td></td>
                <td id="SIM-${id}">${spin}</td>
                <td></td>
                <td id="NEUROTICISM-${id}">${spin}</td><td></td>
                <td id="EXTRAVERSION-${id}">${spin}</td><td></td>
                <td id="OPENESSTOEXPERIENCE-${id}">${spin}</td><td></td>
                <td id="AGREEABLENESS-${id}">${spin}</td><td></td>
                <td id="CONSCIENTIOUSNESS-${id}">${spin}</td><td></td>
                <td id="anxiety-${id}">${spin}</td>
                <td id="angry_hostility-${id}">${spin}</td>
                <td id="depression-${id}">${spin}</td>
                <td id="self_consciousness-${id}">${spin}</td>
                <td id="impulsiveness-${id}">${spin}</td>
                <td id="vulnerability-${id}">${spin}</td>
                <td id="warmth-${id}">${spin}</td>
                <td id="gregariousness-${id}">${spin}</td>
                <td id="assertiveness-${id}">${spin}</td>
                <td id="activity-${id}">${spin}</td>
                <td id="excitement_seeking-${id}">${spin}</td>
                <td id="positive_emotions-${id}">${spin}</td>
                <td id="fantasy-${id}">${spin}</td>
                <td id="aesthetic-${id}">${spin}</td>
                <td id="feelings-${id}">${spin}</td>
                <td id="actions-${id}">${spin}</td>
                <td id="ideas-${id}">${spin}</td>
                <td id="values-${id}">${spin}</td>
                <td id="trust-${id}">${spin}</td>
                <td id="straightforwardness-${id}">${spin}</td>
                <td id="altruism-${id}">${spin}</td>
                <td id="compliance-${id}">${spin}</td>
                <td id="modesty-${id}">${spin}</td>
                <td id="tenderMindedness-${id}">${spin}</td>
                <td id="competence-${id}">${spin}</td>
                <td id="order-${id}">${spin}</td>
                <td id="dutifulness-${id}">${spin}</td>
                <td id="achievement-${id}">${spin}</td>
                <td id="SelfDiscipline-${id}">${spin}</td>
                <td id="deliberation-${id}">${spin}</td>
                <td id="CRUD-${id}">${spin}</td>
                <td id="EGO-${id}">${spin}</td>
                <td id="MACH-${id}">${spin}</td>
                <td id="NARC-${id}">${spin}</td>
                <td id="FRUST-${id}">${spin}</td>
                <td id="GRD-${id}">${spin}</td>
                <td id="MD-${id}">${spin}</td>
                <td id="PE-${id}">${spin}</td>
                <td id="PSY-${id}">${spin}</td>
                <td id="SAD-${id}">${spin}</td>
                <td id="SC-${id}">${spin}</td>
                <td id="SPITE-${id}">${spin}</td>
                <td id="Mt-${id}">${spin}</td>
                <td id="L-${id}">${spin}</td>
                <td id="TRT-${id}">${spin}</td>
                <td id="TRT1-${id}">${spin}</td>
                <td id="TRT2-${id}">${spin}</td>
                <td></td>
                <td></td>
            </tr>`;
        }).join('');
    }

    // ─── Load nilai satu siswa (1 API call) ───────────────────────────────────
    async function loadNilaiSiswa(id) {
        try {
            const res  = await fetch(`/api/laporan/siswa/${id}/semua-nilai`);
            const json = await res.json();
            if (json.status !== 'success') return;

            const n = json.nilai;
            set(id, 'nilaiIQ',  n.tscore);
            set(id, 'scoreIQ',  n.skor_iq);
            set(id, 'norma',    n.kualifikasi);
            set(id, 'MR',       n.tscore);
            set(id, 'ARTd',     n.artd);
            set(id, 'SIM',      n.sim);

            const parts = json.parts;

            const p51 = parts['part5_1'];
            if (p51 && p51.facet) {
                p51.facet.forEach(facet => {
                    const dom   = facet.domain;
                    const total = facet.totalScore;
                    if (dom === 'NEUROTICISM')           set(id, 'NEUROTICISM', total);
                    if (dom === 'EXTRAVERSION')          set(id, 'EXTRAVERSION', total);
                    if (dom === 'OPENESS TO EXPERIENCE') set(id, 'OPENESSTOEXPERIENCE', total);
                    if (dom === 'AGREEABLENESS')         set(id, 'AGREEABLENESS', total);
                    if (dom === 'CONSCIENTIOUSNESS')     set(id, 'CONSCIENTIOUSNESS', total);

                    const sd = facet.subdomain ?? {};
                    setSD(id, sd, 'anxiety',             'anxiety');
                    setSD(id, sd, 'angry',               'angry_hostility');
                    setSD(id, sd, 'depression',          'depression');
                    setSD(id, sd, 'impulsiveness',       'impulsiveness');
                    setSD(id, sd, 'vulnerability',       'vulnerability');
                    setSD(id, sd, 'warmth',              'warmth');
                    setSD(id, sd, 'gregariousness',      'gregariousness');
                    setSD(id, sd, 'assertiveness',       'assertiveness');
                    setSD(id, sd, 'activity',            'activity');
                    setSD(id, sd, 'excitement',          'excitement_seeking');
                    setSD(id, sd, 'positive',            'positive_emotions');
                    setSD(id, sd, 'fantasy',             'fantasy');
                    setSD(id, sd, 'aesthetic',           'aesthetic');
                    setSD(id, sd, 'feelings',            'feelings');
                    setSD(id, sd, 'actions',             'actions');
                    setSD(id, sd, 'ideas',               'ideas');
                    setSD(id, sd, 'values',              'values');
                    setSD(id, sd, 'trust',               'trust');
                    setSD(id, sd, 'straightforwardness', 'straightforwardness');
                    setSD(id, sd, 'altruism',            'altruism');
                    setSD(id, sd, 'compliance',          'compliance');
                    setSD(id, sd, 'modesty',             'modesty');
                    setSD(id, sd, 'tender',              'tenderMindedness');
                    setSD(id, sd, 'competence',          'competence');
                    setSD(id, sd, 'order',               'order');
                    setSD(id, sd, 'dutifulness',         'dutifulness');
                    setSD(id, sd, 'achievement',         'achievement');
                    setSD(id, sd, 'self',                'SelfDiscipline');
                    setSD(id, sd, 'deliberation',        'deliberation');

                    if (sd['self'] && sd['self'].code_facet === 'n4') {
                        set(id, 'self_consciousness', sd['self'].total_score);
                    }
                });
            }

            const p52 = parts['part5_2'];
            if (p52 && p52.sekala && p52.sekala.average_scores) {
                p52.sekala.average_scores.forEach(s => {
                    const kodeMap = {
                        CRUD: 'CRUD', EGO: 'EGO', MACH: 'MACH', NARC: 'NARC',
                        FRUST: 'FRUST', GRD: 'GRD', MD: 'MD', PE: 'PE',
                        PSY: 'PSY', SAD: 'SAD', SC: 'SC', SPITE: 'SPITE',
                    };
                    if (kodeMap[s.kode_sekala]) set(id, kodeMap[s.kode_sekala], s.average_score);
                });
            }

            const p53 = parts['part5_3'];
            if (p53 && p53.sekala && p53.sekala.average_scores) {
                p53.sekala.average_scores.forEach(s => {
                    const kodeMap = { Mt: 'Mt', L: 'L', TRT: 'TRT', TRT1: 'TRT1', TRT2: 'TRT2' };
                    if (kodeMap[s.kode_sekala]) set(id, kodeMap[s.kode_sekala], s.total_score);
                });
            }
        } catch (e) {
            console.error('loadNilaiSiswa error', id, e);
        }
    }

    // ─── DOM helpers ──────────────────────────────────────────────────────────
    function set(id, field, val) {
        const el = document.getElementById(`${field}-${id}`);
        if (el) el.textContent = val ?? '-';
    }
    function setSD(id, sd, sdKey, elKey) {
        if (sd[sdKey]) set(id, elKey, sd[sdKey].total_score);
    }
    function esc(str) {
        return (str ?? '').replace(/'/g, "\\'").replace(/\n/g, ' ');
    }

    // ─── Filter + Search ──────────────────────────────────────────────────────
    function applyFilter() {
        state.search = document.getElementById('searchInput').value;
        state.batch  = document.getElementById('batchSelect').value;
        state.limit  = parseInt(document.getElementById('limitInput').value) || 10;
        state.page   = 1;
        loadSiswa();
    }

    // ─── Pagination ───────────────────────────────────────────────────────────
    function renderPagination(meta) {
        const ul = document.getElementById('pagination');
        ul.innerHTML = '';

        const prev = document.createElement('li');
        prev.className = `page-item ${meta.current_page === 1 ? 'disabled' : ''}`;
        prev.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${meta.current_page - 1})">Previous</a>`;
        ul.appendChild(prev);

        for (let i = 1; i <= meta.last_page; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === meta.current_page ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        const next = document.createElement('li');
        next.className = `page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}`;
        next.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${meta.current_page + 1})">Next</a>`;
        ul.appendChild(next);
    }

    function goToPage(page) {
        if (page < 1) return;
        state.page = page;
        loadSiswa();
    }

    // ─── Modal Hasil Tes ──────────────────────────────────────────────────────
    async function openModalHasil(id, nama, tempatLahir, tanggalLahir, gender) {
        // Destroy existing chart instances
        Object.values(modalChartInstances).forEach(c => { try { c.destroy(); } catch(e) {} });
        modalChartInstances = {};

        currentPrintName = nama;
        const body = document.getElementById('modalBodyContent');
        body.innerHTML = `<div class="text-center py-4"><span class="spinner-border text-primary"></span></div>`;

        const res  = await fetch(`/api/laporan/siswa/${id}/semua-nilai`);
        const json = await res.json();

        if (json.status !== 'success') {
            body.innerHTML = '<p class="text-danger">Gagal memuat data.</p>';
            return;
        }

        currentPrintPayload = { json, nama, tempatLahir, tanggalLahir, gender };
        body.innerHTML = buildModalHtml(json, nama, tempatLahir, tanggalLahir, gender);

        // Render charts setelah HTML ada di DOM (hanya jika SHOW_CHART aktif)
        if (SHOW_CHART) renderModalCharts(json);
    }

    // ─── Build modal HTML (static content + canvas placeholders) ─────────────
    function buildModalHtml(json, nama, tempatLahir, tanggalLahir, gender) {
        const n     = json.nilai;
        const parts = json.parts;
        const umur  = hitungUsia(tanggalLahir);

        let html = `
        <h5 class="text-center" style="color:black">HASIL TEST TALENTA MUDA</h5>
        <table style="color:black">
            <tr><td><b>Nama</b></td><td>:</td><td>${nama}</td></tr>
            <tr><td><b>Tempat/Tgl Lahir</b></td><td>:</td><td>${tempatLahir}, ${tanggalLahir}</td></tr>
            <tr><td><b>Jenis Kelamin</b></td><td>:</td><td>${gender}</td></tr>
            <tr><td><b>Usia</b></td><td>:</td><td>${umur} tahun</td></tr>
        </table>
        <hr>
        <p style="color:black"><b>Skor IQ:</b> ${n.skor_iq} &nbsp; <b>Kualifikasi:</b> ${n.kualifikasi}</p>`;

        // Tabel PG / Visual / Essay
        const pgParts = ['part1_1', 'part1_2', 'part1_3', 'part1_4', 'part2', 'part3', 'part4'];

        html += `<div class="table-responsive"><table border="1" style="width:100%;color:black"><tr>`;
        pgParts.forEach(kode => {
            const p = parts[kode];
            html += `<td style="padding:4px"><b>${p?.type ?? kode}</b></td>`;
        });
        html += `</tr>`;

        const maxRows = Math.max(...pgParts.map(k => parts[k]?.siswa?.length ?? 0));
        for (let i = 0; i < maxRows; i++) {
            html += `<tr>`;
            pgParts.forEach(kode => {
                const p  = parts[kode];
                const s  = p?.siswa?.[i];
                const jw = s?.jawaban ?? '-';
                const ni = s?.nilai;
                const check = (ni == 1) ? '✔' : (ni == 0 && ni !== null ? '✘' : '');
                html += `<td style="padding:2px;font-size:11px">${String(i+1).padStart(2,'0')}. ${jw} ${check}</td>`;
            });
            html += `</tr>`;
        }
        html += `<tr>`;
        pgParts.forEach(kode => {
            const p = parts[kode];
            html += `<td style="padding:4px"><b>${(p?.nilai ?? 0) + (p?.niaiTambah ?? 0)}</b></td>`;
        });
        html += `</tr></table></div>`;

        // Kuesioner sections
        ['part5_1', 'part5_2', 'part5_3'].forEach(kode => {
            const p = parts[kode];
            if (!p) return;
            html += `<div class="mt-4" style="page-break-before:always">`;
            html += `<p style="color:black"><b>${p.ujian?.nama_ujian ?? kode}</b></p>`;

            // ── Tabel jawaban kuesioner (20 baris × N chunk kolom) ─────────────
            if (p.siswa && p.siswa.length) {
                html += `<div class="table-responsive"><table border="1" style="width:100%;color:black;">`;
                for (let i = 0; i < 20; i++) {
                    html += `<tr>`;
                    let qNo = i + 1;
                    p.siswa.forEach(chunk => {
                        const item = Array.isArray(chunk) ? chunk[i] : null;
                        html += `<td style="text-align:left;"><p style="margin:6px;font-size:10px;color:black;">${qNo}. ${item?.jawaban ?? '-'}</p></td>`;
                        qNo += 20;
                    });
                    html += `</tr>`;
                }
                html += `</table></div>`;
            }

            // ── Facet domain totals + chart ────────────────────────────────────
            if (p.facet && p.facet.some(f => f.totalScore != 0)) {
                html += `<div class="row mt-3">`;
                p.facet.forEach(f => {
                    html += `<div class="col-md-6" style="color:black">${f.domain}: <b>${f.totalScore}</b></div>`;
                });
                html += `</div>`;
                if (SHOW_CHART) {
                    html += `<div class="chart-wrap"><canvas id="chart-${kode}-domain" height="120"></canvas></div>`;
                }

                // ── Subdomain detail per domain (khusus part5_1) ────────────
                if (kode === 'part5_1') {
                    p.facet.forEach(f => {
                        const subEntries = Object.values(f.subdomain ?? {});
                        if (!subEntries.length) return;
                        const domainSlug = f.domain.replace(/\s+/g, '-');
                        html += `<div class="mt-3" style="page-break-before:always">`;
                        html += `<p style="color:black"><b>${p.ujian?.nama_ujian ?? kode} — ${f.domain}</b></p>`;
                        if (SHOW_CHART) {
                            html += `<canvas id="chart-${kode}-${domainSlug}" height="80"></canvas>`;
                        }
                        html += `<table border="1" style="width:100%;color:black;font-size:11px;">`;
                        html += `<thead><tr><th style="padding:4px;text-align:left">Facet</th><th style="padding:4px;">Total Score</th></tr></thead><tbody>`;
                        subEntries.forEach(sd => {
                            html += `<tr>
                                <td style="padding:4px;text-align:left">${sd.deskripsi_facet ?? ''}</td>
                                <td style="padding:4px;text-align:center">${sd.total_score ?? 0}</td>
                            </tr>`;
                        });
                        html += `</tbody></table></div>`;
                    });
                }

                if (SHOW_CHART) {
                    html += `<div class="chart-wrap"><canvas id="chart-${kode}-facets" height="180"></canvas></div>`;
                }
            }

            // ── Sekala scores + chart ──────────────────────────────────────────
            if (p.sekala && p.sekala.average_scores && p.sekala.average_scores.some(s => s.average_score != 0)) {
                html += `<div class="row mt-2">`;
                if (p.skorNilai) {
                    let total = 0;
                    p.sekala.average_scores.forEach(s => {
                        html += `<div class="col-md-6" style="color:black">${s.keterangan}: ${s.total_score}</div>`;
                        total += s.total_score;
                    });
                    html += `<div class="col-md-12 mt-3" style="color:black;font-weight:bold;text-align:center">Skor: ${total}</div>`;
                } else {
                    p.sekala.average_scores.forEach(s => {
                        html += `<div class="col-md-6" style="color:black">${s.keterangan}: ${Math.ceil((s.total_score / s.count) * 10) / 10}</div>`;
                    });
                    html += `<div class="col-md-12 mt-2" style="color:black;font-weight:bold;text-align:center">Skor Dark Triad: ${p.sekala.total_average_score}</div>`;
                }
                html += `</div>`;
                if (SHOW_CHART) {
                    html += `<div class="chart-wrap"><canvas id="chart-${kode}-sekala" height="120"></canvas></div>`;
                }
            } else if (p.skorNilai) {
                html += `<div class="mt-3" style="color:black;font-weight:bold;text-align:center">Skor: ${p.kuisonersBenarSalah?.totalNilai ?? 0}</div>`;
            }

            html += `</div>`;
        });

        return html;
    }

    // ─── Render Chart.js instances ke canvas di modal ─────────────────────────
    function renderModalCharts(json) {
        const parts = json.parts;

        ['part5_1', 'part5_2', 'part5_3'].forEach(kode => {
            const p = parts[kode];
            if (!p) return;

            // Radar chart domain (NEO-PI)
            if (p.facet && p.facet.some(f => f.totalScore != 0)) {
                const domCanvas = document.getElementById(`chart-${kode}-domain`);
                if (domCanvas) {
                    const labels = p.facet.map(f => f.domain);
                    const data   = p.facet.map(f => f.totalScore);
                    modalChartInstances[`${kode}-domain`] = new Chart(domCanvas, {
                        type: 'radar',
                        data: {
                            labels,
                            datasets: [{
                                label: 'Domain Score',
                                data,
                                backgroundColor: 'rgba(54,162,235,0.2)',
                                borderColor:     'rgba(54,162,235,1)',
                                pointBackgroundColor: 'rgba(54,162,235,1)',
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: { r: { beginAtZero: true, ticks: { stepSize: 20 } } },
                        }
                    });
                }

                // Bar chart subdomains (semua domain digabung)
                const facetCanvas = document.getElementById(`chart-${kode}-facets`);
                if (facetCanvas) {
                    const facetLabels = [];
                    const facetData   = [];
                    const facetColors = [];
                    const domColors = [
                        'rgba(255,99,132,0.7)',
                        'rgba(255,159,64,0.7)',
                        'rgba(255,205,86,0.7)',
                        'rgba(75,192,192,0.7)',
                        'rgba(54,162,235,0.7)',
                    ];
                    p.facet.forEach((f, di) => {
                        Object.values(f.subdomain ?? {}).forEach(sd => {
                            facetLabels.push(sd.deskripsi_facet ?? sd.code_facet ?? '');
                            facetData.push(sd.total_score ?? 0);
                            facetColors.push(domColors[di % domColors.length]);
                        });
                    });
                    if (facetLabels.length) {
                        modalChartInstances[`${kode}-facets`] = new Chart(facetCanvas, {
                            type: 'bar',
                            data: {
                                labels: facetLabels,
                                datasets: [{
                                    label: 'Facet Score',
                                    data: facetData,
                                    backgroundColor: facetColors,
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                responsive: true,
                                indexAxis: 'y',
                                plugins: { legend: { display: false } },
                                scales: { x: { beginAtZero: true } },
                            }
                        });
                    }
                }

                // Mini bar chart per domain (khusus part5_1)
                if (kode === 'part5_1') {
                    p.facet.forEach(f => {
                        const subEntries = Object.values(f.subdomain ?? {});
                        if (!subEntries.length) return;
                        const domainSlug = f.domain.replace(/\s+/g, '-');
                        const domCanvas  = document.getElementById(`chart-${kode}-${domainSlug}`);
                        if (!domCanvas) return;
                        modalChartInstances[`${kode}-${domainSlug}`] = new Chart(domCanvas, {
                            type: 'bar',
                            data: {
                                labels: subEntries.map(sd => sd.deskripsi_facet ?? ''),
                                datasets: [{
                                    label: f.domain,
                                    data: subEntries.map(sd => sd.total_score ?? 0),
                                    backgroundColor: 'rgba(54,162,235,0.7)',
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { legend: { display: false } },
                                scales: { y: { beginAtZero: true } },
                            }
                        });
                    });
                }
            }

            // Bar chart sekala (Dark Triad / MMPI)
            if (p.sekala && p.sekala.average_scores && p.sekala.average_scores.length) {
                const sekCanvas = document.getElementById(`chart-${kode}-sekala`);
                if (sekCanvas) {
                    const labels = p.sekala.average_scores.map(s => s.keterangan ?? s.kode_sekala);
                    const data   = p.sekala.average_scores.map(s =>
                        p.skorNilai ? s.total_score : parseFloat(s.average_score)
                    );
                    modalChartInstances[`${kode}-sekala`] = new Chart(sekCanvas, {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [{
                                label: p.skorNilai ? 'Total Score' : 'Average Score',
                                data,
                                backgroundColor: 'rgba(153,102,255,0.7)',
                                borderColor:     'rgba(153,102,255,1)',
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true } },
                        }
                    });
                }
            }
        });
    }

    function hitungUsia(tanggal_lahir) {
        if (!tanggal_lahir) return '-';
        const today = new Date();
        const birth = new Date(tanggal_lahir);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        return age;
    }

    // ─── Print PDF ────────────────────────────────────────────────────────────
    async function printNilaiSiswa() {
        if (!currentPrintPayload) return;
        const { json, nama, tempatLahir, tanggalLahir, gender } = currentPrintPayload;
        const komentar = document.getElementById('formKomentar').value || 'Tidak ada komentar';

        // Ambil gambar dari chart yang sudah dirender di modal (jika SHOW_CHART aktif)
        const chartImages = {};
        if (SHOW_CHART) {
            Object.entries(modalChartInstances).forEach(([key, chart]) => {
                try { chartImages[key] = chart.toBase64Image('image/png', 1); } catch (e) {}
            });
        }

        const el = document.createElement('div');
        el.style.cssText = 'padding:20px;width:760px;background:white;color:black;';
        el.innerHTML = buildModalHtml(json, nama, tempatLahir, tanggalLahir, gender)
            + `<div style="margin-top:20px;color:black"><b>Komentar:</b><p>${komentar}</p></div>`;

        // Replace setiap canvas dengan gambar dari modal
        el.querySelectorAll('canvas[id^="chart-"]').forEach(canvas => {
            const kodeKey = canvas.id.replace('chart-', '');
            const imgSrc  = chartImages[kodeKey];
            if (imgSrc) {
                const img = document.createElement('img');
                img.src = imgSrc;
                img.style.cssText = 'max-width:100%;height:auto;display:block;margin:8px 0;';
                canvas.parentNode.replaceChild(img, canvas);
            } else {
                // Sembunyikan canvas kosong agar tidak ada area blank di PDF
                canvas.style.display = 'none';
            }
        });

        await html2pdf().from(el).set({
            margin:     [10, 10, 10, 10],
            filename:   `Hasil_Test_${nama}.pdf`,
            image:      { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF:      { unit: 'mm', format: 'a4', orientation: 'portrait' },
        }).save();
    }

    // ─── Download Excel ───────────────────────────────────────────────────────
    function downloadExcel() {
        const original = document.getElementById('datatable-table');
        const clone    = original.cloneNode(true);

        // Hapus kolom "Hasil Ujian" (index 0)
        clone.querySelectorAll('tr').forEach(row => {
            if (row.cells.length > 0) row.deleteCell(0);
        });

        clone.setAttribute('border', '1');
        clone.querySelectorAll('th,td').forEach(c => {
            c.style.border  = '1px solid black';
            c.style.padding = '5px';
        });

        const html = clone.outerHTML.replace(/ /g, '%20');
        const a    = document.createElement('a');
        a.href     = 'data:application/vnd.ms-excel,' + html;
        a.download = 'Data_Ujian_Siswa.xls';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
    </script>
@endsection
