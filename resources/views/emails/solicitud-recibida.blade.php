<x-mail::message>
# POR FAVOR NO RESPONDA ESTE EMAIL, ESTA ES UNA NOTIFICACIÓN ELECTRÓNICA AUTOMÁTICA

Se ha recepcionado a través de la Ventanilla Única Virtual una solicitud con los siguientes datos:

# SOLICITUD:

- Fecha de Solicitud: {{ now()->format('d-m-Y \a \l\a\s H:i:s') }}
- Tipo petición: {{ $solicitud->tipo_peticion }}
- Asunto: {{ $solicitud->asunto }}
- Valor Consignado: ${{ $solicitud->valor_consignado ?? '$0' }}
- Mensaje: {!! $solicitud->mensaje !!}
{{-- - Mensaje: {{ $solicitud->mensaje }} --}}

# DATOS USUARIO:

- Identificación: {{ $usuario->username }}
- Nombre Completo: {{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
- Email: {{ $usuario->email }}
- Móvil: {{ $usuario->movil }}
- Dirección: {{ $usuario->direccion }}
- Ciudad: {{ $usuario->Municipios->municipio }}
- Valor a pagar antes del {{ $info_deportista->fecha_antes ?? '' }}: ${{ $info_deportista->valor_pagar_antes ?? '' }}
- Valor a pagar a partir del {{ $info_deportista->fecha_despues ?? '' }}: ${{ $info_deportista->valor_apagar_despues ?? '' }}

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>