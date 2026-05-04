<?php

namespace App\Controller;

use App\Entity\Subjects;
use App\Form\AddSubjectFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/subject/overview', name: 'app_subjects')]
    public function subjectOverview(EntityManagerInterface $entityManager): response
    {
        $subjects = $entityManager->getRepository(Subjects::class)->findAll();

        return $this->render('home/subject-overview.html.twig',[
            'subjects' => $subjects
        ]);
    }

    #[Route('/add/subject/student', name: 'app_add_subject')]
    public function addSubjectToStudent(EntityManagerInterface $entityManager, Request $request,): response
    {
        $form = $this->createForm(AddSubjectFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $form->getData();
            $entityManager->persist($subject);
            $entityManager->flush();

            $this->addFlash('success', 'student is toegevoegd aan vak');

            return $this->redirectToRoute('app_subjects');
        }

        return $this->render('home/subject_student.html.twig',[
            'form' => $form,
        ]);
    }
}
