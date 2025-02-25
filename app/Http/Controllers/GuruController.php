<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSubject;
use App\Models\Task;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Submission;
use App\Models\FinalGrade;
use App\Models\Period;

class GuruController extends Controller
{

    //Dashboard guru
    public function index()
    {
        $user = Auth::user();
        $tasks = Task::all();
        $materials = Material::all();
        return view('guru.dashboard', compact('user', 'tasks', 'materials'));
    }

    public function materi()
    {
        $user = Auth::user();
        return view('guru.materi', compact('user'));
    }

    //lihat tugas
    public function tugas()
    {
        $user = Auth::user()->load(['subjects', 'classModel']);
        $tasks = Task::with(['subject', 'classModel'])->where('created_by', $user->id)->get();
        return view('guru.tugas', compact('user', 'tasks'));
    }

    //detail tugas
    public function show($id)
    {
        $user = Auth::user();
        $task = Task::with(['subject', 'classModel', 'createdBy'])->find($id);
        
        $tasks = Task::with(['subject', 'classModel'])->where('created_by', $user->id)->get();
        $classes = ClassModel::all();
        $periods = Period::all(); 

        $subjectId = $task ? $task->subject_id : null;

        if (!$task) {
            return view('guru.detail-tugas', [
                'task' => null,
                'tasks' => $tasks,
                'classes' => $classes,
                'user' => $user,
                'message' => 'Tugas tidak ditemukan.',
                'subjectId' => $subjectId,
                'periods' => $periods,
            ]);
        }

        return view('guru.detail-tugas', compact('task', 'tasks', 'classes', 'user', 'subjectId', 'periods'));
    }

    //tambah tugas
    public function createTask(Request $request)
    {

        // Validasi
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_model_id' => 'required|exists:class_models,id',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:20048',
            'title' => 'required|string',
            'period_id' => 'required|exists:periods,id',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('task', 'public');
        }

        // Simpan tugas
        $task = Task::create([
            'subject_id' => $request->subject_id,
            'class_model_id' => $request->class_model_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'created_by' => Auth::id(),
            'file_path' => $filePath,
            'title' => $request->title,
            'period_id' => $request->period_id,
        ]);

