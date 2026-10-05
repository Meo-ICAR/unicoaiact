<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManualeUtente extends Page
{
    protected string $view = 'filament.pages.manuale-utente';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|UnitEnum|null $navigationGroup = 'Documentazione';

    protected static ?string $navigationLabel = 'Manuale Utente';

    protected static ?string $title = 'Manuale Utente';
}
