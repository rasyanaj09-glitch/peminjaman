<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('avatar')
                    ->label('Foto pengguna')
                    ->disk('public')
                    ->circular(),
                TextEntry::make('name')
                    ->label('Nama lengkap'),
                TextEntry::make('email')
                    ->label('Alamat email'),
                TextEntry::make('gender')
                    ->label('Jenis kelamin')
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'laki-laki' => 'Laki-laki',
                        'perempuan' => 'Perempuan',
                        default => '-',
                    }),
                TextEntry::make('ttl')
                    ->label('Tanggal lahir')
                    ->date('d M Y')
                    ->placeholder('-'),
                TextEntry::make('role')
                    ->label('Peran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'success',
                        'petugas' => 'warning',
                        default => 'gray',
                    }),
                TextEntry::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
