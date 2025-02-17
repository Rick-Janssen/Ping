@extends('layouts.head')

@section('content')
    <br><br>
    @if ($host != '')
        <div class="container">
            <div class="host-container">
                <div class="back">
                    <a href="/dashboard"> <i class="fa-solid fa-arrow-left"></i> Back </a>
                </div> <br><br>
                <p class="text-3xl font-semibold underline">{{ $host->name }}</p> <br>
                <p> Ip: {{ $host->ip }} </p>
                <p>Location: {{ $host->location }}</p>

                <h2 class="mt-4 mb-2 text-xl font-semibold">Hourly Averages</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Avg</th>
                                <th>Min</th>
                                <th>Max</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hourlyData as $data)
                                <tr>
                                    <td>{{ $data->created_at->format('H:i') }}</td>
                                    <td>{{ $data->avg }} ms</td>
                                    <td>{{ $data->minMS }} ms</td>
                                    <td>{{ $data->maxMS }} ms</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="containerID" class="chart-container">
                <div id="main" class="chart"></div>
            </div>
        </div>
        <script>
            var myChart = echarts.init(document.getElementById('main'));

            var xAxisData = [];
            var seriesData = [];

            @foreach ($hourlyData as $data)
                xAxisData.push('{{ $data->created_at->format('H:i') }}');
                seriesData.push({
                    value: {!! json_encode($data->avg) !!},
                    name: '{{ $data->created_at->format('H:i') }}'
                });
            @endforeach

            var option = {
                grid: {
                    left: '10%',
                    right: '10%',
                    top: '10%',
                    bottom: '10%'
                },
                xAxis: {
                    type: 'category',
                    data: xAxisData,
                },
                yAxis: {
                    type: 'value',
                },
                series: [{
                    type: 'line',
                    data: seriesData,
                }],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        animation: false
                    }
                },
            };

            myChart.setOption(option, {
                notMerge: true,
                lazyUpdate: true
            });

            function setChartSize() {
                var container = document.getElementById('containerID');
                var main = document.getElementById('main');
                var containerWidth = container.offsetWidth;
                var containerHeight = container.offsetHeight;

                main.style.width = containerWidth + 'px';
                main.style.height = containerHeight + 'px';

                myChart.resize();
            }

            setChartSize();
            window.addEventListener('resize', setChartSize);
        </script>
    @else
        <div class='container'>
            <a class="back" href="/dashboard"> <i class="fa-solid fa-arrow-left"></i> Back </a><br>
            <h1>Host does not exist</h1>
        </div>
    @endif
    </body>
@endsection
