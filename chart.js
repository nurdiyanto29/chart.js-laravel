 $(document).ready(function() {
            var statistics_chart = document.getElementById("myChart").getContext('2d');
            fetch("{{url('chart')}}")
            .then(response =>response.json())
            .then(json=>{
                var myChart = new Chart(statistics_chart, {
                    type: 'line',
                    data: {
                        labels: json.labels,
                        datasets: json.dataset,
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    // display: false,
                                    drawBorder: false,
                                    color: '#f2f2f2',
                                },
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 10000,
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    tickMarkLength: 15,
                                }
                            }]
                        },
                    }
                });
            })
        });
