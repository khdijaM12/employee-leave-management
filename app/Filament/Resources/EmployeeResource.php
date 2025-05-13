<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'الموظفين';

    protected static ?string $pluralModelLabel = 'كل الموظفين';

    protected static ?string $modelLabel = 'موظف';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              TextInput::make('employee_name')
                    ->required()
                    ->label('اسم الموظف'),
                    
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('البريد الإلكتروني'),

                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->required()
                    ->reactive()
                    ->live(onBlur: false) 
                    ->rules([
                        Password::min(8)
                            ->mixedCase()
                            ->letters()
                            ->numbers()
                            ->symbols()
                    ])
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->validationAttribute('كلمة المرور'),
                    

                TextInput::make('mobile_number')
                    ->required()
                    ->tel()
                    ->label('رقم الهاتف'),

                TextInput::make('address')
                    ->required()
                    ->label('العنوان'),

                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('employee_name', 'asc')
            ->columns([
                TextColumn::make('employee_name')->label('اسم الموظف')->searchable(),
                TextColumn::make('email')->label('البريد الالكتروني')->searchable(),
                TextColumn::make('employee_number')->label('رقم الموظف'),
                TextColumn::make('mobile_number')->label('رقم الهاتف'),
                TextColumn::make('address')->label('العننوان'),
                TextColumn::make('notes')->label('ملاحظات')->limit(30),
                TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;    
    }
    }
