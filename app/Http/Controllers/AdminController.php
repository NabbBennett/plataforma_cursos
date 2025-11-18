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
    public function dashboard() {
        if (auth()->user()->role !== 'admin') abort(403);

        return view('admin.dashboard', [
            'users' => User::count(),
            'courses' => Course::count(),
            'exams' => Exam::count(),
            'resources' => Resource::count(),
            'coupons' => Coupon::count(),
            'sales' => Purchase::count(),
        ]);
    }

    public function usersIndex(Request $request) {
        $role = $request->query('role');
        $search = $request->query('search');
        
        $query = User::query();

        // Filtro por rol
        if ($role) {
            $query->where('role', $role);
        }

        // Búsqueda por ID, nombre o correo
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Paginación con 10 usuarios por página
        $users = $query->paginate(10);

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function editUser(User $user, Request $request) {
        $roleFilter = $request->query('role');
        return view('admin.users.edit', compact('user', 'roleFilter'));
    }

    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('admin.users')->with('success', 'Usuario actualizado correctamente');
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users', ['role' => request('role')])->with('success', 'Usuario eliminado correctamente.');
    }

    public function createCourse(Request $request) {
        $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            'start_date' => 'nullable|date',
            'price_per_week' => 'required|numeric|min:0',
            "number_of_weeks" => "required|integer|min:1",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048"
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

    public function coursesIndex() {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function showCreateCourseForm() {
        return view('admin.courses.create');
    }

    public function edit($id) {
        $course = Course::with('weeks', 'evaluationBlocks')->findOrFail($id);
        $weeks = $course->weeks()->orderBy('number')->get();
        $evals = $course->evaluationBlocks()->get();
        $allExams = Exam::withCount('questions')->get();
        $resources = Resource::all();

        $combined = [];
        foreach ($weeks as $week) {
            $combined[] = ['type' => 'week', 'data' => $week];
            $block = $evals->firstWhere('after_week_id', $week->id);
            if ($block) {
                $combined[] = ['type' => 'evaluation', 'data' => $block];
            }
        }

        return view('admin.courses.edit', compact('course', 'combined', 'resources', 'allExams'));
    }

    public function updateCourse(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'nullable|date',
            'price_per_week' => 'required|numeric|min:0',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->only(['title', 'description', 'price_per_week', 'start_date']));

        $weeksData = $request->input('weeks', []);
        $evalsData = $request->input('evaluation_blocks', []);
        $realWeekCounter = 1;
        $lastWeekId = null;

        foreach ($weeksData as $index => $data) {
            $hasValidContent = !empty($data['title']) || !empty($data['live_meet_link']) || !empty($data['has_live']) || !empty($data['has_recorded']) || !empty($data['exam_id']) || !empty($data['resource_id']);
            if (!isset($data['id']) && !$hasValidContent) continue;

            $week = isset($data['id']) && $data['id'] != 0 ? Week::find($data['id']) : new Week();
            if (!$week) continue;

            $week->course_id = $course->id;
            $week->number = $realWeekCounter++;
            $week->title = $data['title'] ?? 'Semana ' . $week->number;
            $week->live_meet_link = !empty($data['live_meet_link']) ? $this->convertDriveToPreview($data['live_meet_link']) : null;
            $week->exam_id = $data['exam_id'] ?? null;
            $week->resource_id = $data['resource_id'] ?? null;
            $week->save();

            $lastWeekId = $week->id;

            WeekDay::where('week_id', $week->id)->delete();
            $firstDayId = null;

            if (!empty($data['has_recorded']) && isset($data['days'])) {
                foreach ($data['days'] as $dayNumber => $dayData) {
                    if (isset($dayData['enabled'])) {
                        $createdDay = WeekDay::create([
                            'course_id' => $course->id,
                            'week_id' => $week->id,
                            'day_number' => $dayNumber,
                            'title' => $dayData['title'] ?? null,
                            'recording_link' => $dayData['recording_link'] ?? null,
                        ]);

                        if (is_null($firstDayId)) {
                            $firstDayId = $createdDay->id;
                        }
                    }
                }
            }

            $week->recording_link = $firstDayId;
            $week->save();
        }

        foreach ($evalsData as $evalKey => $evalData) {
            $eval = isset($evalData['id']) && $evalData['id'] != 0
                ? EvaluationBlock::find($evalData['id'])
                : new EvaluationBlock();

            $eval->course_id = $course->id;
            $afterWeekId = $evalData['after_week_id'] ?? null;
            $eval->after_week_id = $afterWeekId > 0 ? $afterWeekId : null;
            $eval->live_meet_link = !empty($evalData['live_meet_link']) ? $this->convertDriveToPreview($evalData['live_meet_link']) : null;
            $eval->recording_link = !empty($evalData['recording_link']) ? $this->convertDriveToPreview($evalData['recording_link']) : null;
            $eval->exam_id = $evalData['exam_id'] ?? null;
            $eval->resource_id = $evalData['resource_id'] ?? null;

            $eval->save();
        }


        if ($request->has('deleted_weeks')) {
            foreach ($request->deleted_weeks as $weekId) {
                $week = Week::find($weekId);
                if ($week) {
                    $week->weekDays()->delete();
                    $week->delete();
                }
            }
        }

        if ($request->has('deleted_evaluation_blocks')) {
            EvaluationBlock::whereIn('id', $request->deleted_evaluation_blocks)->delete();
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
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with("success", "Curso eliminado.");
    }

    public function showExamForm($weekId) {
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

        return view(
            $isEvaluation ? 'admin.courses.partials.evaluation-block' : 'admin.courses.partials.week-block',
            [
                'week' => new Week(),
                'index' => $index,
                'course_id' => $course_id,
                'after_week_id' => $after_week_id,
                'allExams' => $allExams,
                'resources' => $resources
            ]
        );
    }
}
