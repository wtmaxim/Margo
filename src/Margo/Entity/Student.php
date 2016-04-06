<?php

namespace Margo\Entity;

/**
 * Created by PhpStorm.
 * User: Dinam
 * Date: 05-Apr-16
 * Time: 2:45 PM
 */
class Student
{
    private $studentId;
    private $name;
    private $firstName;
    private $idCategory;

    /**
     * Student constructor.
     * @param $name
     * @param $studentId
     * @param $firstName
     * @param $category
     */
    public function __construct($name, $studentId, $firstName, $idCategory)
    {
        $this->name = $name;
        $this->studentId = $studentId;
        $this->firstName = $firstName;
        $this->idCategory = $idCategory;
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
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param mixed $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
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
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * @param mixed $idCategory
     */
    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;
    }



}