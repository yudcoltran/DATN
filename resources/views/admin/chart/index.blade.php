@extends('layouts.admin')
@section('title', 'Orders')
@section('content')
    <div style="height: 700px;">
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        fetch("{{ url('admin/statistic/chart') }}")
            .then(response => response.json())
            .then(json => {
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: json.labels,
                        datasets: [{
                            label: json.dataset.label,
                            data: json.dataset.data,
                            backgroundColor: [
                                "#ea5545", "#f46a9b", "#ef9b20", "#edbf33", "#ede15b", "#bdcf32",
                                "#87bc45", "#27aeef", "#b33dc6"
                            ],
                            borderColor: [
                                "#ea5545", "#f46a9b", "#ef9b20", "#edbf33", "#ede15b", "#bdcf32",
                                "#87bc45", "#27aeef", "#b33dc6"
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
    </script>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    @endpush
@endsection
