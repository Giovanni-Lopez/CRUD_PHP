<?php
    //Incluimos el archivo de conexion
    include('conexion.php');    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="descripcion">
    <meta class="autor">
    <title>ITCA-FEPADE</title>
    <!-- Referencia a Bootstrap care CSS-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Referencia a la librería de JQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){
        setTimeout(function(){
            $(".content").fadeOut(1500);
        },3000);
    });
    </script>
</head>
<body>

    <div class="container md-5">
    <?php
    if(isset($_POST['eliminar'])){
        ///////Elimnar registros de la tabla///////
        $consulta = "DELETE FROM tbl_personal where id =:id";
        $sql = $conect->prepare($consulta);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $id=trim($_POST['id']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $count = $sql->rowCount();
            echo "<div class='content alert alert-primary' style='position: absolute; top: 0px;'>
            Gracias: $count registro ha sido eliminado </div>";
        }else{
            echo "<div class='content alert alertdanger' style='position: absolute; top: 0px;'> No se pudo eliminar el registro </div>";
        }
    }// Cierra envio de eliminado
    if(isset($_POST['insertar'])){
        ///////////// Informacion enviada por el formulario /////////////
        $nombres=$_POST['nombres'];
        $apellidos=$_POST['apellidos'];
        $profesion=$_POST['profesion'];
        $estado=$_POST['estado'];
        $fregis = date('Y-m-d');
        ///////// Fin informacion enviada por el formulario ///
        $sql="insert into tbl_personal(nombres,apellidos,profesion,estado,fregis) values(:nombres,:apellidos,:profesion,:estado,:fregis)"; 

        $sql = $conect->prepare($sql);

        $sql->bindParam(':nombres',$nombres,PDO::PARAM_STR, 25);
        $sql->bindParam(':apellidos',$apellidos,PDO::PARAM_STR, 25);
        $sql->bindParam(':profesion',$profesion,PDO::PARAM_STR,25);
        $sql->bindParam(':estado',$estado,PDO::PARAM_STR,25);
        $sql->bindParam(':fregis',$fregis,PDO::PARAM_STR);
        $sql->execute();
        $lastInsertId = $conect->lastInsertId();
        if($lastInsertId>0){
        echo "<div class='content alert alertprimary' style='position: absolute; top: 0px;'> Gracias .. Tu Nombre es : $nombres </div>";
        }else{
            echo "<div class='content alert alertdanger' style='position: absolute; top: 0px;'> No se pueden agregar datos, comuníquese con el adminis
           trador </div>";
        }
        }// Cierra envio de guardado

        if(isset($_POST['actualizar'])){
            ///////////// Informacion enviada por el formulario /////////////
            $id=trim($_POST['id']);
            $nombres=trim($_POST['nombres']);
            $apellidos=trim($_POST['apellidos']);
            $profesion=trim($_POST['profesion']);
            $estado=trim($_POST['estado']);
            $fregis = date('Y-m-d');
            ///////// Fin informacion enviada por el formulario ///

            ////////////// Actualizar la tabla /////////
            $consulta = "UPDATE tbl_personal
            SET `nombres`= :nombres, `apellidos` = :apellidos, `profesion` = :profesion, `estado` = :estado,
            `fregis` = :fregis
            WHERE `id` = :id";
            $sql = $conect->prepare($consulta);
            $sql->bindParam(':nombres',$nombres,PDO::PARAM_STR, 25);
            $sql->bindParam(':apellidos',$apellidos,PDO::PARAM_STR, 25);
            $sql->bindParam(':profesion',$profesion,PDO::PARAM_STR,25);
            $sql->bindParam(':estado',$estado,PDO::PARAM_STR,25);
            $sql->bindParam(':fregis',$fregis,PDO::PARAM_STR);
            $sql->bindParam(':id',$id,PDO::PARAM_INT);
            $sql->execute();
            if($sql->rowCount() > 0){
            $count = $sql -> rowCount();
            echo "<div class='content alert alert-primary' style='position: absolute; top: 0px;'>
            Gracias: $count registro ha sido actualizado </div>";
            }
            else{
            echo "<div class='content alert alertdanger' style='position: absolute; top: 0px;'> No se pudo actulizar el registro </div>";
            }
            }// Cierra envio de guardado
            ?>
            <h3 class="mt-5" style="color: tomato;">CRUD PDO PHP y MySQL</h3>
            <hr>
            <div class="row">

            <!-- Formulario de captura de nuevos registros -->
            <?php
            if (isset($_POST['formInsertar'])){
            ?>
            <div class="col-12 col-md-12">
                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="nombres">Nombres</label>
                        <input name="nombres" type="text" class="form-control" placeholder="Nombres">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="edad">Apellidos</label>
                        <input name="apellidos" type="text" class="form-control" id="edad" placeholder="Apellidos">
                    </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="profesion">Profesión</label>
                            <input name="profesion" type="text" class="form-control" id="profesion" placeholder="Profesion">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Estado">Estado</label>
                            <select required name="estado" class="form-control" id="Estado">
                                <option value=""><< >></option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Panamá">Panamá</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button name="insertar" type="submit" class="btn btn-info">Guardar</button>
                    </div>
                </form>
            </div>
            <?php
            }
            ?>
            <!-- Fin formulario de captura de nuevos registros -->
            <!-- Formulario de edición de registros -->
                <?php
                    if (isset($_POST['editar'])){
                    $id = $_POST['id'];
                    $sql= "SELECT * FROM tbl_personal WHERE id = :id";
                    $stmt = $conect->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $obj = $stmt->fetchObject();
                ?>
                    <div class="col-12 col-md-12">
                        <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <input value="<?php echo $obj->id;?>" name="id" type="hidden">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nombres">Nombres</label>
                                    <input value="<?php echo $obj->nombres;?>" name="nombres" type="text" class="form-control" placeholder="Nombres">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edad">Apellidos</label>
                                    <input value="<?php echo $obj->apellidos;?>" name="apellidos" type="text" class="form-control" id="edad" placeholder="Apellidos">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="profesion">Profesión</label>
                                    <input value="<?php echo $obj->profesion;?>" name="profesion" type="text" class="form-control" id="profesion" placeholder="Profesion">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Estado">Estado</label>
                                    <select required name="estado" class="form-control" id="Estado">
                                        <option value="<?php echo $obj->estado;?>"><?php echo $obj->estado;?></option>
                                        <option value=""><< >></option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Panamá">Panamá</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button name="actualizar" type="submit" class="btn btn-info">Guardar Cambios</button>
                            </div>
                        </form>
                    </div> 
                <?php
                }
                ?>

        <!--********Formulario de buscar********-->               
        <style type="text/css">
        .busc{            
            padding: 10px;
            border-radius: 5px; 
            width: 40%;
        }

        .consul{
            padding: 11px;
            border-radius: 5px; 
        }
        
        </style>         
        
        <!-- Fin formulario de edición de registros -->
        <!-- Formulario para vista de listado de registros -->
        <div class="col-12 col-md-12">
            <div style="float:left; margin-bottom:5px;">
                <form action="" method="post">
                    <button class="btn btn-success" name="formInsertar">Nuevo registro</button> <a href="index.php"> <button type="button" class="btn btn-primary">Cancelar</button></a>                                                                                            
                </form>
                <br>
            </div>
        </div>
        <div class="container">
            <form action="buscar.php" method="post">
                <div class="form-groud">                
                    <input type="text" class= "busc form-group" name="busqueda" placeholder="Realizar Buscar" required> <button type="submit" class= "consul btn btn-primary">Consultar</button> 
                </div>   
                <br>                                            
            </form>
        </div>          
          

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <th width="5%">Id</th>
                    <th width="18%">Nombres</th>
                    <th width="22%">Apellidos</th>
                    <th width="22%">Profesión</th>
                    <th width="14%">Estado</th>
                    <th width="13%">Fecha registro</th>
                    <th width="13%" colspan="2"></th>
                </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM tbl_personal";
                    $query = $conect -> prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if($query->rowCount() > 0) {
                    foreach($results as $result) {
                    echo "<tr>
                    <td>".$result->id."</td>
                    <td>".$result->nombres."</td>
                    <td>".$result->apellidos."</td>
                    <td>".$result->profesion."</td>
                    <td>".$result->estado."</td>
                    <td>".$result->fregis."</td>
                    <td>
                    <form method='POST' action='".$_SERVER['PHP_SELF']."'>
                    <input type='hidden' name='id' value='".$result -> id."'>
                    <button name='editar' class='btn btn-info btn-sm'>Editar</button>
                    </form>
                    </td>
                    <td>
                    <form onsubmit=\"return confirm('¿Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                    <input type='hidden' name='id' value='".$result -> id."'>
                    <button name='eliminar' class='btn btn-danger btn-sm'>Eliminar</button>
                    </form>
                    </td>
                    </tr>";
                    }
                    }
                ?>
            </tbody>
             </table>
        </div>
 <!-- Formulario para vista de listado de registros -->
        </div>
 </div>
</div>
    <footer class="footer">
        <div class="container">
            <span class="text-muted" style="text-align: center;">
            <p>ITCA-FEPADE <?php echo date('Y'); ?></p>
            </span>
        </div>
    </footer>
</body>
</html>