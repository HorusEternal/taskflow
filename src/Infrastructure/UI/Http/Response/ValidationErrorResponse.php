<?php

namespace App\Infrastructure\UI\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorResponse extends JsonResponse
{
    public static function fromViolations(ConstraintViolationListInterface $violations): self
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return new self([
            'error' => 'Validation failed.',
            'violations' => $errors,
        ], Response::HTTP_BAD_REQUEST);
    }
}
