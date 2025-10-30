@extends('layouts.admin')

@section('title', 'Crear Examen')
@include('layouts.help')

@section('content')
<div class="container">
    <h2>Crear Examen</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="exam-form" method="POST" action="{{ route('admin.exams.store') }}">
        @csrf

        <div class="mb-3">
            <label for="title">Título del examen</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Duración (minutos)</label>
            <input type="number" name="duration_minutes" class="form-control" required>
        </div>

        <hr>
        <h4>Preguntas</h4>

        <div id="questions-container"></div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addQuestion()">+ Añadir Pregunta</button>
        <button type="submit" class="btn btn-success">Guardar Examen</button>
    </form>
</div>

{{-- Template para añadir preguntas --}}
<template id="question-template">
    <div class="question-block border p-3 mb-4 rounded">
        <h5>Pregunta <span class="question-number"></span></h5>
        <div class="mb-2"><label>Texto</label>
            <textarea name="questions[__INDEX__][text]" class="form-control question-text" required></textarea>
        </div>
        <div class="mb-2"><label>Tema de la pregunta</label>
            <input type="text" name="questions[__INDEX__][theme]" class="form-control">
        </div>
        <div class="mb-2"><label>Respuesta correcta</label>
            <textarea name="questions[__INDEX__][correct]" class="form-control" required></textarea>
        </div>
        <div class="mb-2"><label>Incorrecta 1</label>
            <textarea name="questions[__INDEX__][wrong1]" class="form-control"></textarea>
        </div>
        <div class="mb-2"><label>Incorrecta 2</label>
            <textarea name="questions[__INDEX__][wrong2]" class="form-control"></textarea>
        </div>
        <div class="mb-2"><label>Incorrecta 3</label>
            <textarea name="questions[__INDEX__][wrong3]" class="form-control"></textarea>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
let questionIndex = 0;

function addQuestion() {
    const template = document.getElementById('question-template').innerHTML;
    const html = template.replace(/__INDEX__/g, questionIndex);
    const div = document.createElement('div');
    div.innerHTML = html;
    document.getElementById('questions-container').appendChild(div);
    div.querySelector('.question-number').textContent = questionIndex + 1;

    // Inicializa CKEditor 4 en el textarea de texto de la pregunta
    const textarea = div.querySelector('textarea.question-text');
    CKEDITOR.replace(textarea, {
        // Puedes agregar configuración extra aquí
        filebrowserUploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token() }}",
        filebrowserUploadMethod: 'form'
    });

    questionIndex++;
}

document.addEventListener('DOMContentLoaded', () => addQuestion());
</script>
@endsection
