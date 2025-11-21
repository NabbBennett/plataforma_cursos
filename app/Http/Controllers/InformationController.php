<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\InstitutionInformation;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller{
    public function index(Request $request)
    {
        $institutions = \App\Models\InstitutionInformation::all();
        $currentId = $request->query('id', $institutions->first()->id ?? null);
        $info = $institutions->where('id', $currentId)->first();

        // Si no hay instituciones, redirigir o mostrar mensaje
        if (!$info) {
            return view('general.information.index', [
                'info' => null,
                'recommendedCourses' => collect(),
                'allInstitutions' => $institutions,
                'prevId' => null,
                'nextId' => null
            ]);
        }

        // Procesa recommended_courses como antes
        $raw = json_decode($info->recommended_courses ?? '[]');
        $ids = [];
        foreach ($raw as $item) {
            foreach (explode(',', $item) as $id) {
                $id = trim($id);
                if ($id !== '') $ids[] = $id;
            }
        }
        $recommendedCourses = \App\Models\Course::whereIn('id', $ids)->get();

        // Para navegación
        $currentIndex = $institutions->search(fn($inst) => $inst->id == $currentId);
        $prevId = $institutions[$currentIndex - 1]->id ?? null;
        $nextId = $institutions[$currentIndex + 1]->id ?? null;

        return view('general.information.index', compact(
            'info', 
            'recommendedCourses', 
            'prevId', 
            'nextId',
            'institutions' // Pasamos todas las instituciones para el dropdown
        ));
    }

    // Vista pública (mantener por compatibilidad)
    public function show(){
        $institutions = \App\Models\InstitutionInformation::all();
        $info = InstitutionInformation::first();
        
        if (!$info) {
            return view('general.information.index', [
                'info' => null,
                'recommendedCourses' => collect(),
                'allInstitutions' => $institutions,
                'prevId' => null,
                'nextId' => null
            ]);
        }

        $raw = json_decode($info->recommended_courses ?? '[]');
        $ids = [];
        foreach ($raw as $item) {
            foreach (explode(',', $item) as $id) {
                $id = trim($id);
                if ($id !== '') $ids[] = $id;
            }
        }
        $recommendedCourses = \App\Models\Course::whereIn('id', $ids)->get();
        
        return view('general.information.index', [
            'info' => $info,
            'recommendedCourses' => $recommendedCourses,
            'allInstitutions' => $institutions,
            'prevId' => null,
            'nextId' => null
        ]);
    }

    public function create(){
        $courses = \App\Models\Course::all(); // Para el checklist
        return view('admin.information.create', compact('courses'));
    }

    // Admin: Editar información
    public function edit($id){
        $info = InstitutionInformation::findOrFail($id);
        $courses = Course::all();
        return view('admin.information.edit', compact('info', 'courses'));
    }

    // Admin: Guardar nueva información
    public function store(Request $request){
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'careers' => 'required|string',
            'admission_dates' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'recommended_courses' => 'nullable|array',
            'recommended_courses.*' => 'exists:courses,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('institution_images', 'public');
        }

        $validated['recommended_courses'] = json_encode($validated['recommended_courses'] ?? []);
        $validated['name'] = $request->institution_name;

        \App\Models\InstitutionInformation::create($validated);

        return redirect()->route('admin.information.index')->with('success', 'Información institucional creada.');
    }

    // Admin: Actualizar información existente
    public function update(Request $request, $id){
        $info = InstitutionInformation::findOrFail($id);

        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'image_path' => 'nullable|image|max:2048',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'careers' => 'nullable|string',
            'admission_dates' => 'nullable|string',
            'recommended_courses' => 'nullable|array',
            'recommended_courses.*' => 'exists:courses,id',
        ]);

        $validated['name'] = $request->institution_name;
        $validated['recommended_courses'] = json_encode($request->recommended_courses ?? []);

        if ($request->has('block_order') && !empty($request->block_order)) {
            $blockOrder = json_decode($request->block_order, true);
            $this->updateBlockOrder($course, $blockOrder);
        }

        if ($request->hasFile('image_path')) {
            if ($info->image_path && Storage::disk('public')->exists($info->image_path)) {
                Storage::disk('public')->delete($info->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('institution', 'public');
        }

        $info->update($validated);

        return redirect()->route('admin.information.index')->with('success', 'Información actualizada correctamente.');
    }

    private function updateBlockOrder(Course $course, array $blockOrder){
        $position = 1;
        $lastWeekId = null;
        
        foreach ($blockOrder as $block) {
            if ($block['type'] === 'week') {
                // Actualizar semana normal
                $week = Week::find($block['id']);
                if ($week) {
                    $week->update([
                        'number' => $position,
                        'order' => $position
                    ]);
                    $lastWeekId = $week->id;
                }
                $position++;
            } elseif ($block['type'] === 'evaluation') {
                // Actualizar bloque de evaluación
                $evaluation = EvaluationBlock::find($block['id']);
                if ($evaluation && $lastWeekId) {
                    $evaluation->update([
                        'after_week_id' => $lastWeekId,
                        'order' => $position
                    ]);
                }
                $position++;
            }
        }
    }

    public function destroy($id){
        $info = InstitutionInformation::findOrFail($id);
        if ($info->image_path && \Storage::disk('public')->exists($info->image_path)) {
            \Storage::disk('public')->delete($info->image_path);
        }
        $info->delete();
        return redirect()->route('admin.information.index')->with('success', 'Información eliminada correctamente.');
    }
}