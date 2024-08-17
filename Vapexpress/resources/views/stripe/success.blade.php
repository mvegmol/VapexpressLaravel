@extends('template.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen">
        <h1 class="text-2xl font-bold mb-4">Procesando tu pedido...</h1>
        <p class="text-gray-500">Por favor, espera mientras procesamos tu pedido.</p>

        <!-- Formulario de Pedido -->
        <form id="orderForm" action="{{ route('order.store') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="address" value="{{ session('address') }}">
        </form>
    </div>
@endsection

<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("orderForm").submit();
    });
</script>
