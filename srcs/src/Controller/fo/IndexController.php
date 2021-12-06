<?php

namespace App\Controller\fo;

use App\Entity\Logement;
use App\Entity\TypeLogement;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $logementLists = $this->em->getRepository(Logement::class)->findBy(['status' => true]) ;

        $typeLogementLists =  $this->em->getRepository(TypeLogement::class)->findBy([] , ['id' => "DESC"]) ;

        return $this->render('fo/logement/index.html.twig', [

            'controller_name'   => 'IndexController',
            'logementLists'     => $logementLists,
            'typeLogementLists'     => $typeLogementLists,

        ]);

    }

    /**
     * @Route("/reservation/{id}", name="reservation")
     */
    public function reservation(Logement $logement , Request $request)
    {
        
        if (count($request->request) > 0) {
            # code...
            $name       = $request->request->get('name') ;
            $firstname  = $request->request->get('firstname') ;
            $address    = $request->request->get('address') ;
            $cin        = $request->request->get('cin') ;
            $dateStart  = $request->request->get('dateStart') ;
            $dateEnd    = $request->request->get('dateEnd') ;

            $user = new User() ;

            $user->setName($name) 
                    ->setFirstname($firstname)
                    ->setAddress($address)
                    ->setCin($cin)
                    ;
          
            $this->em->persist($user) ;
            
            $logement->setDisponibility(false)
                    ->setStartedDate(new \DateTime($dateStart))
                    ->setEndingDate(new \DateTime( $dateEnd))
                    ->setUser($user)
                    ;

            $this->em->persist($logement) ;
            $this->em->flush() ;

            $this->addFlash('succes' , "reservation envoyer avec succès merci de votre confiance") ;

           return $this->redirectToRoute('index') ; 
        }
        return $this->render('fo/logement/reservation.html.twig', [

            'controller_name'   => 'IndexController',
            'logement'     => $logement,

        ]);

    }

}
