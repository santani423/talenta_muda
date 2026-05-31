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
  ReferenceLine,
} from 'recharts'

const PALETTE = [
  '#6366f1', '#8b5cf6', '#ec4899', '#f97316',
  '#eab308', '#22c55e', '#14b8a6', '#3b82f6',
  '#6366f1', '#8b5cf6', '#ec4899', '#f97316',
]

const CustomTooltip = ({ active, payload, label }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-white border border-gray-200 rounded-lg shadow-lg px-3 py-2 text-xs max-w-52">
        <p className="font-semibold text-gray-700 mb-1">{label}</p>
        <p className="text-primary-600">
          Score: <span className="font-bold">{Number(payload[0]?.value).toFixed(1)}</span>
        </p>
      </div>
    )
  }
  return null
}

export default function SekalaBar({ data = [], title = '', refLine = null }) {
  if (!data.length) {
    return (
      <div className="flex items-center justify-center h-32 text-gray-400 text-sm">
        Tidak ada data sekala
      </div>
    )
  }

  const formattedData = data.map((d) => ({
    ...d,
    shortName: d.name?.length > 10 ? d.name.slice(0, 9) + '…' : (d.name || d.kode || ''),
    displayScore: parseFloat(d.score || 0).toFixed(1),
  }))

  const maxScore = Math.max(...data.map((d) => parseFloat(d.score || 0)), 10)

  return (
    <div>
      {title && (
        <p className="text-xs font-medium text-gray-500 mb-2 text-center">{title}</p>
      )}
      <ResponsiveContainer width="100%" height={240}>
        <BarChart
          data={formattedData}
          margin={{ top: 20, right: 16, left: 0, bottom: 55 }}
          barCategoryGap="28%"
        >
          <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" vertical={false} />
          <XAxis
            dataKey="shortName"
            tick={{ fontSize: 10, fill: '#6b7280' }}
            angle={-40}
            textAnchor="end"
            interval={0}
          />
          <YAxis
            domain={[0, Math.ceil(maxScore * 1.15)]}
            tick={{ fontSize: 10, fill: '#9ca3af' }}
            width={28}
          />
          {refLine !== null && (
            <ReferenceLine
              y={refLine}
              stroke="#ef4444"
              strokeDasharray="5 3"
              label={{ value: `Ref: ${refLine}`, position: 'insideTopRight', fontSize: 10, fill: '#ef4444' }}
            />
          )}
          <Tooltip content={<CustomTooltip />} cursor={{ fill: 'rgba(99,102,241,0.08)' }} />
          <Bar dataKey="score" radius={[4, 4, 0, 0]}>
            {formattedData.map((entry, index) => (
              <Cell key={`cell-${index}`} fill={PALETTE[index % PALETTE.length]} />
            ))}
            <LabelList
              dataKey="displayScore"
              position="top"
              style={{ fontSize: 9, fill: '#374151' }}
            />
          </Bar>
        </BarChart>
      </ResponsiveContainer>
    </div>
  )
}
