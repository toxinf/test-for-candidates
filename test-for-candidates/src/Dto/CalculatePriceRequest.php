<?php
// src/Dto/CalculatePriceRequest.php

namespace App\Dto;

use App\Validator\Constraints\TaxNumber;
use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest
{
	#[Assert\NotBlank]
	#[Assert\Type(type: 'integer')]
	public int $product;

	#[Assert\NotBlank]
	#[TaxNumber]
	public string $taxNumber;

	#[Assert\Type('string')]
	public ?string $couponCode = null;
}
