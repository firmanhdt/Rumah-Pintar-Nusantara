<?php
namespace App\Filament\Resources\SubjectResource\Pages;


use App\Filament\Resources\SubjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use App\Models\Subject;

class CreateSubject extends CreateRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     // Validasi data
    //     $this->validate([
    //         'name' => 'required|string|max:255',
    //         'classes' => 'required|array', // Pastikan classes adalah array
    //         'classes.*' => 'exists:class_models,id', // Pastikan setiap ID kelas ada di tabel class_models
    //     ]);

    //     \Log::info('Data yang diterima untuk mata pelajaran:', $data); // Log data yang diterima

    //     // Buat mata pelajaran
    //     $subject = Subject::create([
    //         'name' => $data['name'],
    //     ]);

    //     // Hubungkan mata pelajaran dengan kelas yang dipilih
    //     if (isset($data['classes']) && !empty($data['classes'])) {
    //         $subject->classes()->attach($data['classes']);
    //         \Log::info('Kelas yang terhubung:', $data['classes']); // Log kelas yang terhubung
    //     } else {
    //         \Log::warning('Tidak ada kelas yang dipilih untuk mata pelajaran: ' . $data['name']);
    //     }

    //     return $data;
    // }
}
