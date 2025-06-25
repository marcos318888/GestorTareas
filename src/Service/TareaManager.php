<?php

namespace App\Service;

use App\Entity\Tarea;
use App\Repository\TareaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TareaManager
{
    private EntityManagerInterface $em;
    private TareaRepository $tareaRepository;
    private ValidatorInterface $validator;

    public function __construct(
        TareaRepository $tareaRepository,
        ValidatorInterface $validator,
        EntityManagerInterface $em
    ) {
        $this->em = $em;
        $this->tareaRepository = $tareaRepository;
        $this->validator = $validator;
    }

    public function crear(Tarea $tarea): void
    {
        $this->em->persist($tarea);
        $this->em->flush();
    }

    public function editar(Tarea $tarea): void
    {
        // Como la entidad ya está gestionada por Doctrine, solo flush es suficiente.
        $this->em->flush();
    }

    public function eliminar(Tarea $tarea): void
    {
        $this->em->remove($tarea);
        $this->em->flush();
    }

    public function validar(Tarea $tarea): ConstraintViolationListInterface
    {
        $errores = $this->validator->validate($tarea);

        // Si quieres, puedes agregar validaciones manuales, ejemplo:
        /*
        if (empty($tarea->getDescripcion())) {
            // Symfony Validator es preferible para estas validaciones, pero si no, podrías lanzar excepción o manejar aquí.
        }

        $tareaExistente = $this->tareaRepository->buscarTareaPorDescripcion($tarea->getDescripcion());
        if ($tareaExistente !== null && $tareaExistente->getId() !== $tarea->getId()) {
            // Esto es una validación personalizada para evitar duplicados.
        }
        */

        return $errores;
    }
}
