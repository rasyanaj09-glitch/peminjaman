<?php

namespace App\Filament\Resources\Peminjamen\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PeminjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Peminjam'),

                Select::make('tool_id')
                    ->relationship('tool', 'name')
                    ->required()
                    ->label('Alat'),

                DatePicker::make('borrow_date')
                    ->required()
                    ->label('Tgl Pinjam'),

                DatePicker::make('return_date')
                    ->required()
                    ->label('Tgl Kembali'),

                DatePicker::make('actual_return_date')
                    ->label('Tgl Dikembalikan (Aktual)'),

                Select::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'returned' => 'Returned',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // HITUNG DENDA OTOMATIS SAAT STATUS DIUBAH KE 'RETURNED'
                        if ($state === 'returned') {
                            $returnDate = $get('return_date') ? Carbon::parse($get('return_date')) : null;
                            $actualReturn = $get('actual_return_date') 
                                ? Carbon::parse($get('actual_return_date')) 
                                : Carbon::now();

                            // Atur tanggal dikembalikan ke hari ini jika belum diisi
                            $set('actual_return_date', $actualReturn->toDateString());

                            // Cek keterlambatan
                            if ($returnDate && $actualReturn->greaterThan($returnDate)) {
                                $lateDays = $actualReturn->diffInDays($returnDate);
                                $finePerDay = 5000; // Tarif Rp 5.000 / hari
                                $set('fine_amount', $lateDays * $finePerDay);
                            } else {
                                $set('fine_amount', 0);
                            }
                        }
                    }),

                TextInput::make('fine_amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0)
                    ->label('Jumlah Denda'),
            ]);
    }
}