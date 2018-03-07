<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Person;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CrudController extends Controller {
    public function index(Request $request) {
		$people = $this->getDoctrine()
			->getRepository(Person::class)
			->findAll();
		
		$person = new Person();
        $form = $this->createFormBuilder($person)
        ->add('username', TextType::class, array('attr' => array(
				'placeholder' => 'Username',
				'required' => true,
			),'label' => false)
		)
        ->add('mail', EmailType::class, array('attr' => array(
				'placeholder' => 'Email',
			),'label' => false)
		)
        ->add('firstName', TextType::class, array('attr' => array(
            'placeholder' => 'First name',
			'required' => true,
			),'label' => false)
		)
		->add('lastName', TextType::class, array('attr' => array(
            'placeholder' => 'Last name',
			'required' => true,
			),'label' => false)
		)
		
        ->add('save', SubmitType::class, array('attr' => array(
			'class' => 'btn btn-success'
			),'label' => 'Save'))
		
        ->getForm();
		
		$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($person);
            $entityManager->flush();
			return $this->redirectToRoute('app_crud');
		}
		
		if (!$people) {
			return $this->render('crud\empty.html.twig', array('users' => 'No users were found, create a new one:', 'form' => $form->createView()
			));
		}
	
		return $this->render('crud\crud.html.twig', 
			array('users' => $people, 'form' => $form->createView()
		));
	}
	public function delete($slug) {
		$person = $this->getDoctrine()
			->getRepository(Person::class)
			->findOneById($slug);

		if (!$person) {
			return $this->render('crud\notFound.html.twig', array('users' => 'User not found'));
		}
		
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($person);
		$entityManager->flush();
		return $this->redirectToRoute('app_crud');
	}
	
	public function update(Request $request, $slug) {
		$person = $this->getDoctrine()
			->getRepository(Person::class)
			->findOneById($slug);

		if (!$person) {
			return $this->render('crud\notFound.html.twig', array('users' => 'User not found, no changes were made'));
		}
		
        $updateForm = $this->createFormBuilder($person)
        ->add('username', TextType::class, array('attr' => array(
				'placeholder' => $person->getUsername(),
				'required' => true,
			),'label' => false)
		)
        ->add('mail', EmailType::class, array('attr' => array(
				'placeholder' => $person->getMail(),
			),'label' => false)
		)
        ->add('firstName', TextType::class, array('attr' => array(
            'placeholder' => $person->getFirstName(),
			'required' => true,
			),'label' => false)
		)
		->add('lastName', TextType::class, array('attr' => array(
            'placeholder' => $person->getLastName(),
			'required' => true,
			),'label' => false)
		)
		
        ->add('save', SubmitType::class, array('attr' => array(
			'class' => 'btn btn-success'
			),'label' => 'Save'))
        
		->getForm();
		
		$updateForm->handleRequest($request);
        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
			return $this->redirectToRoute('app_crud');
		}
		
		return $this->render('crud\update.html.twig', 
			array('updateForm' => $updateForm->createView()
		));
	}
}