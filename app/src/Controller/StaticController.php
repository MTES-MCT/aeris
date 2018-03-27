<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StaticController extends Controller
{
    public function homepage()
    {
        return $this->render("static/homepage.html.twig");
    }
} 