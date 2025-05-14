<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'طلبات الإجازات';
    protected static ?string $pluralModelLabel = 'طلبات';
    protected static ?string $modelLabel = 'طلب إجازة';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employee_id')
                    ->relationship('employee', 'employee_name')
                    ->label('الموظف')
                    ->required(),

                Select::make('leave_type_id')
                    ->relationship('leaveType', 'name')
                    ->label('نوع الإجازة')
                    ->required(),

                Textarea::make('reason')
                    ->label('سبب الإجازة')
                    ->required(),

                DatePicker::make('start_date')
                    ->label('تاريخ البدء')
                    ->required(),

                DatePicker::make('end_date')
                    ->label('تاريخ الانتهاء')
                    ->required(),

                Textarea::make('notes')
                    ->label('ملاحظات إضافية'),

                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'approved' => 'موافقة',
                        'rejected' => 'مرفوضة',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.employee_name')->label('الموظف')->searchable(),
                TextColumn::make('leaveType.name')->label('نوع الإجازة'),
                TextColumn::make('start_date')->label('من'),
                TextColumn::make('end_date')->label('إلى'),
               BadgeColumn::make('status')
                ->label('الحالة')
                ->formatStateUsing(fn (string $state) => match ($state) {
                    'pending' => 'قيد المراجعة',
                    'approved' => 'موافقة',
                    'rejected' => 'مرفوضة',
                    default => $state,
                })
                ->colors([
                    'primary' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ]),

                TextColumn::make('created_at')->label('تاريخ الطلب')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
