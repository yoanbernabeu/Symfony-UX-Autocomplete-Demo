<?php

namespace App\Controller;

use App\Entity\Simple;
use App\Form\SimpleType;
use App\Repository\SimpleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/simple')]
class SimpleController extends AbstractController
{
    #[Route('/', name: 'app_simple_index', methods: ['GET'])]
    public function index(SimpleRepository $simpleRepository): Response
    {
        return $this->render('simple/index.html.twig', [
            'simples' => $simpleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_simple_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SimpleRepository $simpleRepository): Response
    {
        $simple = new Simple();
        $form = $this->createForm(SimpleType::class, $simple);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $simpleRepository->add($simple, true);

            return $this->redirectToRoute('app_simple_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('simple/new.html.twig', [
            'simple' => $simple,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_simple_show', methods: ['GET'])]
    public function show(Simple $simple): Response
    {
        return $this->render('simple/show.html.twig', [
            'simple' => $simple,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_simple_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Simple $simple, SimpleRepository $simpleRepository): Response
    {
        $form = $this->createForm(SimpleType::class, $simple);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $simpleRepository->add($simple, true);

            return $this->redirectToRoute('app_simple_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('simple/edit.html.twig', [
            'simple' => $simple,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_simple_delete', methods: ['POST'])]
    public function delete(Request $request, Simple $simple, SimpleRepository $simpleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$simple->getId(), $request->request->get('_token'))) {
            $simpleRepository->remove($simple, true);
        }

        return $this->redirectToRoute('app_simple_index', [], Response::HTTP_SEE_OTHER);
    }
}
