<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Period;

class AuthController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'phone_number' => 'required|string',
            'birth_date' => 'required|date',
            'subjects' => 'required|array',
            'class' => 'required|exists:class_models,id',
            'period_id' => 'required|exists:periods,id',
        ]);

        $approvedMuridCount = User::where('role', 'murid')->where('is_approved', 1)->count();
        
        // Batasi pendaftaran jika sudah mencapai 200 murid yang disetujui
        if ($approvedMuridCount >= 200) {
            return redirect()->back()->withErrors(['message' => 'Pendaftaran murid sudah mencapai batas maksimum.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'class_id' => $request->class,
            'role' => 'murid',
            'period_id' => $request->period_id,
        ]);

        $user->subjects()->attach($request->subjects);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Anda harus menunggu persetujuan admin.');
    }

    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function index()
    {
        $user = Auth::user();
        $subjects = $user->subjects; 

        return view('dashboard', compact('user', 'subjects'));
    }

    public function showRegistrationForm()
    {
        $classes = ClassModel::all(); 
        $subjects = Subject::all();
        $periods = Period::all();
        return view('auth.register', compact('classes', 'subjects', 'periods'));
    }

    public function createGuru(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'phone_number' => 'required|string',
            'birth_date' => 'required|date',
            'subjects' => 'required|array',
        ]);

        $guruCount = User::where('role', 'guru')->count();
        if ($guruCount >= 3) {
            return redirect()->back()->withErrors(['message' => 'Pendaftaran guru sudah mencapai batas maksimum.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'role' => 'guru',
            'is_approved' => true,
        ]);

        $user->subjects()->attach($request->subjects);

        return redirect()->back()->with('success', 'Pendaftaran guru berhasil! Silakan isi data lainnya jika diperlukan.');   
    }

    public function showGuruRegistrationForm()
    {
        $subjects = Subject::all();
        return view('auth.guru-register', compact( 'subjects'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if (!$user->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin.',
                ]);
            }

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Login berhasil!');
            }

            if ($user->role === 'guru') {
                return redirect()->intended('/guru/dashboard')->with('success', 'Login berhasil!');
            }

            return redirect()->intended('/murid/dashboard')->with('success', 'Login berhasil!');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ]);
    }
}
