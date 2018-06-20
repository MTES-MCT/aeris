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

class DeclarationDioxinesController extends AerisController
{
    public function declarer()
    {
        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        $request = Request::createFromGlobals();
        // This method (especially, others are no better) is terrible and should be split ASAP
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationDioxines = $this->createDeclarationDioxine();
        $form = $this->createDeclarationForm(
            $declarationDioxines,
            $request
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $declaration = $form->getData();

            $declaration->setIncinerateur($mainIncinerateur);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($declaration);
            $entityManager->flush();

            $response = new RedirectResponse($this->generateUrl('route_review_declaration_dioxines', [
                'declarationId' => $declaration->getId()
            ]));
            $response->prepare($request);

            return $response->send();
        }

        return $this->render("dioxines/declaration.html.twig", [
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
        ]);
    }

    public function modify(Request $request){
        $declarationId = $request->get('declarationId');

        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationDioxines = $this->getDoctrine()
            ->getRepository(DeclarationDioxine::class)
            ->find($declarationId);

        if (!$declarationDioxines) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        $form = $this->createDeclarationForm(
            $declarationDioxines,
            $request
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $declaration = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($declaration);
            $entityManager->flush();

            $response = new RedirectResponse($this->generateUrl('route_review_declaration_dioxines', [
                'declarationId' => $declaration->getId()
            ]));
            $response->prepare($request);

            return $response->send();
        }

        return $this->render("dioxines/declaration.html.twig", [
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
        ]);
    }

    private function createDeclarationForm($declaration, $request){
        $formFactory = $this->get('form.factory');

        $formBuilderDeclarationIncinerateur = $formFactory->createBuilder(
            DeclarationDioxineType::class,
            $declaration
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
            ->getRepository(DeclarationDioxine::class)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }

        return $this->render("dioxines/review.html.twig", [
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
            ->getRepository(DeclarationDioxine::class)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        
        $declaration->setStatus(DeclarationDioxine::STATUS_VALIDATED);    
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($declaration);
        $entityManager->flush();

        /*
        $mailFactory = $this->get('app.mailfactory');
        $message = $mailFactory->createNewDeclarationInspecteurMessage($declaration->getId());
        $mailService = $this->get('app.mailservice');
        $mailService->send($message);
        */

        return $this->render("dioxines/validate.html.twig", [
            'incinerateur' =>  $mainIncinerateur,
            'declaration' =>  $declaration,
        ]);
    }

    public function compteRendu($declarationId)
    {
        return $this->generateCRIfAllowed(
            $declarationId,
            DeclarationDioxine::class,
            "dioxines/compte-rendu-declaration-dioxine.html.twig"
        );
    }

    private function generateCRIfAllowed(
        $declarationId,
        $type,
        $template)
    {
        $declaration = $this->getDoctrine()
            ->getRepository($type)
            ->find($declarationId);

        if (!$declaration) {
            throw $this->createNotFoundException(
                "Pas de declaration pour l' id ".$declarationId
            );
        }
        if(!$this->get('app.security.helper')->canAccessIncinerateur($declaration->getIncinerateur())) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        return $this->render($template, [
            'declaration' => $declaration
        ]);
    }

    private function createDeclarationDioxine(){
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationDioxines = new DeclarationDioxine();

        foreach($mainIncinerateur->getLignes() as $currLine) {
            $mesureDioxine = new MesureDioxine();
            $mesureDioxine->setLigne($currLine);
            $declarationDioxines->addMesuresDioxines($mesureDioxine);
        }

        return $declarationDioxines;
    }
} 