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

        return $this->render("owner/choix-type-declaration.html.twig", []);
    }
} 