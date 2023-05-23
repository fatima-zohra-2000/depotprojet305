<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\TailleCommande;
use App\Entity\Produit;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeRepository $commandeRepository, EntityManagerInterface $entityManager): Response
    {
//        $commande = new Commande();
//        $form = $this->createForm(CommandeType::class, $commande);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $commandeRepository->save($commande, true);
//
//            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
//        }
        $commande = new Commande();
        $tailleCommande = new TailleCommande();
        $commande->addTailleCommande($tailleCommande);

        $lastCommande = $commandeRepository->findOneBy([], ['id' => 'desc']);
        $lastNumCommande = $lastCommande ? $lastCommande->getNumCommande() : 0;
        $commande->setNumCommande($lastNumCommande + 1);

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $somme = 0;
            foreach ($commande->getTailleCommandes() as $tc) {
                $tc->setPrix($tc->getProduit()->getPrix());
                $somme += $tc->getPrix() * $tc->getQuantite();
                $entityManager->persist($tc); // cette ligne pour persister chaque tailleCommande
            }

            $montantTva = $somme * $commande->getTVA() / 100;
            $total = $somme + $montantTva;

            $commande->setTotal($total);
            $commande->setMantantTVA($montantTva);

            $entityManager->persist($commande);
//            $entityManager->persist($tailleCommande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande, true);
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
