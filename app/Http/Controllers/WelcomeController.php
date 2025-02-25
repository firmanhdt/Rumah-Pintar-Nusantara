<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //Landingpage
    public function index()
    {
        $teachers = User::with('subjects')->where('role', 'guru')->get();

        // Hitung jumlah murid yang disetujui dan aktif
        $approvedStudentsCount = User::where('role', 'murid')
            ->where('is_approved', 1)
            ->where('is_active', 1)
            ->count();

        // Tentukan kuota maksimum
        $maxQuota = 200;

        // Hitung sisa kuota
        $remainingQuota = $maxQuota - $approvedStudentsCount;

        // Jika kuota sudah penuh
        if ($remainingQuota <= 0) {
            $remainingQuotaMessage = 'Kuota sudah penuh';
        } else {
            $remainingQuotaMessage = 'Sisa Kuota pendaftaran: ' . $remainingQuota;
        }

        return view('welcome', compact('teachers', 'remainingQuotaMessage'));
    }
}
