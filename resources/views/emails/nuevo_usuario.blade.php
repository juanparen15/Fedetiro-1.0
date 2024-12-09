<x-mail::message>
# POR FAVOR NO RESPONDA A ESTE EMAIL

Señor Deportista, una vez revisada la información del año inmediatamente anterior,
el valor de la credencial {{ config('app.name') }} se relaciona a continuación:

1. Si es la primera vez que solicita su credencial {{ config('app.name') }}, tenga en cuenta
la siguiente información:

- Valor de credencial: ${{ $info_deportista->valor_credencial }}
- Porcentaje de descuento por pronto pago: {{ $info_deportista->porcentaje_descuento }}% (aplica para pagos realizados hasta el {{ $info_deportista->fecha_antes }})
- Valor a pagar antes del {{ $info_deportista->fecha_antes }}: ${{ $info_deportista->valor_pagar_antes }}
- Valor a pagar a partir del {{ $info_deportista->fecha_despues }}: ${{ $info_deportista->valor_apagar_despues }}

2. Si ha sido Federado en años inmediatamente anteriores, comuníquese con la FEDERACIÓN COLOMBIANA DE TIRO Y CAZA DEPORTIVO
para verificar el valor a pagar.

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
