<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Mail\BookingPaymentConfirmed;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Daftar Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pelanggan')
                    ->schema([
                        TextInput::make('kode_booking')
                            ->label('Kode Booking')
                            ->readOnly(),

                        TextInput::make('nama_pemesan')
                            ->label('Nama Pemesan')
                            ->readOnly(),

                        TextInput::make('email_pemesan')
                            ->label('Email')
                            ->email()
                            ->prefixIcon('heroicon-m-envelope')
                            ->readOnly(),

                        TextInput::make('telepon_pemesan')
                            ->label('WhatsApp / Telepon')
                            ->tel()
                            ->prefixIcon('heroicon-m-phone')
                            ->readOnly(),

                        DatePicker::make('tanggal_event')
                            ->label('Tanggal Acara')
                            ->displayFormat('d M Y')
                            ->prefixIcon('heroicon-m-calendar')
                            ->readOnly(),
                    ])->columns(2),

                Section::make('Informasi Transfer')
                    ->schema([
                        TextInput::make('nama_bank')
                            ->label('Bank')
                            ->readOnly(),
                        TextInput::make('nomor_rekening')
                            ->label('Nomor Rekening')
                            ->readOnly(),
                        TextInput::make('atas_nama_rekening')
                            ->label('Atas Nama')
                            ->readOnly(),
                        Placeholder::make('paid_at_info')
                            ->label('Waktu Konfirmasi')
                            ->content(fn (Order $record): string => $record->paid_at?->format('d M Y H:i') ?? 'Belum dikonfirmasi'),
                    ])->columns(2),

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

                        Placeholder::make('grand_total')
                            ->label('TOTAL YANG HARUS DITRANSFER')
                            ->content(fn (Order $record): string => 'Rp ' . number_format($record->grand_total, 0, ',', '.'))
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
                TextColumn::make('nama_bank')->label('Bank')->badge()->color('info'),
                TextColumn::make('grand_total')
                    ->label('Total Transfer')
                    ->formatStateUsing(fn (Order $record): string => 'Rp ' . number_format($record->grand_total, 0, ',', '.')),
                TextColumn::make('tanggal_event')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tgl Acara'),
                TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('paid_at')
                    ->label('Dikonfirmasi')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make(),
                Action::make('confirm_payment')
                    ->label('Konfirmasi Pembayaran')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->button()
                    ->visible(fn (Order $record): bool => $record->status_pembayaran !== 'success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi pembayaran customer')
                    ->modalDescription('Status pesanan akan diubah menjadi lunas dan email konfirmasi otomatis dikirim ke customer.')
                    ->action(function (Order $record): void {
                        $record->update([
                            'status_pembayaran' => 'success',
                            'paid_at' => now(),
                        ]);

                        Mail::to($record->email_pemesan)->send(new BookingPaymentConfirmed($record->fresh()));

                        Notification::make()
                            ->title('Pembayaran berhasil dikonfirmasi')
                            ->body('Status pesanan menjadi lunas dan email sudah dikirim ke customer.')
                            ->success()
                            ->send();
                    })
                    ->failureNotificationTitle('Gagal mengonfirmasi pembayaran'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
