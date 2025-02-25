<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Resources\Pages\Create;
use Filament\Resources\Pages\Update;
use App\Models\Subject;
use App\Models\ClassModel;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Management Users';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->required()
                ->email()
                ->maxLength(255)
                ->unique(User::class, 'email'),
            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->required()
                ->minLength(5)
                ->maxLength(255)
                ->password(),
            Forms\Components\TextInput::make('phone_number')
                ->required()
                ->maxLength(15),
            Forms\Components\DatePicker::make('birth_date')
                ->required(),
            Forms\Components\Select::make('role')
                ->label('Role')
                ->required()
                ->options([
                    'murid' => 'Murid',
                    'guru' => 'Guru',
                ])
                ->placeholder('Pilih Role')
                ->reactive(),
            Forms\Components\Select::make('class_id')
                ->label('Kelas')
                ->options(ClassModel::pluck('class', 'id'))
                ->relationship('class', 'class')
                ->visible(fn (callable $get) => $get('role') === 'murid'),
            Forms\Components\Select::make('subjects')
                ->relationship('subjects', 'name')
                ->label('Mata Pelajaran')
                ->multiple()
                ->required()
                ->options(Subject::pluck('name', 'id'))
                ->visible(fn (callable $get) => $get('role') === 'guru')
                ->saveRelationships(),
            Forms\Components\Toggle::make('is_approved')
                ->label('Disetujui')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::with(['class', 'subjects'])->whereIn('role', ['murid', 'guru']))
            ->columns([
                    TextColumn::make('name')->label('Name')->searchable(),
                    TextColumn::make('email')->label('Email')->searchable(),
                    TextColumn::make('phone_number')->label('Phone Number')->searchable(),
                    TextColumn::make('birth_date')->label('Birth Date')->searchable(),
                    TextColumn::make('role')->label('Role')->searchable(),
                    TextColumn::make('class.class')
                    ->label('Class')
                    ->searchable(),
                    TextColumn::make('subjects')
                    ->label('Mata Pelajaran')
                    ->formatStateUsing(fn ($state, $record) => 
                        $record->subjects->pluck('name')->implode(', ') ?: '-'
                    )
                    ->searchable(),
                    BooleanColumn::make('is_approved')
                        ->label('Disetujui')
                        ->trueIcon('heroicon-o-check')
                        ->falseIcon('heroicon-o-x-mark')
                        ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('sendWhatsApp')
                    ->label('Send WhatsApp Message')
                    ->action(function (User $record) {
                        $response = self::sendWhatsAppMessage($record);

                        if ($response['success']) {
                            Notification::make()
                                ->title($response['message'])
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title($response['message'])
                                ->danger()
                                ->send();
                        }

                        return redirect()->route('filament.admin.resources.users.index');
                    }),
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->action(function (User $record) {
                        $record->is_approved = true;
                        $record->save();
                        Notification::make()
                            ->title('Pengguna berhasil disetujui.')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\BulkAction::make('approveSelected')
                    ->label('Setujui yang Dipilih')
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            $record->is_approved = true;
                            $record->save();
                        }
                        Notification::make()
                            ->title('Pengguna yang dipilih berhasil disetujui.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\BulkAction::make('sendWhatsAppToSelected')
                    ->label('Kirim Pesan WhatsApp ke yang Dipilih')
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            $response = self::sendWhatsAppMessage($record);
                            if (!$response['success']) {
                                Notification::make()
                                    ->title('Gagal mengirim pesan ke ' . $record->name . ': ' . $response['message'])
                                    ->danger()
                                    ->send();
                            }
                        }
                        Notification::make()
                            ->title('Pesan WhatsApp berhasil dikirim ke pengguna yang dipilih.')
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'murid' => 'Murid',
                        'guru' => 'Guru',
                    ])
                    ->label('Role'),
                SelectFilter::make('class')
                    ->options([
                        'PAUD' => 'PAUD',
                        'SD Kelas 1 & 2' => 'SD Kelas 1 & 2',
                        'SD Kelas 3 & 4' => 'SD Kelas 3 & 4',
                        'SD Kelas 5 & 6' => 'SD Kelas 5 & 6',
                        'SMP & SMA' => 'SMP & SMA',
                    ])
                    ->label('Class'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected static function sendWhatsAppMessage(User $user)
    {
        $curl = curl_init();

        // Token API dari Fonnte
        $apiKey = '26Nepuv9HXitEuWPi6va'; // Ganti dengan token API yang valid

        // Format nomor telepon ke internasional (62 untuk Indonesia)
        $toNumber = preg_replace('/^0/', '62', $user->phone_number);
        if (!preg_match('/^62\d+$/', $toNumber)) {
            throw new \Exception("Format nomor telepon salah: {$toNumber}");
        }

        // Pesan yang akan dikirim
        $message = "Halo {$user->name},\n\nPendaftaran Anda berhasil!\nEmail: {$user->email}\nSilakan gunakan password yang Anda buat untuk login.";

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
                "Authorization: ".$apiKey, // Tambahkan "Bearer"
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        // Eksekusi request dan ambil respons
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        // Logging respons API
        \Log::info("HTTP Code: {$httpCode}");
        \Log::info("API Response: " . $response);

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
}
