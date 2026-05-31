import { useState } from 'react'
import Modal from './ui/Modal'
import Spinner from './ui/Spinner'
import Badge from './ui/Badge'
import RadarDomain from './charts/RadarDomain'
import BarDomain from './charts/BarDomain'
import SekalaBar from './charts/SekalaBar'
import { useSiswaDetail } from '../hooks/useSiswaDetail'
import { formatDate, hitungUsia, kualifikasiColor, genderLabel, genderBadgeColor } from '../utils/formatters'
import {
  getFacetDomainData,
  getSubdomainData,
  getSekalaData,
  getKuesionerAnswers,
  getDomainColor,
} from '../utils/scoreHelpers'

// ─────────────────────────────────────────────────────
// Section Header
// ─────────────────────────────────────────────────────
function SectionHeader({ icon, title, subtitle, color = 'primary' }) {
  const colorMap = {
    primary: 'bg-primary-600',
    blue: 'bg-blue-600',
    purple: 'bg-purple-600',
    green: 'bg-green-600',
    orange: 'bg-orange-500',
    red: 'bg-red-600',
  }
  return (
    <div className={`${colorMap[color]} rounded-xl px-5 py-3 mb-4 flex items-center gap-3`}>
      {icon && <span className="text-white text-xl">{icon}</span>}
      <div>
        <h3 className="text-white font-bold text-sm">{title}</h3>
        {subtitle && <p className="text-white/70 text-xs">{subtitle}</p>}
      </div>
    </div>
  )
}

// ─────────────────────────────────────────────────────
// Info Row helper
// ─────────────────────────────────────────────────────
function InfoRow({ label, value }) {
  return (
    <div className="flex flex-col sm:flex-row sm:items-center py-2 border-b border-gray-100 last:border-0 gap-1">
      <span className="text-xs font-medium text-gray-500 sm:w-40 flex-shrink-0">{label}</span>
      <span className="text-sm text-gray-800 font-medium">{value || '-'}</span>
    </div>
  )
}

