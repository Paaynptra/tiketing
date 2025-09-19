<?php

namespace App\Services\Qr;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class QrService
{
    public function generateSigned(string $ticketUid): string
    {
        $key = config('app.key');
        $hmac = hash_hmac('sha256', $ticketUid, $key);
        $payload = json_encode(['u' => $ticketUid, 's' => $hmac], JSON_UNESCAPED_SLASHES);

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($payload)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(2)
            ->build();

        return $result->getDataUri();
    }

    public function verify(string $ticketUid, string $signature): bool
    {
        $key = config('app.key');
        $expected = hash_hmac('sha256', $ticketUid, $key);
        return hash_equals($expected, $signature);
    }
}

