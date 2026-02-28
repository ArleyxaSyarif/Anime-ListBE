<?php

namespace App\Filament\Resources\Heroes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;


class HeroesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->disk('public')->label('Hero Image'),
                IconColumn::make('is_active')->boolean()->label('Aktif'),
                TextColumn::make('created_at')->dateTime()->label('dibuat'),
            ]);
    }
}
