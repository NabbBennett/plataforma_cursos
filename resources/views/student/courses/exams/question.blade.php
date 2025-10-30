@extends('layouts.app')

@section('content')

<div class="exam-bg py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 exam-header" style="background: rgba(0, 0, 0, 0.5);">
            <div class="d-flex align-items-center">
                <span class="fs-4 fw-bold text-white">Instituto Resiliencia</span>
            </div>
            <div class="exam-title text-center flex-grow-1">
                <span class="fs-3 fw-bold text-white">Examen de semana #{{ $exam->id }}</span>
            </div>
            <div>
                <span class="fs-4 fw-bold text-white" id="timer">00:00</span>
            </div>
        </div>

        <form id="examAnswersForm" method="POST" action="{{ route('student.exams.submit', ['course' => $course->id, 'exam' => $exam->id]) }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3 border rounded p-2">
                        <strong>Num pregunta: {{ $questionNumber }}</strong>
                    </div>
                    <div class="border rounded p-3" style="min-height: 180px;">
                        {!! $question->text !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 border rounded p-2">
                        <strong>RESPUESTA</strong>
                    </div>
                    <div class="border rounded p-3" style="min-height: 180px;">
                        @foreach ($question->answers as $answer)
                            <div class="form-check mb-2">
                                <input class="form-check-input"
                                       type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $answer->id }}"
                                       onchange="saveAnswer({{ $question->id }}, {{ $answer->id }})"
                                       {{ old("answers.{$question->id}", session("exam_{$exam->id}.answers.{$question->id}")) == $answer->id ? 'checked' : '' }}
                                       {{ session("exam_{$exam->id}.finished") ? 'disabled' : '' }}>
                                <label class="form-check-label">{!! $answer->text !!}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>

        <hr class="my-4">

        {{-- Navegación inferior --}}
        <div class="exam-nav d-flex flex-wrap justify-content-center align-items-center gap-2 py-3">
            @foreach ($exam->questions->sortBy('order')->values() as $i => $q)
                @php
                    $answered = session("exam_{$exam->id}.answers.{$q->id}") ?? null;
                    $active = $q->id == $question->id;
                @endphp
                <a href="{{ route('student.exams.question', [
                        'course' => $course->id,
                        'exam' => $exam->id,
                        'questionNumber' => $i + 1
                    ]) }}"
                   class="btn btn-sm {{ $active ? 'btn-light' : 'btn-secondary' }}"
                   style="opacity: {{ $active ? '1' : '0.7' }}; text-decoration: {{ $answered ? 'line-through' : 'none' }};">
                    {{ $i + 1 }}
                </a>
            @endforeach
            <button type="submit" form="examAnswersForm" class="btn btn-danger btn-sm ms-3" {{ session("exam_{$exam->id}.finished") ? 'disabled' : '' }}>FIN</button>
        </div>
    </div>
</div>
@endsection

<script>
function saveAnswer(questionId, answerId) {
    fetch("{{ route('student.exams.saveAnswer', ['course' => $course->id, 'exam' => $exam->id]) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            question_id: questionId,
            answer_id: answerId,
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Guardado correctamente:', data);
    })
    .catch(error => console.error('Error al guardar respuesta:', error));
}

// Timer
const expirationTimestamp = "{{ session("exam_{$exam->id}")['expires_at'] ?? now() }}";
const endTime = new Date(expirationTimestamp).getTime();

function updateTimer() {
    const now = new Date().getTime();
    const distance = endTime - now;
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("timer").textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    if (distance < 0) {
        clearInterval(timerInterval);
        document.getElementById("timer").textContent = "00:00";
        document.getElementById('examAnswersForm').submit();
    }
}
const timerInterval = setInterval(updateTimer, 1000);
updateTimer();
</script>
