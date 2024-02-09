<?php
// src/PaymentProcessor/StripePaymentProcessorAdapter.php

namespace App\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePaymentProcessorAdapter implements PaymentProcessorInterface
{
	private StripePaymentProcessor $stripeProcessor;

	public function __construct()
	{
		$this->stripeProcessor = new StripePaymentProcessor();
	}

	public function processPayment(float $price): bool
	{
		return $this->stripeProcessor->processPayment($price);
	}
}
