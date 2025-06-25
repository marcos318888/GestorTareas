<?php

namespace App\Validator;

use App\Repository\TareaRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TareaUnicaValidator extends ConstraintValidator
{
    private TareaRepository $tareaRepository;

    public function __construct(TareaRepository $tareaRepository)
    {
        $this->tareaRepository = $tareaRepository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof TareaUnica) {
            throw new UnexpectedTypeException($constraint, TareaUnica::class);
        }

        if (null === $value || '' === $value) {
            return; // No validamos valores vacíos
        }

        // Verifica si ya existe una tarea con la misma descripción
        $tareaExistente = $this->tareaRepository->buscarTareaPorDescripcion($value);

        if ($tareaExistente !== null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
