<?php

namespace App\Controller;

use App\Entity\Politicien;
use App\Form\Politicien3Type;
use App\Repository\PoliticienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Form;

/**
 * @Route("/politicien")
 */
class PoliticienController extends AbstractController
{
    /**
     * @Route("/", name="politicien_index", methods={"GET"})
     */
    public function index(PoliticienRepository $politicienRepository): Response
    {
        return $this->render('politicien/index.html.twig', [
            'politiciens' => $politicienRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="politicien_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $politicien = new Politicien();
        $form = $this->createForm(Politicien3Type::class, $politicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($politicien);
            $entityManager->flush();

            return $this->redirectToRoute('politicien_index');
        }

        return $this->render('politicien/new.html.twig', [
            'politicien' => $politicien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="politicien_show", methods={"GET"})
     */
    public function show(Politicien $politicien): Response
    {
        return $this->render('politicien/show.html.twig', [
            'politicien' => $politicien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="politicien_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Politicien $politicien): Response
    {
        $form = $this->createForm(Politicien3Type::class, $politicien);
        /*$form->add('nom',TextType::class,[<
            'attr'=>[
                'disabled'=>'disabled'

            ]
        ]);*/
        $form->remove('nom');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('politicien_index');
        }

        return $this->render('politicien/edit.html.twig', [
            'politicien' => $politicien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="politicien_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Politicien $politicien): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$politicien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($politicien->getAffaires() as $affaire) {
                $politicien->removeAffaire($affaire);
            }
            $entityManager->persist($politicien);
            $entityManager->remove($politicien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('politicien_index');
    }
}
