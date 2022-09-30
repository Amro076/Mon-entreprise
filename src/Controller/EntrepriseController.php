<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('entreprise/home.html.twig');
    }

    #[Route('liste', name: 'liste_employes')]
    public function liste(EmployeRepository $repo)
    {
        $employes=$repo->findAll();
        return $this->render('entreprise/liste.html.twig', [
            'employes' => $employes
        ]);
    }

    #[Route('new', name:'entreprise_new')] 
    #[Route('/entreprise/edite{id}', name:'entreprise_edit')]
    public function form( Request $globals, EntityManagerInterface $manager, Employe $employe = null )
    {
        if($employe == null)
        {
            $employe = new Employe;
        }
        $form=$this->createForm(EmployeType::class, $employe);
        $form->handleRequest($globals);

        if($form->issubmitted() && $form->isvalid())
        {
            $manager->persist($employe);
            $manager->flush();
            return $this->redirectToRoute('liste_employes');
        }

        return $this->renderForm('entreprise/form.html.twig', [
            'formEmploye' => $form,
            'editMode' => $employe->getId() !== NULL
        ]);

    }

    #[Route('delete{id}', name:'entreprise_delete')]
    public function delete(Employe $employe, EntityManagerInterface $manager)
    {

        $manager->remove($employe);
        $manager->flush();
        return $this->redirectToRoute('liste_employes');
    }


}
