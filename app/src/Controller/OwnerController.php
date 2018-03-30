<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\MesureDioxine;
use App\Form\DeclarationIncinerateurType;
use App\Form\MesureDioxineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OwnerController extends AerisController
{
    public function downloadDeclarationTemplate()
    {
        $filename = 'modele-declaration.xls';
        $path = $this->get('kernel')->getRootDir().
        '/../public/build/static/';

        return $this->downloadFileByPath($path, $filename);
    }

    public function soumettreDeclaration()
    {
        
    }

    public function declaration()
    {
        $formFactory = $this->get('form.factory');
        $formBuilderDeclarationIncinerateur = $formFactory->createBuilder(DeclarationIncinerateurType::class
        );
        $form = $formBuilderDeclarationIncinerateur->getForm();


        $formBuilderMesureDioxine = $formFactory->createBuilder(MesureDioxineType::class
        );
        $formMesureDioxine = $formBuilderMesureDioxine->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mainIncinerateur = $this->getMainIncinerateur();
            $declaration = $form->getData();

            $declaration->setIncinerateur($mainIncinerateur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($declaration);
            $entityManager->flush();

            $response = new RedirectResponse($this->generateUrl('route_history', [
                'incinerateurId' => $mainIncinerateur->getId()
            ]));
            $response->prepare($request);

            return $response->send();
        }

        return $this->render("owner/declaration.html.twig", [
            'form' => $form->createView(),
            'form_mesure_dioxine' =>  $formMesureDioxine->createView()
        ]);
    }
} 