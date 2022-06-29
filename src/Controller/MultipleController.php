<?php

namespace App\Controller;

use App\Entity\Multiple;
use App\Form\MultipleType;
use App\Repository\MultipleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/multiple')]
class MultipleController extends AbstractController
{
    #[Route('/', name: 'app_multiple_index', methods: ['GET'])]
    public function index(MultipleRepository $multipleRepository): Response
    {
        return $this->render('multiple/index.html.twig', [
            'multiples' => $multipleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_multiple_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MultipleRepository $multipleRepository): Response
    {
        $multiple = new Multiple();
        $form = $this->createForm(MultipleType::class, $multiple);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $multipleRepository->add($multiple, true);

            return $this->redirectToRoute('app_multiple_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('multiple/new.html.twig', [
            'multiple' => $multiple,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_multiple_show', methods: ['GET'])]
    public function show(Multiple $multiple): Response
    {
        return $this->render('multiple/show.html.twig', [
            'multiple' => $multiple,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_multiple_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Multiple $multiple, MultipleRepository $multipleRepository): Response
    {
        $form = $this->createForm(MultipleType::class, $multiple);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $multipleRepository->add($multiple, true);

            return $this->redirectToRoute('app_multiple_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('multiple/edit.html.twig', [
            'multiple' => $multiple,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_multiple_delete', methods: ['POST'])]
    public function delete(Request $request, Multiple $multiple, MultipleRepository $multipleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$multiple->getId(), $request->request->get('_token'))) {
            $multipleRepository->remove($multiple, true);
        }

        return $this->redirectToRoute('app_multiple_index', [], Response::HTTP_SEE_OTHER);
    }
}
