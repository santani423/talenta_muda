/**
 * Extract NEO-PI domain data for Radar chart
 * p51 = parts.part5_1
 */
export function getFacetDomainData(p51) {
  if (!p51?.facet) return []
  return p51.facet.map((f) => ({
    domain: f.domain,
    score: f.totalScore ?? f.total_score ?? 0,
    fullMark: 100,
  }))
}

/**
 * Extract subdomain/facet data for a specific domain's BarChart
 * facet = one element of parts.part5_1.facet
 */
export function getSubdomainData(facet) {
  if (!facet) return []
  const subdomain = facet.subdomain || facet.subdomains || {}
  if (Array.isArray(subdomain)) {
    return subdomain.map((sd) => ({
      name: sd.deskripsi_facet ?? sd.name ?? '',
      score: sd.total_score ?? sd.score ?? 0,
    }))
  }
  return Object.values(subdomain).map((sd) => ({
    name: sd.deskripsi_facet ?? sd.name ?? '',
    score: sd.total_score ?? sd.score ?? 0,
  }))
}

/**
 * Extract sekala data for Dark Triad or MMPI bar chart
 * sekala = parts.part5_2 or parts.part5_3
 */
export function getSekalaData(sekala) {
  if (!sekala) return []

  // Try average_scores array first
  if (Array.isArray(sekala.average_scores) && sekala.average_scores.length > 0) {
    return sekala.average_scores.map((s) => ({
      name: s.keterangan ?? s.kode_sekala ?? s.name ?? '',
      score: parseFloat(s.average_score ?? s.total_score ?? 0),
      total: s.total_score,
      kode: s.kode_sekala ?? '',
    }))
  }

  // Try sekala array
  if (Array.isArray(sekala.sekala) && sekala.sekala.length > 0) {
    return sekala.sekala.map((s) => ({
      name: s.keterangan ?? s.kode_sekala ?? s.name ?? '',
      score: parseFloat(s.average_score ?? s.total_score ?? s.score ?? 0),
      total: s.total_score,
      kode: s.kode_sekala ?? '',
    }))
  }

  // Try scores object
  if (sekala.scores && typeof sekala.scores === 'object') {
    return Object.entries(sekala.scores).map(([key, val]) => ({
      name: val.keterangan ?? key,
      score: parseFloat(val.average_score ?? val.score ?? val ?? 0),
      total: val.total_score ?? null,
      kode: key,
    }))
  }

  return []
}

/**
 * Get kuesioner answers from part 5.2 or 5.3
 */
export function getKuesionerAnswers(part) {
  if (!part) return []
  return part.jawaban ?? part.answers ?? part.kuesioner ?? []
}

/**
 * Get PG table data helper
 */
export function getPgTableData(parts) {
  const keys = ['part1_1', 'part1_2', 'part1_3', 'part1_4', 'part2', 'part3', 'part4']
  const maxRows = Math.max(
    0,
    ...keys.map((k) => {
      const part = parts?.[k]
      if (!part) return 0
      return part.siswa?.length ?? part.jawaban?.length ?? part.soal?.length ?? 0
    }),
  )
  return { keys, maxRows }
}

/**
 * Get answer value display
 */
export function getAnswerDisplay(answer) {
  if (answer === null || answer === undefined || answer === '') return '-'
  if (answer === 1 || answer === '1' || answer === true) return '✓'
  if (answer === 0 || answer === '0' || answer === false) return '✗'
  return String(answer)
}

/**
 * Get score color class based on value
 */
export function getScoreColorClass(score, max = 100) {
  const pct = (score / max) * 100
  if (pct >= 80) return 'text-purple-600 font-bold'
  if (pct >= 65) return 'text-blue-600 font-semibold'
  if (pct >= 45) return 'text-green-600'
  if (pct >= 30) return 'text-yellow-600'
  return 'text-red-600'
}

/**
 * NEO-PI domain colors
 */
export const DOMAIN_COLORS = {
  NEUROTICISM: '#ef4444',
  EXTRAVERSION: '#f97316',
  OPENNESS: '#eab308',
  AGREEABLENESS: '#22c55e',
  CONSCIENTIOUSNESS: '#6366f1',
  N: '#ef4444',
  E: '#f97316',
  O: '#eab308',
  A: '#22c55e',
  C: '#6366f1',
}

export function getDomainColor(domain) {
  if (!domain) return '#6366f1'
  const upper = domain.toUpperCase()
  for (const [key, color] of Object.entries(DOMAIN_COLORS)) {
    if (upper.includes(key)) return color
  }
  return '#6366f1'
}
