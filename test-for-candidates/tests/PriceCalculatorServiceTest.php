<?php
namespace App\Tests\Service;

use App\Entity\Product;
use App\Entity\Coupon;
use App\Repository\ProductRepository;
use App\Repository\CouponRepository;
use App\Service\PriceCalculatorService;
use PHPUnit\Framework\TestCase;

class PriceCalculatorServiceTest extends TestCase
{
	private $productRepository;
	private $couponRepository;
	private $priceCalculatorService;

	protected function setUp(): void
	{
		// creating mocks for repositories
		$this->productRepository = $this->createMock(ProductRepository::class);
		$this->couponRepository = $this->createMock(CouponRepository::class);

		// init PriceCalculatorService with mocks
		$this->priceCalculatorService = new PriceCalculatorService($this->productRepository, $this->couponRepository);
	}

	public function testCalculatePriceWithoutCoupon()
	{
		// creation of a new product
		$product = new Product();
		$product->setPrice(100.00); // set price
		$this->productRepository->method('find')->willReturn($product);

		// call the method calculatePrice w/o coupon
		$result = $this->priceCalculatorService->calculatePrice(1, 'GR123456789', null);

		// checking that the price was calculated correctly
		// let's assume the tax for GR is 24%
		$expectedPrice = 100.00 * 1.24;
		$this->assertEquals($expectedPrice, $result);
	}

	public function testCalculatePriceWithCoupon()
	{
		// create product
		$product = new Product();
		$product->setPrice(100.00); // set price
		$this->productRepository->method('find')->willReturn($product);

		// create coupon
		$coupon = new Coupon();
		$coupon->setPercentageDiscount(6); // set percentage discount
		$this->couponRepository->method('findByCode')->willReturn($coupon);

		// call method calculatePrice w/o coupon
		$result = $this->priceCalculatorService->calculatePrice(1, 'GR123456789', 'D6');

		// checking that the price was calculated correctly
		// let's assume the tax for GR is 24%
		$expectedPrice = (100.00 - 100.00 * 0.06) * 1.24;
		$this->assertEquals($expectedPrice, $result);
	}
}
