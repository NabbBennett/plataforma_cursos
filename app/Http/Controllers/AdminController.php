<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\User;
use App\Models\Course;
use App\Models\Week;
use App\Models\WeekDay;
use App\Models\Exam;
use App\Models\Purchase;
use App\Models\EvaluationBlock;
use App\Models\Coupon;

class AdminController extends Controller
{

    private function checkPermission($allowedRoles){
        $user = auth()->user();
        
        if (!$user || !in_array($user->role, $allowedRoles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    public function dashboard() {
        $this->checkPermission(['admin', 'ayudante', 'maestro']);

        $stats = [
            'users' => User::count(),
            'courses' => Course::count(),
            'exams' => Exam::count(),
            'resources' => Resource::count(),
            'coupons' => Coupon::count(),
            'sales' => Purchase::count(),
        ];

        // Los maestros solo ven cursos, exámenes y recursos
        if (auth()->user()->isMaestro()) {
            $stats['users'] = 0;
            $stats['coupons'] = 0;
            $stats['sales'] = 0;
        }

        // Los ayudantes solo ven usuarios y ventas
        if (auth()->user()->isAyudante()) {
            $stats['courses'] = 0;
            $stats['exams'] = 0;
            $stats['resources'] = 0;
            $stats['coupons'] = 0;
        }

        return view('admin.dashboard', $stats);
    }

    public function usersIndex(Request $request) {
        $this->checkPermission(['admin', 'ayudante']);

        $role = $request->query('role');
        $search = $request->query('search');
        
        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function editUser(User $user, Request $request) {
        $this->checkPermission(['admin', 'ayudante']);
        $roleFilter = $request->query('role');
        return view('admin.users.edit', compact('user', 'roleFilter'));
    }

    public function updateUser(Request $request, $id)
    {
        $this->checkPermission(['admin']);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,ayudante,maestro,student',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->only(['name','email','role']));
        $user->save();

        return back()->with('success', 'Usuario actualizado correctamente');
    }

    public function deleteUser($id) {
        $this->checkPermission(['admin']); // Solo admin puede eliminar

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users', ['role' => request('role')])->with('success', 'Usuario eliminado correctamente.');
    }

    public function coursesIndex() {
        $this->checkPermission(['admin', 'maestro']);
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function showCreateCourseForm() {
        $this->checkPermission(['admin', 'maestro']);
        return view('admin.courses.create');
    }

    public function createCourse(Request $request) {
            $this->checkPermission(['admin', 'maestro']);
    
        $request->validate([
            'course_group' => 'required|integer|min:1|max:10',
            'schedule' => 'required|string|max:100',
            "title" => "required|string|max:255",
            "description" => "required|string",
            'start_date' => 'nullable|date',
            'price_per_week' => 'required|numeric|min:0',
            "number_of_weeks" => "required|integer|min:1",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            'capacity' => 'nullable|integer|min:1|max:1000'
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('courses', 'public')
            : null;

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'price_per_week' => $request->price_per_week,
            'number_of_weeks' => $request->number_of_weeks,
            'image' => $imagePath,
            'capacity' => $request->capacity,
            'course_group' => $request->course_group,
            'schedule' => $request->schedule,
        ]);

        for ($i = 1; $i <= $request->number_of_weeks; $i++) {
            Week::create([
                'course_id' => $course->id,
                'number' => $i,
                'title' => "Semana $i"
            ]);
        }


        return redirect()->route('admin.courses.index')->with("success", "Curso creado.");
    }

    public function edit($id) {
        $this->checkPermission(['admin', 'maestro']);

        $course = Course::with([
            'weeks.resource',
            'weeks.weekDays',
            'weeks.exam',
            'evaluationBlocks.exams'
        ])->findOrFail($id);

        $weeks = $course->weeks()
            ->with(['weekDays','resource'])
            ->orderBy('order','asc')
            ->orderBy('number','asc')
            ->get();
        
        // Cargar bloques de evaluación ordenados
        $evals = $course->evaluationBlocks()
                   ->with('exams')
                   ->orderBy('order', 'asc')
                   ->orderBy('id', 'asc')
                   ->get();
        
        $allExams = Exam::withCount('questions')->get();
        $resources = Resource::all();

        // Combinar y ordenar todos los bloques por el campo order
        $combined = collect();
        
        foreach ($weeks as $week) {
            $combined->push([
                'type' => 'week', 
                'data' => $week,
                'order' => $week->order ?: 999
            ]);
        }
        
        foreach ($evals as $block) {
            $combined->push([
                'type' => 'evaluation', 
                'data' => $block,
                'order' => $block->order ?: 999
            ]);
        }
        
        // Ordenar por el campo order
        $combined = $combined->sortBy('order')->values()->toArray();

        return view('admin.courses.edit', compact('course', 'combined', 'resources', 'allExams'));
    }

    public function updateCourse(Request $request, $id) {
                    $this->checkPermission(['admin', 'maestro']);

        $request->validate([
            'course_group' => 'required|integer|min:1|max:10',
            'schedule' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'nullable|date',
            'price_per_week' => 'required|numeric|min:0',
            'block_order' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $course = Course::findOrFail($id);
        
        $course->update($request->only([
            'course_group',
            'schedule',
            'title', 
            'description', 
            'price_per_week', 
            'start_date', 
            'capacity'
        ]));
        
        // Manejar la carga de imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($course->image) {
                $oldImagePath = storage_path('app/public/' . $course->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            // Guardar nueva imagen
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = $imagePath;
            $course->save();
        }
        
        // Debug: Ver qué datos llegan
        \Log::info('Datos de semanas recibidos:', $request->input('weeks'));

        // Procesar orden de bloques
        $blockOrder = [];
        if ($request->filled('block_order')) {
            $blockOrderJson = $request->input('block_order');
            $blockOrder = json_decode($blockOrderJson, true);
            
            if (json_last_error() === JSON_ERROR_NONE && is_array($blockOrder)) {
                $this->updateBlockOrder($course, $blockOrder);
            }
        }

        // Procesar semanas
        $weeksData = $request->input('weeks', []);
        $realWeekCounter = 1;

        foreach ($weeksData as $index => $data) {
            $hasValidContent = !empty($data['title']) || 
                              !empty($data['live_meet_link']) || 
                              !empty($data['has_live']) || 
                              !empty($data['has_recorded']) || 
                              !empty($data['has_resources']) || 
                              !empty($data['exam_id']) || 
                              !empty($data['resource_ids']) ||
                              isset($data['days']);
            
            if (!isset($data['id']) && !$hasValidContent) continue;

            if (isset($data['id']) && $data['id'] != 0) {
                $week = Week::where('id', $data['id'])
                           ->where('course_id', $course->id)
                           ->first();
                
                if (!$week) {
                    $week = new Week();
                }
            } else {
                $week = new Week();
            }

            $order = $this->getOrderFromBlockOrder($blockOrder, 'week', (int)$index, $data['id'] ?? null);

            $week->course_id = $course->id;
            $week->number = $realWeekCounter++;
            $week->order = $order;
            // Si no se especifica título, usar "Semana X" automáticamente
            $week->title = !empty($data['title']) ? $data['title'] : 'Semana ' . $week->number;
            $week->live_meet_link = !empty($data['live_meet_link']) ? $this->convertDriveToPreview($data['live_meet_link']) : null;
            $week->exam_id = $data['exam_id'] ?? null;
            $week->resource_id = $data['resource_id'] ?? null;
            $week->save();

            // Procesar días grabados
            WeekDay::where('week_id', $week->id)->delete();
            $firstDayId = null;

            // Crear días si hay información de días (grabadas o recursos)
            if (isset($data['days'])) {
                foreach ($data['days'] as $dayNumber => $dayData) {
                    $hasDayData = !empty($dayData['enabled']) ||
                                  !empty($dayData['title']) ||
                                  !empty($dayData['recording_link']) ||
                                  !empty($dayData['resource_id']);

                    if ($hasDayData) {
                        $createdDay = WeekDay::create([
                            'course_id' => $course->id,
                            'week_id' => $week->id,
                            'day_number' => $dayNumber,
                            'title' => $dayData['title'] ?? null,
                            'recording_link' => $dayData['recording_link'] ?? null,
                            'resource_id' => $dayData['resource_id'] ?? null,
                        ]);

                        if (is_null($firstDayId) && !empty($dayData['recording_link'])) {
                            $firstDayId = $createdDay->id;
                        }
                    }
                }
            }

            $week->recording_link = $firstDayId;
            $week->save();
        }

        // Procesar bloques de evaluación (hasta cinco exámenes)
        $evalsData = $request->input('evaluation_blocks', []);
        $processedEvalIds = [];
        $slotKeys = ['slot1', 'slot2', 'slot3', 'slot4', 'slot5'];

        foreach ($evalsData as $evalKey => $evalData) {
            $examIds = $evalData['exam_ids'] ?? [];
            $type = isset($evalData['evaluation_type']) ? $evalData['evaluation_type'] : 'universidad';
            // Mapear examIds preservando el índice del slot
            $slotIndexToExamId = [];
            foreach ($slotKeys as $index => $slot) {
                if (!empty($examIds[$slot])) {
                    $slotIndexToExamId[$index] = (int)$examIds[$slot];
                }
            }

            $eval = null;
            if (isset($evalData['id']) && $evalData['id'] != 0) {
                $eval = EvaluationBlock::where('id', $evalData['id'])
                                      ->where('course_id', $course->id)
                                      ->first();
                
                if ($eval) {
                    $processedEvalIds[] = $eval->id;
                }
            }
            
            if (!$eval) {
                $eval = new EvaluationBlock();
            }

            $order = $this->getOrderFromBlockOrder($blockOrder, 'evaluation', (int)$evalKey, $evalData['id'] ?? null);

            $eval->course_id = $course->id;
            $eval->order = $order;
            $afterWeekId = $evalData['after_week_id'] ?? null;
            $eval->after_week_id = $afterWeekId > 0 ? $afterWeekId : null;
            $eval->evaluation_type = $evalData['evaluation_type'] ?? ($eval->evaluation_type ?? 'universidad');
            $eval->exam_id = !empty($slotIndexToExamId) ? reset($slotIndexToExamId) : null; // Mantiene compatibilidad con el primer examen
            $eval->live_meet_link = null;
            $eval->recording_link = null;
            $eval->resource_id = null;
            $eval->save();

            // Limpiar exámenes que ya no pertenecen a este bloque
            Exam::where('evaluation_block_id', $eval->id)->update(['evaluation_block_id' => null, 'slot_index' => null]);

            // Asignar los exámenes seleccionados al bloque con su índice de slot correcto
            if (!empty($slotIndexToExamId)) {
                foreach ($slotIndexToExamId as $slotIndex => $examId) {
                    Exam::whereKey($examId)->update([
                        'evaluation_block_id' => $eval->id,
                        'slot_index' => $slotIndex,
                    ]);
                }
            }
            
            if (!in_array($eval->id, $processedEvalIds)) {
                $processedEvalIds[] = $eval->id;
            }
        }

        // Eliminar semanas marcadas para eliminar
        if ($request->has('deleted_weeks')) {
            $deletedWeeks = array_filter($request->deleted_weeks);
            
            \Log::info('Semanas a eliminar:', $deletedWeeks);
            
            foreach ($deletedWeeks as $weekId) {
                if ($weekId && $weekId > 0) {
                    $week = Week::find($weekId);
                    if ($week && $week->course_id == $course->id) {
                        \Log::info('Eliminando semana:', ['id' => $weekId]);
                        $week->weekDays()->delete();
                        $week->delete();
                    }
                }
            }
        }

        // Eliminar bloques de evaluación marcados para eliminar
        if ($request->has('deleted_evaluation_blocks')) {
            $deletedBlocks = array_filter($request->deleted_evaluation_blocks);
            
            \Log::info('Bloques de evaluación a eliminar:', $deletedBlocks);
            
            if (!empty($deletedBlocks)) {
                foreach ($deletedBlocks as $blockId) {
                    if ($blockId && $blockId > 0) {
                        $block = EvaluationBlock::find($blockId);
                        if ($block && $block->course_id == $course->id) {
                            \Log::info('Eliminando bloque de evaluación:', ['id' => $blockId]);
                            Exam::where('evaluation_block_id', $block->id)->update(['evaluation_block_id' => null]);
                            $block->delete();
                        }
                    }
                }
            }
        }

        $course->number_of_weeks = $course->weeks()->count();
        $course->save();

        return redirect()->route('admin.courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    private function convertDriveToPreview($url) {
        if (strpos($url, 'drive.google.com') === false) {
            return $url;
        }
        return preg_replace('/\/view\?[^"]*/', '/preview', $url);
    }

    public function deleteWeek($id) {
        $week = Week::findOrFail($id);
        $week->weekDays()->delete();
        $week->delete();
        return back()->with('success', 'Semana eliminada con éxito.');
    }

    public function deleteCourse($id) {
        $this->checkPermission(['admin']);
        
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with("success", "Curso eliminado.");
    }

    public function showExamForm($weekId) {
         $this->checkPermission(['admin', 'maestro']);
        $week = Week::findOrFail($weekId);
        $exam = $week->exam;
        return $exam
            ? redirect()->route('admin.exams.edit', $exam->id)
            : view('admin.exams.create', compact('week'));
    }

    public function getWeekBlock(Request $request) {
        $index = $request->get('index', 0);
        $isEvaluation = $request->get('evaluation') == 1;
        $after_week_id = $request->get('after_week_id', null);
        $course_id = $request->get('course_id', null);
        $allExams = Exam::withCount('questions')->get();
        $resources = Resource::all();

        if ($isEvaluation) {
            // Crear un objeto EvaluationBlock para el bloque de evaluación
            $evaluationBlock = new EvaluationBlock();
            $evaluationBlock->after_week_id = $after_week_id;
            
            return view('admin.courses.partials.evaluation-block', [
                'evaluationBlock' => $evaluationBlock,
                'index' => $index,
                'course_id' => $course_id,
                'after_week_id' => $after_week_id,
                'allExams' => $allExams,
                'resources' => $resources
            ]);
        } else {
            // Crear un objeto Week para el bloque de semana
            return view('admin.courses.partials.week-block', [
                'week' => new Week(),
                'index' => $index,
                'course_id' => $course_id,
                'allExams' => $allExams,
                'resources' => $resources
            ]);
        }
    }

    // Agregar estos métodos para exámenes
    public function createExam(Request $request) {
        $this->checkPermission(['admin', 'maestro']);

        
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'week_id' => 'nullable|exists:weeks,id',
            'evaluation_block_id' => 'nullable|exists:evaluation_blocks,id',
        ]);

        $exam = Exam::create([
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes,
            'week_id' => $request->week_id,
            'evaluation_block_id' => $request->evaluation_block_id,
        ]);

        // Procesar preguntas si existen
        if ($request->has('questions')) {
            foreach ($request->questions as $index => $questionData) {
                $questionImagePath = null;
                
                // Manejar imagen de pregunta
                if (isset($questionData['image']) && is_file($questionData['image'])) {
                    $questionImagePath = $questionData['image']->store('uploads/exams/questions', 'public');
                }

                $question = $exam->questions()->create([
                    'text' => $questionData['text'] ?? '',
                    'theme' => $questionData['theme'] ?? '',
                    'order' => $index + 1,
                    'has_image' => !empty($questionImagePath),
                    'image_path' => $questionImagePath,
                ]);

                // Procesar respuestas
                if (isset($questionData['answers'])) {
                    foreach ($questionData['answers'] as $answerIndex => $answerData) {
                        $answerImagePath = null;
                        
                        // Manejar imagen de respuesta
                        if (isset($answerData['image']) && is_file($answerData['image'])) {
                            $answerImagePath = $answerData['image']->store('uploads/exams/answers', 'public');
                        }

                        $question->answers()->create([
                            'text' => $answerData['text'] ?? '',
                            'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'] == '1',
                            'has_image' => !empty($answerImagePath),
                            'image_path' => $answerImagePath,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.exams.index')->with('success', 'Examen creado correctamente.');
    }

    public function updateExam(Request $request, $id) {
                $this->checkPermission(['admin', 'maestro']);

        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->update([
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes,
        ]);

        // Eliminar preguntas existentes y crear nuevas
        $exam->questions()->delete();

        if ($request->has('questions')) {
            foreach ($request->questions as $index => $questionData) {
                $questionImagePath = null;
                
                // Manejar imagen de pregunta
                if (isset($questionData['image']) && is_file($questionData['image'])) {
                    $questionImagePath = $questionData['image']->store('uploads/exams/questions', 'public');
                }

                $question = $exam->questions()->create([
                    'text' => $questionData['text'] ?? '',
                    'theme' => $questionData['theme'] ?? '',
                    'order' => $index + 1,
                    'has_image' => !empty($questionImagePath),
                    'image_path' => $questionImagePath,
                ]);

                // Procesar respuestas
                if (isset($questionData['answers'])) {
                    foreach ($questionData['answers'] as $answerIndex => $answerData) {
                        $answerImagePath = null;
                        
                        // Manejar imagen de respuesta
                        if (isset($answerData['image']) && is_file($answerData['image'])) {
                            $answerImagePath = $answerData['image']->store('uploads/exams/answers', 'public');
                        }

                        $question->answers()->create([
                            'text' => $answerData['text'] ?? '',
                            'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'] == '1',
                            'has_image' => !empty($answerImagePath),
                            'image_path' => $answerImagePath,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.exams.index')->with('success', 'Examen actualizado correctamente.');
    }

    private function updateBlockOrder($course, array $blockOrder) {
        foreach ($blockOrder as $item) {
            $id = $item['id'];
            $type = $item['type'];
            $position = $item['position'];

            if (strpos($id, 'new_') === 0) {
                // Saltar elementos nuevos, se procesarán después
                continue;
            }

            if ($type === 'week') {
                Week::where('id', $id)
                    ->where('course_id', $course->id)
                    ->update(['order' => $position]);
            } elseif ($type === 'evaluation') {
                EvaluationBlock::where('id', $id)
                    ->where('course_id', $course->id)
                    ->update(['order' => $position]);
            }
        }
    }

    private function getOrderFromBlockOrder(array $blockOrder, string $type, $index, $blockId = null) {
        // Convertir el índice a int para asegurar el tipo correcto
        $index = (int) $index;
        
        foreach ($blockOrder as $item) {
            // Verificar por ID exacto primero
            if ($blockId && $blockId != 0 && $item['id'] == $blockId && $item['type'] === $type) {
                return $item['position'];
            }
            
            // Verificar por patrón de nuevo elemento
            if ($item['type'] === $type && strpos($item['id'], "new_{$type}_") === 0) {
                // Extraer el índice del ID generado
                $pattern = "/new_{$type}_(\d+)/";
                if (preg_match($pattern, $item['id'], $matches)) {
                    $itemIndex = (int)$matches[1];
                    if ($itemIndex === $index) {
                        return $item['position'];
                    }
                }
            }
        }
        
        // Si no se encuentra, usar la posición basada en el índice
        return $index + 1;
    }
}
