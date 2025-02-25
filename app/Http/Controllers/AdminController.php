<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WhatsAppMessageNotification;
use App\Models\Period;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $subjects = Subject::all();
        $classes = ClassModel::all();
        
        // Ambil pengguna yang belum disetujui dan aktif
        $users = User::where('is_approved', 0)
            ->where('is_active', 1) 
            ->get();

        // Filter untuk hanya menampilkan murid
        $students = $users->where('role', 'murid');

        if ($request->has('role')) {
            $students = $students->where('role', $request->input('role'));
        }

        // Mengambil data pengguna yang disetujui per bulan
        $approvedUsersCount = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('is_approved', 1)
            ->where('is_active', 1) 
            ->where('role', 'murid') 
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mengubah data menjadi array untuk digunakan di tampilan
        $months = [];
        $counts = [];
        foreach ($approvedUsersCount as $data) {
            $months[] = $data->month;
            $counts[] = $data->count; 
        }

        return view('admin.dashboard', compact('user', 'subjects', 'classes', 'students', 'months', 'counts'));
    }

    public function showmanagementUser(Request $request)
    {
        $user = Auth::user();

        // Ambil filter role, query pencarian, dan hasil per halaman dari request
        $roleFilter = $request->input('role');
        $searchQuery = $request->input('search');
        $resultsPerPage = $request->input('results_per_page', 6);

        // Query pengguna berdasarkan filter role dan query pencarian dengan pagination
        $users = User::with('period')
            ->when($roleFilter, function ($query) use ($roleFilter) {
                // Hanya terapkan filter role jika tidak kosong
                if (!empty($roleFilter)) {
                    return $query->where('role', $roleFilter);
                }
            })->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'like', '%' . $searchQuery . '%');
            })->paginate($resultsPerPage); 

        $allUsersAreEditable = $users->every(function ($user) {
            return $user->is_edit === 1;
        });

        $subjects = Subject::all();
        $classes = ClassModel::all();
        return view('admin.management-user', compact('user', 'users', 'subjects', 'classes', 'roleFilter', 'searchQuery','allUsersAreEditable'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = 1;
        $user->save();

        return redirect()->back()->with('success', 'Pengguna berhasil disetujui.');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Toggle status
        $user->is_active = !$user->is_active;

        // Jika akun dinonaktifkan, set waktu dinonaktifkan
        if (!$user->is_active) {
            $user->deactivated_at = now(); 
        } else {
            $user->deactivated_at = null; 
        }

        $user->save();

        return redirect()->back()->with('success', 'Status pengguna berhasil diperbarui.');
    }

    public function toggleUserEdit(Request $request)
    {
       
        $currentStatus = User::first()->is_edit;

       
        $newStatus = !$currentStatus;

        User::query()->update(['is_edit' => $newStatus]);

        return redirect()->back()->with('success', 'Status edit profile untuk semua pengguna berhasil diperbarui.');
    }

    protected static function sendWhatsAppMessage(User $user)
    {
        $curl = curl_init();

        // Token API dari Fonnte diambil dari .env
        $apiKey = '26Nepuv9HXitEuWPi6va';

        // Format nomor telepon ke internasional (62 untuk Indonesia)
        $toNumber = preg_replace('/^0/', '62', $user->phone_number);
        if (!preg_match('/^62\d+$/', $toNumber)) {
            throw new \Exception("Format nomor telepon salah: {$toNumber}");
        }

        // Pesan yang akan dikirim
        $message = "Pendaftaran pada Rumah Pintar Nusantara berhasil! Silahkan login dengan email: {$user->email} dan password yang Anda buat.";

        // Cek apakah pesan kosong
        if (empty(trim($message))) {
            throw new \Exception("Pesan WhatsApp tidak boleh kosong.");
        }

        // Konfigurasi cURL untuk mengirim permintaan ke API Fonnte
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'target' => $toNumber,
                'message' => $message,
            )),
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$apiKey,
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        // Eksekusi request dan ambil respons
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        // Jika ada error dalam cURL
        if ($error) {
            throw new \Exception("Gagal mengirim pesan: " . $error);
        }

        // Decode respons JSON
        $responseData = json_decode($response, true);

        // Jika JSON tidak valid
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error decoding JSON response: " . json_last_error_msg());
        }

        // Cek apakah API mengembalikan status berhasil
        if ($httpCode === 200 && isset($responseData['status']) && $responseData['status'] === true) {
            return [
                'success' => true,
                'message' => 'Pesan WhatsApp berhasil dikirim!',
            ];
        } else {
            $errorMessage = $responseData['reason'] ?? 'Pesan gagal dikirim, detail tidak tersedia.';
            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan: ' . $errorMessage,
            ];
        }
    }

    public function sendMessage(User $user)
    {
        try {
            $response = self::sendWhatsAppMessage($user);

            if ($response['success']) {
                $user->notify(new WhatsAppMessageNotification('Pesan WhatsApp berhasil dikirim!'));
                return redirect()->back()->with('success', $response['message']);
            } else {
                return redirect()->back()->with('error', $response['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function ShowLaporan(Request $request)
    {
        $roleFilter = $request->input('role');

        // Ambil pengguna dengan relasi yang diperlukan, aktif, dan sudah disetujui
        $users = User::with(['classModel', 'subjects', 'period'])
            ->where('role', '!=', 'admin')
            ->where('is_active', 1) 
            ->where('is_approved', 1)
            ->when($roleFilter, function ($query) use ($roleFilter) {
                // Hanya terapkan filter role jika tidak kosong
                if (!empty($roleFilter)) {
                    return $query->where('role', $roleFilter);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get statistics
        $statistics = [
            'total_teachers' => User::where('role', 'guru')->where('is_active', 1)->where('is_approved', 1)->count(),
            'sma_smk_teachers' => User::where('role', 'guru')
                ->where('is_active', 1)
                ->where('is_approved', 1)
                ->whereHas('classModel', function($query) {
                    $query->where('class', 'like', '%SMA%')
                          ->orWhere('class', 'like', '%SMK%');
                })->count(),
            'sd_teachers' => User::where('role', 'guru')
                ->where('is_active', 1)
                ->where('is_approved', 1)
                ->whereHas('classModel', function($query) {
                    $query->where('class', 'like', '%SD%');
                })->count(),
            'total_students' => User::where('role', 'murid')->where('is_active', 1)->where('is_approved', 1)->count(),
        ];

        // Mengambil pengguna dengan role admin
        $adminUser = User::where('role', 'admin')->first();

        return view('admin.laporan', [
            'users' => $users,
            'statistics' => $statistics,
            'user' => $adminUser,
            'roleFilter' => $roleFilter,
        ]);
    }

    public function search(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Apply search filters
        if ($request->has('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->orWhere('class', 'like', "%{$searchTerm}%");
        });
        }

        // Apply role filter
        if ($request->has('role')) {
        $query->where('role', $request->role);
        }

        $users = $query->get();

        return response()->json($users);
        }

        public function updateApproval(Request $request, $id)
        {
        $user = User::findOrFail($id);
        $user->is_approved = $request->is_approved;
        $user->save();

        return response()->json(['message' => 'User approval status updated successfully']);
        }
        public function exportPDF()
        {
        $users = User::where('role', '!=', 'admin')->get();

        return response()->download('path/to/generated/pdf');
        }

    public function ShowLaporanAkhir(Request $request)
    {
        $user = Auth::user();
        $periods = Period::all(); // Ambil semua periode
        $subjects = Subject::all(); // Ambil semua mata pelajaran
        $classes = ClassModel::all(); // Ambil semua kelas

        // Ambil data berdasarkan filter yang dipilih
        $students = User::where('role', 'murid')
            ->when($request->class_id, function($query) use ($request) {
                return $query->where('class_id', $request->class_id);
            })
            ->when($request->subject_id, function($query) use ($request) {
                return $query->whereIn('id', function($subQuery) use ($request) {
                    $subQuery->select('user_id')
                              ->from('subject_user')
                              ->where('subject_id', $request->subject_id);
                });
            })
            ->when($request->period_id, function($query) use ($request) {
                return $query->where('period_id', $request->period_id);
            })
            ->get();

        return view('admin.laporan-akhir', compact('user', 'periods', 'subjects', 'classes', 'students', 'request'));
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Simpan periode baru
        Period::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->back()->with('success', 'Periode berhasil ditambahkan.');
    }

    public function export(Request $request)
    {

        $students = User::where('role', 'murid')
            ->when($request->class_id, function($query) use ($request) {
                return $query->where('class_id', $request->class_id);
            })
            ->when($request->subject_id, function($query) use ($request) {
                return $query->whereIn('id', function($subQuery) use ($request) {
                    $subQuery->select('user_id')
                              ->from('subject_user')
                              ->where('subject_id', $request->subject_id);
                });
            })
            ->when($request->period_id, function($query) use ($request) {
                return $query->where('period_id', $request->period_id);
            })
            ->get();

        return Excel::download(new StudentsExport($students), 'students.xlsx');
    }


}
