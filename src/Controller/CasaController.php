<?php

namespace App\Controller;


use App\Entity\Casa;
use App\Entity\Borrar;
use App\Form\CasaFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  #[Route('/casas')]
final class CasaController extends AbstractController
{


 #[Route('/lista_casa', name: 'lista_casas')]
    public function index(ManagerRegistry $doctrine): Response {
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $casas = $doctrine->getRepository(Casa::class)->findAll();
        return $this->render('casa/lista_casas.html.twig', ['casas' => $casas]);
    }


//---------------------------------------------------------------------------------------BORRAR CASA
#[Route('/casas/borrar/{id}', name: 'borrar_casa', methods: ['POST'])]
    public function borrar(Casa $casa, ManagerRegistry $doctrine): Response
    {
        // Requiere que el usuario esté autenticado
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Eliminar la casa
        $entityManager = $doctrine->getManager();
        $entityManager->remove($casa);
        $entityManager->flush();

        // Mensaje flash de confirmación
        $this->addFlash('success', 'La casa ha sido eliminada correctamente.');

        // Redirigir al listado
        return $this->redirectToRoute('lista_casas');
    }
    

//-------------------------------------------------------------------------------------------AÑADIR CASAS
    #[Route('/nueva', name: 'nueva_casa')]
    public function nueva(Request $request, ManagerRegistry $doctrine): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $casa = new Casa();
        $form = $this->createForm(CasaFormType::class, $casa);
        $form->handleRequest($request);
        //dump($casa);
        //exit;
        if ($form->isSubmitted() && $form->isValid() && $form->get('guardar')->isClicked()) {
            $em = $doctrine->getManager();
            $em->persist($casa);
            $em->flush();
            return $this->redirectToRoute('lista_casas');
        }

        return $this->render('casa/form.html.twig', ['form' => $form->createView()]);
    }
//--------------------------------------------------------------------------------------------------------Editar CASAS

#[Route('/{id}', name: 'detalle_casa')]
public function detalle(Request $request, Casa $casa, ManagerRegistry $doctrine): Response {
     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $form = $this->createForm(CasaFormType::class, $casa);
    $form->handleRequest($request);

    $em = $doctrine->getManager();

    if ($form->isSubmitted() && $form->get('guardar')->isClicked() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'Casa actualizada');
        return $this->redirectToRoute('lista_casas');
    }

    return $this->render('casa/detalle.html.twig', [
        'form' => $form->createView(),
        'casa' => $casa
    ]);
}
}