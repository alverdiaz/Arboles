<?php
include_once("arbol.php");
include_once("nodo.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      type="text/javascript"
      src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js">
   </script>
   <link rel="stylesheet" href="estilos.css">
  </head>
  <body>
    <div class="container">
      <div id="ppal-content">
        <header class="header">
        <div id="tituloCab">
          <img
            src="/Arboles/img/arbolBinario-icon.jfif"
            alt="Imagen arbol binario"
          />
          <h1 id="tituloArbolBinanio">Arbol Binario</h1>
        </div>
      </header>
      <main>
      </div>
        <section class="secction1">
          <div id="secction1-content">
            <div>
            <h3>Crear Árbol</h3>
           <form action="index.php" method="POST" name="CrearArbol">
            <input
              type="text"
              name="Info-CrearArbol"
              placeholder="Nombre de la raíz (info)"
            />
            <input type="submit" name="Crear-CrearArbol" value="Crear Árbol" />
           </form>
           <form action="index.php" method="POST" name="AgregarNodo">
            <input
              type="text"
              name="InfoNA-AgregarNodo"
              placeholder="Nombre del nodo (info)"
            />

              <input
              type="checkbox"
              id="Ubicacion-AgregarNodo"
              name="Ubicacion-AgregarNodo"
              value="Izq"
            />
            <label for="Ubicacion-AgregarNodo"> Izq</label> 
            <input
              type="checkbox"
              id="Ubicacion-AgregarNodo"
              name="Ubicacion-AgregarNodo"
              value="Der"
            />
            <label for="Ubicacion-AgregarNodo"> Der</label>
        
            <input
              type="text"
              name="InfoP-AgregarNodo"
              placeholder="Nombre del nodo padre"
            />
            <input
              type="submit"
              name="Agregar-AgregarNodo"
              value="Agregar Nodo"
            />
          
           </form>
           <form action="index.php" method="POST" name="EliminarNodo">
            <input
              type="text"
              name="InfoNE-EliminarNodo"
              placeholder="Nombre del nodo"
            />
            <input
              type="submit"
              name="Eliminar-EliminarNodo"
              value="Eliminar Nodo"
            />
           </form> 
           <br>
           <hr>
           <br>
           </div>
          
          <div id="methods-content">
            <br>
           <h3>Contar Nodos</h3>
           <form action="index.php" method="POST" name="ContarNodos">
            <input
              type="text"
              name="InfoNR-ContarNodos"
              placeholder="Nombre del nodo raíz"
             />
             <input
              type="submit"
              name="Contar-ContarNodos"
              value="Contar Nodos"
             />
            </form>
            <h3>Contar Número De Nodos Pares</h3>
           <form action="index.php" method="POST" name="ContarNumerosPares">
             <input
              type="text"
              name="InfoNR-ContarNumerosPares"
              placeholder="Nombre del nodo raíz"
             />
             <input
              type="submit"
              name="Contar-ContarNumerosPares"
              value="Contar Números Pares"
             />
             </form>
             <div id="Resultados">
              <?php
              //Crear Arbol
              if (
                  isset($_POST["Info-CrearArbol"]) &&
                  isset($_POST["Crear-CrearArbol"])
              ) {
                  $info = intval($_POST["Info-CrearArbol"]);
                  $_SESSION["A"] = new Arbol($info);
              }
              //Agregar Nodo
              if (
                  isset($_POST["InfoNA-AgregarNodo"]) &&
                  isset($_POST["InfoP-AgregarNodo"]) &&
                  isset($_POST["Ubicacion-AgregarNodo"]) &&
                  isset($_POST["Agregar-AgregarNodo"])
              ) {
                  $info = intval($_POST["InfoNA-AgregarNodo"]);
                  $infoP = intval($_POST["InfoP-AgregarNodo"]);
                  $U = $_POST["Ubicacion-AgregarNodo"];
                  $E = $_SESSION["A"]->agregarNodo($info, $infoP, $U);
                  if ($E == null) {
                      echo "<br>No Agregado";
                  }
              }
              //Eliminar Nodo
              if (
                  isset($_POST["InfoNE-EliminarNodo"]) &&
                  isset($_POST["Eliminar-EliminarNodo"])
              ) {
                  $info = intval($_POST["InfoNE-EliminarNodo"]);
                  $E = $_SESSION["A"]->eliminarNodo($info);
                  if ($E == null) {
                      echo "<br>No Eliminado";
                  }
              }
              //Contar Nodos
              if (
                  isset($_POST["InfoNR-ContarNodos"]) &&
                  isset($_POST["Contar-ContarNodos"])
              ) {
                  $NR = $_SESSION["A"]->buscarNodo($_POST["InfoNR-ContarNodos"], $_SESSION["A"]->getR());
                  if ($NR != null) {
                      echo "<br>Cantidad Nodos: " . $_SESSION["A"]->contarNodos($NR);
                  } else {
                      echo "<br>No Encontrado";
                  }
              }
              //Contar Pares
              if (
                  isset($_POST["InfoNR-ContarNumerosPares"]) &&
                  isset($_POST["Contar-ContarNumerosPares"])
              ) {
                  $NR = $_SESSION["A"]->buscarNodo($_POST["InfoNR-ContarNumerosPares"], $_SESSION["A"]->getR());
                  if ($NR != null) {
                      echo "<br>Cantidad Nodos Pares: " . $_SESSION["A"]->contarNumerosPares($NR);
                  } else {
                      echo "<br>No Encontrado";
                  }
              }
              //Recorrido Niveles
              if (isset($_POST["Recorrido-RecorridoNiveles"])) {
                  $R = $_SESSION["A"]->recorridoNiveles();
                  if ($R != null) {
                      echo "<br>Recorrido Por Niveles:<br>";
                      foreach ($R as $N) {
                          echo $N;
                      }
                  }
              }
              //Recorrido PreOrden
              if (isset($_POST["Recorrido-RecorridoPreOrden"])) {
                  echo "<br>Recorrido PreOrden:<br>";
                  $_SESSION["A"]->recorridoPreOrden($_SESSION["A"]->getR());
              }
              //Recorrido InOrden
              if (isset($_POST["Recorrido-RecorridoInOrden"])) {
                  echo "<br>Recorrido InOrden:<br>";
                  $R = $_SESSION["A"]->recorridoInOrden($_SESSION["A"]->getR());
              }
              //Recorrido PostOrden
              if (isset($_POST["Recorrido-RecorridoPostOrden"])) {
                  echo "<br>Recorrido PostOrden:<br>";
                  $R = $_SESSION["A"]->recorridoPostOrden($_SESSION["A"]->getR());
              }
              //Calcular Altura
              if (isset($_POST["Calcular-CalcularAltura"])) {
                echo "<br>Calcular Altura:<br>";
                echo $_SESSION["A"]->calcularAltura($_SESSION["A"]->getR());
              }
              //Nodos Hijos
              if (isset($_POST["Calcular-NodosHijos"])) {
                  $NHS = $_SESSION["A"]->nodosHijos($_SESSION["A"]->getR());
                  echo "<br>Nodos Hijos:<br>";
                  foreach ($NHS as $N) {
                      echo $N;
                  }
              }
              //Árbol completo
              if (isset($_POST["Calcular-ArbolCompleto"])) {
                  $C = $_SESSION["A"]->arbolCompleto();
                  if ($C) {
                      echo "<br>Completo";
                  } else {
                      echo "<br>No Completo";
                  }
              }
              ?>
          </div>
           <div id="recorridos-content">
             <h3 id="recorridos-title">Recorridos</h3>
             <form action="index.php" method="POST" name="RecorridoNiveles">
               <input
               type="submit"
               name="Recorrido-RecorridoNiveles"
               value="Por nivles"
               />
              </form>
             <form action="index.php" method="POST" name="RecorridoPreOrden">
               <input
                type="submit"
                name="Recorrido-RecorridoPreOrden"
                value="PreOrden"
               />
             </form>
           <form action="index.php" method="POST" name="RecorridoInOrden">
             <input
              type="submit"
              name="Recorrido-RecorridoInOrden"
              value="InOrden"
             />
              </form>
              <form action="index.php" method="POST" name="RecorridoPostOrden">
                <input
                  type="submit"
                  name="Recorrido-RecorridoPostOrden"
                  value="PostOrden"
                />
              </form>
              <h3>Calcular Altura</h3>
              <form action="index.php" method="POST" name="CalcularAltura">
                <input
                  type="submit"
                  name="Calcular-CalcularAltura"
                  value="Calcular Altura"
                />
              </form>
              <h3>Nodos Hijos</h3>
              <form action="index.php" method="POST" name="NodosHijos">
                <input
                  type="submit"
                  name="Calcular-NodosHijos"
                  value="Nodos Hijos"
                />
              </form>
              <h3>¿Árbol Completo?</h3>
              <form action="index.php" method="POST" name="ArbolCompleto">
                <input
                  type="submit"
                  name="Calcular-ArbolCompleto"
                  value="¿Arbol Completo?"
                />
              </form>
           </div>
          </div>
          </div>
        </section>
        <section class="secction2">
          <div id="network">
          <script type="text/javascript">
            var Nodos = new vis.DataSet([
                <?php
                $Nodos = $_SESSION["A"]->recorridoNiveles();
                foreach ($Nodos as $N) {
                    $Info = $N->getInfo();
                    echo "{id: '$Info', label: '$Info',},";
                }
                ?>
            ]);

            var Hijos = new vis.DataSet([
                <?php
                foreach ($Nodos as $N) {
                    $Info = $N->getInfo();
                    $I = $N->getI();
                    $D = $N->getD();
                    if (isset($I)) {
                        $InfoI = $I->getInfo();
                        echo "{from: '$Info', to: '$InfoI', label: null},";
                    }
                    if (isset($D)) {
                        $InfoD = $D->getInfo();
                        echo "{from: '$Info', to: '$InfoD', label: null},";
                    }
                }
                ?>
            ]);

            var container = document.getElementById("network");
            var data = {
                nodes: Nodos,
                edges: Hijos,
            };
            var options = {
                layout: {
                    hierarchical: {
                        direction: "UD",
                        sortMethod: "directed",
                    },
                },
                physics: {
                    hierarchicalRepulsion: {
                        avoidOverlap: 0.01,
                    },
                },
            };
            var network = new vis.Network(container, data, options);
          </script>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
