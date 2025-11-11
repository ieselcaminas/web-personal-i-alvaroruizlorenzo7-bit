<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
class UsuarioController extends AbstractController
{
   
   #[Route('/crear-usuario', name: 'crear_usuario')]
public function crearUsuario(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
{
    $usuario = new Usuario();

    $form = $this->createFormBuilder($usuario)
        ->add('yes', EmailType::class, ['label' => 'Correo electrónico'])
        ->add('password', PasswordType::class, ['label' => 'Contraseña'])
        ->add('crear', SubmitType::class, ['label' => 'Crear usuario'])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $usuario->setPassword($passwordHasher->hashPassword($usuario, $usuario->getPassword()));
        $usuario->setRoles(['ROLE_USER']);

        $em = $doctrine->getManager();
        $em->persist($usuario);
        $em->flush();

        $this->addFlash('success', '✅ Usuario creado correctamente');
        return $this->redirectToRoute('crear_usuario');
    }

    return $this->render('usuario/crear.html.twig', [
        'formulario' => $form->createView(),
    ]);
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




















   