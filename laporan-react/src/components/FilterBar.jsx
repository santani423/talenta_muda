import { useState } from 'react'
import { useBatch } from '../hooks/useBatch'
import Spinner from './ui/Spinner'

const LIMIT_OPTIONS = [5, 10, 20, 50]

export default function FilterBar({ initialValues = {}, onFilter }) {
  const { data: batchData, isLoading: batchLoading } = useBatch()

  const [search, setSearch] = useState(initialValues.search || '')
  const [batch, setBatch] = useState(initialValues.batch || '')
  const [limit, setLimit] = useState(initialValues.limit || 10)

  const batches = batchData?.data || []

  const handleSubmit = (e) => {
    e.preventDefault()
    onFilter({ search, batch, limit, page: 1 })
  }

  const handleReset = () => {
    setSearch('')
    setBatch('')
    setLimit(10)
    onFilter({ search: '', batch: '', limit: 10, page: 1 })
  }

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
      <form onSubmit={handleSubmit} className="flex flex-wrap items-end gap-3">
        {/* Search */}
        <div className="flex-1 min-w-48">
          <label className="block text-xs font-medium text-gray-600 mb-1.5">
            Cari Siswa
          </label>
          <div className="relative">
            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                className="w-4 h-4 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={2}
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
              </svg>
            </div>
            <input
              type="text"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Nama siswa..."
              className="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
            />
          </div>
        </div>

        {/* Batch */}
        <div className="min-w-44">
          <label className="block text-xs font-medium text-gray-600 mb-1.5">
            Batch / Kelas
          </label>
          <div className="relative">
            {batchLoading && (
              <div className="absolute inset-y-0 right-7 flex items-center">
                <Spinner size="sm" />
              </div>
            )}
            <select
              value={batch}
              onChange={(e) => setBatch(e.target.value)}
              className="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white appearance-none transition-colors"
            >
              <option value="">Semua Batch</option>
              {batches.map((b) => (
                <option key={b.id} value={b.id}>
                  {b.nama_kelas}
                </option>
              ))}
            </select>
            <div className="absolute inset-y-0 right-2 flex items-center pointer-events-none">
              <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </div>
        </div>

        {/* Limit */}
        <div className="min-w-28">
          <label className="block text-xs font-medium text-gray-600 mb-1.5">
            Per Halaman
          </label>
          <div className="relative">
            <select
              value={limit}
              onChange={(e) => setLimit(Number(e.target.value))}
              className="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white appearance-none transition-colors"
            >
              {LIMIT_OPTIONS.map((l) => (
                <option key={l} value={l}>
                  {l} data
                </option>
              ))}
            </select>
            <div className="absolute inset-y-0 right-2 flex items-center pointer-events-none">
              <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </div>
        </div>

        {/* Buttons */}
        <div className="flex items-end gap-2">
          <button
            type="submit"
            className="flex items-center gap-1.5 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm"
          >
            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Cari
          </button>
          <button
            type="button"
            onClick={handleReset}
            className="flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors"
          >
            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Reset
          </button>
        </div>
      </form>
    </div>
  )
}
