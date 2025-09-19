<?php

namespace App\Services\Payments;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        protected PaymentGateway $gateway
    ) {}

    public function create(Booking $booking): array
    {
        return $this->gateway->createPayment($booking);
    }

    public function webhook(array $payload): void
    {
        // Delegate to gateway; ensure idempotency within gateway
        $this->gateway->handleWebhook($payload);
        Log::info('Payment webhook processed');
    }
}

