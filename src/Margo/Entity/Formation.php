<?php
namespace Margo\Entity;
/**
 * Created by PhpStorm.
 * User: Dinam
 * Date: 06-Apr-16
 * Time: 6:51 PM
 */
class Formation
{
    private $idFormation;
    private $nameFormation;

    /**
     * Formation constructor.
     * @param $idFormation
     * @param $nameFormation
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getNameFormation()
    {
        return $this->nameFormation;
    }

    /**
     * @param mixed $nameFormation
     */
    public function setNameFormation($nameFormation)
    {
        $this->nameFormation = $nameFormation;
    }

    /**
     * @return mixed
     */
    public function getIdFormation()
    {
        return $this->idFormation;
    }

    /**
     * @param mixed $idFormation
     */
    public function setIdFormation($idFormation)
    {
        $this->idFormation = $idFormation;
    }


}