<p><strong>¡Gracias por tu compra!</strong></p>
<p>Aquí están los detalles de tu pedido:</p>
<ul>
    @foreach ($products as $product)
        <li>{{ $product->name }} - {{ $product->pivot->quantity }} unidades</li>
    @endforeach
</ul>
<p><strong>Dirección de envío:</strong> {{ $order->address }}</p>
<p><strong>Total de la compra:</strong> ${{ $order->total_price }}</p>
