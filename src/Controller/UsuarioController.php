<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioController extends AbstractController
{
   
    #[Route('/crear-usuario', name: 'crear_usuario')]
    public function crearUsuario(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
        $usuario = new Usuario();
        $usuario->setYes('alvaro@example.com'); // este campo actúa como identificador
        $usuario->setPassword($passwordHasher->hashPassword($usuario, '123456'));
        $usuario->setRoles(['ROLE_USER']);

        $em = $doctrine->getManager();
        $em->persist($usuario);
        $em->flush();

        return new Response('✅ Usuario creado correctamente');
    }

    #[Route('/usuarios', name: 'listar_usuarios')]
    public function listarUsuarios(ManagerRegistry $doctrine): Response
    {
        $usuarios = $doctrine->getRepository(Usuario::class)->findAll();

    return $this->render('usuario/lista.html.twig', [
        'usuarios' => $usuarios,
    ]);
    }

}




















   