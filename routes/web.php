<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MuridController;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Log;
use App\Exports\UsersExport;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckGuru;
use App\Http\Middleware\CheckMurid;
use Illuminate\Support\Facades\Password;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

Route::get('/guru/penilaian', function () {
    return view('guru.penilaian');
});

Route::get('/murid/tugas', function () {
    return view('murid.tugas');
});

Route::get('/admin/laporan', function () {
    return view('admin.laporan');
});

Route::get('/', [WelcomeController::class, 'index']);


//murid
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'create'])->name('register');


//admin
Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'showmanagementUser'])->name('admin.management-user');
    Route::post('/admin/users/approve/{id}', [AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/{user}/send-message', [AdminController::class, 'sendMessage'])->name('admin.users.sendMessage');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/laporan', [AdminController::class, 'ShowLaporan'])->name('admin.laporan');
    Route::get('/export-users', function () {
        return Excel::download(new UsersExport, 'users.xlsx');
    })->name('export.users');
    Route::get('/admin/laporan-akhir', [AdminController::class, 'ShowLaporanAkhir'])->name('admin.laporan-akhir');
    Route::get('/admin/laporan-akhir/export', [AdminController::class, 'export'])->name('admin.laporan-akhir.export');
    Route::post('/admin/store-period', [AdminController::class, 'storePeriod'])->name('periods.store');
    Route::post('/admin/users/toggle-status/{id}', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggleStatus');
    Route::post('/admin/users/toggle-edit', [AdminController::class, 'toggleUserEdit'])->name('admin.users.toggleEdit');});


//guru
Route::get('/guru-register', [AuthController::class, 'showGuruRegistrationForm'])->name('guru.register.form');
Route::post('/guru-register', [AuthController::class, 'createGuru'])->name('register.guru');
Route::middleware(['auth', CheckGuru::class])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/guru/materi', [GuruController::class, 'materi'])->name('guru.materi');
    Route::get('/guru/tugas', [GuruController::class, 'tugas'])->name('guru.tugas');
    Route::get('/guru/task/{id}', [GuruController::class, 'show'])->name('task.details');
    Route::post('/tasks', [GuruController::class, 'createTask'])->name('tasks.store');
    Route::get('/tasks/create', [GuruController::class, 'create'])->name('guru.create');
    Route::delete('/tasks/{id}', [GuruController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/{id}/edit', [GuruController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [GuruController::class, 'update'])->name('tasks.update');
    Route::get('/guru/materi', [GuruController::class, 'showMateri'])->name('materi.show');
    Route::get('/upload-material', [GuruController::class, 'showUploadForm'])->name('materials.upload');
    Route::post('/materials', [GuruController::class, 'storeMaterial'])->name('materials.store');
    Route::get('/guru/materi/{id}/edit', [GuruController::class, 'editMaterial'])->name('materi.edit');
    Route::put('/guru/materi/{id}', [GuruController::class, 'updateMaterial'])->name('materi.update');
    Route::delete('/guru/materi/{id}', [GuruController::class, 'deleteMaterial'])->name('materi.delete');
    Route::get('/guru/materi/{id}/preview', [GuruController::class, 'previewMaterial'])->name('preview.materi');
    Route::get('/guru/absensi',[GuruController::class,'ShowAbsensi'])->name('guru.absensi');
    Route::post('/guru/absensi/store', [GuruController::class, 'storeAttendance'])->name('guru.absensi.store');
    Route::get('/guru/absensi/export', function (Request $request) {
        \Log::info('Exporting attendance with:', [
            'class_id' => $request->input('class_id'),
            'subject_id' => $request->input('subject_id'),
            'date' => $request->input('date'),
        ]);
        
        return Excel::download(new AttendanceExport($request->input('class_id'), $request->input('subject_id'), $request->input('date')), 'attendance.xlsx');
    })->name('guru.absensi.export');
    Route::get('/guru/penilaian/{taskId}', [GuruController::class, 'showPenilaian'])->name('guru.penilaian');
    Route::post('/guru/penilaian/{taskId}/grade', [GuruController::class, 'gradeSubmission'])->name('guru.gradeSubmission');
    Route::get('/guru/schedule', [GuruController::class, 'showSchedule'])->name('show.schedule');
    Route::post('/api/schedule', [GuruController::class, 'createSchedule']);
    Route::get('/guru/schedule/{id}/edit', [GuruController::class, 'Showedit'])->name('schedules.edit');
    Route::post('/guru/schedule/{id}', [GuruController::class, 'Showupdate'])->name('schedules.update');
    Route::delete('/guru/schedule/{id}', [GuruController::class, 'Showdestroy'])->name('schedules.destroy');
    Route::get('/guru/data-nilai',[GuruController::class,'ShowDataNilai'])->name('guru.data-nilai');
    Route::get('/guru/nilai-akhir',[GuruController::class,'ShowNilaiAkhir'])->name('guru.nilai-akhir');
    Route::post('/guru/store-nilai', [GuruController::class, 'storeNilai'])->name('guru.store-nilai');
});

