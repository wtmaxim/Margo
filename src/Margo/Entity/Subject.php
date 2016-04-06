<?php
/**
 * Created by PhpStorm.
 * User: Dinam
 * Date: 06-Apr-16
 * Time: 6:47 PM
 */
class Subject
{
    private $idSubject;
    private $nameSubject;
    private $timeVolume;
    private $coefficient;

    /**
     * Subject constructor.
     * @param $idSubject
     * @param $timeVolume
     * @param $nameSubject
     * @param $coefficient
     */
    public function __construct($idSubject, $timeVolume, $nameSubject, $coefficient)
    {
        $this->idSubject = $idSubject;
        $this->timeVolume = $timeVolume;
        $this->nameSubject = $nameSubject;
        $this->coefficient = $coefficient;
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


}