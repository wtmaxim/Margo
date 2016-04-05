<?php

namespace Margo\Entity;

/**
 * Created by PhpStorm.
 * User: Dinam
 * Date: 05-Apr-16
 * Time: 2:56 PM
 */
class Teacher
{
    private $teacherId;
    private $teacherName;
    private $teacherFirstName;

    /**
     * Teacher constructor.
     * @param $teacherId
     * @param $teacherName
     * @param $teacherFirstName
     */
    public function __construct($teacherId, $teacherName, $teacherFirstName)
    {
        $this->teacherId = $teacherId;
        $this->teacherName = $teacherName;
        $this->teacherFirstName = $teacherFirstName;
    }

    /**
     * @return mixed
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param mixed $teacherId
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    /**
     * @return mixed
     */
    public function getTeacherName()
    {
        return $this->teacherName;
    }

    /**
     * @param mixed $teacherName
     */
    public function setTeacherName($teacherName)
    {
        $this->teacherName = $teacherName;
    }

    /**
     * @return mixed
     */
    public function getTeacherFirstName()
    {
        return $this->teacherFirstName;
    }

    /**
     * @param mixed $teacherFirstName
     */
    public function setTeacherFirstName($teacherFirstName)
    {
        $this->teacherFirstName = $teacherFirstName;
    }



}