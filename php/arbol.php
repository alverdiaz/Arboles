<?php
include_once("nodo.php");
class Arbol
{
    private $R; //Nodo raíz

    //$infoR: información del nodo raíz
    public function __construct($infoR)
    {
        if (is_numeric($infoR)) {
            $NR = new Nodo($infoR); //Nodo raíz
            $this->R = $NR;
        }
    }

    //$info: información del nodo a agregar, $infoP: información del nodo padre, $U: ubicación del nodo (Izq o Der)
    public function agregarNodo($info, $infoP, $U)
    {
        if ($this->buscarNodo($info, $this->R) == null) {
            $P = $this->buscarNodo($infoP, $this->R); //Nodo padre
            if ($P != null) {
                $NA = new Nodo($info); //Nodo agregar
                if ($U == "Izq") {
                    if ($P->getI() != null) {
                        $NA->setI($P->getI());
                    }
                    $P->setI($NA);
                    return true;
                } else if ($U == "Der") {
                    if ($P->getD() != null) {
                        $NA->setD($P->getD());
                    }
                    $P->setD($NA);
                    return true;
                }
            }
        }
        return false;
    }

    //$info: información del nodo a eliminar
    public function eliminarNodo($info)
    {
        $NE = $this->buscarNodo($info, $this->R); //Nodo a eliminar
        if ($NE != null) {
            if ($NE->getI() == null && $NE->getD() == null) {
                $NP = $this->buscarPadre($info, $this->R); //Nodo padre del nodo a eliminar
                if ($NP != null) {
                    if ($NP->getI()->getInfo() == $info) {
                        $NP->setI(null);
                    } else {
                        $NP->setD(null);
                    }
                } else {
                    $this->R = null;
                }
                return true;
            }
        }
        return false;
    }

    //$R: nodo raíz
    public function contarNodos($R)
    {
        if ($R != null) {
            return 1 + $this->contarNodos($R->getI()) + $this->contarNodos($R->getD());
        } else {
            return 0;
        }
    }

    //$R: nodo raíz
    public function contarNumerosPares($R)
    {
        if ($R == null) {
            return 0;
        }
        if ((intval($R->getInfo()) % 2) == 0) {
            return 1 + $this->contarNumerosPares($R->getI()) + $this->contarNumerosPares($R->getD());
        } else {
            return $this->contarNumerosPares($R->getI()) + $this->contarNumerosPares($R->getD());
        }
    }

    public function recorridoNiveles()
    {
        if ($this->R == null) {
            return null;
        }
        $Nodos = array();
        $Cola = array();

        array_push($Cola, $this->R);
        while (count($Cola) > 0) {
            $NA = array_shift($Cola); //Nodo actual
            array_push($Nodos, $NA);
            if ($NA->getI() != null) {
                array_push($Cola, $NA->getI());
            }
            if ($NA->getD() != null) {
                array_push($Cola, $NA->getD());
            }
        }
        return $Nodos;
    }

    //$R: nodo raíz, $Visitados arreglo de nodos visitados
    public function recorridoPreOrden($R)
    {
        if ($R != null) {
            echo $R;
            $this->recorridoPreOrden($R->getI());
            $this->recorridoPreOrden($R->getD());
        }
    }

    //$R: nodo raíz, $Visitados arreglo de nodos visitados
    public function recorridoInOrden($R)
    {
        if ($R != null) {
            $this->recorridoInOrden($R->getI());
            echo $R;
            $this->recorridoInOrden($R->getD());
        }
    }

    //$R: nodo raíz, $Visitados arreglo de nodos visitados
    public function recorridoPostOrden($R)
    {
        if ($R != null) {
            $this->recorridoPostOrden($R->getI());
            $this->recorridoPostOrden($R->getD());
            echo $R;
        }
    }

    //Definición: Un árbol binario con n nodos y profundidad k se dice que es
    //completo si y sólo si sus nodos se corresponden con los nodos numerados de
    //0 a n-1 en el árbol binario lleno de profundidad k.

    //$RN: recorridoNiveles, $NumN: número del nodo
    public function arbolCompleto()
    {
        if ($this->R != null) {
            $K = $this->calcularAltura($this->R); //Altura
            $MaxN = (pow(2, $K)) - 1; //Maximo Nodos
            $NumN = $this->contarNodos($this->R); //Número Nodos
            if ($NumN == $MaxN) {
                return true;
            }
        }
        return false;
    }

    //$R: nodo raíz
    public function calcularAltura($R)
    {
        if ($R->getI() == null && $R->getD() == null) {
            return 1;
        }
        $NI = 0;
        $ND = 0;
        if ($R->getI() != null) {
            $NI =  1 + $this->calcularAltura($R->getI()); //Nivel Izq
        }
        if ($R->getD() != null) {
            $ND =  1 + $this->calcularAltura($R->getD()); //Nivel Der
        }
        if ($NI > $ND) {
            return $NI;
        } else {
            return $ND;
        }
    }

    //$R: nodo raíz
    public function nodosHijos($R)
    {
        $NHS = array(); //Nodos Hijos
        if ($R->getI() == null && $R->getD() == null) {
            $NHS = array_merge($NHS, array($R));
        }
        if ($R->getI() != null) {
            $NHS = array_merge($NHS, $this->nodosHijos($R->getI()));
        }
        if ($R->getD() != null) {
            $NHS = array_merge($NHS, $this->nodosHijos($R->getD()));
        }
        return $NHS;
    }

    //$info: información del nodo hijo, $R: nodo raíz, $P: nodo padre
    public function buscarPadre($info, $R, $P = null)
    {
        if ($R == null) {
            return null;
        }
        if ($R->getInfo() == $info) {
            return $P;
        }
        $Izq = $this->buscarPadre($info, $R->getI(), $R);
        $Der = $this->buscarPadre($info, $R->getD(), $R);
        if ($Izq != null) {
            return $Izq;
        } else {
            return $Der;
        }
    }

    //$info: información del nodo a buscar, $R: nodo raíz
    public function buscarNodo($info, $R)
    {
        if ($R == null) {
            return null;
        }
        if ($R->getInfo() == $info) {
            return $R;
        }
        $Izq = $this->buscarNodo($info, $R->getI());
        $Der = $this->buscarNodo($info, $R->getD());
        if ($Izq != null) {
            return $Izq;
        } else {
            return $Der;
        }
    }

    public function getR()
    {
        return $this->R;
    }

    public function setR($R)
    {
        $this->R = $R;
    }

    //$R: nodo raíz
    public function mostrarArbol($R)
    {
        if ($R == null) {
            return "";
        } else if ($R->getI() != null && $R->getD() != null) {
            return "<br>" . $R . $this->mostrarArbol($R->getI()) . $this->mostrarArbol($R->getD());
        } else if ($R->getI() != null) {
            return "<br>" . $R . $this->mostrarArbol($R->getI());
        } else if ($R->getD() != null) {
            return "<br>" . $R . $this->mostrarArbol($R->getD());
        } else {
            return "<br>" . $R;
        }
    }
}
