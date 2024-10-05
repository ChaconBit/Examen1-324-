<?php
session_start();

if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] === -1) {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
include "conexion.inc.php";

// Inicializar variable para almacenar los resultados de búsqueda PERSONA 
$searchResults1 = '';
if (isset($_GET['ci'])) {
    $ciP = $_GET['ci'];
    // Cambié el operador LIKE a un operador de igualdad
    $sql = "SELECT * FROM persona WHERE ci like '$ciP'"; // Buscar por CI exacto
    $resultado1 = mysqli_query($con, $sql);

    // Generar los resultados en formato HTML
    while ($fila = mysqli_fetch_array($resultado1)) {
        $searchResults1 .= "<tr>";
        $searchResults1 .= "<td>$fila[ci]</td>";
        $searchResults1 .= "<td>$fila[nombre]</td>";
        $searchResults1 .= "<td>$fila[paterno]</td>";
        $searchResults1 .= "<td>";
        $searchResults1 .= "<a class='btn btn-warning' href='actualizarPersona.php?ci=$fila[ci]'>Editar</a>";
        $searchResults1 .= "<a class='btn btn-success' href='agregarCatastro.php?ci={$fila['ci']}'>Agregar catastro</a>";
        $searchResults1 .= "<a class='btn btn-danger' href='eliminarPersona.php?ci=$fila[ci]'>Eliminar</a>";
        $searchResults1 .= "</td>";
        $searchResults1 .= "</tr>";
    }

    // Verificar si se encontraron resultados
    if ($searchResults1 === '') {
        $searchResults1 = '<tr><td colspan="4">No se encontraron resultados.</td></tr>';
    }
}
// Inicializar variable para almacenar los resultados de búsqueda CATASTRO
$searchResults3 = '';
if (isset($_GET['ci'])) {
    $idC = $_GET['ci'];  

    $sql3 = "SELECT * FROM catastro WHERE ci like $idC"; // Buscar por ID exacto

    // Ejecutar la consulta
    $resultado3 = mysqli_query($con, $sql3);

    if ($resultado3) {
        // Generar los resultados en formato HTML
        while ($fila3 = mysqli_fetch_array($resultado3)) {

            $searchResults3 .= "<tr>";
            $searchResults3 .= "<td>{$fila3['id']}</td>"; // ID
            $searchResults3 .= "<td>{$fila3['zona']}</td>"; // Zona
            $searchResults3 .= "<td>{$fila3['Xini']}</td>"; // Xini
            $searchResults3 .= "<td>{$fila3['Yini']}</td>"; // Yini
            $searchResults3 .= "<td>{$fila3['Xfin']}</td>"; // Xfin
            $searchResults3 .= "<td>{$fila3['Yfin']}</td>"; // Yfin
            $searchResults3 .= "<td>{$fila3['superficie']}</td>"; // Superficie
            $searchResults3 .= "<td>{$fila3['distrito']}</td>"; // Distrito
            $searchResults3 .= "<td>{$fila3['ci']}</td>"; // CI Propietario
            $searchResults3 .= "<td>";
            $searchResults3 .= "<a class='btn btn-warning' href='actualizarCatastro.php?id={$fila3['id']}'>Editar</a> ";
            $searchResults3 .= "<a class='btn btn-danger' href='eliminarCatastro.php?id={$fila3['id']}'>Eliminar</a>";
            $searchResults3 .= "</td>";
            $searchResults3 .= "</tr>";
        }

        // Verificar si se encontraron resultados
        if ($searchResults3 === '') {
            $searchResults3 = '<tr><td colspan="10">No se encontraron resultados.</td></tr>'; // Ajuste de colspan
        }
    } else {
        // En caso de error en la consulta
        $searchResults3 = '<tr><td colspan="10">Error en la consulta. Intente nuevamente.</td></tr>';
    }
}

?>
<?php include "cabecera.inc.php"; ?>

<!-- ***************  overview   ***************** -->
<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
    <div class="row">
        <div class="col-lg-12 d-flex flex-column" style="display: flex;">
            <div class="row flex-grow">
                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <!--   ************************* CUERPO DE PERSONAS ********************************************* -->
                            <div class="container mt-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <a href="agregarPersona.php" class="btn btn-success" style="padding: 10px;">Crear
                                        Persona</a>
                                    <form action="" method="GET" class="d-flex" onsubmit="return false;">
                                        <input type="text" class="form-control height-100"
                                            placeholder="Buscar por CI..." aria-label="Buscar" name="ci" required
                                            style="padding: 10px; align-self: stretch;">
                                        <button type="button" class="btn btn-primary height-100"
                                            style="padding: 10px; align-self: stretch;"
                                            onclick="buscarPersona()">Buscar</button>
                                    </form>
                                </div>
                            </div>
                            <center>
                                <h2>Listado de Personas</h2>
                            </center><br>
                            <table class="table table-striped" id="personasTable">
                                <tr>
                                    <th scope="col">CI</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Paterno</th>
                                    <th scope="col">Operaciones</th>
                                </tr>
                                <?php
                                $sql1 = "SELECT * FROM persona ORDER BY nombre"; // Consulta para todas las personas
                                $resultado1 = mysqli_query($con, $sql1);
                                // Mostrar todos los resultados (sin filtro)
                                while ($fila = mysqli_fetch_array($resultado1)) {
                                    echo "<tr>";
                                    echo "<td>$fila[ci]</td>";
                                    echo "<td>$fila[nombre]</td>";
                                    echo "<td>$fila[paterno]</td>";
                                    echo "<td>";
                                    echo "<a class='btn btn-warning' href='actualizarPersona.php?ci=$fila[ci]'>Editar</a>";
                                    echo "<a class='btn btn-success' href='agregarCatastro.php?ci=$fila[ci]'>Agregar Catastro</a>";
                                    echo "<a class='btn btn-danger' href='eliminarPersona.php?ci=$fila[ci]'>Eliminar</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>

                            <!-- Modal de PERSONAS -->
                            <div class="modal fade" id="resultadoModal" tabindex="-1"
                                aria-labelledby="resultadoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg"> <!-- Aumenta el tamaño del modal con modal-lg -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="resultadoModalLabel">Resultados de Búsqueda</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="modalBody">
                                            <div class="table-responsive">
                                                <!-- Envuelve la tabla en una clase table-responsive -->
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CI</th>
                                                            <th scope="col">Nombre</th>
                                                            <th scope="col">Apellido</th>                                                
                                                            <th scope="col">Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <?php echo $searchResults1; ?>
                                                    <!-- Aquí aparecen los resultados de la búsqueda -->

                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <!--       cierre dl cuerpo de personas      -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!--                  AUDIENIES                  -->
<div class="tab-pane fade show active" id="audiences" role="tabpanel" aria-labelledby="audiences">
    <div class="row">
        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="container mt-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <form action="" method="GET" class="d-flex" onsubmit="return false;">
                                        <input type="text" class="form-control height-100"
                                            placeholder="Buscar por CI..." aria-label="Buscar" name="ci" required
                                            style="padding: 9px; align-self: stretch;">
                                        <button type="button" class="btn btn-primary height-100"
                                            style="padding: 9px; align-self: stretch;"
                                            onclick="buscarCatastro()">Buscar</button>

                                    </form>

                                </div>
                            </div>
                            <center>
                                <h2>Listado de Catastros</h2>
                            </center><br>
                            <table class="table table-striped" id="catastrosTable">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Zona</th>
                                    <th scope="col">Xini</th>
                                    <th scope="col">Yini</th>
                                    <th scope="col">Xfin</th>
                                    <th scope="col">Yfin</th>
                                    <th scope="col">Superficie</th>
                                    <th scope="col">Distrito</th>
                                    <th scope="col">CI</th>
                                    <th scope="col">Operaciones</th>
                                </tr>
                                <?php
                                $sql2 = "SELECT * FROM catastro ORDER BY id"; // Consulta para todas las personas
                                $resultado2 = mysqli_query($con, $sql2);
                                // Mostrar todos los resultados (sin filtro)
                                while ($fila2 = mysqli_fetch_array($resultado2)) {
                                    echo "<tr>";
                                    echo "<td>$fila2[id]</td>";
                                    echo "<td>$fila2[zona]</td>";
                                    echo "<td>$fila2[Xini]</td>";
                                    echo "<td>$fila2[Yini]</td>";
                                    echo "<td>$fila2[Xfin]</td>";
                                    echo "<td>$fila2[Yfin]</td>";
                                    echo "<td>$fila2[superficie]</td>";
                                    echo "<td>$fila2[distrito]</td>";
                                    echo "<td>$fila2[ci]</td>";
                                    echo "<td>";
                                    echo "<a class='btn btn-warning' href='actualizarCatastro.php?id=$fila2[id]'>Editar</a>";
                                    echo "<a class='btn btn-danger' href='eliminarCatastro.php?id=$fila2[id]'>Eliminar</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                            <!-- Modal de Catastro -->
                            <div class="modal fade" id="resultadoModal1" tabindex="-1"
                                aria-labelledby="resultadoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg"> <!-- Aumenta el tamaño del modal con modal-lg -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="resultadoModalLabel">Resultados de Búsqueda</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="modalBody1">
                                            <div class="table-responsive">
                                                <!-- Envuelve la tabla en una clase table-responsive -->
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">ID</th>
                                                            <th scope="col">Zona</th>
                                                            <th scope="col">Xini</th>
                                                            <th scope="col">Yini</th>
                                                            <th scope="col">Xfin</th>
                                                            <th scope="col">Yfin</th>
                                                            <th scope="col">Superficie</th>
                                                            <th scope="col">Distrito</th>
                                                            <th scope="col">CI</th>
                                                            <th scope="col">Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <?php echo $searchResults3; ?>
                                                    <!-- Aquí aparecen los resultados de la búsqueda -->

                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--------------------------------------------------------------------------->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!--*****************************************************************************-->
<div class="tab-pane fade show active" id="personasCatastros" role="tabpanel" aria-labelledby="personasCatastros">
    <div class="row">
        <div class="" style="display: flex;">
            <div class="row flex-grow">
                <div class="" style="display: flex;">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <!--   ************************* CUERPO DE PERSONAS ********************************************* -->
                            <center>
                                <h2>Listado de Personas y Catastros</h2>
                            </center><br>
                            <table class="table table-striped" id="personasTable">
                                <tr>
                                    <th scope="col">CI</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Paterno</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Zona</th>
                                    <th scope="col">Xini</th>
                                    <th scope="col">Yini</th>
                                    <th scope="col">Xfin</th>
                                    <th scope="col">Yfin</th>
                                    <th scope="col">Superficie</th>
                                    <th scope="col">Distrito</th>                                    
                                    <th scope="col">Alto</th>
                                    <th scope="col">Medio</th>
                                    <th scope="col">Bajo</th>
                                </tr>
                                <?php
                                $sql1 = "SELECT p.ci,p.nombre,p.paterno,c.id,c.zona,c.Xini,c.Yini,c.Xfin,c.Yfin,c.superficie,c.distrito
                                FROM persona p, catastro c
                                WHERE p.ci like c.ci
                                order by p.ci"; // Consulta para todas las personas
                                $resultado1 = mysqli_query($con, $sql1);
                                
                                // Mostrar todos los resultados (sin filtro)
                                while ($fila = mysqli_fetch_array($resultado1)) {
                                    echo "<tr>";
                                    echo "<td>$fila[ci]</td>";
                                    echo "<td>$fila[nombre]</td>";
                                    echo "<td>$fila[paterno]</td>";
                                    echo "<td>$fila[id]</td>";
                                    echo "<td>$fila[zona]</td>";
                                    echo "<td>$fila[Xini]</td>";
                                    echo "<td>$fila[Yini]</td>";
                                    echo "<td>$fila[Xfin]</td>";
                                    echo "<td>$fila[Yfin]</td>";
                                    echo "<td>$fila[superficie]</td>";
                                    echo "<td>$fila[distrito]</td>";
                                    if (isset($fila['id']) && is_string($fila['id']) && substr($fila['id'], 0, 1) == '1') {
                                        echo "<td scope='row'>1</td>";
                                        echo "<td scope='row'>0</td>";
                                        echo "<td scope='row'>0</td>";
                                    } else {
                                        
                                        if(isset($fila['id']) && is_string($fila['id']) && substr($fila['id'], 0, 1) == '2'){
                                            echo "<td scope='row'>0</td>";
                                            echo "<td scope='row'>1</td>";
                                            echo "<td scope='row'>0</td>";
                                        }
                                        else{
                                            if(isset($fila['id']) && is_string($fila['id']) && substr($fila['id'], 0, 1) == '3'){
                                                echo "<td scope='row'>0</td>";
                                                echo "<td scope='row'>0</td>";
                                                echo "<td scope='row'>1</td>";
                                            }
                                            else{
                                                echo "<td scope='row'>NULL</td>";
                                                echo "<td scope='row'>NULL</td>";
                                                echo "<td scope='row'>NULL</td>";
                                            }
                                        }
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                            <!--       cierre dl cuerpo de personas      -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<?php include "pie.inc.php"; ?>