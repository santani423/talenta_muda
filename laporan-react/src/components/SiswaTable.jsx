import { useSiswaDetail } from '../hooks/useSiswaDetail'
import { formatDate, hitungUsia, kualifikasiColor, genderLabel, genderBadgeColor } from '../utils/formatters'
import Badge from './ui/Badge'
import Spinner from './ui/Spinner'

// ---------- Skeleton Row ----------
function SkeletonRow({ cols }) {
  return (
    <tr className="animate-pulse">
      {[...Array(cols)].map((_, i) => (
        <td key={i} className="px-4 py-3">
          <div className="h-4 bg-gray-200 rounded w-full" />
        </td>
      ))}
    </tr>
  )
}

// ---------- Individual Siswa Row that loads its own detail ----------
function SiswaRow({ siswa, index, offset, onDetail }) {
  const { data: detail, isLoading } = useSiswaDetail(siswa?.id)

  const nilai = detail?.nilai || null
  const siswaDetail = detail?.siswa || siswa

  const iq = nilai?.skor_iq ?? '-'
  const kualifikasi = nilai?.kualifikasi ?? '-'
  const tScore = nilai?.tscore ?? '-'
  const artd = nilai?.artd ?? '-'
  const sim = nilai?.sim ?? '-'

  return (
    <tr className="hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
      {/* No */}
      <td className="px-4 py-3 text-center text-sm text-gray-500 sticky left-0 bg-white z-10 font-medium">
        {offset + index + 1}
      </td>

      {/* Nama */}
      <td className="px-4 py-3 sticky left-10 bg-white z-10 min-w-44">
        <div className="font-medium text-gray-900 text-sm leading-tight">
          {siswaDetail?.nama_siswa || '-'}
        </div>
        <div className="text-xs text-gray-400 mt-0.5">ID: {siswa?.id}</div>
      </td>

      {/* Kelas */}
      <td className="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
        {siswa?.nama_kelas || siswaDetail?.nama_kelas || '-'}
      </td>

      {/* TTL */}
      <td className="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
        <div>{siswaDetail?.tempat_lahir || '-'}</div>
        <div className="text-xs text-gray-400">
          {formatDate(siswaDetail?.tanggal_lahir)}
        </div>
      </td>

      {/* Gender */}
      <td className="px-4 py-3 text-center">
        <Badge className={genderBadgeColor(siswaDetail?.gender)}>
          {genderLabel(siswaDetail?.gender)}
        </Badge>
      </td>

      {/* Usia */}
      <td className="px-4 py-3 text-center text-sm text-gray-700">
        {siswaDetail?.umur ?? hitungUsia(siswaDetail?.tanggal_lahir)}
        {(siswaDetail?.umur || siswaDetail?.tanggal_lahir) ? ' th' : ''}
      </td>

      {/* IQ Score */}
      <td className="px-4 py-3 text-center">
        {isLoading ? (
          <div className="flex justify-center">
            <Spinner size="sm" />
          </div>
        ) : (
          <span className="text-sm font-bold text-primary-700">{iq}</span>
        )}
      </td>

      {/* T-Score */}
      <td className="px-4 py-3 text-center text-sm text-gray-600">
        {isLoading ? <Spinner size="sm" className="mx-auto" /> : tScore}
      </td>

      {/* ARTD */}
      <td className="px-4 py-3 text-center text-sm text-gray-600">
        {isLoading ? <Spinner size="sm" className="mx-auto" /> : artd}
      </td>

      {/* SIM */}
      <td className="px-4 py-3 text-center text-sm text-gray-600">
        {isLoading ? <Spinner size="sm" className="mx-auto" /> : sim}
      </td>

      {/* Kualifikasi */}
      <td className="px-4 py-3 text-center">
        {isLoading ? (
          <Spinner size="sm" className="mx-auto" />
        ) : kualifikasi !== '-' ? (
          <Badge className={kualifikasiColor(kualifikasi)}>{kualifikasi}</Badge>
        ) : (
          <span className="text-gray-400 text-xs">-</span>
        )}
      </td>

      {/* Action */}
      <td className="px-4 py-3 text-center sticky right-0 bg-white z-10">
        <button
          onClick={() => onDetail(siswa.id)}
          className="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors shadow-sm"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="w-3.5 h-3.5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            strokeWidth={2}
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
            />
          </svg>
          Detail
        </button>
      </td>
    </tr>
  )
}

