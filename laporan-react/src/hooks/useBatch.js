import { useQuery } from '@tanstack/react-query'
import { laporanService } from '../services/laporanService'

export function useBatch() {
  return useQuery({
    queryKey: ['laporan', 'batch'],
    queryFn: laporanService.getBatch,
    staleTime: 10 * 60 * 1000,
  })
}
