<?php
// src/Entity/Product.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: Types::INTEGER)]
	private ?int $id = null;

	#[ORM\Column(type: Types::STRING, length: 255)]
	private ?string $name = null;

	#[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
	private ?float $price = null;

	public function getId(): int
	{
		return $this->id;
	}

	public function setId($id): void
	{
		$this->id = $id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName($name): void
	{
		$this->name = $name;
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function setPrice($price): void
	{
		$this->price = $price;
	}
}
