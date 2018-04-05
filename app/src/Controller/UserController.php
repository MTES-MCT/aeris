<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function dashboard()
    {
        $authChecker = $this->get('security.authorization_checker'); 
        if ($authChecker->isGranted('ROLE_INSPECTEUR')) {
            return $this->redirect($this->generateUrl("route_dashboard_inspecteur"));
        }
        return $this->redirect($this->generateUrl("route_dashboard_owner"));
    }
} 