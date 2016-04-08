<?php

namespace Margo\Entity;

class Teacher
{
    private $teacherId;
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
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param mixed $id
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
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