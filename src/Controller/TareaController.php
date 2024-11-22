<?php

namespace App\Controller;

use App\Entity\Tarea;
use App\Repository\TareaRepository;
use App\Service\TareaManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TareaController extends AbstractController
{

    /**
     * @Route("/tarea", name="tarea")
     */
    public function index(): Response
    {
        return $this->render('tarea/index.html.twig', [
            'controller_name' => 'TareaController',
            ]);
    }
    /**
     * @Route("/", name="app_listado_tarea")
     */
    public function listado(TareaRepository $tareaRepository): Response
    {
        $tareas = $tareaRepository->findAll();

        return $this->render('tarea/listado.html.twig', [
            'tareas' => $tareas,
        ]);
    }

    /**
     * @Route("/crear-tarea", name="app_crear_tarea", methods={"GET", "POST"})
     */
    public function crear(Request $request, EntityManagerInterface $em): Response
    {
        $tarea = new Tarea();
        $descripcion = $request->request->get('descripcion');

        if ($request->isMethod('POST')) {
            if (!empty($descripcion)) {
                $tarea->setDescripcion($descripcion);

                $em->persist($tarea);
                $em->flush();

                $this->addFlash('success', 'Tarea creada correctamente!');
                return $this->redirectToRoute('app_listado_tarea');
            } else {
                $this->addFlash('warning', 'El campo "Descripción" es obligatorio.');
            }
        }

        return $this->render('tarea/crear.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/editar-tarea/{id}", name="app_editar_tarea", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function editar(
        int $id,
        TareaRepository $tareaRepository,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $tarea = $tareaRepository->find($id);

        if (!$tarea) {
            throw $this->createNotFoundException('Tarea no encontrada.');
        }

        $descripcion = $request->request->get('descripcion');

        if ($request->isMethod('POST')) {
            if (!empty($descripcion)) {
                $tarea->setDescripcion($descripcion);

                $em->flush();

                $this->addFlash('success', 'Tarea editada correctamente!');
                return $this->redirectToRoute('app_listado_tarea');
            } else {
                $this->addFlash('warning', 'El campo "Descripción" es obligatorio.');
            }
        }

        return $this->render('tarea/editar.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/eliminar-tarea/{id}", name="app_eliminar_tarea", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function eliminar(Tarea $tarea, EntityManagerInterface $em): Response
    {
        $em->remove($tarea);
        $em->flush();

        $this->addFlash('success', 'Tarea eliminada correctamente!');
        return $this->redirectToRoute('app_listado_tarea');
    }

    /**
     * @Route("/crear-tarea-servicio", name="app_crear_tarea_servicio", methods={"GET", "POST"})
     */
    public function crearServicio(TareaManager $tareaManager, Request $request): Response
    {
        $descripcion = $request->request->get('descripcion');
        $tarea = new Tarea();

        if ($request->isMethod('POST')) {
            $tarea->setDescripcion($descripcion);
            $errores = $tareaManager->validar($tarea);

            if (empty($errores)) {
                $tareaManager->crear($tarea);
                $this->addFlash('success', 'Tarea creada correctamente!');
                return $this->redirectToRoute('app_listado_tarea');
            }

            foreach ($errores as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->render('tarea/crear.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/editar-tarea-servicio/{id}", name="app_editar_tarea_servicio", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function editarServicio(TareaManager $tareaManager, Tarea $tarea, Request $request): Response
    {
        $descripcion = $request->request->get('descripcion');

        if ($request->isMethod('POST')) {
            $tarea->setDescripcion($descripcion);
            $errores = $tareaManager->validar($tarea);

            if (empty($errores)) {
                $tareaManager->crear($tarea);
                $this->addFlash('success', 'Tarea editada correctamente!');
                return $this->redirectToRoute('app_listado_tarea');
            }

            foreach ($errores as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->render('tarea/editar.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/eliminar-tarea-servicio/{id}", name="app_eliminar_tarea_servicio", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function eliminarServicio(Tarea $tarea, TareaManager $tareaManager): Response
    {
        $tareaManager->eliminar($tarea);

        $this->addFlash('success', 'Tarea eliminada correctamente!');
        return $this->redirectToRoute('app_listado_tarea');
    }
}