//murid
Route::middleware(['auth', CheckMurid::class])->group(function () {
    Route::get('/murid/dashboard', [MuridController::class, 'index'])->name('murid.dashboard');
    Route::get('/murid/profile', [MuridController::class, 'showProfile'])->name('murid.profile');
    Route::post('/murid/profile/update', [MuridController::class, 'updateProfile'])->name('murid.profile.update');
    Route::get('/murid/materi', [MuridController::class, 'showMaterials'])->name('murid.materi');
    Route::get('/murid/materi/{id}/preview', [MuridController::class, 'previewMaterial'])->name('materi.preview');
    Route::get('/murid/tugas', [MuridController::class, 'showTasks'])->name('murid.tugas');
    Route::post('/murid/tugas/upload', [MuridController::class, 'uploadTask'])->name('murid.tugas.upload');
});

// Route untuk login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Anda telah berhasil logout.');
})->name('logout');


//Reset password
// Route::get('/forgot-password', function () {
//     return view('auth.forgot-password');
// })->middleware('guest')->name('password.request');

// Route::post('/forgot-password', function (Request $request) {
//     $request->validate(['email' => 'required|email']);
 
//     $status = Password::sendResetLink(
//         $request->only('email')
//     );

//     \Log::info('Password reset link status: ', ['status' => $status]);

//     return $status === Password::RESET_LINK_SENT
//                 ? back()->with(['status' => __($status)])
//                 : back()->withErrors(['email' => __($status)]);
// })->middleware('guest')->name('password.email');

// Route::get('/reset-password/{token}', function (string $token) {
//     return ' Berhasil kirim email notifikasi reset password';
//     // return view('auth.reset-password', ['token' => $token]);
// })->middleware('guest')->name('password.reset');




Route::get('/api/subjects/{classId}', [ClassController::class, 'getSubjectsByClass']);

Route::get('/test-email', function () {
    $email = 'hello@example.com'; // Ganti dengan email yang valid

    try {
        \Mail::raw('This is a test email.', function ($message) use ($email) {
            $message->to($email)
                    ->subject('Test Email');
        });

        return 'Email sent!';
    } catch (\Exception $e) {
        \Log::error('Email sending failed: ' . $e->getMessage());
        return 'Failed to send email: ' . $e->getMessage();
    }
});

Route::get('/send-welcome-email', function () {
    $data = [
        'name' => 'User Name', // Ganti dengan nama pengguna yang sesuai
        'message' => 'Welcome to Rumah Pintar Nusantara!', // Pesan yang ingin dikirim
    ];

    \Log::info('Data yang dikirim ke email: ', $data); // Tambahkan log

    Mail::to('firmanhidayat7007@gmail.com')->send(new WelcomeMail($data));

    return 'Email sent!';
});


