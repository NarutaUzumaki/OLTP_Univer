<?php
/**
 * @Entity @Table(name="automobiles")
 **/

class Automobile{
    /** @Id @Column(name="code", type="integer") @GeneratedValue */
    protected $code;
    /** @Column(type="integer") */
    protected $number;
    /** @Column(type="integer") */
    protected $pass_place_count;
    /** @Column(type="integer") */
    protected $code_owner;
    /** @Column(type="integer") */
    protected $code_park;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getPassPlaceCount()
    {
        return $this->pass_place_count;
    }

    /**
     * @return mixed
     */
    public function getCodeOwner()
    {
        return $this->code_owner;
    }

    /**
     * @return mixed
     */
    public function getCodePark()
    {
        return $this->code_park;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param mixed $pass_place_count
     */
    public function setPassPlaceCount($pass_place_count)
    {
        $this->pass_place_count = $pass_place_count;
    }

    /**
     * @param mixed $code_owner
     */
    public function setCodeOwner($code_owner)
    {
        $this->code_owner = $code_owner;
    }

    /**
     * @param mixed $code_park
     */
    public function setCodePark($code_park)
    {
        $this->code_park = $code_park;
    }
}