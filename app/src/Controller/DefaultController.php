<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function hello()
    {
        /*
        CREATE TABLE public.test
        (
        plop integer
        )
        WITH (
        OIDS=FALSE
        );
        ALTER TABLE public.test
        OWNER TO symfony;
        insert into test (plop) values (42);
        insert into test (plop) values (23);
        */
        $sql = "select plop from test;";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        var_dump($data);

        return $this->render("hello.html.twig");
    }

    public function index()
    {
        return $this->render("index.html.twig");
    }
} 