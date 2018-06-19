<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationDechets;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\DeclarationDioxine;
use App\Entity\Declaration\DeclarationFonctionnementLigne;
use App\Entity\Declaration\MesureDioxine;
use App\Form\DeclarationDioxineType;
use App\Form\DeclarationIncinerateurType;
use App\Form\DeclarationFonctionnementLigneType;
use App\Form\DeclarationDechetsType;
use App\Form\MesureDioxineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Aeris\Component\Report\AppliableRules;
use Aeris\Component\Report\MonthlyReport;

class DeclarationMesuresContinuesController extends AerisController
{
    public function declare(Request $request)
    {
        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        $declarationIncinerateur = $this->createDeclarationMesuresContinues();
        $mainIncinerateur = $this->getMainIncinerateur();

        $form = $this->createDeclarationForm(
            $declarationIncinerateur,
            $request
        );       

        if ($form->isSubmitted() && $form->isValid()) {
            $declaration = $form->getData();

            $declaration->setIncinerateur($mainIncinerateur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($declaration);
            $entityManager->flush();

            $response = new RedirectResponse($this->generateUrl('route_review_declaration_mesures_continues', [
                'declarationId' => $declaration->getId()
            ]));
            $response->prepare($request);

            return $response->send();
        }

        return $this->render("owner/declaration-mesures-continues.html.twig", [
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
        ]);
    }


    public function modify(Request $request){
        $declarationId = $request->get('declarationId');

        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        $declarationIncinerateur = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class)
            ->find($declarationId);

        if (!$declarationIncinerateur) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }

        $mainIncinerateur = $this->getMainIncinerateur();

        $form = $this->createDeclarationForm(
            $declarationIncinerateur,
            $request
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $declaration = $form->getData();

            $declaration->setIncinerateur($mainIncinerateur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($declaration);
            $entityManager->flush();

            $response = new RedirectResponse($this->generateUrl('route_review_declaration_mesures_continues', [
                'declarationId' => $declaration->getId()
            ]));
            $response->prepare($request);

            return $response->send();
        }

        return $this->render("owner/declaration-mesures-continues.html.twig", [
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
        ]);
    }

    private function createDeclarationForm(
        DeclarationIncinerateur $declarationIncinerateur,
        Request $request
    ){
        $formFactory = $this->get('form.factory');

        $formBuilderDeclarationIncinerateur = $formFactory->createBuilder(
            DeclarationIncinerateurType::class,
            $declarationIncinerateur
        );
        $form = $formBuilderDeclarationIncinerateur->getForm();

        $form->handleRequest($request);
        return $form;
    }

    public function review($declarationId){
        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        $mainIncinerateur = $this->getMainIncinerateur();
        $declaration = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }

        return $this->render("owner/review-declaration-mesures-continues.html.twig", [
            'incinerateur' =>  $mainIncinerateur,
            'declaration' =>  $declaration,
        ]);
    }


    public function validate($declarationId){
        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        $mainIncinerateur = $this->getMainIncinerateur();
        $declaration = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        
        /*
        if ($declaration->getMethodeDeclaration() === DeclarationIncinerateur::METHOD_DREAL) {
            $this->get('app.services.declaration_importer')->loadDeclaration($declaration);
        }

        $this->addFlash(
            'declaration',
            $declaration->getId()
        );

        $mailFactory = $this->get('app.mailfactory');
        $message = $mailFactory->createNewDeclarationInspecteurMessage($declaration->getId());
        $mailService = $this->get('app.mailservice');
        $mailService->send($message);
        */

        return $this->render("owner/validate-declaration-mesures-continues.html.twig", [
            'incinerateur' =>  $mainIncinerateur,
            'declaration' =>  $declaration,
        ]);
    }

    private function createDeclarationMesuresContinues(){
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationIncinerateur = new DeclarationIncinerateur();

        foreach($mainIncinerateur->getLignes() as $currLine)
        {
            $fonctionnementLigne = new DeclarationFonctionnementLigne();
            $fonctionnementLigne->setLigne($currLine);
            $declarationIncinerateur->addDeclarationFonctionnementLigne($fonctionnementLigne);
        }

        return $declarationIncinerateur;
    }

    public function compteRendu($declarationId)
    {
        $declaration = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        if(!$this->get('app.security.helper')->canAccessIncinerateur($declaration->getIncinerateur())) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        $rules = new AppliableRules();

        $reports = [];
        foreach($declaration->getDeclarationsFonctionnementLigne() as $declarationLigne) {
            $report = new MonthlyReport($declaration->getDeclarationMonth(), $rules);
            $report->fillWithMeasures($declarationLigne->getMesures());
        
            $reports[$declarationLigne->getLigne()->getNumero()] = $report;
        }

        return $this->render("user/compte-rendu-declaration.html.twig", [
            'declaration' => $declaration,
            'reports' => $reports,
        ]);
    }
} 