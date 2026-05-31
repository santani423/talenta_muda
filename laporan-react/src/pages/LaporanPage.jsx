import { useState, useCallback } from 'react'
import { useSiswa } from '../hooks/useSiswa'
import StatsCards from '../components/StatsCards'
import FilterBar from '../components/FilterBar'
import SiswaTable from '../components/SiswaTable'
import Pagination from '../components/Pagination'
import HasilModal from '../components/HasilModal'

const DEFAULT_PARAMS = {
  search: '',
  batch: '',
  limit: 10,
  page: 1,
}

export default function LaporanPage() {
  const [params, setParams] = useState(DEFAULT_PARAMS)
  const [selectedSiswaId, setSelectedSiswaId] = useState(null)
  const [modalOpen, setModalOpen] = useState(false)

  const { data: siswaResponse, isLoading, isError, error, refetch } = useSiswa(params)

  const siswaList = siswaResponse?.data || []
  const meta = siswaResponse?.meta || null

  const handleFilter = useCallback((filterParams) => {
    setParams((prev) => ({ ...prev, ...filterParams }))
  }, [])

  const handlePageChange = useCallback((page) => {
    setParams((prev) => ({ ...prev, page }))
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }, [])

  const handleOpenDetail = useCallback((id) => {
    setSelectedSiswaId(id)
    setModalOpen(true)
  }, [])

  const handleCloseModal = useCallback(() => {
    setModalOpen(false)
    // Keep selectedSiswaId so data stays cached in query
  }, [])

  return (
    <div>
      {/* Page Title */}
      <div className="mb-6">
        <div className="flex items-center gap-3 mb-1">
          <div className="w-1 h-6 bg-primary-600 rounded-full" />
          <h2 className="text-xl font-bold text-gray-900">Laporan Ujian Siswa</h2>
        </div>
        <p className="text-sm text-gray-500 ml-4">
          Kelola dan lihat hasil ujian seluruh siswa beserta analisis psikologis lengkap
        </p>
      </div>

      {/* Stats Cards */}
      <StatsCards
        siswaData={siswaList}
        meta={meta}
        isLoading={isLoading}
      />

      {/* Filter Bar */}
      <FilterBar
        initialValues={{ search: params.search, batch: params.batch, limit: params.limit }}
        onFilter={handleFilter}
      />

      {/* Status indicator (fetching in background) */}
      {isLoading && (
        <div className="flex items-center gap-2 text-xs text-primary-600 mb-3">
          <svg className="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          Memuat data...
        </div>
      )}

      {/* Table */}
      <SiswaTable
        data={siswaList}
        isLoading={isLoading}
        isError={isError}
        error={error}
        onRetry={refetch}
        onDetail={handleOpenDetail}
        meta={meta}
      />

      {/* Pagination */}
      <div className="mt-4">
        <Pagination
          currentPage={meta?.current_page ?? params.page}
          lastPage={meta?.last_page ?? 1}
          onPageChange={handlePageChange}
        />
      </div>

      {/* Detail Modal */}
      <HasilModal
        isOpen={modalOpen}
        onClose={handleCloseModal}
        siswaId={selectedSiswaId}
      />
    </div>
  )
}
