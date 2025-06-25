<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class TareaUnica extends Constraint
{
    public string $message = 'Tarea con descripción "{{ value }}" existente.';
    
    // Opcional si no necesitas cambiar el target por defecto
    public function getTargets(): string|array
{
    return self::PROPERTY_CONSTRAINT;
}

}
