<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Mata Pelajaran';

    protected static ?string $slug = 'subjects';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Mata Pelajaran')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('classes')
                    ->label('Kelas')
                    ->multiple()
                    ->relationship('classes', 'class')
                    ->required()
                    ->placeholder('Pilih Kelas'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Subject::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Mata Pelajaran')->searchable(),
                Tables\Columns\TextColumn::make('classes')
                    ->label('Kelas')
                    ->getStateUsing(fn ($record) => $record->classes->pluck('class')->implode(', '))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
