<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;
use App\Entity\Declaration\DeclarationDechets;
use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\MesureDioxine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Aeris\Component\Report\Dashboard\GeneralReport;
use Aeris\Component\Report\Dashboard\LineReport;

class DashboardController extends AerisController
{
    public function dashboard(Request $request)
    {
        $authChecker = $this->get('security.authorization_checker');
        $params = [];
        if ($authChecker->isGranted('ROLE_INSPECTEUR')) {
            return $this->redirect($this->generateUrl("route_liste_incinerateurs", $params));
        }
        $incinerateur = $this->getMainIncinerateur();
        $params['incinerateurId'] = $incinerateur->getId();

        if(!empty($request->get('ligne'))) {
            $params['ligne'] = $request->get('ligne');
            return $this->redirect($this->generateUrl("route_dashboard_incinerateur_ligne", $params));
        }

        return $this->redirect($this->generateUrl("route_dashboard_incinerateur", $params));
    }

    public function dashboard_incinerateur(Request $request, $incinerateurId)
    {
        $incinerateurRepository = $this->getDoctrine()
            ->getRepository(Incinerateur::class);
        $declarationRepository = $this->getDoctrine()
            ->getRepository(DeclarationIncinerateur::class);
        $incinerateur = $incinerateurRepository
            ->find($incinerateurId);

        if (!$incinerateur) {
            throw $this->createNotFoundException(
                "Pas d'incinerateur pour l' id ".$incinerateurId
            );
        }
        if(!$this->get('app.security.helper')->canAccessIncinerateur($incinerateur)) {
            return $this->redirect($this->generateUrl("route_index"));
        }

        $dashboardData = new GeneralReport(
            $declarationRepository,
            $incinerateur
        );

        return $this->render("dashboard/dashboard-incinerateur.html.twig", [
            'incinerateur' =>  $incinerateur,
            'dashboardData' =>  $dashboardData,
            'ligneId' =>  null
        ]
        );
    }

    public function dashboard_ligne(Request $request, $incinerateurId, $ligneId)
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

        $dashboardData = $this->getIncinerateurDashboardData(
            $incinerateur,
            $ligneId
        );

        return $this->render("dashboard/dashboard-line.html.twig", array_merge([
            'incinerateur' =>  $incinerateur
        ], $dashboardData));
    }

    private function getIncinerateurDashboardData(
        $incinerateur,
        $ligneId
    ){
        $dioxines = [];
        $listOfMonths = $this->createListOfMonths();
        $output = [
            'months' =>  [],
            'lines' => []
        ];

        foreach($incinerateur->getLignes() as $currLine) {
            $output['lines'][$currLine->getNumero()] = [];
            $dioxines[$currLine->getNumero()] = [];
        }

        foreach($listOfMonths as $date) {
            $currDate = $date->format("M Y");
            $output['months'][] = $currDate;

            foreach($incinerateur->getLignes() as $currLine) {
                $output['lines'][$currLine->getNumero()][] = 0;
            }
        }

        foreach ($incinerateur->getDeclarationsDioxine() as $declaration) {

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

                    $month = $currDeclarationDioxines->getDateDebut()->format('M Y');
                    $monthIndex = array_search($month, $output['months']);
                    if($monthIndex !== NULL) {
                        $output['lines'][$ligne->getNumero()][$monthIndex] = $currDeclarationDioxines->getConcentration();
                    }
                    array_push($dioxines[$ligne->getNumero()], $result);
                }
            }
           }
        }

        return [
            'ligneId' => $ligneId,
            'dioxineGraphData' => $output,
            'dioxines' => $dioxines,
            'lineReport' => new LineReport($incinerateur, $ligneId),
            'expectedGraphs' => LineReport::graphMapping
        ];
    }

    private function createListOfMonths(){
        $period = new \DatePeriod(
             new \DateTime('-6 months'),
             new \DateInterval('P1M'),
             new \DateTime()
        );

        return $period;
    }
}