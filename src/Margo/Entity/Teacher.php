<?php

namespace Margo\Entity;

class Teacher
{
    private $id;
    private $firstName;
    private $name;
    private $idSubject;

    /**
     * Teacher constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getIdSubject()
    {
        return $this->idSubject;
    }

    /**
     * @param mixed $idSubject
     */
    public function setIdSubject($idSubject)
    {
        $this->idSubject = $idSubject;
    }


}