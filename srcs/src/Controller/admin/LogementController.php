<?php

namespace App\Controller\admin;

use App\Entity\Logement;
use App\Form\LogementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/admin/logement" , name="logement.")
     */
class LogementController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="list")
     */
    public function index(): Response
    {
        $logementLists = $this->em->getRepository(Logement::class)->findAll() ; 
        return $this->render('admin/logement/index.html.twig', [
            'logementLists' => $logementLists,
            'controller_name' => 'LogementController',
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @Route("/edit/{id}", name="edit")
     */
    public function add(Logement $logement = null , Request $request): Response
    {
        if(!$logement){
            $logement = new Logement();
        }

        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($logement);
            $this->em->flush();

            return $this->redirectToRoute('logement.list');

        }


        return $this->render('admin/logement/add.html.twig', [
            'controller_name' => 'LogementController',
            'formlogement'  => $form->createView() , 
            'editMode'          => $logement->getId() != null ,
        ]);
    }

}
