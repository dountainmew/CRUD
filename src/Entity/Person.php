<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
	
	/**
     * @ORM\Column(type="string", length=100)
	 * @Assert\Type(
     *     type="alpha",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
	private $username;
	
	/**
     * @ORM\Column(type="string", length=100)
	 * @Assert\Type(
     *     type="alpha",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
	private $firstName;
	
	/**
     * @ORM\Column(type="string", length=100)
	 * @Assert\Type(
     *     type="alpha",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
	private $lastName;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
	private $mail;
	
	public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }
	
	public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
	
	public function getLastName()
    {
        return $this->lastName;
    }
	
	public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }
	
	public function getMail()
    {
        return $this->mail;
    }
    
}

