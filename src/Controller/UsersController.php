<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\InscriptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController
{
    #[Route('profile/user_account', name: 'app_user_account')]
    public function index(UsersRepository $usersRepository): Response
    {
        $connectedUser=$this->getUser();
        $users = $usersRepository->findAll();
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'users' => $users,
            'connectedUser' => $connectedUser,
        ]);

}
}