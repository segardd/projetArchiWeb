<?php

namespace App\Controller;

use App\Entity\Affaire;
use App\Form\Affaire3Type;
use App\Repository\AffaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\Form\Extension\Core\Type\TextType;



use Symfony\Flex\Response as FlexResponse;

/**
 * @Route("/affaire")
 */
class AffaireController extends AbstractController
{

   

    /**
     * @Route("/", name="affaire_index", methods={"GET","POST"})
     */
    public function index(AffaireRepository $affaireRepository,Request $request): Response
    {
        
        $data=array("designation"=>'');
        $form = $this->createFormBuilder($data)
        ->add('designation', TextType::class)
        ->getForm();
        $form->handleRequest($request);
        
        dump($form->getData());
        $data=$form->getData();
        dump($affaireRepository->findByDesignation($data["designation"]));
        if ($form->isSubmitted()){
            return $this->render('affaire/index.html.twig', [
                'affaires' => $affaireRepository->findByDesignation($data["designation"]),
                'form' => $form->createView(),
                'button_label'=>"chercher"
            ]);
        }

        return $this->render('affaire/index.html.twig', [
            'affaires' => $affaireRepository->findAll(),
            'form' => $form->createView(),
            'button_label'=>"chercher"
        ]);
    }

    /**
     * @Route("/new", name="affaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $affaire = new Affaire();
        $form = $this->createForm(Affaire3Type::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($affaire);
            $entityManager->flush();

            return $this->redirectToRoute('affaire_index');
        }

        return $this->render('affaire/new.html.twig', [
            'affaire' => $affaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="affaire_show", methods={"GET"})
     */
    public function show(Affaire $affaire): Response
    {
        return $this->render('affaire/show.html.twig', [
            'affaire' => $affaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="affaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Affaire $affaire): Response
    {
        $form = $this->createForm(Affaire3Type::class, $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affaire_index');
        }

        return $this->render('affaire/edit.html.twig', [
            'affaire' => $affaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="affaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Affaire $affaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($affaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('affaire_index');
    }
    /**
     * @Route("/getAffaire", name="affaire_find", methods={"POST"})
     */
    public function getAffaireByDesignation(Request $request, AffaireRepository $affaireRepository): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        
        $serializer = new Serializer($normalizers, $encoders);

        $data=json_decode($request->getContent(),true);
        dump($request->getContent());
        dump(json_decode($request->getContent()));
        dump(json_last_error_msg());
        dump($data['designation']);

        $result=$affaireRepository->findByDesignation($data["designation"]);
        dump($result);
        $response= new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($serializer->serialize($result,'json', ['ignored_attributes' => ['politicien']]));
        dump(json_last_error_msg());
        dump($response->getContent());
        return $response;
    }
}
