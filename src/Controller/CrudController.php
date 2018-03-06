<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Driver\Connection;

class CrudController extends Controller
{
    public function indexAction(Connection $connection)
    {
		$users = $connection->fetchAll('SELECT * FROM users');
		return $this->render('crud\crud.html.twig', array('users' => $users));
    }
	
}