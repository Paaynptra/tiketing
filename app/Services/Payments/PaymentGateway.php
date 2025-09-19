<?php

namespace App\Services\Payments;

use App\Models\Booking;

interface PaymentGateway
{
    /**
     * Create a payment/invoice for a booking and return a redirect URL or snap token.
     */
    public function createPayment(Booking $booking): array;

    /**
     * Handle webhook notification. Must be idempotent.
     */
    public function handleWebhook(array $payload): void;
}

