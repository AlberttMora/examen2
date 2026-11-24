@extends('layouts.app')

@section('title', 'Editar lista')

@section('content')
    <div class="bg-light rounded p-4">
        <h6 class="mb-4">Editar lista</h6>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('listas.update', $lista->id_lista) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control"
                    value="{{ old('titulo', $lista->titulo) }}" required>
            </div>

            <label class="form-label">Ítems</label>
            <div id="contenedor-items">
                {{-- Ítems que ya existen: items[ID_ITEM] --}}
                @foreach ($lista->items as $item)
                    <div class="input-group mb-2 fila-item">
                        <input type="text" name="items[{{ $item->id_item }}]" class="form-control"
                            value="{{ $item->descripcion }}" required>
                        <button type="button" class="btn btn-outline-danger btn-quitar">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="btn-agregar" class="btn btn-outline-primary btn-sm mb-3">
                <i class="fa fa-plus me-1"></i>Agregar ítem
            </button>

            <div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('listas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Ítems nuevos: nuevos[]
        $('#btn-agregar').on('click', function () {
            $('#contenedor-items').append(`
                    <div class="input-group mb-2 fila-item">
                        <input type="text" name="nuevos[]" class="form-control"
                               placeholder="Descripción del ítem" required>
                        <button type="button" class="btn btn-outline-danger btn-quitar">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);
        });

        // Quitar una fila: al desaparecer del formulario, el controller la borra
        $(document).on('click', '.btn-quitar', function () {
            $(this).closest('.fila-item').remove();
        });
    </script>
@endpush