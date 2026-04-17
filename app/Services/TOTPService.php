<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;

class TOTPService
{
    protected static function getGoogle2FA()
    {
        return new Google2FA();
    }

    public static function generateSecret(): string
    {
        return self::getGoogle2FA()->generateSecretKey();
    }

    public static function getCode(string $secret, int $timeSlice = null): string
    {
        $google2fa = self::getGoogle2FA();
        if ($timeSlice !== null) {
            return $google2fa->getCurrentOtp($secret, $timeSlice * 30);
        }
        return $google2fa->getCurrentOtp($secret);
    }

    public static function verifyCode(string $secret, string $code): bool
    {
        $google2fa = self::getGoogle2FA();
        // 4 windows = 2 minutes tolerance
        return $google2fa->verifyKey($secret, $code, 4);
    }

    public static function getQRCodeUrl(string $email, string $secret, string $issuer = 'E-RentCar'): string
    {
        $google2fa = self::getGoogle2FA();
        return $google2fa->getQRCodeUrl($issuer, $email, $secret);
    }
}
