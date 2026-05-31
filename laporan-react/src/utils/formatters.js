export function hitungUsia(tanggalLahir) {
  if (!tanggalLahir) return '-'
  const today = new Date()
  const birth = new Date(tanggalLahir)
  let age = today.getFullYear() - birth.getFullYear()
  const m = today.getMonth() - birth.getMonth()
  if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--
  return age
}

export function formatDate(dateStr) {
  if (!dateStr) return '-'
  return new Date(dateStr).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  })
}

export function kualifikasiColor(k) {
  const map = {
    SUPERIOR: 'bg-purple-100 text-purple-800',
    'ABOVE AVERAGE': 'bg-blue-100 text-blue-800',
    AVERAGE: 'bg-green-100 text-green-800',
    'BELOW AVERAGE': 'bg-yellow-100 text-yellow-800',
    INFERIOR: 'bg-red-100 text-red-800',
  }
  return map[k?.toUpperCase()] || 'bg-gray-100 text-gray-700'
}

export function genderLabel(g) {
  if (!g) return '-'
  const lower = g.toLowerCase()
  if (lower === 'l' || lower === 'laki-laki' || lower === 'male') return 'Laki-laki'
  if (lower === 'p' || lower === 'perempuan' || lower === 'female') return 'Perempuan'
  return g
}

export function genderBadgeColor(g) {
  const lower = (g || '').toLowerCase()
  if (lower === 'l' || lower === 'laki-laki' || lower === 'male') {
    return 'bg-blue-100 text-blue-700'
  }
  return 'bg-pink-100 text-pink-700'
}

export function truncateText(text, maxLength = 30) {
  if (!text) return '-'
  return text.length > maxLength ? text.slice(0, maxLength) + '...' : text
}
