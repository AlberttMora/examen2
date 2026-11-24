@extends('layouts.app')

@section('title', $lista->titulo)

@section('content')
    <div class="bg-light rounded p-4" id="lista-publica" data-token="{{ $lista->token }}">

        <h4 class="mb-1">{{ $lista->titulo }}</h4>
        <p class="text-muted mb-3">
            <i class="fa fa-user me-1"></i>Lista creada por: {{ $lista->user->nombre }}
        </p>

        {{-- Contador y porcentaje (publica.js los actualiza) --}}
        @php
            $total = $lista->items->count();
            $completados = $lista->items->where('completado', 1)->count();
            $porcentaje = $total > 0 ? round(($completados / $total) * 100) : 0;
        @endphp

        <div class="d-flex justify-content-between mb-1">
            <span id="contador" class="fw-bold">{{ $completados }} de {{ $total }} completados</span>
            <span id="porcentaje" class="fw-bold">{{ $porcentaje }}%</span>
        </div>

        {{-- Barra de progreso --}}
        <div class="progress mb-3" style="height: 12px;">
            <div id="barra" class="progress-bar" role="progressbar" style="width: {{ $porcentaje }}%;"
                aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        {{-- Ítems --}}
        <ul class="list-group">
            @forelse ($lista->items as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <label class="d-flex align-items-center mb-0 flex-grow-1" style="cursor: pointer;">
                        <input type="checkbox" class="form-check-input item-check me-3 mt-0" data-id="{{ $item->id_item }}" {{ $item->completado ? 'checked' : '' }}>
                        <span class="item-texto">{{ $item->descripcion }}</span>
                    </label>
                    <small class="item-estado text-muted">{{ $item->completado ? 'Completado' : 'Pendiente' }}</small>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">Esta lista no tiene ítems.</li>
            @endforelse
        </ul>

        {{-- Mensaje de felicitación: oculto hasta completar todo --}}
        <div id="mensaje-exito" class="alert alert-success mt-3 mb-0 d-none" role="alert">
            <strong>¡Lo lograste!</strong> Has completado todos los elementos de tu lista
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('publica.js') }}"></script>
@endpush