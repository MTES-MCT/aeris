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
} 