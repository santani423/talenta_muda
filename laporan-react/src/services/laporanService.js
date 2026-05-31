import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || '',
})

api.interceptors.response.use(
  (response) => response,
  (error) => {
    console.error('API Error:', error.response?.data || error.message)
    return Promise.reject(error)
  },
)

export const laporanService = {
  getBatch: () => api.get('/api/laporan/batch').then((r) => r.data),
  getSiswa: (params) =>
    api.get('/api/laporan/siswa', { params }).then((r) => r.data),
  getSiswaDetail: (id) =>
    api.get(`/api/laporan/siswa/${id}/semua-nilai`).then((r) => r.data),
}
