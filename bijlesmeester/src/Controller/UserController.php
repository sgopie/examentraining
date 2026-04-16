<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user/overview', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $search = $request->query->get('search');
        $role = $request->query->get('role');

        $repo = $entityManager->getRepository(User::class);

        $qb = $repo->createQueryBuilder('u');

        if ($search) {
            $qb->andWhere('u.email LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($role) {
            $qb->andWhere('u.roles LIKE :role')
                ->setParameter('role', '%' . $role . '%');
        }

        $users = $qb->getQuery()->getResult();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/user/read/{user}', name:'app_user_read')]
    public function readUser(User $user):response
    {

        return $this->render('user/read.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/edit/{user}', name:'app_user_edit')]
    public function editUser(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'User succesvol aangepast');

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/edit.html.twig', [
            'editForm' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/user/delete/{user}', name: 'app_user_delete', methods: ['POST'])]
    public function deleteUser(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete_user_'.$user->getId(), $request->request->get('_token'))) {

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user');
    }
}
