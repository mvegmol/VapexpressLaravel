@extends('template.app')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Sección de Usuarios Registrados -->
        <div class="flex flex-wrap mb-6">
            <!-- Card de Usuarios Registrados -->
            <div class="w-full md:w-1/3 p-2">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold text-gray-700">Usuarios Registrados</h2>
                    <p class="text-5xl font-semibold text-center mt-4">{{ $totalUsers }}</p>
                </div>
            </div>

            <!-- Gráfico de Usuarios Registrados -->
            <div class="w-full md:w-2/3 p-2">
                <div class="bg-white p-6 rounded-lg shadow-md h-full">
                    <h2 class="text-xl font-bold text-gray-700">Usuarios Registrados en los Últimos 30 Días</h2>
                    <div class="h-64">
                        <canvas id="userRegistrationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pedidos Realizados -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-bold text-gray-700">Pedidos Realizados en los Últimos 30 Días</h2>
            <div class="h-64">
                <canvas id="orderChart"></canvas>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-bold text-gray-700">Productos Más Vendidos</h2>
            <div class="h-64">
                <canvas id="bestSellingProductsChart"></canvas>
            </div>
        </div>

        <!-- Proveedores Más Comprados -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-bold text-gray-700">Proveedores Más Comprados</h2>
            <div class="h-64">
                <canvas id="topSuppliersChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Usuarios Registrados (Line Chart)
        const userRegistrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
        const userRegistrationsChart = new Chart(userRegistrationsCtx, {
            type: 'line',
            data: {
                labels: @json($userRegistrationDates),
                datasets: [{
                    label: 'Usuarios Registrados',
                    data: @json($userRegistrationCounts),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                maintainAspectRatio: false
            }
        });

        // Pedidos Realizados (Line Chart)
        const orderCtx = document.getElementById('orderChart').getContext('2d');
        const orderChart = new Chart(orderCtx, {
            type: 'line',
            data: {
                labels: @json($orderDates),
                datasets: [{
                    label: 'Pedidos Realizados',
                    data: @json($orderCounts),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1,
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });

        // Productos Más Vendidos (Bar Chart)
        const bestSellingProductsCtx = document.getElementById('bestSellingProductsChart').getContext('2d');
        const bestSellingProductsChart = new Chart(bestSellingProductsCtx, {
            type: 'bar',
            data: {
                labels: @json($bestSellingProductNames),
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: @json($bestSellingProductQuantities),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });

        // Proveedores Más Comprados (Bar Chart)
        const topSuppliersCtx = document.getElementById('topSuppliersChart').getContext('2d');
        const topSuppliersChart = new Chart(topSuppliersCtx, {
            type: 'bar',
            data: {
                labels: @json($supplierNames),
                datasets: [{
                    label: 'Productos Comprados',
                    data: @json($supplierQuantities),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
