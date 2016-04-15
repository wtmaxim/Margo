<?php
/**
 * Created by PhpStorm.
 * User: Dinam
 * Date: 06-Apr-16
 * Time: 6:47 PM
 */
namespace Margo\Entity;

class Subject
{
    private $idSubject;
    private $nameSubject;
    private $timeVolume;
    private $coefficient;
    private $category;
    private $teacher;

    /**
     * Subject constructor.
     * @param $idSubject
     * @param $timeVolume
     * @param $nameSubject
     * @param $coefficient
     */

    public function __construct()
    {

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

    /**
     * @return mixed
     */
    public function getNameSubject()
    {
        return $this->nameSubject;
    }

    /**
     * @param mixed $nameSubject
     */
    public function setNameSubject($nameSubject)
    {
        $this->nameSubject = $nameSubject;
    }

    /**
     * @return mixed
     */
    public function getTimeVolume()
    {
        return $this->timeVolume;
    }

    /**
     * @param mixed $timeVolume
     */
    public function setTimeVolume($timeVolume)
    {
        $this->timeVolume = $timeVolume;
    }

    /**
     * @return mixed
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * @param mixed $coefficient
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;
    }

    /**
     * @param mixed $idCategory
     */

    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $Category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

}