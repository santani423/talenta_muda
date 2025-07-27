<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chart ke PDF</title>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- html2canvas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <!-- jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    #chart-container {
      width: 600px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <h2 style="text-align:center;">Laporan Penjualan</h2>

  <div id="chart-container">
    <canvas id="myChart" width="600" height="300"></canvas>
  </div>

  <div style="text-align:center; margin-top: 20px;">
    <button onclick="printPDF()">Download PDF</button>
  </div>

  <script>
    // Inisialisasi Chart.js
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
          label: 'Penjualan',
          data: [12, 19, 3, 5, 2],
          backgroundColor: 'rgba(75, 192, 192, 0.7)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: false,
        maintainAspectRatio: false
      }
    });

    // Fungsi cetak PDF
    async function printPDF() {
      const chartElement = document.getElementById('chart-container');

      // Render canvas ke gambar
      const canvas = await html2canvas(chartElement, {
        backgroundColor: "#ffffff"
      });

      const imageData = canvas.toDataURL("image/png");

      // Gunakan jsPDF versi UMD
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF({
        orientation: 'landscape',
        unit: 'mm',
        format: 'a4'
      });

      // Tambahkan gambar ke PDF (disesuaikan ukurannya)
      const imgProps = pdf.getImageProperties(imageData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.addImage(imageData, 'PNG', 0, 10, pdfWidth, pdfHeight);
      pdf.save('laporan-penjualan.pdf');
    }
  </script>
</body>
</html>
