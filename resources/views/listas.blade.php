@extends('layouts.app')

@section('title', 'Mis listas')

@section('content')
    <div class="bg-light rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Mis listas</h6>
            <a href="{{ route('listas.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus me-1"></i>Nueva lista
            </a>
        </div>

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th>#</th>
                        <th>Título</th>
                        <th>Token</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listas as $lista)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lista->titulo }}</td>
                            <td><code>{{ $lista->token }}</code></td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- ESTUDIANTE B --}}
                                    <a href="{{ url($lista->token) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye me-1"></i>Ver pública
                                    </a>

                                    <a href="https://wa.me/?text={{ urlencode('Mirá mi lista «' . $lista->titulo . '»: ' . url($lista->token)) }}"
                                        target="_blank" class="btn btn-sm btn-success">
                                        <i class="fab fa-whatsapp me-1"></i>Compartir
                                    </a>

                                    {{-- ESTUDIANTE A --}}
                                    <a href="{{ route('listas.edit', $lista->id_lista) }}"
                                        class="btn btn-sm btn-warning">Editar</a>

                                    <form method="POST" action="{{ route('listas.destroy', $lista->id_lista) }}"
                                        onsubmit="return confirm('¿Eliminar la lista «{{ $lista->titulo }}»?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Todavía no tenés listas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection