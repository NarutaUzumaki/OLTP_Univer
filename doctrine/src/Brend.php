<?php

/**
 * @Entity @Table(name="brends")
 */
class Brend{
    /** @Id @Column(name="code", type="integer") @GeneratedValue */
    private $code;
    /** @Column(type="integer") */
    private $code_car;
    /** @Column(type="string") */
    private $auto_brend;

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
    public function getCodeCar()
    {
        return $this->code_car;
    }

    /**
     * @return mixed
     */
    public function getAutoBrend()
    {
        return $this->auto_brend;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param mixed $code_car
     */
    public function setCodeCar($code_car)
    {
        $this->code_car = $code_car;
    }

    /**
     * @param mixed $auto_brend
     */
    public function setAutoBrend($auto_brend)
    {
        $this->auto_brend = $auto_brend;
    }
}