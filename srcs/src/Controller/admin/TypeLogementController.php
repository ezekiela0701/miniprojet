<?php

namespace App\Controller\admin;

use App\Entity\TypeLogement;
use App\Form\TypeLogementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/admin/type/logement" , name="typelogement.")
     */
class TypeLogementController extends AbstractController
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
        $typeLogementLists = $this->em->getRepository(TypeLogement::class)->findAll() ; 
        return $this->render('admin/typelogement/index.html.twig', [
            'typeLogementLists' => $typeLogementLists,
            'controller_name'   => 'TypeLogementController',
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @Route("/edit/{id}", name="edit")
     */
    public function add(TypeLogement $typeLogement = null , Request $request): Response
    {
        if(!$typeLogement){
            $typeLogement = new TypeLogement();
        }

        $form = $this->createForm(TypeLogementType::class, $typeLogement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($typeLogement);
            $this->em->flush();

            return $this->redirectToRoute('typelogement.list');

        }

        return $this->render('admin/typelogement/add.html.twig', [
            // 'typeLogementLists' => $typeLogementLists,
            'controller_name'   => 'TypeLogementController',
            'formTypelogement'  => $form->createView() , 
            'editMode'          => $typeLogement->getId() != null ,
        ]);
    }

}
