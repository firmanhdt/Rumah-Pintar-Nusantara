<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $classId;
    protected $subjectId;
    protected $date;

    public function __construct($classId, $subjectId, $date)
    {
        $this->classId = $classId;
        $this->subjectId = $subjectId;
        $this->date = $date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $attendances = Attendance::where('class_id', $this->classId)
            ->where('subject_id', $this->subjectId)
            ->where('date', $this->date)
            ->get();

        $data = [];
        foreach ($attendances as $attendance) {
            $student = User::find($attendance->student_id);
            $class = ClassModel::find($this->classId);
            $subject = Subject::find($this->subjectId);

            $data[] = [
                'name' => $student ? $student->name : 'N/A',
                'class' => $class ? $class->class : 'N/A',
                'subject' => $subject ? $subject->name : 'N/A',
                'status' => $attendance->status,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Nama Murid',
            'Kelas',
            'Mata Pelajaran',
            'Status',
        ];
    }
}
