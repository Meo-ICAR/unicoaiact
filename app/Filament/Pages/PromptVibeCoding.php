<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PromptVibeCoding extends Page
{
    protected string $view = 'filament.pages.prompt-vibe-coding';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Documentazione';

    protected static ?string $navigationLabel = 'Prompt Vibe Coding';

    protected static ?string $title = 'Prompt Vibe Coding';
}
