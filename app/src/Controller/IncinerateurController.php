<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\DeclarationDioxine;

class IncinerateurController extends AerisController
{
    public function historique($incinerateurId)
    {
        $incinerateur = $this->getDoctrine()
            ->getRepository(Incinerateur::class)
            ->find($incinerateurId);

        if (!$incinerateur) {
            throw $this->createNotFoundException(
                "Pas d'incinerateur pour l' id ".$incinerateurId
            );
        }
        if(!$this->get('app.security.helper')->canAccessIncinerateur($incinerateur)) {
            return $this->redirect($this->generateUrl("route_index"));
        }
        $declarations = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class)
            ->findValidatedDeclarations($incinerateur);
        $declarationsDioxines = $this->getDoctrine()
            ->getRepository(DeclarationDioxine::class)
            ->findValidatedDeclarations($incinerateur);

        return $this->render("user/historique.html.twig", [
            'incinerateur' =>  $incinerateur,
            'declarations' =>  $declarations,
            'declarationsDioxines' =>  $declarationsDioxines,
        ]);
    }
} 