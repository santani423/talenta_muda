import { useMemo } from 'react'

function StatCard({ icon, label, value, subValue, color, bgColor }) {
  return (
    <div className={`bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex items-start gap-4`}>
      <div className={`w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 ${bgColor}`}>
        <span className={`text-xl ${color}`}>{icon}</span>
      </div>
      <div className="min-w-0">
        <p className="text-xs text-gray-500 font-medium mb-1">{label}</p>
        <p className={`text-2xl font-bold ${color}`}>{value}</p>
        {subValue && <p className="text-xs text-gray-400 mt-0.5">{subValue}</p>}
      </div>
    </div>
  )
}

export default function StatsCards({ siswaData, meta, isLoading }) {
  const stats = useMemo(() => {
    if (!siswaData || !siswaData.length) {
      return {
        total: meta?.total ?? 0,
        avgIq: '-',
        topKualifikasi: '-',
        totalPage: meta?.last_page ?? 0,
      }
    }

    // Collect IQ scores from data that has nilai loaded (from the detail calls)
    // We use meta.total for total count
    const total = meta?.total ?? siswaData.length

    return {
      total,
      avgIq: '-',
      topKualifikasi: '-',
      totalPage: meta?.last_page ?? 1,
    }
  }, [siswaData, meta])

  if (isLoading) {
    return (
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {[...Array(4)].map((_, i) => (
          <div key={i} className="bg-white rounded-xl border border-gray-200 shadow-sm p-5 animate-pulse">
            <div className="flex items-start gap-4">
              <div className="w-12 h-12 rounded-xl bg-gray-200" />
              <div className="flex-1">
                <div className="h-3 bg-gray-200 rounded w-20 mb-2" />
                <div className="h-7 bg-gray-200 rounded w-16" />
              </div>
            </div>
          </div>
        ))}
      </div>
    )
  }

  return (
    <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <StatCard
        icon={
          <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        }
        label="Total Siswa"
        value={stats.total.toLocaleString('id-ID')}
        subValue="Terdaftar dalam sistem"
        color="text-primary-600"
        bgColor="bg-primary-50"
      />
      <StatCard
        icon={
          <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        }
        label="Halaman Terakhir"
        value={stats.totalPage}
        subValue={`Per ${meta?.per_page ?? '-'} data`}
        color="text-blue-600"
        bgColor="bg-blue-50"
      />
      <StatCard
        icon={
          <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
          </svg>
        }
        label="Halaman Saat Ini"
        value={meta?.current_page ?? '-'}
        subValue={`dari ${meta?.last_page ?? '-'} halaman`}
        color="text-green-600"
        bgColor="bg-green-50"
      />
      <StatCard
        icon={
          <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        }
        label="Data Ditampilkan"
        value={siswaData?.length ?? 0}
        subValue={`dari total ${stats.total} siswa`}
        color="text-orange-600"
        bgColor="bg-orange-50"
      />
    </div>
  )
}
