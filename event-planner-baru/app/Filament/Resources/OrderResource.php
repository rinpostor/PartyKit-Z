<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Mail\BookingPaymentConfirmed;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Daftar Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // KELOMPOK 1: DATA PELANGGAN
                Section::make('Informasi Pelanggan')
                    ->schema([
                        TextInput::make('kode_booking')
                            ->label('Kode Booking')
                            ->readOnly(),
                        
                        TextInput::make('nama_pemesan')
                            ->label('Nama Pemesan')
                            ->readOnly(),

                        // PERBAIKAN: Gunakan prefixIcon
                        TextInput::make('email_pemesan')
                            ->label('Email')
                            ->email()
                            ->prefixIcon('heroicon-m-envelope') // GANTI icon JADI prefixIcon
                            ->readOnly(),

                        TextInput::make('telepon_pemesan')
                            ->label('WhatsApp / Telepon')
                            ->tel()
                            ->prefixIcon('heroicon-m-phone') // GANTI icon JADI prefixIcon
                            ->readOnly(),
                        
                        DatePicker::make('tanggal_event')
                            ->label('Tanggal Acara')
                            ->displayFormat('d M Y')
                            ->prefixIcon('heroicon-m-calendar') // GANTI icon JADI prefixIcon
                            ->readOnly(),
                    ])->columns(2),

                // KELOMPOK 2: RINCIAN PEMBAYARAN
                Section::make('Rincian Pembayaran')
                    ->schema([
                        TextInput::make('total_bayar')
                            ->label('Harga Paket')
                            ->prefix('Rp')
                            ->numeric()
                            ->readOnly(),
                        
                        TextInput::make('kode_unik')
                            ->label('Kode Unik')
                            ->prefix('Rp')
                            ->readOnly(),
                        
                        // TOTAL OTOMATIS
                        Placeholder::make('grand_total')
                            ->label('TOTAL YANG HARUS DITRANSFER')
                            ->content(function (Order $record) {
                                $total = $record->total_bayar + $record->kode_unik;
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            })
                            ->extraAttributes(['class' => 'font-bold text-xl text-primary-600']),

                        Select::make('status_pembayaran')
                            ->label('Update Status Pembayaran')
                            ->options([
                                'pending' => 'Pending (Belum Bayar)',
                                'success' => 'Success (Lunas)',
                                'failed' => 'Failed (Batal)',
                            ])
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_booking')->searchable()->copyable(),
                TextColumn::make('nama_pemesan')->searchable(),
                
                TextColumn::make('tanggal_event')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tgl Acara'),

                TextColumn::make('kode_unik')
                    ->badge()
                    ->color('info')
                    ->label('Kode Unik'),

                TextColumn::make('total_bayar')->money('IDR')->label('Harga Paket'),
                
                TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        'default' => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make(), 

                // TOMBOL KIRIM EMAIL
                Action::make('send_email')
                    ->label('Kirim Email Lunas')
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi & Kirim Email')
                    ->modalDescription('Pastikan uang sudah masuk. Status akan berubah jadi LUNAS.')
                    ->action(function (Order $record) {
                        $record->update(['status_pembayaran' => 'success']);
                        
                        try {
                            Mail::to($record->email_pemesan)->send(new BookingPaymentConfirmed($record));
                            Notification::make()->title('Email Terkirim')->success()->send();
                        } catch (\Exception $e) {
                            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                        }
                    }),
            ]);
    }
    
    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool { return false; }
}