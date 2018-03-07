<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Person;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CrudController extends Controller
{
    public function index(Request $request)
    {

    $people = $this->getDoctrine()
        ->getRepository(Person::class)
        ->findAll();

    if (!$people) {
        throw $this->createNotFoundException(
            'No users found'
        );
    }
	$person = new Person();
        $form = $this->createFormBuilder($person)
        ->add('username', TextType::class, array('attr' => array(
				'placeholder' => 'Username',
			),'label' => false)
		)
        ->add('mail', TextType::class, array('attr' => array(
				'placeholder' => 'Email',
			),'label' => false)
		)
        ->add('firstName', TextType::class, array('attr' => array(
            'placeholder' => 'First name',
			),'label' => false)
		)
		->add('lastName', TextType::class, array('attr' => array(
            'placeholder' => 'Last name',
			),'label' => false)
		)
		
        ->add('save', SubmitType::class, array('label' => 'Save'))
        ->getForm();
		
		$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($person);
            $entityManager->flush();
			return $this->redirectToRoute('app_crud');
		}
	
		return $this->render('crud\crud.html.twig', 
			array('users' => $people, 'form' => $form->createView()
		));
	}
}