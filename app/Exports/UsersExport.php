<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with(['classModel', 'subjects']) // Eager load class dan subjects
            ->where('role', '!=', 'admin')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Pengguna',
            'Nama',
            'Kelas',
            'Mata Pelajaran',
            'Email',
            'No. Telepon',
            'Tanggal Lahir',
        ];
    }

    public function map($user): array
    {
        return [
            ucfirst($user->role),
            $user->name,        
            $user->classModel->class ?? 'Tidak ada', 
            $user->subjects->pluck('name')->join(', ') ?? 'Matematika',
            $user->email,     
            $user->phone_number, 
            $user->birth_date, 
        ];
    }
}
