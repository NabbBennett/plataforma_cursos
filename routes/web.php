<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ExamStudentController;
use App\Http\Controllers\ContactController;

use App\Models\Course;
use App\Models\WeekDay;
use App\Models\Week;

// Página principal
Route::get('/', function () {
    return view('main');
})->name('welcome');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Autenticación
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Recuperar contraseña
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Vistas del administrador
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/upload-video', [AdminController::class, 'uploadVideo'])->name('admin.upload.video');
});

// Lista de usuarios
Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users');

// Formulario para editar un usuario
Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');

// Guardar cambios del formulario de edición
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');

//borrar en lista de usuarios
Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

//ruta de creación de cursos
Route::get('/admin/courses/create', [AdminController::class, 'showCreateCourseForm'])->name('admin.courses.create');

// Administración de cursos 
Route::get('/admin/courses', [AdminController::class, 'coursesIndex'])->name('admin.courses.index');
Route::post('/admin/courses/store', [AdminController::class, 'createCourse'])->name('admin.courses.store');

Route::get('/admin/courses/{id}/edit', [AdminController::class, 'edit'])->name('admin.courses.edit');
Route::put('/admin/courses/{id}/update', [AdminController::class, 'updateCourse'])->name('admin.courses.update');

Route::post('/admin/courses/{id}/delete', [AdminController::class, 'deleteCourse'])->name('admin.courses.delete');

// Exámenes - Admin
Route::prefix('admin/exams')->name('admin.exams.')->middleware('auth')->group(function () {
    Route::get('/', [ExamController::class, 'index'])->name('index');
    Route::get('/create', [ExamController::class, 'create'])->name('create');
    Route::post('/', [ExamController::class, 'store'])->name('store');
    Route::get('/{exam}/edit', [ExamController::class, 'edit'])->name('edit');
    Route::put('/{exam}', [ExamController::class, 'update'])->name('update');
    Route::get('/{exam}/preview', [ExamController::class, 'preview'])->name('preview');
    Route::delete('/{exam}', [ExamController::class, 'destroy'])->name('destroy'); // ✅ ESTA
});

// CKEditor
Route::post('ckeditor/upload', [App\Http\Controllers\CKEditorController::class, 'upload'])->name('ckeditor.upload');

//Recursos - Admin
Route::prefix('admin/resources')->name('admin.resources.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\ResourceController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\ResourceController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\ResourceController::class, 'store'])->name('store');
    Route::get('/download/{resource}', [\App\Http\Controllers\ResourceController::class, 'download'])->name('download');
    Route::delete('/{resource}', [\App\Http\Controllers\ResourceController::class, 'destroy'])->name('destroy');
});

//ventas - admin
Route::prefix('admin/purchases')->name('admin.purchases.')->middleware('auth')->group(function () {
    Route::get('/sales', [PurchasesController::class, 'ventasGlobales'])->name('sales');
    Route::post('/manual', [PurchasesController::class, 'guardarAccesoManual'])->name('manual.store');
    Route::post('/update-field', [PurchasesController::class, 'actualizarCampos'])->name('updateField'); // <- AJAX
});

// Ruta API para cargar semanas
Route::get('/api/courses/{id}/weeks', function ($id) {
    return \App\Models\Week::where('course_id', $id)
        ->orderBy('number')
        ->get(['id', 'number', 'title']);
})->middleware('auth');

Route::get('/api/purchase/weeks/{user_id}/{course_id}', function ($user_id, $course_id) {
    // Puedes adaptarlo si luego usas tabla purchase_weeks
    $purchase = \App\Models\Purchase::where('user_id', $user_id)
        ->where('course_id', $course_id)
        ->first();

    if (!$purchase) return [];

    // Simulación: desbloquea primeras N semanas
    return \App\Models\Week::where('course_id', $course_id)
        ->orderBy('number')
        ->take($purchase->weeks_unlocked)
        ->pluck('id');
    })->middleware('auth');

// Verificación de correo electrónico
    Route::get('/verificar-correo', [VerificationController::class, 'showForm'])->name('verification.form');
    Route::post('/verificar-codigo', [VerificationController::class, 'checkCode'])->name('verification.check');
    Route::post('/reenviar-codigo', [VerificationController::class, 'resendCode'])->name('verification.resend');

    Route::middleware(['auth', 'verified'])->get('/profile', [ProfileController::class, 'perfil'])->name('profile.profile');
    Route::get('admin/courses/week-block', [AdminController::class, 'getWeekBlock'])->name('admin.courses.week-block');


