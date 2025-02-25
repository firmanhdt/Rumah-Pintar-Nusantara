<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->students->map(function ($student) {
            $finalGrade = \App\Models\FinalGrade::where('student_id', $student->id)
                ->where('period_id', request('period_id'))
                ->first();

            return [
                'Nama Siswa' => $student->name,
                'Kelas' => $student->classModel->class ?? 'N/A',
                'Mata Pelajaran' => $student->subjects->pluck('name')->implode(', '),
                'Nilai Akhir' => $finalGrade ? $finalGrade->final_grade : 'N/A',
                'Periode' => $student->period ? \Carbon\Carbon::parse($student->period->start_date)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($student->period->end_date)->format('d/m/Y') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Mata Pelajaran',
            'Nilai Akhir',
            'Periode',
        ];
    }
}
