<?php
// src/Controller/PurchaseController.php

namespace App\Controller;

use App\PaymentProcessor\PaypalPaymentProcessorAdapter;
use App\PaymentProcessor\StripePaymentProcessorAdapter;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dto\PurchaseRequest;
use App\Service\PriceCalculatorService;
use App\Service\PaymentService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
	private PriceCalculatorService $priceCalculatorService;
	private PaymentService $paymentService;
	private SerializerInterface $serializer;
	private ValidatorInterface $validator;

	public function __construct(PriceCalculatorService $priceCalculatorService, PaymentService $paymentService, SerializerInterface $serializer, ValidatorInterface $validator)
	{
		$this->priceCalculatorService = $priceCalculatorService;
		$this->paymentService = $paymentService;
		$this->serializer = $serializer;
		$this->validator = $validator;
	}

	#[Route('purchase', name: 'purchase', methods: ['POST'])]
	public function purchase(Request $request): Response
	{
		$requestData = $request->getContent();

		$purchaseRequest = $this->serializer->deserialize($requestData, PurchaseRequest::class, 'json');
		$errors = $this->validator->validate($purchaseRequest);

		if (count($errors) > 0) {
			return $this->json(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
		}

		try {
			$finalPrice = $this->priceCalculatorService->calculatePrice($purchaseRequest->product, $purchaseRequest->taxNumber, $purchaseRequest->couponCode);
			$processor = match ($purchaseRequest->paymentProcessor) {
				'paypal' => new PaypalPaymentProcessorAdapter(),
				'stripe' => new StripePaymentProcessorAdapter(),
				default => throw new Exception("Unsupported payment processor"),
			};
			$paymentResult = $this->paymentService->processPayment($finalPrice, $processor);

			if ($paymentResult) {
				return $this->json(['message' => 'Payment successful']);
			} else {
				return $this->json(['error' => 'Payment failed'], Response::HTTP_BAD_REQUEST);
			}
		} catch (Exception $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
		}
	}
}