// USUARIO //
// Contact routes
Route::get('/contacto', [ContactController::class, 'contact'])->name('contact');
Route::post('/contacto', [ContactController::class, 'contactSubmit'])->name('contact.submit');

//Vista de tienda
Route::get('/store', [StoreController::class, 'store'])->name('store');
Route::get('/store/course/{id}', [StoreController::class, 'show'])->name('store.course');
Route::post('/store/course/{id}/review', [StoreController::class, 'storeReview'])->name('course.review.store')->middleware('auth');
Route::post('/cart/coupon', [StoreController::class, 'applyCoupon'])->name('cart.coupon');

//carrito de compras
Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/view', [CartController::class, 'view'])->name('view');
    Route::post('/add/{course}', [CartController::class, 'add'])->name('add');
    Route::post('/remove/{course}', [CartController::class, 'remove'])->name('remove');
    Route::post('/update/{course}', [CartController::class, 'update'])->name('update'); 
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

//ticket de compra
Route::get('/ticket', [CartController::class, 'ticket'])->name('cart.ticket');

//INFORMACIÓN INSTITUCIONAL
// Vista pública
Route::get('/information', [InformationController::class, 'index'])->name('information.index');
Route::get('/information/show', [InformationController::class, 'show'])->name('information.show');

Route::get('/information', [InformationController::class, 'index'])->name('information.index');
// Panel admin (todas protegidas con auth + gate)
Route::prefix('admin/information')->middleware(['auth', 'can:isAdmin'])->name('admin.information.')->group(function () {
    Route::get('/', [InformationController::class, 'index'])->name('index');
    Route::get('/create', [InformationController::class, 'create'])->name('create');
    Route::post('/store', [InformationController::class, 'store'])->name('store'); 
    Route::get('/edit/{id}', [InformationController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [InformationController::class, 'update'])->name('update');
    Route::delete('/{id}', [InformationController::class, 'destroy'])->name('destroy');
});

//VISTASO DE PERFIL USUARIO
Route::middleware(['auth'])->group(function () {
    Route::get('/mi-perfil', [ProfileController::class, 'perfil'])->name('student.profile');
    Route::get('/configuracion', [ProfileController::class, 'configuration'])->name('student.configuration');
    
    // Rutas para actualizaciones AJAX
    Route::post('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('student.update.avatar');
    Route::post('/update-banner', [ProfileController::class, 'updateBanner'])->name('student.update.banner');
    Route::post('/update-name', [ProfileController::class, 'updateName'])->name('student.update.name');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('student.update.password');
});

//Ver clases grabadas
Route::get('/student/courses/recorded/{day}', [ProfileController::class, 'showRecorded'])->name('student.recorded');

Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

//EXAMEN DE USUARIOS
Route::get('/student/exams/{course}/{exam}/start', [ExamStudentController::class, 'start'])->name('student.exams.start');
Route::post('/student/exams/{course}/{exam}/begin', [ExamStudentController::class, 'begin'])->name('student.exams.begin');
Route::get('/student/exams/{course}/{exam}/question/{questionNumber}', [ExamStudentController::class, 'question'])->name('student.exams.question');
Route::post('/student/exams/{course}/{exam}/save-answer', [ExamStudentController::class, 'saveAnswer'])->name('student.exams.saveAnswer');
Route::post('/student/exams/{course}/{exam}/submit', [ExamStudentController::class, 'submit'])->name('student.exams.submit');
Route::get('/student/exams/{course}/{exam}/result', [ExamStudentController::class, 'result'])->name('student.exams.result');

// Vista del recurso
Route::get('/student/resources/{type}/{id}', [ProfileController::class, 'viewResource'])->name('student.resources.view');

// Entrega segura del archivo
Route::get('/student/resources/file/{resource}', [ProfileController::class, 'serveFile'])->name('student.resources.serveFile');
Route::get('/student/courses/{course}/progress', [ExamStudentController::class, 'getExamProgress'])->name('student.courses.progress');
