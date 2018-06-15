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

class OwnerController extends AerisController
{
    public function downloadDeclarationTemplate()
    {
        $filename = 'modele-declaration.xls';
        $path = $this->get('kernel')->getRootDir().
        '/../public/build/static/';

        return $this->downloadFileByPath($path, $filename);
    }

    // Clearly not the best way to have a list of downloadable files, but also a quick and safe one...
    public function downloadAsset(Request $request) {
        $downloadableAssets = [
            'modele_saisie_compteurs.xls',
            'modele_saisie_flux.xls',
            'modele_saisie_concentrations.xls',
            'referentiel-parametres.xlsx',
        ];

        $asset = $request->get('asset', '');

        if(in_array($asset, $downloadableAssets)) {
            $path = $this->get('kernel')->getRootDir().
            '/../public/build/static/modeles/';

            return $this->downloadFileByPath($path, $asset);
        }
        throw $this->createNotFoundException(
            "Le fichier $asset n'est pas disponible"
        );
    }

    public function declarationChoice(){
        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }

        return $this->render("owner/declaration.html.twig", []);
    }

    public function declarationDioxines()
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
    public function declarationMesuresContinues()
    {
        if(!$this->get('app.security.helper')->isOwner()){
            return $this->redirect($this->generateUrl("route_index"));
        }
        // This method (especially, others are no better) is terrible and should be split ASAP
        $mainIncinerateur = $this->getMainIncinerateur();
        $declarationIncinerateur = $this->createDeclarationMesuresContinues();

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

            return $response->send();
        }

        return $this->render("owner/declaration-mesures-continues.html.twig", [
            'mainIncinerateur' => $mainIncinerateur,
            'form' => $form->createView()
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
} 