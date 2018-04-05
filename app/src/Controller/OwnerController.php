<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationDechets;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\MesureDioxine;
use App\Form\DeclarationIncinerateurType;
use App\Form\DeclarationFonctionnementLigneType;
use App\Form\DeclarationDechetsType;
use App\Form\MesureDioxineType;
use App\Form\DeclarationFonctionnementLigne;
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

    private function createDeclaration(){
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationIncinerateur = new DeclarationIncinerateur();

        foreach($mainIncinerateur->getLignes() as $currLine) {
            $mesureDioxine = new MesureDioxine();
            $mesureDioxine->setLigne($currLine);
            $declarationIncinerateur->addMesuresDioxines($mesureDioxine);
        }

        return $declarationIncinerateur;
    }

    public function declaration()
    {
        // This method (especially, others are no better) is terrible and should be split ASAP
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationIncinerateur = $this->createDeclaration();

        $formFactory = $this->get('form.factory');

        $formBuilderDeclarationIncinerateur = $formFactory->createBuilder(
            DeclarationIncinerateurType::class,
            $declarationIncinerateur
        );
        $form = $formBuilderDeclarationIncinerateur->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
        ]);
    }

    public function declarationPOC()
    {
        $mainIncinerateur = $this->getMainIncinerateur();

        $formFactory = $this->get('form.factory');

        $formBuilderDeclarationIncinerateur = $formFactory->createBuilder(DeclarationIncinerateurType::class
        );
        $form = $formBuilderDeclarationIncinerateur->getForm();

        $formBuilderDeclarationFonctionnementLigne = $formFactory->createBuilder(DeclarationFonctionnementLigneType::class
        );
        $formDeclarationFonctionnementLigne = $formBuilderDeclarationFonctionnementLigne->getForm();


        $formBuilderMesureDioxine = $formFactory->createBuilder(MesureDioxineType::class
        );
        $formMesureDioxine = $formBuilderMesureDioxine->getForm();


        $formBuilderDeclarationDechets = $formFactory->createBuilder(DeclarationDechetsType::class
        );
        $formDeclarationDechets = $formBuilderDeclarationDechets->getForm();


        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
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
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView(),
            'form_mesure_dioxine' =>  $formMesureDioxine->createView(),
            'form_declaration_dechets' =>  $formDeclarationDechets->createView(),
            'form_declaration_fonctionnement_ligne' =>  $formDeclarationFonctionnementLigne->createView()
        ]);
    }

    public function dashboard(){
        $mainIncinerateur = $this->getMainIncinerateur();
        $dioxines = [];
        foreach($mainIncinerateur->getLignes() as $currLine) {
            $dioxines[$currLine->getNumero()] = [];
        }


        foreach ($mainIncinerateur->getDeclarationsIncinerateur() as $declaration) {

           $declarationsDioxines = $declaration->getMesuresDioxine();
           if ($declarationsDioxines) {
            foreach ($declarationsDioxines as $currDeclarationDioxines) {
                $ligne = $currDeclarationDioxines->getLigne();
                if ($ligne != null) {
                    $result = [
                        'numeroLigne' =>  $ligne->getNumero(),
                        'debut' => $currDeclarationDioxines->getDateDebut(),
                        'fin' => $currDeclarationDioxines->getDateFin(),
                        'disponibiliteLigne' =>  $currDeclarationDioxines->getDisponibiliteLigne(),
                        'disponibiliteAnalyseur' =>  $currDeclarationDioxines->getDisponibiliteAnalyseur(),
                        'concentration' =>  $currDeclarationDioxines->getConcentration(),
                    ];
                    array_push($dioxines[$ligne->getNumero()], $result);
                }
            }
           }
        }




        return $this->render("owner/dashboard.html.twig", [
            'dioxines' => $dioxines,
            'mainIncinerateur' =>  $mainIncinerateur
        ]);
    }
} 