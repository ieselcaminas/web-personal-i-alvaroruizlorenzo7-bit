<?php

namespace App\Controller;

use App\Entity\Casa;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IndexController extends AbstractController
{
//-----------------------------------------------------------------------------------------LISTADO DE CASAS
    #[Route('/', name: 'lista_casas')]
    public function index(ManagerRegistry $doctrine): Response {
       // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $casas = $doctrine->getRepository(Casa::class)->findAll();
        return $this->render('casa/lista_casas.html.twig', ['casas' => $casas]);
    }
}
