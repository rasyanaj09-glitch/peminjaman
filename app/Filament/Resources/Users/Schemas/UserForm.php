<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Alamat email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                FileUpload::make('avatar')
                    ->label('Foto pengguna')
                    ->image()
                    ->avatar()
                    ->disk('public')
                    ->directory('users')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->nullable()
                    ->helperText('Format: JPG, PNG, atau WebP. Maksimal 2 MB.'),

                Select::make('gender')
                    ->label('Jenis kelamin')
                    ->options([
                        'laki-laki' => 'Laki-laki',
                        'perempuan' => 'Perempuan',
                    ])
                    ->required()
                    ->native(false),

                DatePicker::make('ttl')
                    ->label('Tanggal lahir')
                    ->required()
                    ->maxDate(now()),

                Select::make('role')
                    ->label('Peran akses')
                    ->options([
                        'admin' => 'Admin',
                        'petugas' => 'Petugas',
                        'peminjam' => 'Peminjam',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('password')
                    ->label('Kata sandi')
                    ->password()
                    ->revealable()
                    ->autocomplete('new-password')
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->minLength(8)
                    ->helperText('Kosongkan saat mengedit jika tidak ingin mengganti kata sandi.'),
            ]);
    }
}
