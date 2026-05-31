import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  Cell,
  LabelList,
} from 'recharts'

const COLORS = [
  '#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe',
  '#4f46e5', '#4338ca', '#3730a3', '#312e81',
]

const CustomTooltip = ({ active, payload, label }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-white border border-gray-200 rounded-lg shadow-lg px-3 py-2 text-xs max-w-48">
        <p className="font-semibold text-gray-700 mb-1">{label}</p>
        <p className="text-primary-600">Score: <span className="font-bold">{payload[0]?.value}</span></p>
      </div>
    )
  }
  return null
}

export default function BarDomain({ data = [], color = '#6366f1', maxValue = 50 }) {
  if (!data.length) {
    return (
      <div className="flex items-center justify-center h-32 text-gray-400 text-sm">
        Tidak ada data facet
      </div>
    )
  }

  // Truncate long names for X axis
  const formattedData = data.map((d) => ({
    ...d,
    shortName: d.name?.length > 14 ? d.name.slice(0, 12) + '…' : (d.name || ''),
  }))

  return (
    <ResponsiveContainer width="100%" height={220}>
      <BarChart
        data={formattedData}
        margin={{ top: 20, right: 16, left: 0, bottom: 50 }}
        barCategoryGap="30%"
      >
        <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" vertical={false} />
        <XAxis
          dataKey="shortName"
          tick={{ fontSize: 10, fill: '#6b7280' }}
          angle={-35}
          textAnchor="end"
          interval={0}
        />
        <YAxis
          domain={[0, maxValue]}
          tick={{ fontSize: 10, fill: '#9ca3af' }}
          width={28}
        />
        <Tooltip content={<CustomTooltip />} cursor={{ fill: 'rgba(99,102,241,0.08)' }} />
        <Bar dataKey="score" radius={[4, 4, 0, 0]}>
          {formattedData.map((entry, index) => (
            <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
          ))}
          <LabelList dataKey="score" position="top" style={{ fontSize: 10, fill: '#374151' }} />
        </Bar>
      </BarChart>
    </ResponsiveContainer>
  )
}
