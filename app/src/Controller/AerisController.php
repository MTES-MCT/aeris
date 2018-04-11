<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Incinerateur;

class AerisController extends Controller
{
    protected function getMainIncinerateur(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $incinerateurs = $user->getIncinerateurs();
        if(!empty($incinerateurs)) {
            return $incinerateurs[0];
        }
        return null;
    }

    protected function downloadFileByPath($path, $filename) {
        $content = file_get_contents($path.$filename);

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);
        return $response;
    }

    public function getIncinerateurDashboardData($incinerateur){
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

        foreach ($incinerateur->getDeclarationsIncinerateur() as $declaration) {

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
            'output' => $output,
            'dioxines' => $dioxines
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