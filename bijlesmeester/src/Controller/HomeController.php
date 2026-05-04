<?php

namespace App\Controller;

use App\Entity\Subjects;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/add/subject/student/{id}', name: 'app_add_subject')]
    public function addSubjectToStudent(EntityManagerInterface $entityManager, id $id): response
    {
        return $this->render('home/subject_student.html.twig');
    }

    #[Route('/subject/overview', name: 'app_subjects')]
    public function subjectOverview(EntityManagerInterface $entityManager): response
    {
        $subjects = $entityManager->getRepository(Subjects::class)->findAll();

        return $this->render('home/subject-overview.html.twig',[
            'subjects' => $subjects
        ]);
    }
}
