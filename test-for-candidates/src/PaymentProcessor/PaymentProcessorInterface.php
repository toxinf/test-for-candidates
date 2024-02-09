<?php
// src/PaymentProcessor/PaymentProcessorInterface.php

namespace App\PaymentProcessor;

interface PaymentProcessorInterface
{
	public function processPayment(float $price): bool;
}
