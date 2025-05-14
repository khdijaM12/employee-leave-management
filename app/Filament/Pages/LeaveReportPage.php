<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Http\Controllers\LeaveRequestController;
use Filament\Actions\Action;

class LeaveReportPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.leave-report-page';

    protected static ?string $navigationLabel = 'تقارير الإجازات';

    protected function getHeaderActions(): array
{
    return [
        Action::make('generateReport')
            ->label('تنزيل تقرير الإجازات')
            ->url(route('generate-leave-report'))
            ->openUrlInNewTab(),
    ];
}


    public function generateReport()
    {
        return app(LeaveRequestController::class)->generateLeaveReport();
    }
}
