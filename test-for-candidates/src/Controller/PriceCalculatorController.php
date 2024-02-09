<?php
// src/Controller/PriceCalculatorController.php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Dto\CalculatePriceRequest;
use App\Service\PriceCalculatorService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceCalculatorController extends AbstractController
{
	private PriceCalculatorService $priceCalculatorService;
	private SerializerInterface $serializer;
	private ValidatorInterface $validator;

	public function __construct(PriceCalculatorService $priceCalculatorService, SerializerInterface $serializer, ValidatorInterface $validator)
	{
		$this->priceCalculatorService = $priceCalculatorService;
		$this->serializer = $serializer;
		$this->validator = $validator;
	}

	#[Route('calculate-price', name: 'calculate_price', methods: ['POST'])]
	public function calculatePrice(Request $request): Response
	{
		$requestData = $request->getContent();

		// Deserialize and validate data
		$calculatePriceRequest = $this->serializer->deserialize($requestData, CalculatePriceRequest::class, 'json');
		$errors = $this->validator->validate($calculatePriceRequest);

		if (count($errors) > 0) {
			// return error if validation is failed
			return $this->json(['error' => (string)$errors], Response::HTTP_BAD_REQUEST);
		}

		try {
			// calculate price and return result
			$finalPrice = $this->priceCalculatorService->calculatePrice($calculatePriceRequest->product, $calculatePriceRequest->taxNumber, $calculatePriceRequest->couponCode);
			return $this->json(['finalPrice' => $finalPrice]);
		} catch (Exception $e) {
			// catch and return error
			return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
		}
	}
}
