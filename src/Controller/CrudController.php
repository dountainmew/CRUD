<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CrudController extends Controller
{
    public function number()
    {
        $number = mt_rand(0, 100);

        return $this->render('crud/crud.html.twig', array(
            'number' => $number,
		));
    }
}