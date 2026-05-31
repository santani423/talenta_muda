import { useQuery } from '@tanstack/react-query'
import { laporanService } from '../services/laporanService'

export function useSiswaDetail(id) {
  return useQuery({
    queryKey: ['laporan', 'siswa', id, 'detail'],
    queryFn: () => laporanService.getSiswaDetail(id),
    enabled: !!id,
    staleTime: 5 * 60 * 1000,
  })
}
