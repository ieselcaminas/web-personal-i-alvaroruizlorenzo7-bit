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

 #[Route('/', name: 'home')]
        public function redirigirAlLogin(): Response
        {
             return $this->redirectToRoute('app_login');
        }


}
