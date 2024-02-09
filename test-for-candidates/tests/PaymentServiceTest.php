<?php
namespace App\Tests\Service;

use App\Entity\Product;
use App\Entity\Coupon;
use App\PaymentProcessor\PaypalPaymentProcessorAdapter;
use App\PaymentProcessor\StripePaymentProcessorAdapter;
use App\Repository\ProductRepository;
use App\Repository\CouponRepository;
use App\Service\PaymentService;
use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
	public function testPaymentUsingPaypalProcessor()
	{
		// creating mocks for PaypalPaymentProcessorAdapter
		$paypalProcessorMock = $this->createMock(PaypalPaymentProcessorAdapter::class);

		// setting up a mock to expect a call to the processPayment method with any argument value and to return true
		$paypalProcessorMock->expects($this->once())->method('processPayment')->with($this->anything())->willReturn(true);

		// creating an instance of PaymentService, passing a mock payment processor to it
		$paymentService = new PaymentService();

		// calling the processPayment method and storing the result
		$amount = 100.00;
		$result = $paymentService->processPayment($amount, $paypalProcessorMock);

		// asserting that the result of the processPayment method execution is true
		$this->assertTrue($result);
	}
	public function testPaymentUsingStripeProcessor()
	{
		// creating mocks for StripePaymentProcessorAdapter
		$stripeProcessorMock = $this->createMock(StripePaymentProcessorAdapter::class);

		// setting up a mock to expect a call to the processPayment method with any argument value and to return true
		$stripeProcessorMock->expects($this->once())->method('processPayment')->with($this->anything())->willReturn(true);

		// creating an instance of PaymentService, passing a mock payment processor to it
		$paymentService = new PaymentService();

		// calling the processPayment method and storing the result
		$amount = 100.00;
		$result = $paymentService->processPayment($amount, $stripeProcessorMock);

		// asserting that the result of the processPayment method execution is true
		$this->assertTrue($result);
	}
}
