@extends('layouts.app')
@section('title', 'Home')

@section('header')
    <h1 class="page-title">Dashboard</h1>
    <div class="page-header-actions">
    </div>
@endsection

@section('content')
    <div class="row">
        
        <div class="col-xxl-3 col-lg-3 h-p50 h-only-lg-p100 h-only-xl-p100">
            <!-- Panel Overall Sales -->
            <div class="card card-shadow card-inverse bg-blue-600 white">
                <div class="card-block p-30">
                    <div class="counter counter-lg counter-inverse text-left">
                        <div class="counter-label mb-20">
                            <div>Active Promocode</div>
                        </div>
                        <div class="counter-number-group mb-15">
                            <span class="counter-number-related">#</span>
                            <span class="counter-number">111</span>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel Overall Sales -->
        </div>
        
        <div class="col-xxl-3 col-lg-3 h-p50 h-only-lg-p100 h-only-xl-p100">
            <!-- Panel Overall Sales -->
            <div class="card card-shadow card-inverse bg-red-600 white">
                <div class="card-block p-30">
                    <div class="counter counter-lg counter-inverse text-left">
                        <div class="counter-label mb-20">
                            <div><a href="{{ url('charging-activities?active=true') }}" class="text-white">Active Charging</a></div>
                        </div>
                        <div class="counter-number-group mb-15">
                            <span class="counter-number-related">#</span>
                            <span class="counter-number">7777</span>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel Overall Sales -->
        </div>
        
        <div class="col-xxl-3 col-lg-3 h-p50 h-only-lg-p100 h-only-xl-p100">
            <!-- Panel Overall Sales -->
            <div class="card card-shadow card-inverse bg-yellow-600 white">
                <div class="card-block p-30">
                    <div class="counter counter-lg counter-inverse text-left">
                        <div class="counter-label mb-20">
                            <div>Users</div>
                        </div>
                        <div class="counter-number-group mb-15">
                            <span class="counter-number-related">#</span>
                            <span class="counter-number">{{ count($customers)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Panel Overall Sales -->
        </div>
        
        <div class="col-xxl-3 col-lg-3 h-p50 h-only-lg-p100 h-only-xl-p100">
            <!-- Panel Overall Sales -->
            <div class="card card-shadow card-inverse bg-green-600 white">
                <div class="card-block p-30">
                    <div class="counter counter-lg counter-inverse text-left">
                        <div class="counter-label mb-20">
                            <div>Charge Points</div>
                        </div>
                        <div class="counter-number-group mb-15">
                            <span class="counter-number-related">#</span>
                            <span class="counter-number">{{count($charge_points)}}</span>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel Overall Sales -->
        </div>
        
        <div class="col-xxl-3 col-lg-3 h-p50 h-only-lg-p100 h-only-xl-p100">
            <div class="card card-shadow card-inverse bg-blue-600 white">
                <div class="card-block p-30">
                    <div class="counter counter-lg counter-inverse text-left">
                        <div class="counter-label mb-20">
                            <div>Total Energy (KW)</div>
                        </div>
                        <div class="counter-number-group mb-15">
                            <span class="counter-number-related"></span>
                            <span class="counter-number">9889</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xxl-3 col-lg-3 h-p50 h-only-lg-p100 h-only-xl-p100">
            <div class="card card-shadow card-inverse bg-yellow-600 white">
                <div class="card-block p-30">
                    <div class="counter counter-lg counter-inverse text-left">
                        <div class="counter-label mb-20">
                            <div>Total Duration</div>
                        </div>
                        <div class="counter-number-group mb-15">
                            <span class="counter-number-related"></span>
                            <span class="counter-number">878</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-xxl-6 col-lg-6 h-p50 h-only-lg-p100 h-only-xl-p100">
        <canvas id="myChart"></canvas>
    </div>
    <div class="col-xxl-6 col-lg-6 h-p50 h-only-lg-p100 h-only-xl-p100">
        <canvas id="myChart2"></canvas>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div id="map" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@endpush