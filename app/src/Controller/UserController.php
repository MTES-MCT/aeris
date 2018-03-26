<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function dashboard()
    {
        return $this->render("inside/dashboard.html.twig");
    }

    public function declaration()
    {
        return $this->render("inside/declaration.html.twig");
    }

    public function cr()
    {
        return $this->render("inside/cr.html");
    }
} 