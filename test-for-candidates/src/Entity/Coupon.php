<?php
// src/Entity/Coupon.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Coupon
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: Types::INTEGER)]
	private ?int $id = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $code = null;

	#[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
	private ?float $fixedDiscount = null;

	#[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
	private ?float $percentageDiscount = null;

	public function getId(): int
	{
		return $this->id;
	}

	public function getCode(): string
	{
		return $this->code;
	}

	public function setId($id): void
	{
		$this->id = $id;
	}

	public function setCode($code): void
	{
		$this->code = $code;
	}

	public function getFixedDiscount(): ?float
	{
		return $this->fixedDiscount;
	}

	public function setFixedDiscount($fixedDiscount): void
	{
		$this->fixedDiscount = $fixedDiscount;
	}

	public function getPercentageDiscount(): ?float
	{
		return $this->percentageDiscount;
	}

	public function setPercentageDiscount($percentageDiscount): void
	{
		$this->percentageDiscount = $percentageDiscount;
	}
}
