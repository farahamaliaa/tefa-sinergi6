<script>
    var studentChartData = @json($studentChart);

    var late = studentChartData.chartLate;
    var sick = studentChartData.chartSick;
    var alpha = studentChartData.chartAlpha;

    var options = {
        series: [sick, late, alpha], // Data numerik untuk 'Izin/Sakit', 'Telat', 'Alfa'
        chart: {
            type: 'donut',
            width: 450 // Perbesar chart
        },
        labels: ['Izin/Sakit', 'Telat', 'Alfa'], // Label keterangan
        colors: ['#3ABFF8', '#FFAE1F', '#F73131'], // Custom warna chart: Cyan, Yellow, Red
        legend: {
            position: 'bottom', // Pindahkan keterangan ke bawah chart
            horizontalAlign: 'center', // Selaraskan secara horizontal
            itemMargin: {
                horizontal: 20, // Atur jarak horizontal antar keterangan
                vertical: 10 // Atur jarak vertikal antar keterangan
            }
        },
        dataLabels: {
            enabled: false // Menghilangkan persen
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 400 // Atur ukuran lebih kecil untuk layar kecil
                },
                legend: {
                    position: 'bottom',
                    itemMargin: {
                        horizontal: 20, // Tetap atur jarak untuk perangkat kecil
                        vertical: 10
                    }
                }
            }
        }]
    };

    window.studentStatisticChart = new ApexCharts(document.querySelector("#chart-student"), options);
    window.studentStatisticChart.render();
</script>
