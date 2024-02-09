<?php
// src/PaymentProcessor/PaypalPaymentProcessorAdapter.php

namespace App\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentProcessorAdapter implements PaymentProcessorInterface
{
	private $paypalProcessor;

	public function __construct()
	{
		$this->paypalProcessor = new PaypalPaymentProcessor();
	}

	public function processPayment(float $price): bool
	{
		try {
			// PayPal accepts prices in the smallest currency unit (cents)
			$this->paypalProcessor->pay((int)($price * 100));
			return true;
		} catch (\Exception $e) {
			// logging or other exception handling
			return false;
		}
	}
}
