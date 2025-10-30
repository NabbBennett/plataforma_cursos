@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div style="max-width: 900px; margin: 2rem auto; padding: 1rem;">
    <h2>Mi perfil</h2>

    {{-- Información personal --}}
    <div style="margin-bottom: 2rem;">
        <h3>Información personal</h3>
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    {{-- Cursos comprados --}}
    <div style="margin-bottom: 2rem;">
        <h3>Cursos comprados</h3>

        @if($compras->isEmpty())
            <p>No has comprado ningún curso todavía.</p>
        @else
            <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($compras as $compra)
                @php $curso = $compra->course; @endphp
                @if($curso)
                <div style="border: 1px solid #ccc; border-radius: 8px; padding: 1rem; display: flex; align-items: center;">
                    <img src="{{ $curso->image ? asset('storage/' . $curso->image) : asset('images/default-course.png') }}"
                        alt="Imagen del curso"
                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; margin-right: 1rem;">
                    <div>
                        <h4 style="margin: 0;">{{ $curso->title }}</h4>
                        <p style="font-size: 0.9rem; color: #555;">{{ Str::limit($curso->description, 60) }}</p>
                        <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-primary btn-sm">Entrar</a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
