<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $authChecker = $this->get('security.authorization_checker');              
        $params = [];  
        if(!empty($request->get('ligne'))) {
            $params['ligne'] = $request->get('ligne');
        }
        if ($authChecker->isGranted('ROLE_INSPECTEUR')) {
            return $this->redirect($this->generateUrl("route_dashboard_inspecteur", $params));
        }
        return $this->redirect($this->generateUrl("route_dashboard_owner", $params));
    }
} 