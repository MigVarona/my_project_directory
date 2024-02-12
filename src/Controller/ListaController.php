<?php

namespace App\Controller;

use App\Entity\Lista;
use App\Form\ListaType;
use App\Repository\ListaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lista')]
class ListaController extends AbstractController
{
    #[Route('/', name: 'app_lista_index', methods: ['GET'])]
    public function index(ListaRepository $listaRepository): Response
    {
        return $this->render('lista/index.html.twig', [
            'listas' => $listaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lista_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listum = new Lista();
        $form = $this->createForm(ListaType::class, $listum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listum);
            $entityManager->flush();

            return $this->redirectToRoute('app_lista_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lista/new.html.twig', [
            'listum' => $listum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lista_show', methods: ['GET'])]
    public function show(Lista $listum): Response
    {
        return $this->render('lista/show.html.twig', [
            'listum' => $listum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lista_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lista $listum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListaType::class, $listum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lista_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lista/edit.html.twig', [
            'listum' => $listum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lista_delete', methods: ['POST'])]
    public function delete(Request $request, Lista $listum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($listum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lista_index', [], Response::HTTP_SEE_OTHER);
    }
}
