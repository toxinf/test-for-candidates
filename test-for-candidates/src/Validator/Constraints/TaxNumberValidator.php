<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TaxNumberValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if (!$constraint instanceof TaxNumber) {
			throw new UnexpectedTypeException($constraint, TaxNumber::class);
		}

		if (!is_string($value)) {
			throw new UnexpectedValueException($value, 'string');
		}

		$countryCode = substr($value, 0, 2);

		$isValid = match ($countryCode) {
			'DE' => preg_match('/^DE[0-9]{9}$/', $value),
			'IT' => preg_match('/^IT[0-9]{11}$/', $value),
			'GR' => preg_match('/^GR[0-9]{9}$/', $value),
			'FR' => preg_match('/^FR[A-Z]{2}[0-9]{9}$/', $value),
			default => false,
		};

		if (!$isValid) {
			$this->context->buildViolation($constraint->message)->setParameter('{{ value }}', $value)->setParameter('{{ country_code }}', $countryCode)->addViolation();
		}
	}
}
