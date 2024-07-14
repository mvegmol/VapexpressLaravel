@switch(true)
    @case(session('success'))
        <div class="alert bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md flex items-center space-x-3 my-3"
            role="alert">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @break

    @case(session('error'))
        <div class="alert bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md flex items-center space-x-3 my-3"
            role="alert">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18.364 5.636L5.636 18.364M5.636 5.636L18.364 18.364"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @break
@endswitch

{{-- Script para que se elimine el mensaje cuando aparece cada 3 segundos --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona todas las alertas
        var alerts = document.querySelectorAll('.alert');

        // Oculta cada alerta después de 3 segundos
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.display = 'none';
            }, 3000);
        });
    });
</script>
