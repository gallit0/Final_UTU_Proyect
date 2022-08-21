<?php
    $timezone = "America/Montevideo";
    date_default_timezone_set($timezone);
    session_start();
    if(isset($_SESSION['idUsuario'])){
		if($_SESSION['permisoUsuario']==1){
			header("Location: usuarioPerfil.php");
		}
	} else {
		header("Location: index.php");
	}


    if(isset($_GET['codigo'])){
        include "conexion.php";
        $codigo=$_GET['codigo'];
        $consultaR="SELECT * FROM reparacion WHERE codigoReparacion='$codigo'";
        $resR=mysqli_query($conexion, $consultaR) or die ("error");
        if (mysqli_num_rows($resR)>0){
            $consulta= "SELECT repuestousado.*, repuesto.* FROM repuestousado INNER JOIN repuesto USING(idRepuesto) WHERE codigoReparacion='$codigo'";
                        $res=mysqli_query($conexion, $consulta) or die ("error");
                        $precio=0.00;
                        while($fila=mysqli_fetch_array($res)){
                            $precioTot=$fila['precioMomento']*$fila['cantidadusada'];
                            $precio+=$precioTot;
                            
                        }
            $filaR=mysqli_fetch_array($resR);
            $matriculaV=$filaR['matriculaVehiculo'];
            $consultaV="SELECT ciCliente as idCliente FROM llevataller WHERE matriculaVehiculo='$matriculaV'";
            $resV=mysqli_query($conexion, $consultaV) or die ("error");
            if (mysqli_num_rows($resV)==0){
                $consultaV="SELECT rutCliente as idCliente FROM llevacorporacion WHERE matriculaVehiculo='$matriculaV'";
                $resV=mysqli_query($conexion, $consultaV);
                if(mysqli_num_rows($resV)==0){
                    header("Location: usuarioPerfil.php");
                }

            } 
        } else {
            header("Location: usuarioPerfil.php");
        }
    } else {
        header("Location: usuarioPerfil.php");
    }
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
    <title>MadMotors - Check Fix In</title>
</head>
<body>
<?php include 'cambioModoOscuro.php'?>
    <div id = "ingresoReparacionMecanico">
        <!-------------Header------------->
        <?php
			include 'barraHeader.php';
		?>
        
        <div id = "cuerpoIngresoReparacionMecanico" class="cuerpo">
            <div class="titulos">Ingresar reparación</div>

            <form id="formLog" method = "post">
                <label for="codigo">Código de Reparación:
                    <input type="text" name = "codigo" value="<?php echo $codigo ?>" readonly>
                </label>
                <label for="codigo">Id cliente:
                    <?php
                        echo "<select name ='idSeleccion'>";
                        while($filaV=mysqli_fetch_array($resV)){
                                echo "<option value='".$filaV['idCliente']."'>ID: ".$filaV['idCliente']."</option>";
                                }
                        echo "</select>";
                     ?>
                </label>
                <label for="matricula">Matricula Vehiculo:
                    <input type="text" name = "matricula" value="<?php echo $matriculaV ?>" readonly>
                </label>
                <br>
                <br>
                <p>
                    <label for="obra">Mano de Obra:
                        <input type="text" name = "obra"  placeholder = "Mano de Obra">
                    </label>
                </p>
                <br>
                <p>
                    <label for="repuestosTot">SubTotal Repuestos:
                        <input type="text" name = "repuestosTot"  value="<?php echo $precio ?>" readonly>
                    </label>
                </p>
                <br>
                <p>
                    <label for="tipoPago">Tipo Importe:
                        <select name ='tipoPago'>
                                <option value="contado">Contado</option>
                                <option value="debito">Débito</option>
                        </select>
                    </label>
                </p>
                <br>
                <p>
                    <label for="moneda">Moneda Usada:
                        <input type="text" name = "moneda"  value = "UYU" readonly>
                    </label>
                </p>
                <br>
                <p>
                    <label for="vencimiento">Vencimiento Factura:
                        <input type="date" name = "vencimiento">
                    </label>
                </p>
                <br>

                <br>
                <p>
                    <input type="submit" id= "btnSubmit" value="Ingresar">
                </p>
            </form>
            <div id="output"></div>
        </div>
    </div>
    <!-----------------------------------------------Footer----------------------------------------------->
	<?php
		include 'footer.php';
	?>
    <!-----------------------------------------------Conexion Ajax----------------------------------------------->
<script type="text/javascript">
            $(document).ready(function () {
            $("#btnSubmit").click(function (event) {
                //No envia el formulario directamente despues de presioanr.
                event.preventDefault();
         
                // Guarda el Formulario.
                var form = $('#formLog')[0];
         
                // Guarda los datos del formulario.
                var data = new FormData(form);
         

         
                // Desabilita el boton de enviar.
                $("#btnSubmit").prop("disabled", true);
                //Usa ajax para enviar los datos al formulario de validacion y conexión.
                $.ajax({
                    type: "POST",
                    url: "conexionFacturacion.php",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    //La bitacora de la consola muestra CORRECTO y el output del conexión se carga en el div de output
                    success: function (data) {
                        if(data=="ok"){
                            console.log("COORRECTO : ", data);
                            alert("Error en los datos");
                            window.location.href = "usuarioPerfil.php";
                        } else if(data=="next"){
                            console.log("COORRECTO : ", data);
                            alert("Factura Correcta");
                            window.location.href ="facturasFin.php?codigo=<?php echo $codigo ?>"
                        } else if (data=="repe"){
                            console.log("COORRECTO : ", data);
                            alert("Reparacion ya realizada");
                            window.location.href = "usuarioPerfil.php";
                            $("#output").html(data);
                        } else if (data.includes("Error:")){
                            console.log("Error : ", data);
                            $("#output").html(data);
                        }

                        console.log("COORRECTO : ", data);
                        //Vuelve a habilitar el boton de Enviar
                        $("#btnSubmit").prop("disabled", false);
                    },
                     //La bitacora de la consola muestra ERROR y no envia el formulario
                    error: function (e) {
                        $("#output").text(e.responseText);
                        console.log("ERROR : ", e);
                        //Vuelve a habilitar el boton de Enviar
                        $("#btnSubmit").prop("disabled", false);
                    }
                });
            });
        });
</script>
</body>
</html>