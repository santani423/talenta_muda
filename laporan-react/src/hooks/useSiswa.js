import { useQuery } from '@tanstack/react-query'
import { laporanService } from '../services/laporanService'

export function useSiswa({ search, batch, limit, page }) {
  return useQuery({
    queryKey: ['laporan', 'siswa', { search, batch, limit, page }],
    queryFn: () => laporanService.getSiswa({ search, batch, limit, page }),
    placeholderData: (prev) => prev,
  })
}
