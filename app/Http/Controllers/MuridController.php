<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Material;
use App\Models\Schedule;
use App\Models\Submission;
use App\Models\Period;

class MuridController extends Controller
{

    //Dashboard murid
    public function index()
    {
        $user = Auth::user();
        $classes = ClassModel::all();
        $subjects = Subject::with('classes')->get(); 

        $totalHadir = Attendance::where('student_id', $user->id)->where('status', 'hadir')->count();
        $totalTidakHadir = Attendance::where('student_id', $user->id)->where('status', 'tidak_hadir')->count();
        $totalIzin = Attendance::where('student_id', $user->id)->where('status', 'izin')->count();

        // Ambil jadwal yang relevan untuk murid
        $schedules = Schedule::with('class', 'subject')
            ->where('class_id', $user->class_id) 
            ->where('date', '>=', now()) 
            ->get();

        // Ambil tugas yang relevan untuk murid
        $tasks = Task::with('subject', 'classModel')
            ->where('class_model_id', $user->class_id)
            ->where('due_date', '>=', now()) 
            ->get();

        return view('murid.dashboard', compact('user', 'classes', 'subjects', 'schedules', 'tasks', 'totalHadir', 'totalTidakHadir', 'totalIzin'));
    }

    //Menampilkan materi
    public function showMaterials(Request $request)
    {
        $user = Auth::user(); 
        $subjectId = $request->input('subject_id'); 
        $classId = $user->class_id; 
        $subjects = Subject::all();
    
        // Ambil waktu dinonaktifkan
        $deactivatedAt = $user->deactivated_at;
    
        $materials = Material::with('user', 'class')
            ->where('class_model_id', $classId) 
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('subject_id', $subjectId); 
            })
            ->when($deactivatedAt, function ($query) use ($deactivatedAt) {
                return $query->where('created_at', '<', $deactivatedAt); 
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Jika akun dinonaktifkan, tampilkan pesan
        if (!$user->is_active) {
            return view('murid.materi', compact('materials', 'user', 'subjects', 'subjectId'))
                ->with('warning', 'Akun Anda dinonaktifkan. Anda masih dapat melihat materi sebelumnya.');
        }
    
        return view('murid.materi', compact('materials', 'user', 'subjects', 'subjectId'));
    }

    //Preview materi
    public function previewMaterial($id)
    {
        $material = Material::findOrFail($id);
        $classes = ClassModel::all(); 
        $subjects = Subject::all(); 
        $user = Auth::user();

        return view('murid.preview-materi', compact('material', 'classes', 'subjects', 'user'));
    }

    //Tampil Tugas
    public function showTasks(Request $request)
    {
        $user = Auth::user();
    
        // Ambil tugas yang relevan untuk murid
        $subjectId = $request->input('subject_id');
        $classId = $user->class_id; 
        $subjects = Subject::all();
    
        // Ambil waktu dinonaktifkan
        $deactivatedAt = $user->deactivated_at;
    
        $tasks = Task::with('createdBy', 'subject')
            ->where('class_model_id', $classId) 
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('subject_id', $subjectId); 
            })
            ->when($deactivatedAt, function ($query) use ($deactivatedAt) {
                return $query->where('created_at', '<', $deactivatedAt); 
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Jika akun dinonaktifkan, tampilkan pesan
        if (!$user->is_active) {
            return view('murid.tugas', compact('tasks', 'user', 'subjects', 'subjectId'))
                ->with('warning', 'Akun Anda dinonaktifkan. Anda masih dapat melihat tugas sebelumnya.');
        }
    
        return view('murid.tugas', compact('tasks', 'user', 'subjects', 'subjectId'));
    }


    //Upload tugas
    public function uploadTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'file' => 'required|file|mimes:jpg,png,pdf|max:20048', // Validasi file
            'comment' => 'nullable|string',
        ]);

        $task = Task::findOrFail($request->task_id);

        // Cek apakah tugas sudah melewati tenggat waktu
        if (now()->isAfter(\Carbon\Carbon::parse($task->due_date)->endOfDay())) {
            return back()->with('error', 'Tugas sudah ditutup, tidak bisa upload!');
        }

        // Cek apakah kelas murid sesuai dengan kelas tugas
        $user = Auth::user();
        if ($user->class_id !== $task->class_model_id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengupload tugas ini.');
        }

        // Simpan file jawaban siswa
        $filePath = $request->file('file')->store('uploads', 'public');

        // Simpan jawaban siswa ke tabel submissions
        Submission::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(), // ID siswa yang sedang login
            'file_path' => $filePath,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil diupload.');
    }

    //Upload file tugas
    public function fileTugas(Request $request)
    {
        $user = Auth::user();
        $subjectId = $request->get('subject_id');
        
        // Ambil tugas berdasarkan mata pelajaran yang dipilih
        $tasks = Task::where('subject_id', $subjectId)->get();

        return view('murid.tugas', compact('user', 'tasks', 'subjectId'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        $subjects = Subject::all();
        $classModels = ClassModel::all();
        $periods = Period::all();

        return view('murid.profile', compact('user', 'subjects', 'classModels', 'periods'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kelas' => 'required|string',
            'subjects' => 'required|array',
            'periode' => 'required|integer',
        ]);

        // Update user profile
        $user->class_id = $request->kelas;
        $user->subjects()->sync($request->subjects); 
        $user->period_id = $request->periode;
        $user->save();

        return redirect()->route('murid.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
