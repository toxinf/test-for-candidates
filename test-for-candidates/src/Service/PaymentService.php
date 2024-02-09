<?php
// src/Service/PaymentService.php

namespace App\Service;

use App\PaymentProcessor\PaymentProcessorInterface;

class PaymentService
{
	public function processPayment(float $amount, PaymentProcessorInterface $processor): bool
	{
		return $processor->processPayment($amount);
	}
}
