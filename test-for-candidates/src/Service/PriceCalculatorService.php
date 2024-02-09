<?php
// src/Service/PriceCalculatorService.php

namespace App\Service;

use App\Entity\Coupon;
use App\Repository\ProductRepository;
use App\Repository\CouponRepository;
use Exception;

class PriceCalculatorService
{
	private ProductRepository $productRepository;
	private CouponRepository $couponRepository;

	public function __construct(ProductRepository $productRepository, CouponRepository $couponRepository)
	{
		$this->productRepository = $productRepository;
		$this->couponRepository = $couponRepository;
	}

	public function calculatePrice(int $productId, string $taxNumber, ?string $couponCode): float
	{
		// load a product
		$product = $this->productRepository->find($productId);
		// load a coupon if code is not empty
		$coupon = $couponCode ? $this->couponRepository->findByCode($couponCode) : null;

		if (!$product) {
			// throw an error if product isn't found
			throw new Exception("Product not found");
		}

		// get values for calculation
		$price = $product->getPrice();
		$taxRate = $this->getTaxRate($taxNumber);
		$discount = $this->getDiscount($coupon, $price);

		$discountedPrice = $price - $discount;
		$finalPrice = $discountedPrice * (1 + $taxRate);

		// return rounded result
		return round($finalPrice, 2);
	}

	private function getTaxRate(string $taxNumber): float
	{
		if (preg_match("/^DE/", $taxNumber)) {
			return 0.19;
		} elseif (preg_match("/^IT/", $taxNumber)) {
			return 0.22;
		} elseif (preg_match("/^GR/", $taxNumber)) {
			return 0.24;
		} elseif (preg_match("/^FR/", $taxNumber)) {
			return 0.20;
		}

		throw new Exception("Invalid tax number");
	}

	private function getDiscount(?Coupon $coupon, float $price): float
	{
		if (!$coupon) {
			return 0.0;
		}

		if ($coupon->getFixedDiscount()) {
			return $coupon->getFixedDiscount();
		} elseif ($coupon->getPercentageDiscount()) {
			return $price * ($coupon->getPercentageDiscount() / 100);
		}

		return 0.0;
	}
}
