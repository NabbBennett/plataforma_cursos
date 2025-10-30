@extends('layouts.admin')

@section('title', 'Editar Examen')
@include('layouts.help')

@section('content')
<div class="container">
    <h2>Editar Examen</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.exams.update', $exam->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $exam->title) }}" required>
        </div>

        <div class="mb-3">
            <label>Duración (minutos)</label>
            <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $exam->duration_minutes) }}" required>
        </div>

        <hr>
        <h4>Preguntas</h4>
        <div id="questions-container">
            {{-- Aquí se pueden agregar preguntas dinámicamente --}}
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addQuestion()">+ Añadir Pregunta</button>
        <button type="submit" class="btn btn-success">Guardar Examen</button>
    </form>
</div>

{{-- Template para preguntas dinámicas --}}
<template id="question-template">
    <div class="question-block border p-3 mb-4 rounded">
        <h5>Pregunta <span class="question-number"></span></h5>
        <div class="mb-2"><label>Texto</label>
            <textarea name="questions[__INDEX__][text]" class="form-control rich-text" required></textarea>
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

    function addQuestion(data = {}) {
        const template = document.getElementById('question-template').innerHTML;
        const html = template.replace(/__INDEX__/g, questionIndex);
        const div = document.createElement('div');
        div.innerHTML = html;
        document.getElementById('questions-container').appendChild(div);
        div.querySelector('.question-number').textContent = questionIndex + 1;

        // Rellenar datos si existen (para edición)
        if (data.text) div.querySelector('textarea[name^="questions"]').value = data.text;
        if (data.theme) div.querySelector('input[name^="questions"][name$="[theme]"]').value = data.theme;
        if (data.correct) div.querySelector('textarea[name^="questions"][name$="[correct]"]').value = data.correct;
        if (data.wrong1) div.querySelector('textarea[name^="questions"][name$="[wrong1]"]').value = data.wrong1;
        if (data.wrong2) div.querySelector('textarea[name^="questions"][name$="[wrong2]"]').value = data.wrong2;
        if (data.wrong3) div.querySelector('textarea[name^="questions"][name$="[wrong3]"]').value = data.wrong3;

        // Solo inicializa CKEditor en el textarea de la pregunta
        const questionTextarea = div.querySelector('textarea.rich-text');
        if (questionTextarea) {
            CKEDITOR.replace(questionTextarea, {
                filebrowserUploadUrl: "{{ route('ckeditor.upload').'?_token='.csrf_token() }}",
                filebrowserUploadMethod: 'form',
                language: 'es'
            });
        }

        questionIndex++;
    }

    // Recibe las preguntas desde PHP y las agrega en JS
    @php
        $preguntas = [];
        if(isset($exam) && $exam->questions) {
            foreach($exam->questions as $q) {
                $preguntas[] = [
                    'text' => $q->text,
                    'theme' => $q->theme,
                    'correct' => $q->answers->where('is_correct', true)->first()->text ?? '',
                    'wrong1' => $q->answers->where('is_correct', false)->values()->get(0)->text ?? '',
                    'wrong2' => $q->answers->where('is_correct', false)->values()->get(1)->text ?? '',
                    'wrong3' => $q->answers->where('is_correct', false)->values()->get(2)->text ?? '',
                ];
            }
        }
    @endphp

    const preguntas = @json($preguntas);

    if (preguntas.length > 0) {
        preguntas.forEach(q => addQuestion(q));
    } else {
        document.addEventListener('DOMContentLoaded', () => {
            addQuestion(); // Carga una pregunta inicial si no hay preguntas
        });
    }
</script>

@include('layouts.mathjax')
@endsection
