@extends('template.app')

@section('content')
    <h1>Procesando tu pedido...</h1>
    <form id="orderForm" action="{{ route('order.store') }}" method="POST">
        @method('POST')
        @csrf
        <!-- Puedes incluir datos adicionales aquí si es necesario -->
        <input type="hidden" name="address" value="{{ session('address') }}">
        <!-- Puedes enviar más datos aquí si es necesario -->
    </form>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("orderForm").submit();
    });
</script>
