function PageButton({ children, active, disabled, onClick }) {
  if (disabled) {
    return (
      <button
        disabled
        className="px-3 py-1.5 text-sm text-gray-300 cursor-not-allowed rounded-lg"
      >
        {children}
      </button>
    )
  }
  if (active) {
    return (
      <button className="px-3 py-1.5 text-sm font-semibold bg-primary-600 text-white rounded-lg shadow-sm">
        {children}
      </button>
    )
  }
  return (
    <button
      onClick={onClick}
      className="px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
    >
      {children}
    </button>
  )
}

export default function Pagination({ currentPage, lastPage, onPageChange }) {
  if (!lastPage || lastPage <= 1) return null

  const buildPages = () => {
    const pages = []
    const delta = 2

    if (lastPage <= 7) {
      for (let i = 1; i <= lastPage; i++) pages.push(i)
      return pages
    }

    pages.push(1)

    const left = currentPage - delta
    const right = currentPage + delta

    if (left > 2) pages.push('...')

    for (let i = Math.max(2, left); i <= Math.min(lastPage - 1, right); i++) {
      pages.push(i)
    }

    if (right < lastPage - 1) pages.push('...')

    pages.push(lastPage)
    return pages
  }

  const pages = buildPages()

  return (
    <div className="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
      <p className="text-sm text-gray-500">
        Halaman <span className="font-semibold text-gray-700">{currentPage}</span> dari{' '}
        <span className="font-semibold text-gray-700">{lastPage}</span>
      </p>

      <div className="flex items-center gap-1 bg-white border border-gray-200 rounded-xl px-2 py-1 shadow-sm">
        {/* Previous */}
        <button
          onClick={() => onPageChange(currentPage - 1)}
          disabled={currentPage <= 1}
          className={`flex items-center gap-1 px-3 py-1.5 text-sm rounded-lg transition-colors ${
            currentPage <= 1
              ? 'text-gray-300 cursor-not-allowed'
              : 'text-gray-600 hover:bg-gray-100'
          }`}
        >
          <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
          <span className="hidden sm:inline">Prev</span>
        </button>

        <div className="w-px h-5 bg-gray-200 mx-1" />

        {/* Pages */}
        {pages.map((page, idx) =>
          page === '...' ? (
            <span key={`ellipsis-${idx}`} className="px-2 text-gray-400 text-sm">
              ...
            </span>
          ) : (
            <PageButton
              key={page}
              active={page === currentPage}
              onClick={() => onPageChange(page)}
            >
              {page}
            </PageButton>
          ),
        )}

        <div className="w-px h-5 bg-gray-200 mx-1" />

        {/* Next */}
        <button
          onClick={() => onPageChange(currentPage + 1)}
          disabled={currentPage >= lastPage}
          className={`flex items-center gap-1 px-3 py-1.5 text-sm rounded-lg transition-colors ${
            currentPage >= lastPage
              ? 'text-gray-300 cursor-not-allowed'
              : 'text-gray-600 hover:bg-gray-100'
          }`}
        >
          <span className="hidden sm:inline">Next</span>
          <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
  )
}
