<?php
// src/Dto/PurchaseRequest.php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends CalculatePriceRequest
{
	#[Assert\NotBlank]
	#[Assert\Choice(['paypal','stripe'])]
	public string $paymentProcessor;
}
