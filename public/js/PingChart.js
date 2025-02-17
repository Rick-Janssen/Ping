var myChart = echarts.init(document.getElementById('main'));

function fetchDataAndRefreshChart() {
    fetch('/pingData')
        .then(response => response.json())
        .then(data => {
            var formattedData = data.formattedData;

            var hostsData = {};

            formattedData.forEach(item => {
                var hostName = item.host_name;
                var pingValue = item.ping;

                if (!hostsData[hostName]) {
                    hostsData[hostName] = [];
                }

                if (hostsData[hostName].length < 50) {
                    hostsData[hostName].push({
                        date: item.date,
                        ping: pingValue,
                    });
                }
            });

            var seriesData = [];

            for (var host_name in hostsData) {
                if (hostsData.hasOwnProperty(host_name)) {
                    var hostData = hostsData[host_name];
                    var pingValues = hostData.map(function(item) {
                        return item.ping;
                    });

                    seriesData.push({
                        name: host_name,
                        type: 'line',
                        data: pingValues,
                    });
                }
            }

            var option = {

                grid: {
                    left: '10%',
                    right: '10%', 
                    top: '10%',
                    bottom: '10%'
                },
                legend: {
                    type: 'scroll',
                    color: 'white',
                    orient: 'horizontal',
                    left: 6,
                    data: Object.keys(hostsData),
                    icon: 'rect',
                    textStyle: {
                        color: '@media (prefers-color-scheme: dark) {white}, black'
                    }
                },
                xAxis: {
                    type: 'category',
                    data: hostsData[Object.keys(hostsData)[0]].map(function(item) {
                        return item.date;
                    })
                },
                yAxis: {
                    type: 'value',
                },
                tooltip: {
                    trigger: 'axis',
                    formatter: function(params) {
                        params.sort(function(a, b) {
                            return b.value - a.value;
                        });

                        var tooltipContent = params[0].axisValue + '<br>';
                        params.forEach(function(item) {
                            tooltipContent += item.seriesName + ': ' + item.value + '<br>';
                        });

                        return tooltipContent;
                    }
                },

                series: seriesData,
            };

            myChart.setOption(option, {
                notMerge: true,
                lazyUpdate: true
            });

        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}


function setChartSize() {
    var container = document.getElementById('container');
    var main = document.getElementById('main');
    var containerWidth = container.offsetWidth;
    var containerHeight = container.offsetHeight;

    main.style.width = containerWidth + 'px';
    main.style.height = containerHeight + 'px';

    myChart.resize();
}

setChartSize();
fetchDataAndRefreshChart();

function refreshChart() {
    fetchDataAndRefreshChart();
}

setInterval(refreshChart, 45000);

window.addEventListener('resize', setChartSize, );