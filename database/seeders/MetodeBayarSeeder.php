<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetodeBayar;

class MetodeBayarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodeBayars = [
            [
                'metode_pembayaran' => 'Bank Transfer BCA',
                'tempat_bayar' => 'BCA Mobile / ATM BCA',
                'no_rekening' => '1234567890',
                'midtrans_payment_type' => 'bca_va',
                'url_logo' => 'metode-bayar-logos/bca-logo.png',
            ],
            [
                'metode_pembayaran' => 'Bank Transfer BNI',
                'tempat_bayar' => 'BNI Mobile / ATM BNI',
                'no_rekening' => '0987654321',
                'midtrans_payment_type' => 'bni_va',
                'url_logo' => 'metode-bayar-logos/bni-logo.png',
            ],
            [
                'metode_pembayaran' => 'Bank Transfer BRI',
                'tempat_bayar' => 'BRI Mobile / ATM BRI',
                'no_rekening' => '1122334455',
                'midtrans_payment_type' => 'bri_va',
                'url_logo' => 'metode-bayar-logos/bri-logo.png',
            ],
            [
                'metode_pembayaran' => 'GoPay',
                'tempat_bayar' => 'Aplikasi Gojek',
                'no_rekening' => null,
                'midtrans_payment_type' => 'gopay',
                'url_logo' => 'metode-bayar-logos/gopay-logo.png',
            ],
            [
                'metode_pembayaran' => 'OVO',
                'tempat_bayar' => 'Aplikasi OVO',
                'no_rekening' => null,
                'midtrans_payment_type' => 'ovo',
                'url_logo' => 'metode-bayar-logos/ovo-logo.png',
            ],
            [
                'metode_pembayaran' => 'ShopeePay',
                'tempat_bayar' => 'Aplikasi Shopee',
                'no_rekening' => null,
                'midtrans_payment_type' => 'shopeepay',
                'url_logo' => 'metode-bayar-logos/shopeepay-logo.png',
            ],
            [
                'metode_pembayaran' => 'QRIS',
                'tempat_bayar' => 'Aplikasi E-Wallet',
                'no_rekening' => null,
                'midtrans_payment_type' => 'qris',
                'url_logo' => 'metode-bayar-logos/qris-logo.png',
            ],
            [
                'metode_pembayaran' => 'Kartu Kredit',
                'tempat_bayar' => 'Visa / Mastercard',
                'no_rekening' => null,
                'midtrans_payment_type' => 'credit_card',
                'url_logo' => 'metode-bayar-logos/credit-card-logo.png',
            ],
            [
                'metode_pembayaran' => 'Bank Transfer Mandiri',
                'tempat_bayar' => 'ATM Mandiri / E-Channel',
                'no_rekening' => '6677889900',
                'midtrans_payment_type' => 'echannel',
                'url_logo' => 'metode-bayar-logos/mandiri-logo.png',
            ],
            [
                'metode_pembayaran' => 'Transfer Manual',
                'tempat_bayar' => 'Bank Apotek',
                'no_rekening' => '5566778899',
                'midtrans_payment_type' => null,
                'url_logo' => 'metode-bayar-logos/manual-transfer-logo.png',
            ],
        ];

        foreach ($metodeBayars as $metode) {
            MetodeBayar::updateOrCreate(
                ['metode_pembayaran' => $metode['metode_pembayaran']],
                $metode
            );
        }
    }
}

