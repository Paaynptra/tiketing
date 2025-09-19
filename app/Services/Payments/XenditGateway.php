<?php

namespace App\Services\Payments;

use App\Models\Booking;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class XenditGateway implements PaymentGateway
{
    public function createPayment(Booking $booking): array
    {
        // TODO: integrate Xendit SDK. Return stub for now.
        return [
            'provider' => 'xendit',
            'redirect_url' => url('/booking/'.$booking->id.'/pay/mock'),
        ];
    }

    public function handleWebhook(array $payload): void
    {
        $eventId = $payload['id'] ?? md5(json_encode($payload));
        Cache::lock('webhook:'.$eventId, 10)->block(5, function () use ($payload) {
            Log::info('Xendit webhook payload', $payload);
            // TODO: verify signature & update booking status
        });
    }
}