// ─────────────────────────────────────────────────────
// Jawaban Table for Part 1-4 (PG/Essay answers)
// ─────────────────────────────────────────────────────
function JawabanTable({ parts }) {
  if (!parts) return <p className="text-gray-400 text-sm">Data tidak tersedia</p>

  const partKeys = ['part1_1', 'part1_2', 'part1_3', 'part1_4', 'part2', 'part3', 'part4']
  const partLabels = {
    part1_1: 'Part 1.1',
    part1_2: 'Part 1.2',
    part1_3: 'Part 1.3',
    part1_4: 'Part 1.4',
    part2: 'Part 2',
    part3: 'Part 3',
    part4: 'Part 4',
  }

  return (
    <div className="space-y-4">
      {partKeys.map((key) => {
        const part = parts[key]
        if (!part) return null

        // Try to find array of answers
        const answers = part.jawaban ?? part.soal ?? part.siswa ?? []
        const partTitle = partLabels[key] || key

        if (!Array.isArray(answers) || answers.length === 0) {
          // Show summary if no array
          return (
            <div key={key} className="bg-gray-50 rounded-lg p-3">
              <p className="text-xs font-semibold text-gray-600 mb-2">{partTitle}</p>
              <div className="flex flex-wrap gap-2">
                {Object.entries(part).map(([k, v]) => {
                  if (typeof v === 'object') return null
                  return (
                    <span key={k} className="text-xs bg-white border border-gray-200 rounded px-2 py-1">
                      <span className="text-gray-400">{k}:</span>{' '}
                      <span className="font-medium">{String(v)}</span>
                    </span>
                  )
                })}
              </div>
            </div>
          )
        }

        return (
          <div key={key}>
            <p className="text-xs font-semibold text-gray-600 mb-2 flex items-center gap-2">
              <span className="w-5 h-5 bg-primary-100 text-primary-700 rounded text-center leading-5 font-bold">
                {partTitle.replace('Part ', '')}
              </span>
              {partTitle}
              <span className="text-gray-400 font-normal">({answers.length} soal)</span>
            </p>
            <div className="overflow-x-auto scrollbar-thin rounded-lg border border-gray-200">
              <table className="text-xs w-full">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-3 py-2 text-left text-gray-500 font-medium w-10">No</th>
                    {answers[0] &&
                      Object.keys(answers[0])
                        .filter((k) => !['id', 'siswa_id', 'created_at', 'updated_at'].includes(k))
                        .slice(0, 10)
                        .map((k) => (
                          <th key={k} className="px-3 py-2 text-left text-gray-500 font-medium capitalize">
                            {k.replace(/_/g, ' ')}
                          </th>
                        ))}
                  </tr>
                </thead>
                <tbody>
                  {answers.slice(0, 50).map((row, idx) => (
                    <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                      <td className="px-3 py-1.5 text-gray-400">{idx + 1}</td>
                      {Object.entries(row)
                        .filter(([k]) => !['id', 'siswa_id', 'created_at', 'updated_at'].includes(k))
                        .slice(0, 10)
                        .map(([k, v]) => (
                          <td key={k} className="px-3 py-1.5 text-gray-700">
                            {v === null || v === undefined
                              ? '-'
                              : v === 1 || v === '1' || v === true
                              ? <span className="text-green-600 font-bold">✓</span>
                              : v === 0 || v === '0' || v === false
                              ? <span className="text-red-400">✗</span>
                              : String(v)}
                          </td>
                        ))}
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        )
      })}
    </div>
  )
}

// ─────────────────────────────────────────────────────
// NEO-PI Part 5.1 Section
// ─────────────────────────────────────────────────────
function NeoPISection({ p51 }) {
  const [activeDomain, setActiveDomain] = useState(null)

  if (!p51) {
    return <p className="text-gray-400 text-sm">Data NEO-PI tidak tersedia</p>
  }

  const facets = p51.facet ?? p51.facets ?? []
  const domainData = getFacetDomainData(p51)

  return (
    <div className="space-y-5">
      {/* Domain scores grid */}
      {domainData.length > 0 && (
        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
          {domainData.map((d) => (
            <button
              key={d.domain}
              onClick={() => setActiveDomain(activeDomain === d.domain ? null : d.domain)}
              className={`rounded-xl p-3 text-left transition-all border-2 ${
                activeDomain === d.domain
                  ? 'border-primary-500 bg-primary-50'
                  : 'border-gray-200 bg-white hover:border-primary-300'
              }`}
            >
              <div
                className="w-8 h-1.5 rounded-full mb-2"
                style={{ backgroundColor: getDomainColor(d.domain) }}
              />
              <p className="text-xs font-semibold text-gray-700 leading-tight">{d.domain}</p>
              <p
                className="text-xl font-bold mt-1"
                style={{ color: getDomainColor(d.domain) }}
              >
                {d.score}
              </p>
              <p className="text-xs text-gray-400 mt-0.5">
                {activeDomain === d.domain ? 'Tutup detail' : 'Lihat facet'}
              </p>
            </button>
          ))}
        </div>
      )}

      {/* Radar Chart */}
      {domainData.length > 0 && (
        <div className="bg-gray-50 rounded-xl p-4">
          <p className="text-xs font-semibold text-gray-500 mb-3 text-center uppercase tracking-wide">
            Profil Domain NEO-PI
          </p>
          <RadarDomain data={domainData} />
        </div>
      )}

      {/* Per Domain Facet Detail */}
      {activeDomain && (() => {
        const facet = facets.find(
          (f) => f.domain?.toUpperCase() === activeDomain.toUpperCase()
        )
        if (!facet) return null
        const subData = getSubdomainData(facet)

        return (
          <div className="bg-white border-2 border-primary-200 rounded-xl p-4">
            <div className="flex items-center justify-between mb-3">
              <h4 className="font-bold text-gray-800 text-sm">{activeDomain} — Facet Detail</h4>
              <button
                onClick={() => setActiveDomain(null)}
                className="text-gray-400 hover:text-gray-600 text-xs"
              >
                Tutup
              </button>
            </div>

            {subData.length > 0 ? (
              <>
                <BarDomain
                  data={subData}
                  color={getDomainColor(activeDomain)}
                  maxValue={Math.max(...subData.map((s) => s.score), 30) + 5}
                />
                <div className="mt-3 overflow-x-auto scrollbar-thin">
                  <table className="text-xs w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead className="bg-gray-50">
                      <tr>
                        <th className="px-3 py-2 text-left text-gray-500 font-medium">Facet</th>
                        <th className="px-3 py-2 text-center text-gray-500 font-medium">Score</th>
                        <th className="px-3 py-2 text-left text-gray-500 font-medium">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      {subData.map((sd, idx) => (
                        <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                          <td className="px-3 py-2 text-gray-700 font-medium">{sd.name}</td>
                          <td className="px-3 py-2 text-center">
                            <span
                              className="font-bold"
                              style={{ color: getDomainColor(activeDomain) }}
                            >
                              {sd.score}
                            </span>
                          </td>
                          <td className="px-3 py-2 text-gray-500">
                            {sd.score >= 70
                              ? 'Tinggi'
                              : sd.score >= 40
                              ? 'Sedang'
                              : 'Rendah'}
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </>
            ) : (
              <p className="text-gray-400 text-sm">Tidak ada data facet untuk domain ini</p>
            )}
          </div>
        )
      })()}

      {/* Show all facets table summary */}
      {facets.length > 0 && (
        <div className="overflow-x-auto scrollbar-thin">
          <table className="text-xs w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-3 py-2 text-left text-gray-500 font-medium">Domain</th>
                <th className="px-3 py-2 text-center text-gray-500 font-medium">Total Score</th>
                <th className="px-3 py-2 text-center text-gray-500 font-medium">Kategori</th>
              </tr>
            </thead>
            <tbody>
              {facets.map((f, idx) => (
                <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                  <td className="px-3 py-2 font-medium" style={{ color: getDomainColor(f.domain) }}>
                    {f.domain}
                  </td>
                  <td className="px-3 py-2 text-center font-bold text-gray-700">
                    {f.totalScore ?? f.total_score ?? '-'}
                  </td>
                  <td className="px-3 py-2 text-center">
                    <span className="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                      {f.kategori ?? f.category ?? '-'}
                    </span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  )
}

// ─────────────────────────────────────────────────────
// Dark Triad / MMPI Section (Part 5.2 / 5.3)
// ─────────────────────────────────────────────────────
function SekalaSection({ part, title }) {
  const sekalaData = getSekalaData(part)
  const answers = getKuesionerAnswers(part)

  if (!part) {
    return <p className="text-gray-400 text-sm">Data {title} tidak tersedia</p>
  }

  return (
    <div className="space-y-5">
      {/* Chart */}
      {sekalaData.length > 0 && (
        <div className="bg-gray-50 rounded-xl p-4">
          <SekalaBar data={sekalaData} title={`Profil Sekala ${title}`} />
        </div>
      )}

      {/* Scores Table */}
      {sekalaData.length > 0 && (
        <div className="overflow-x-auto scrollbar-thin">
          <table className="text-xs w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-3 py-2 text-left text-gray-500 font-medium">Sekala</th>
                <th className="px-3 py-2 text-center text-gray-500 font-medium">Score</th>
                <th className="px-3 py-2 text-center text-gray-500 font-medium">Kode</th>
              </tr>
            </thead>
            <tbody>
              {sekalaData.map((s, idx) => (
                <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                  <td className="px-3 py-2 text-gray-700 font-medium">{s.name}</td>
                  <td className="px-3 py-2 text-center font-bold text-primary-700">
                    {Number(s.score).toFixed(2)}
                  </td>
                  <td className="px-3 py-2 text-center text-gray-400 font-mono">{s.kode || '-'}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {/* Kuesioner Answers */}
      {answers.length > 0 && (
        <div>
          <p className="text-xs font-semibold text-gray-500 uppercase mb-2">Jawaban Kuesioner</p>
          <div className="overflow-x-auto scrollbar-thin rounded-lg border border-gray-200 max-h-64 overflow-y-auto">
            <table className="text-xs w-full">
              <thead className="bg-gray-50 sticky top-0">
                <tr>
                  <th className="px-3 py-2 text-left text-gray-500 font-medium">No</th>
                  {answers[0] &&
                    Object.keys(answers[0])
                      .filter((k) => !['id', 'siswa_id', 'created_at', 'updated_at'].includes(k))
                      .slice(0, 8)
                      .map((k) => (
                        <th key={k} className="px-3 py-2 text-left text-gray-500 font-medium capitalize">
                          {k.replace(/_/g, ' ')}
                        </th>
                      ))}
                </tr>
              </thead>
              <tbody>
                {answers.map((row, idx) => (
                  <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                    <td className="px-3 py-1.5 text-gray-400">{idx + 1}</td>
                    {Object.entries(row)
                      .filter(([k]) => !['id', 'siswa_id', 'created_at', 'updated_at'].includes(k))
                      .slice(0, 8)
                      .map(([k, v]) => (
                        <td key={k} className="px-3 py-1.5 text-gray-700">
                          {v === null || v === undefined
                            ? '-'
                            : v === 1 || v === '1' || v === true
                            ? <span className="text-green-600 font-bold">✓</span>
                            : v === 0 || v === '0' || v === false
                            ? <span className="text-red-400">✗</span>
                            : String(v)}
                        </td>
                      ))}
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Raw summary fields */}
      {sekalaData.length === 0 && answers.length === 0 && (
        <div className="bg-gray-50 rounded-lg p-4">
          <p className="text-xs font-semibold text-gray-500 mb-3">Data {title}</p>
          <div className="flex flex-wrap gap-2">
            {Object.entries(part).map(([k, v]) => {
              if (typeof v === 'object' && v !== null) return null
              return (
                <span key={k} className="text-xs bg-white border border-gray-200 rounded px-2 py-1">
                  <span className="text-gray-400">{k}:</span>{' '}
                  <span className="font-medium">{String(v ?? '-')}</span>
                </span>
              )
            })}
          </div>
        </div>
      )}
    </div>
  )
}

// ─────────────────────────────────────────────────────
// HasilModal
// ─────────────────────────────────────────────────────
export default function HasilModal({ isOpen, onClose, siswaId }) {
  const [activeTab, setActiveTab] = useState('profil')

  const { data, isLoading, isError, error } = useSiswaDetail(siswaId)

  const siswa = data?.siswa || {}
  const nilai = data?.nilai || {}
  const parts = data?.parts || {}

  const tabs = [
    { id: 'profil', label: 'Profil & Nilai', icon: '👤' },
    { id: 'jawaban', label: 'Jawaban', icon: '📝' },
    { id: 'neopi', label: 'NEO-PI', icon: '🧠' },
    { id: 'darktriad', label: 'Dark Triad', icon: '🔮' },
    { id: 'mmpi', label: 'MMPI', icon: '📊' },
  ]

  const modalTitle = isLoading
    ? 'Memuat data...'
    : siswa?.nama_siswa
    ? `Detail Hasil — ${siswa.nama_siswa}`
    : 'Detail Hasil Ujian'

  return (
    <Modal isOpen={isOpen} onClose={onClose} title={modalTitle} size="5xl">
      {isLoading ? (
        <div className="flex flex-col items-center justify-center py-20 gap-4">
          <Spinner size="xl" />
          <p className="text-gray-500 text-sm">Memuat data hasil ujian...</p>
        </div>
      ) : isError ? (
        <div className="flex flex-col items-center justify-center py-20 gap-4 px-6">
          <div className="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
            <svg className="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
            </svg>
          </div>
          <p className="text-red-600 font-semibold">Gagal memuat data</p>
          <p className="text-gray-500 text-sm text-center">{error?.message || 'Terjadi kesalahan'}</p>
        </div>
      ) : (
        <div className="flex flex-col">
          {/* Profile Header Card */}
          <div className="bg-gradient-to-br from-primary-50 to-indigo-50 border-b border-primary-100 px-6 py-5">
            <div className="flex flex-wrap items-start gap-4">
              {/* Avatar */}
              <div className="w-14 h-14 rounded-2xl bg-primary-600 flex items-center justify-center flex-shrink-0 shadow-lg">
                <span className="text-white text-xl font-bold">
                  {(siswa?.nama_siswa || 'S').charAt(0).toUpperCase()}
                </span>
              </div>

              {/* Info */}
              <div className="flex-1 min-w-0">
                <h3 className="font-bold text-gray-900 text-lg leading-tight">
                  {siswa?.nama_siswa || '-'}
                </h3>
                <div className="flex flex-wrap items-center gap-2 mt-1.5">
                  <Badge className={genderBadgeColor(siswa?.gender)}>
                    {genderLabel(siswa?.gender)}
                  </Badge>
                  <span className="text-xs text-gray-500">
                    {siswa?.tempat_lahir || '-'}, {formatDate(siswa?.tanggal_lahir)}
                  </span>
                  <span className="text-xs text-gray-500">
                    {siswa?.umur ?? hitungUsia(siswa?.tanggal_lahir)} tahun
                  </span>
                </div>
              </div>

              {/* IQ Badge */}
              <div className="flex flex-col items-center gap-1.5">
                <div className="bg-white rounded-2xl border-2 border-primary-200 px-4 py-2 text-center shadow-sm">
                  <p className="text-xs text-gray-500 font-medium">IQ Score</p>
                  <p className="text-3xl font-black text-primary-700 leading-none my-1">
                    {nilai?.skor_iq ?? '-'}
                  </p>
                  {nilai?.kualifikasi && (
                    <Badge className={kualifikasiColor(nilai.kualifikasi)}>
                      {nilai.kualifikasi}
                    </Badge>
                  )}
                </div>
              </div>
            </div>

            {/* Nilai cards */}
            {(nilai?.tscore || nilai?.artd || nilai?.sim) && (
              <div className="mt-4 grid grid-cols-3 sm:grid-cols-5 gap-2">
                {[
                  { label: 'T-Score', value: nilai.tscore },
                  { label: 'ARTD', value: nilai.artd },
                  { label: 'SIM', value: nilai.sim },
                  { label: 'Kualifikasi', value: nilai.kualifikasi },
                  { label: 'Skor IQ', value: nilai.skor_iq },
                ].map((item) => (
                  <div
                    key={item.label}
                    className="bg-white/80 backdrop-blur-sm rounded-xl px-3 py-2 text-center border border-primary-100"
                  >
                    <p className="text-xs text-gray-400 mb-0.5">{item.label}</p>
                    <p className="font-bold text-gray-800 text-sm">{item.value ?? '-'}</p>
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* Tab Bar */}
          <div className="border-b border-gray-200 bg-white px-4 flex gap-1 overflow-x-auto scrollbar-thin flex-shrink-0">
            {tabs.map((tab) => (
              <button
                key={tab.id}
                onClick={() => setActiveTab(tab.id)}
                className={`flex items-center gap-1.5 px-3 py-3 text-xs font-medium whitespace-nowrap border-b-2 transition-colors ${
                  activeTab === tab.id
                    ? 'border-primary-600 text-primary-700'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                }`}
              >
                <span>{tab.icon}</span>
                {tab.label}
              </button>
            ))}
          </div>

          {/* Tab Content */}
          <div className="p-6">
            {/* ── PROFIL TAB ── */}
            {activeTab === 'profil' && (
              <div className="space-y-4">
                <SectionHeader
                  icon="👤"
                  title="Data Pribadi Siswa"
                  color="primary"
                />
                <div className="bg-white border border-gray-200 rounded-xl p-4 divide-y divide-gray-100">
                  <InfoRow label="Nama Lengkap" value={siswa?.nama_siswa} />
                  <InfoRow label="Tempat Lahir" value={siswa?.tempat_lahir} />
                  <InfoRow label="Tanggal Lahir" value={formatDate(siswa?.tanggal_lahir)} />
                  <InfoRow label="Jenis Kelamin" value={genderLabel(siswa?.gender)} />
                  <InfoRow
                    label="Usia"
                    value={`${siswa?.umur ?? hitungUsia(siswa?.tanggal_lahir)} tahun`}
                  />
                </div>

                {Object.keys(nilai).length > 0 && (
                  <>
                    <SectionHeader
                      icon="📊"
                      title="Hasil Penilaian"
                      subtitle="Skor IQ dan kualifikasi"
                      color="blue"
                    />
                    <div className="grid grid-cols-2 sm:grid-cols-3 gap-3">
                      {Object.entries(nilai).map(([key, val]) => (
                        <div
                          key={key}
                          className="bg-white border border-gray-200 rounded-xl p-4 text-center hover:border-primary-300 transition-colors"
                        >
                          <p className="text-xs text-gray-400 font-medium capitalize mb-1">
                            {key.replace(/_/g, ' ')}
                          </p>
                          {key === 'kualifikasi' ? (
                            <Badge className={kualifikasiColor(val)}>{val || '-'}</Badge>
                          ) : (
                            <p className="text-xl font-black text-gray-800">{val ?? '-'}</p>
                          )}
                        </div>
                      ))}
                    </div>
                  </>
                )}
              </div>
            )}

            {/* ── JAWABAN TAB ── */}
            {activeTab === 'jawaban' && (
              <div>
                <SectionHeader
                  icon="📝"
                  title="Tabel Jawaban"
                  subtitle="Part 1–4 (PG, Visual, Essay)"
                  color="green"
                />
                <JawabanTable parts={parts} />
              </div>
            )}

            {/* ── NEO-PI TAB ── */}
            {activeTab === 'neopi' && (
              <div>
                <SectionHeader
                  icon="🧠"
                  title="NEO-PI — Big Five Personality"
                  subtitle="Klik domain untuk melihat detail facet"
                  color="purple"
                />
                <NeoPISection p51={parts?.part5_1} />
              </div>
            )}

            {/* ── DARK TRIAD TAB ── */}
            {activeTab === 'darktriad' && (
              <div>
                <SectionHeader
                  icon="🔮"
                  title="Dark Triad Assessment"
                  subtitle="Machiavellianism, Narcissism, Psychopathy"
                  color="orange"
                />
                <SekalaSection part={parts?.part5_2} title="Dark Triad" />
              </div>
            )}

            {/* ── MMPI TAB ── */}
            {activeTab === 'mmpi' && (
              <div>
                <SectionHeader
                  icon="📊"
                  title="MMPI Assessment"
                  subtitle="Minnesota Multiphasic Personality Inventory"
                  color="red"
                />
                <SekalaSection part={parts?.part5_3} title="MMPI" />
              </div>
            )}
          </div>
        </div>
      )}
    </Modal>
  )
}
