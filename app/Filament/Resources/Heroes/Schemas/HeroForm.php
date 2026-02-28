<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
class HeroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                ->label('Hero Image')
                ->image()
                ->directory('heroes')
                ->required(),
                Toggle::make('is_active')
                ->label('Aktifkan Hero')
                ->default(true),
            ]);
    }
}