        return redirect()->route('task.details', ['id' => $task->id])->with('success', 'Tugas berhasil ditambahkan!');
    }

    //hapus tugas
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus!');
    }

    //edit tugas
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'class_model_id' => 'required|exists:class_models,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:20048',
            'period_id' => 'required|exists:periods,id',
        ]);

        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->class_model_id = $request->class_model_id;
        $task->period_id = $request->period_id;

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('task', 'public');
            $task->file_path = $filePath;
        }

        $task->save();

        return redirect()->route('task.details', ['id' => $task->id])->with('success', 'Tugas berhasil diperbarui!');
    }
    
    //tambah materi
    public function storeMaterial(Request $request)
    {

        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:20048',
            'subject_id' => 'required|exists:subjects,id', 
            'class_model_id' => 'required|exists:class_models,id',
        ]);

        $material = new Material();
        $material->name = $request->nama_pelajaran;
        $material->description = $request->deskripsi;
        $material->user_id = auth()->id();
        $material->subject_id = $request->subject_id; 
        $material->class_model_id = $request->class_model_id; 

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $material->thumbnail_path = $thumbnailPath;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
            $material->file_path = $filePath;
        }

        $material->save();

        return redirect()->back()->with('success', 'Materi berhasil diunggah!');
    }

    // Lihat form unggah materi
    public function showUploadForm()
    {
        $user = Auth::user();
        $classes = ClassModel::all(); 
        $subjects = Subject::all();

        return view('guru.materi', compact('classes', 'subjects','user'));
    }

    //Lihat materi
    public function showMateri(Request $request)
    {
        $user = Auth::user();
        $classes = ClassModel::all(); 
        $subjects = Subject::all(); 
        // Ambil materi berdasarkan kelas yang dipilih
        $materials = Material::when($request->class_model_id, function ($query) use ($request) {
            return $query->where('class_model_id', $request->class_model_id);
        })->get();

        return view('guru.materi', compact('classes', 'materials', 'user', 'subjects'));
    }

    //Edit materi
    public function editMaterial($id)
    {
        $material = Material::findOrFail($id);
        $classes = ClassModel::all(); 
        $subjects = Subject::all(); 
        return view('guru.materi', compact('material', 'classes', 'subjects'));
    }
    
    //Update materi
    public function updateMaterial(Request $request, $id)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:20048',
            'subject_id' => 'required|exists:subjects,id', 
            'class_model_id' => 'required|exists:class_models,id',
        ]);

        $material = Material::findOrFail($id);
        $material->name = $request->nama_pelajaran;
        $material->description = $request->deskripsi;
        $material->subject_id = $request->subject_id; 
        $material->class_model_id = $request->class_model_id; 

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $material->thumbnail_path = $thumbnailPath;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
            $material->file_path = $filePath;
        }

        $material->save();
        return redirect()->route('materi.show')->with('success', 'Materi berhasil diperbarui!');
    }

    //Delete materi
    public function deleteMaterial($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return redirect()->route('materi.show')->with('success', 'Materi berhasil dihapus!');
    }

    //Preview materi
    public function previewMaterial($id)
    {
        $material = Material::findOrFail($id);
        $classes = ClassModel::all(); 
        $subjects = Subject::all(); 
        $user = Auth::user();

        return view('guru.preview-materi', compact('material', 'classes', 'subjects', 'user'));
    }

    //Lihat absensi
    public function ShowAbsensi(Request $request)
    {
        $user = Auth::user();
        
        // Ambil subject_id dari request
        $userSubject = $request->input('subject_id'); 

        // Ambil semua kelas untuk pilihan filter
        $classes = ClassModel::all();
        
        $students = collect();
        $attendances = collect();
    
        if ($request->has(['class', 'date']) && $request->class) {
            // Ambil siswa yang berada di kelas yang dipilih dan aktif
            $students = User::where('class_id', $request->class)
                ->where('is_active', 1) 
                ->get();
    
            // Ambil data absensi berdasarkan siswa yang sesuai dan tanggal yang dipilih
            $attendances = Attendance::whereIn('student_id', $students->pluck('id'))
                ->where('date', $request->date)
                ->get();
        }
    
        return view('guru.absensi', compact('students', 'attendances', 'classes', 'user', 'userSubject'));
    }

    //Menyimpan Absensi
    public function storeAttendance(Request $request)
    {

    // Validasi data
    $request->validate([
        'class_id' => 'required|exists:class_models,id',
        'subject_id' => 'required|exists:subjects,id',
        'attendance' => 'required|array',
    ]);

    foreach ($request->attendance as $studentId => $status) {
        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'date' => now()->toDateString(),
            ],
            [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'status' => $status,
            ]
        );
    }

        return redirect()->route('guru.absensi')->with('success', 'Absensi berhasil disimpan!');
    }

    public function showPenilaian($taskId)
    {
        $user = Auth::user();
        // Ambil tugas beserta semua submission yang terkait
        $task = Task::with(['submittedBy', 'submissions'])->findOrFail($taskId); 

        // Ambil semua murid yang sudah disetujui dan aktif serta terdaftar di kelas dan mata pelajaran yang sama
        $students = User::where('role', 'murid')
            ->where('is_approved', 1) 
            ->where('is_active', 1)
            ->where('class_id', $task->class_model_id)
            ->whereIn('id', function($query) use ($task) {
                $query->select('user_id')
                      ->from('subject_user')
                      ->where('subject_id', $task->subject_id); 
            })
            ->get();

        return view('guru.penilaian', compact('task', 'user', 'students'));
    }

    public function gradeSubmission(Request $request, $taskId)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id',
            'grade' => 'required|numeric|min:0|max:100', 
            'comment' => 'nullable|string',
        ]);

        // Temukan pengumpulan berdasarkan ID
        $submission = Submission::findOrFail($request->submission_id);
        
        // Update nilai dan komentar
        $submission->grade = $request->grade; 
        $submission->comment = $request->comment;
        $submission->save();

        return redirect()->back()->with('success', 'Nilai berhasil diberikan.');
    }

    // Menampilkan jadwal berdasarkan tanggal
    public function showSchedule(Request $request)
    {
    
        // Ambil semua jadwal untuk pengguna jika tidak ada tanggal yang diberikan
        $schedule = Schedule::with('class', 'subject')
            ->where('teacher_id', $user->id);
    
        // Jika ada parameter date, filter berdasarkan tanggal
        if ($request->has('date')) {
            $request->validate([
                'date' => 'required|date',
            ]);
            $schedule->where('date', $request->date);
        }
    
        $schedule = $schedule->get();
    
        // Ambil data kelas dan mata pelajaran
        $classes = ClassModel::all();
        $subjects = Subject::all();
    
        return view('guru.schedule', compact('schedule', 'user', 'classes', 'subjects'));
    }

    // Menambahkan jadwal baru
    public function createSchedule(Request $request)
    {

        $request->validate([
            'class' => 'required|exists:class_models,id',
            'subject' => 'required|exists:subjects,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        // Simpan jadwal baru
        Schedule::create([
            'class_id' => $request->class,
            'subject_id' => $request->subject,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->date,
            'description' => $request->description,
            'teacher_id' => Auth::id(), 
        ]);

        return redirect()->back()->with('success', 'Schedule added successfully!');
    }

    public function ShowDataNilai(Request $request)
    {
        $user = Auth::user();
        
        // Ambil data kelas dari relasi
        $classes = ClassModel::all();

        // Ambil data mata pelajaran yang dimiliki oleh guru
        $subjects = $user->subjects; 

        $periods = Period::all();

        // Ambil data tugas berdasarkan mata pelajaran, kelas, dan periode yang dipilih
        $tasks = collect(); 
        if ($request->has('subject_id') && $request->has('class_model_id') && $request->has('period_id')) {
            $tasks = Task::where('subject_id', $request->subject_id)
                        ->where('class_model_id', $request->class_model_id)
                        ->where('period_id', $request->period_id);
        }

        // Ambil data nilai berdasarkan tugas yang dipilih jika ada
        $submissions = collect(); 
        if ($request->has('task_id')) {
            $submissions = Submission::where('task_id', $request->task_id)->get();
        } elseif ($request->has('subject_id') && $request->has('class_model_id')) {
            $submissions = Submission::whereHas('task', function($query) use ($request) {
                $query->where('subject_id', $request->subject_id)
                    ->where('class_model_id', $request->class_model_id)
                    ->where('period_id', $request->period_id); 
            })->get();
        }

        return view('guru.data-nilai', compact('user', 'submissions', 'classes', 'subjects', 'tasks', 'periods'));
    }

    public function ShowNilaiAkhir(Request $request)
    {
        $user = Auth::user();
        
        // Ambil data kelas dari relasi
        $classes = ClassModel::all();

        // Ambil semua periode
        $periods = Period::all();

        // Ambil data siswa berdasarkan kelas dan periode yang dipilih
        $students = User::with('period')
            ->where('class_id', $request->class_model_id)
            ->where('role', 'murid') 
            ->where('is_active', 1) 
            ->when($request->period_id, function($query) use ($request) {
                return $query->where('period_id', $request->period_id); 
            })
            ->get();

        // Ambil mata pelajaran yang diambil oleh siswa
        $subjects = Subject::whereIn('id', function($query) use ($students) {
            $query->select('subject_id')
                  ->from('subject_user')
                  ->whereIn('user_id', $students->pluck('id'));
        })->get();

        // Ambil data nilai akhir berdasarkan siswa yang diambil
        $finalGrades = FinalGrade::whereIn('student_id', $students->pluck('id'))
            ->where('subject_id', $request->subject_id)
            ->where('class_model_id', $request->class_model_id)
            ->where('period_id', $request->period_id) 
            ->get()->keyBy('student_id');

        return view('guru.nilai-akhir', compact('user', 'students', 'classes', 'subjects', 'finalGrades', 'periods', 'request'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'grades.*' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->grades as $studentId => $finalGrade) {
            FinalGrade::updateOrCreate(
                ['student_id' => $studentId, 'subject_id' => $request->subject_id, 'class_model_id' => $request->class_model_id,'period_id' => $request->period_id],
                ['final_grade' => $finalGrade]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
}