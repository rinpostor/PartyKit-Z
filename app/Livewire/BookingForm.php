<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Package;
use Livewire\Component;

class BookingForm extends Component
{
    public int $packageId = 0;
    public ?array $package = null;
    public bool $packageLoaded = false;
    public bool $packageError = false;

    // Form Fields
    public string $nama_pemesan = '';
    public string $email_pemesan = '';
    public string $telepon_pemesan = '';
    public string $tanggal_event = '';

    // State
    public bool $showPaymentModal = false;
    public ?array $orderData = null;
    public string $flashMessage = '';
    public string $flashType = '';

    protected $rules = [
        'nama_pemesan'    => 'required|string|min:3|max:100',
        'email_pemesan'   => 'required|email|max:100',
        'telepon_pemesan' => 'required|numeric|digits_between:9,15',
        'tanggal_event'   => 'required|date|after:today',
    ];

    protected $messages = [
        'nama_pemesan.required'          => 'Nama lengkap wajib diisi.',
        'nama_pemesan.min'               => 'Nama minimal 3 karakter.',
        'email_pemesan.required'         => 'Email wajib diisi.',
        'email_pemesan.email'            => 'Format email tidak valid.',
        'telepon_pemesan.required'       => 'Nomor WhatsApp wajib diisi.',
        'telepon_pemesan.numeric'        => 'Nomor WhatsApp hanya boleh angka.',
        'telepon_pemesan.digits_between' => 'Nomor WhatsApp harus 9-15 digit.',
        'tanggal_event.required'         => 'Tanggal acara wajib diisi.',
        'tanggal_event.date'             => 'Format tanggal tidak valid.',
        'tanggal_event.after'            => 'Tanggal acara harus lebih dari hari ini.',
    ];

    public function mount(): void
    {
        $id = (int) request()->query('package_id', 0);

        if (! $id) {
            $this->packageError = true;
            return;
        }

        $this->packageId = $id;
        $this->loadPackage();
    }

    public function loadPackage(): void
    {
        $this->package = null;
        $this->packageLoaded = false;
        $this->packageError = false;

        try {
            $pkg = Package::with('category')->find($this->packageId);

            if ($pkg) {
                $imageUrl = $pkg->gambar_utama
                    ? (str_starts_with($pkg->gambar_utama, 'http')
                        ? $pkg->gambar_utama
                        : asset('storage/' . $pkg->gambar_utama))
                    : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&q=80';

                $this->package = [
                    'id'          => $pkg->id,
                    'name'        => $pkg->nama_paket,
                    'price'       => $pkg->harga,
                    'description' => $pkg->deskripsi_paket ?? '',
                    'category'    => $pkg->category ? $pkg->category->nama_kategori : 'Umum',
                    'image_url'   => $imageUrl,
                ];
                $this->packageLoaded = true;
            } else {
                $this->packageError = true;
            }
        } catch (\Exception $e) {
            $this->packageError = true;
        }
    }

    public function submitBooking(): void
    {
        $this->validate();

        try {
            $order = Order::create([
                'kode_booking'      => 'PKZ-' . strtoupper(uniqid()),
                'package_id'        => $this->packageId,
                'nama_pemesan'      => $this->nama_pemesan,
                'email_pemesan'     => $this->email_pemesan,
                'telepon_pemesan'   => $this->telepon_pemesan,
                'tanggal_event'     => $this->tanggal_event,
                'total_bayar'       => $this->package['price'] ?? 0,
                'kode_unik'         => rand(100, 999),
                'status_pembayaran' => 'pending',
                'nama_bank'         => config('services.bank_name'),
                'nomor_rekening'    => config('services.account_number'),
                'atas_nama_rekening'=> config('services.account_holder'),
            ]);

            $this->orderData = [
                'id'                 => $order->id,
                'kode_booking'       => $order->kode_booking,
                'total_bayar'        => (int) $order->total_bayar,
                'kode_unik'          => (int) $order->kode_unik,
                'grand_total'        => (int) $order->grand_total,
                'nama_bank'          => $order->nama_bank,
                'nomor_rekening'     => $order->nomor_rekening,
                'atas_nama_rekening' => $order->atas_nama_rekening,
            ];
            $this->showPaymentModal = true;
        } catch (\Exception $e) {
            $this->flashMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->flashType = 'error';
        }
    }

    public function closeModal(): void
    {
        $this->showPaymentModal = false;
        $this->redirect('/');
    }

    public function formatPrice(int $price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
