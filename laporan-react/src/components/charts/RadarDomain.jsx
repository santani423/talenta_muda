import {
  Radar,
  RadarChart,
  PolarGrid,
  PolarAngleAxis,
  PolarRadiusAxis,
  ResponsiveContainer,
  Tooltip,
} from 'recharts'

const CustomTooltip = ({ active, payload }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-white border border-gray-200 rounded-lg shadow-lg px-3 py-2 text-sm">
        <p className="font-semibold text-gray-800">{payload[0]?.payload?.domain}</p>
        <p className="text-primary-600">Score: <span className="font-bold">{payload[0]?.value}</span></p>
      </div>
    )
  }
  return null
}

export default function RadarDomain({ data = [] }) {
  if (!data.length) {
    return (
      <div className="flex items-center justify-center h-48 text-gray-400 text-sm">
        Tidak ada data domain
      </div>
    )
  }

  return (
    <ResponsiveContainer width="100%" height={320}>
      <RadarChart cx="50%" cy="50%" outerRadius="75%" data={data}>
        <PolarGrid stroke="#e0e7ff" />
        <PolarAngleAxis
          dataKey="domain"
          tick={{ fontSize: 11, fill: '#4b5563', fontWeight: 500 }}
        />
        <PolarRadiusAxis
          angle={90}
          domain={[0, 100]}
          tick={{ fontSize: 10, fill: '#9ca3af' }}
          tickCount={6}
        />
        <Radar
          name="Score"
          dataKey="score"
          stroke="#4f46e5"
          fill="#6366f1"
          fillOpacity={0.25}
          strokeWidth={2}
          dot={{ r: 4, fill: '#4f46e5', strokeWidth: 0 }}
        />
        <Tooltip content={<CustomTooltip />} />
      </RadarChart>
    </ResponsiveContainer>
  )
}
