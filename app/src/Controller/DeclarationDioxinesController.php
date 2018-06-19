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
        // This method (especially, others are no better) is terrible and should be split ASAP
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationIncinerateur = $this->createDeclarationDioxine();

        $formFactory = $this->get('form.factory');

        $formBuilderDeclarationIncinerateur = $formFactory->createBuilder(
            DeclarationDioxineType::class,
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

            $this->addFlash(
                'declaration',
                $declaration->getId()
            );            

            return $response->send();
        }

        return $this->render("owner/declaration-dioxines.html.twig", [
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
        ]);
    }

    private function createDeclarationDioxine(){
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationDioxines = new DeclarationDioxine();

        foreach($mainIncinerateur->getLignes() as $currLine)
        {
            $mesureDioxine = new MesureDioxine();
            $mesureDioxine->setLigne($currLine);
            $declarationDioxines->addMesuresDioxines($mesureDioxine);
        }

        return $declarationDioxines;
    }


    public function modify(Request $request){
        
    }


    public function review($declarationId){
        
    }


    public function validate($declarationId){
        
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