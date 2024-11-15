<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LoansRepository;

class LoansController extends AbstractController
{
    #[Route('profile/loans', name: 'app_loans')]
    public function index(LoansRepository $loansRepository): Response
    {
        $loans = $loansRepository->findAll();
        return $this->render('loans/index.html.twig', [
            'controller_name' => 'LoansController',
            'loans' => $loans,
        ]);
    }
}
