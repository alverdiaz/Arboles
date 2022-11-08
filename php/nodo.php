<?php
class Nodo
{
    private $info;
    private $I; //Hijo izquierdo
    private $D; //Hijo derecho

    public function __construct($info)
    {
        $this->info = $info;
        $this->I = null;
        $this->D = null;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function getI()
    {
        return $this->I;
    }

    public function setI($I)
    {
        $this->I = $I;
    }

    public function getD()
    {
        return $this->D;
    }

    public function setD($D)
    {
        $this->D = $D;
    }

    public function __toString()
    {
        return strval($this->info);
    }
}
