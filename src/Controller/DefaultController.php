<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * @Route ("/", name="default_home")
     */
 public function home(EntityManagerInterface $entityManager): Response
 {
    # On récupère dans la variable $employes tous les employés enregistrés en BDD
    $employes = $entityManager->getRepository(Employe::class)->findAll();
    return $this->render("default/home.html.twig", [
      "employes" =>  $employes
    ]);
 }
}
