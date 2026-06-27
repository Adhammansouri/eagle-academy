<?php

namespace App\Support;

class PhoneHelper
{
    public static function toWhatsApp(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone);

        if ($digits === '' || $digits === null) {
            return null;
        }

        if (str_starts_with($digits, '20') && strlen($digits) >= 12) {
            return $digits;
        }

        if (str_starts_with($digits, '0')) {
            return '20' . substr($digits, 1);
        }

        if (strlen($digits) === 10 && str_starts_with($digits, '1')) {
            return '20' . $digits;
        }

        return $digits;
    }

    public static function whatsAppUrl(string $phone, string $message): ?string
    {
        $wa = self::toWhatsApp($phone);

        if ($wa === null) {
            return null;
        }

        return 'https://wa.me/' . $wa . '?text=' . rawurlencode($message);
    }
}
