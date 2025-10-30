@extends('layouts.admin')

@section('title', 'Subir recurso')

@section('content')
<div class="container mt-4">
    <h2>Subir nuevo recurso</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Título del recurso</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Archivo (PDF o imagen)</label>
            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>

        <button type="submit" class="btn btn-success">Subir</button>
    </form>
</div>
@endsection