// ---------- Main Table ----------
const HEADERS = [
  { label: 'No', className: 'text-center w-10 sticky left-0 bg-gray-50 z-20' },
  { label: 'Nama Siswa', className: 'sticky left-10 bg-gray-50 z-20 min-w-44' },
  { label: 'Kelas', className: 'min-w-28' },
  { label: 'Tempat / Tgl Lahir', className: 'min-w-40' },
  { label: 'Gender', className: 'text-center' },
  { label: 'Usia', className: 'text-center' },
  { label: 'IQ Score', className: 'text-center' },
  { label: 'T-Score', className: 'text-center' },
  { label: 'ARTD', className: 'text-center' },
  { label: 'SIM', className: 'text-center' },
  { label: 'Kualifikasi', className: 'text-center min-w-32' },
  { label: 'Aksi', className: 'text-center sticky right-0 bg-gray-50 z-20' },
]

export default function SiswaTable({ data, isLoading, isError, error, onRetry, onDetail, meta }) {
  const offset = ((meta?.current_page ?? 1) - 1) * (meta?.per_page ?? 10)

  if (isError) {
    return (
      <div className="bg-white rounded-xl border border-red-200 shadow-sm p-10 text-center">
        <div className="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg className="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
        </div>
        <p className="text-red-600 font-medium mb-2">Gagal memuat data</p>
        <p className="text-gray-500 text-sm mb-4">{error?.message || 'Terjadi kesalahan pada server'}</p>
        <button
          onClick={onRetry}
          className="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors"
        >
          Coba Lagi
        </button>
      </div>
    )
  }

  return (
    <div className="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
      {/* Table container */}
      <div className="overflow-x-auto scrollbar-thin">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 border-b-2 border-gray-200">
              {HEADERS.map((h) => (
                <th
                  key={h.label}
                  className={`px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide whitespace-nowrap ${h.className}`}
                >
                  {h.label}
                </th>
              ))}
            </tr>
          </thead>
          <tbody>
            {isLoading ? (
              [...Array(5)].map((_, i) => (
                <SkeletonRow key={i} cols={HEADERS.length} />
              ))
            ) : !data?.length ? (
              <tr>
                <td colSpan={HEADERS.length} className="px-4 py-16 text-center">
                  <div className="flex flex-col items-center gap-3 text-gray-400">
                    <svg className="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                      <path strokeLinecap="round" strokeLinejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <div>
                      <p className="font-medium text-gray-500">Tidak ada data siswa</p>
                      <p className="text-sm text-gray-400 mt-1">Coba ubah filter pencarian</p>
                    </div>
                  </div>
                </td>
              </tr>
            ) : (
              data.map((siswa, index) => (
                <SiswaRow
                  key={siswa.id}
                  siswa={siswa}
                  index={index}
                  offset={offset}
                  onDetail={onDetail}
                />
              ))
            )}
          </tbody>
        </table>
      </div>

      {/* Footer info */}
      {data?.length > 0 && (
        <div className="px-4 py-3 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-between">
          <span>
            Menampilkan{' '}
            <span className="font-semibold text-gray-700">{offset + 1}</span>–
            <span className="font-semibold text-gray-700">{offset + data.length}</span>{' '}
            dari{' '}
            <span className="font-semibold text-gray-700">{meta?.total ?? data.length}</span> siswa
          </span>
          <span className="text-gray-400">
            IQ Score dimuat dari API per siswa
          </span>
        </div>
      )}
    </div>
  )
}
