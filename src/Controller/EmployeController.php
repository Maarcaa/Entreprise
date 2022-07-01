<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployeController extends AbstractController
{
    
    /**
     * Une fonction d'un controller s'appelera une action.
     * Le nom de cette action (cette fonction) commence TOUJOURS par un verbe
     * On privilégie l'anglais. A defaut, on nomme correectement ses variables en français
     *  @Route("/ajouter-un-employe.html", name="employe_create", methods={"GET|POST"})
     */
public function create(Request $request, EntityManagerInterface $entityManager)
{
    /////////////// ----------------- 1ere PARTIE : GET ------------------ /////////////////
    # Variabilisation d'un nouvel objet de type Employe
$employe = new Employe();

# On créé dans une variable un formulaire a partir de notre prototype EmployeFormType
# Pour faire fonctionner le mécanisme d'auto hydratation d'objet de Symfony, vous devrez passez en 2eme argument votre objet $employe.
# Mais également que tous les noms de vos champs dans le prototye de form (EmployeFormType) aient EXACTEMENT les mêmes noms que les propriétés de la Class à laquelle il est rattaché.
# Pour que Symfony récupère les données des inputs du form, vous devrez handleRequest().

$form = $this->createForm(EmployeFormType::class, $employe);

# Pour que symhpony recupere les données des inputs du form,  vous devrez handleRequest().
$form->handleRequest($request);


////////////////////// -------------------- 2eme PARTIE : POST ----------------- //////////////
if ($form->isSubmitted() && $form->isValid()){

    # Cette méthode pour récupérer les données des inputs est la 1ere méthode
    # Nous utiliserons la seconde, grace au mecanisme d'auto hydratation de symfony
// $form->get('salary')->getData();
$entityManager->persist($employe);
$entityManager->flush();

return $this->redirectToRoute('default_home');
}

#on passe en parametre le formulaire à notre vue Twig
return $this->render("form/employe.html.twig",[
    "form_employe" => $form->createView()
]);
} # en,d function create

/**
 *  @Route("/modifier-un-employe-{id}", name="employe_update", methods={"GET|POST"})
 */
public function  update(Employe $employe, Request $request, EntityManagerInterface $entityManager): Response
{
$form = $this->createForm(EmployeFormType::class, $employe)
->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()){
    $entityManager->persist($employe);
    $entityManager->flush();

    return $this->redirectToRoute('default_home');
} #end if

return $this->render("form/employe.html.twig", [
    'employe' => $employe,
    'form_employe' => $form->createView()
]);
} # end function update

/**
 * @Route ("/supprimer-un-employe-{id}", name="employe_delete", methods={"GET"})
 */
public function delete(Employe $employe, EntityManagerInterface $entityManager): RedirectResponse{
$entityManager->remove($employe);
$entityManager->flush();

return $this->redirectToRoute("default_home");
}

}# end class

