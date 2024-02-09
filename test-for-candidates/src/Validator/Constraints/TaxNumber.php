<?php
// src/Validator/Constraints/TaxNumber.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TaxNumber extends Constraint
{
	public string $message = 'The tax number "{{ value }}" is not valid for the country code "{{ country_code }}".';
}
