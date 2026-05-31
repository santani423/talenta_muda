export default function MainLayout({ children }) {
  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-gradient-to-r from-primary-700 to-primary-500 shadow-lg sticky top-0 z-40">
        <div className="max-w-screen-2xl mx-auto px-6 py-4 flex items-center gap-3">
          <div className="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="w-5 h-5 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={2}
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
              />
            </svg>
          </div>
          <div>
            <h1 className="text-white font-bold text-lg leading-tight">
              Laporan Ujian Siswa
            </h1>
            <p className="text-primary-200 text-xs">
              Talenta Muda Assessment System
            </p>
          </div>
          <div className="ml-auto flex items-center gap-2">
            <span className="text-white/60 text-xs hidden sm:block">
              Powered by TalentaMuda
            </span>
            <div className="w-2 h-2 rounded-full bg-green-400 animate-pulse" title="Connected" />
          </div>
        </div>
      </header>
      <main className="max-w-screen-2xl mx-auto px-4 sm:px-6 py-6">
        {children}
      </main>
      <footer className="mt-10 border-t border-gray-200 bg-white">
        <div className="max-w-screen-2xl mx-auto px-6 py-4 flex items-center justify-between text-xs text-gray-400">
          <span>© {new Date().getFullYear()} Talenta Muda. All rights reserved.</span>
          <span>Assessment System v1.0</span>
        </div>
      </footer>
    </div>
  )
}
