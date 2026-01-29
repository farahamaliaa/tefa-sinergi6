<script>
    function createAttendanceChart(selector, data) {
        var late = data.chartLate;
        var sick = data.chartSick;
        var alpha = data.chartAlpha;

        var options = {
            series: [sick, late, alpha],
            chart: {
                type: 'donut',
                width: 450
            },
            labels: ['Izin/Sakit', 'Telat', 'Alfa'],
            colors: ['#3ABFF8', '#FFAE1F', '#F73131'],
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                itemMargin: {
                    horizontal: 20,
                    vertical: 10
                }
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom',
                        itemMargin: {
                            horizontal: 20,
                            vertical: 10
                        }
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector(selector), options);
        chart.render();
        return chart;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var studentData = @json($studentChart);
        var employeeData = @json($employeeChart);
        var extraData = @json($extraChart);

        if (document.querySelector("#chart-student")) {
            window.studentStatisticChart = createAttendanceChart("#chart-student", studentData);
        }
        if (document.querySelector("#chart-employee")) {
            window.employeeStatisticChart = createAttendanceChart("#chart-employee", employeeData);
        }
        if (document.querySelector("#chart-extra")) {
            window.extraStatisticChart = createAttendanceChart("#chart-extra", extraData);
        }
    });
</script>
