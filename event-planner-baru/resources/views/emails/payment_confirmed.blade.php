<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Diterima</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #eee; padding: 20px; border-radius: 10px;">
        <h2 style="color: #2563eb; text-align: center;">Pembayaran Berhasil! 🎉</h2>
        
        <p>Halo <strong>{{ $order->nama_pemesan }}</strong>,</p>
        
        <p>Terima kasih! Pembayaran Anda telah kami terima. Pesanan Anda sekarang berstatus <strong>LUNAS</strong> dan siap kami proses.</p>
        
        <div style="background-color: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Detail Pesanan:</h3>
            <table style="width: 100%;">
                <tr>
                    <td>Kode Booking:</td>
                    <td><strong>{{ $order->kode_booking }}</strong></td>
                </tr>
                <tr>
                    <td>Total Bayar:</td>
                    <td>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <p>Tim kami akan segera menghubungi Anda melalui WhatsApp ({{ $order->telepon_pemesan }}) untuk koordinasi selanjutnya.</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin-top: 30px;">
        <p style="font-size: 12px; color: #888; text-align: center;">PartyKit'Z Official</p>
    </div>

</body>
</html>