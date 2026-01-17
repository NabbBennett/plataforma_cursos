@extends('layouts.app')

@section('title', 'Tu examen terminó')

@section('content')

<style>
	.exam-finish-wrapper {
		min-height: 100vh;
		background-color: var(--bg-primary);
		padding: 2rem 1rem;
	}

	.exam-finish-card {
		max-width: 480px;
		width: 100%;
		background-color: var(--bg-secondary);
		border: 1px solid var(--border-color);
		border-radius: 12px;
	}

	@media (max-width: 576px) {
		.exam-finish-wrapper {
			padding: 1.5rem 1rem;
		}

		.exam-finish-card .card-body {
			padding: 1.5rem 1.25rem;
		}

		.exam-finish-card h4 {
			font-size: 1.25rem;
		}

		.exam-finish-card p {
			font-size: 0.95rem;
		}
	}
</style>

<div class="exam-finish-wrapper d-flex align-items-center justify-content-center">
	<div class="exam-finish-card card shadow-lg">
		<div class="card-body p-4">
			<h4 class="card-title mb-3" style="color: var(--text-primary);">Tu examen terminó</h4>
			@php
				$finishedReason = $reason ?? session('finished_reason');
			@endphp

			@if($finishedReason === 'timeout')
				<p class="mb-2" style="color: var(--text-primary);">
					El tiempo del examen se ha agotado y tus respuestas se cerraron automáticamente.
				</p>
			@else
				<p class="mb-2" style="color: var(--text-primary);">
					Tu intento de examen se cerró abruptamente o tu sesión expiró.
				</p>
			@endif

			<p class="mb-4" style="color: var(--text-secondary);">
				Si crees que esto fue un error o tuviste algún problema técnico, puedes escribirnos por WhatsApp para que revisemos tu caso.
			</p>

			<div class="d-flex flex-column gap-2">
				<a href="{{ route('student.exams.result', ['course' => $course->id, 'exam' => $exam->id]) }}" class="btn btn-primary w-100">
					Ver resultados del examen
				</a>
				<a href="{{ 'https://wa.me/5212203000543?text=' . urlencode('Hola, tuve un problema con mi examen del curso ' . ($course->title ?? '') . ' (Examen ' . ($exam->title ?? '') . ').') }}" target="_blank" class="btn btn-success w-100">
					Contactar por WhatsApp
				</a>
                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-secondary w-100">
					← Volver al curso
				</a>
			</div>
		</div>
	</div>
</div>

@endsection

