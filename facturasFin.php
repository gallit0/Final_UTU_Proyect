<?php

    include "conexion.php";
    $codigo=$_GET['codigo'];
    $consultaC="SELECT * FROM reparacionfactura WHERE codigoReparacion='$codigo'";
    $resC=mysqli_query($conexion, $consultaC);
    $filaC=mysqli_fetch_array($resC);
    $id=$filaC['idFactura'];
    $consulta="SELECT * FROM facturacion WHERE idFactura='$id' ";
    $res=mysqli_query($conexion, $consulta);
    $fila=mysqli_fetch_array($res);
    $codigoQr=$fila['codigoQr'];
    if($fila['tipoFactura']=="e-Ticket"){
        $consultaT="SELECT * FROM eticket WHERE idFactura='$id'";
        $resT=mysqli_query($conexion, $consultaT);
        $filaT=mysqli_fetch_array($resT);
    } else {
        $consultaF="SELECT * FROM efactura WHERE idFactura='$id'";
        $resF=mysqli_query($conexion, $consultaF);
        $filaF=mysqli_fetch_array($resF);
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadMotors - Bill</title>
    <link rel="icon" type="image/x-icon" href="imagenes_contenido/favicon.ico">
    <!------------------>
    <style>
        td{
            border:none;
        }
        th, td {
            text-align:center;
        }
        th {
            background:#DDD;
        }
        .sinBorde{
            border:0;
        }
        .txtIzq{
            text-align:left;
        }
        #final{
            width:700px;
            display:flex;
            justify-content:flex-end;
        }
        *{
            font-family:arial;
        }
        .algo{
            font-size: 15px;
        }
    </style>
    <!------------------>
</head>
<body>
    <section>
        <table>
            <tr>
                <td rowspan="10" class= "sinBorde"><img src="imagenes_contenido/mm300px.png" width="200px" height="auto"></td>
                <th colspan="2">RUT</th>
                <th colspan="2">Tipo Documento</th>
            </tr>
            <!---->
            <tr>
                <td colspan="2"><?php echo $fila['rutEmisor']; ?></td>
                <td colspan="2"><?php echo $fila['tipoFactura']; ?></td>
            </tr>
            <!---->
            <tr>
                <th>Serie</th>
                <th>Número</th>
                <th>Forma de pago</th>
                <th>Vencimiento</th>
            </tr>
            <!---->
            <tr>
                <td>A</td>
                <td><?php echo $fila['idFactura']; ?></td>
                <td><?php echo $fila['tipoImporte']; ?></td>
                <td><?php echo $fila['vencimientoFactura']; ?></td>
            </tr>
            <!---->
            <tr>
                <th colspan="2">Consumo final</th>
                <th colspan="2">Identificador de compra</th>
            </tr>
            <!---->
            <tr>
                <td colspan="2"><?php echo $filaT['ciCliente']; ?></td>
                <td colspan="2"> </td>
            </tr>
            <!---->
            <tr>
                <th colspan="2">Nombre</th>
                <th colspan="2">Domicilio</th>
            </tr>
            <!---->
            <tr>
                <td colspan="2"><?php echo $filaT['nombreCliente']; ?></td>
                <td colspan="2"><?php echo $fila['direccionCliente']; ?></td>
            </tr>
            <!---->
            <tr>
                <th colspan="2">Fecha de documento</th>
                <th colspan="2">Moneda</th>
            </tr>
            <!---->
            <tr>
                <td colspan="2"><?php echo $fila['fecha']; ?></td>
                <td colspan="2"><?php echo $fila['moneda']; ?></td>
            </tr>
            <tr>
                <td class="algo" rowspan = "2" >Taller Mécanico - Pdte. Tomás Berreta, 91400<br>Santa Rosa,  Departamento de Canelones.</td>
            </tr>
        </table>
    </section>

    <section>
        <table>
            <tr>
                <th>Cantidad</th>
                <th>Despcripción</th>
                <th>P. Unitario</th>
                <th>Importe $</th>
            </tr>
            <!---->
            
            <?php

            $consulta="SELECT reparacionfactura.*, repuesto.* FROM reparacionfactura INNER JOIN repuesto USING(idRepuesto) WHERE idFactura='$id'";
            $res=mysqli_query($conexion, $consulta);
            $subTotal=0;
            while($filaR=mysqli_fetch_array($res)){
                if($filaR['idRepuesto'] != 0){


                echo "<tr>";
                $total=$filaR['cantidad']*$filaR['precio'];
                echo "<td>".$filaR['cantidad']."</td>";
                echo "<td class= 'txtIzq'>".$filaR['desRepuesto']."</td>";
                echo "<td>".$filaR['precio']."</td>";
                echo "<td>".$total."</td>";
                $subTotal+=$total;
                echo "</tr>";
                   }
            }
            echo "<tr>";
                echo "<td>"."1"."</td>";
                echo "<td class= 'txtIzq'>"."Mano de Obra"."</td>";
                echo "<td>".$fila['manoObra']."</td>";
                echo "<td>".$fila['manoObra']."</td>";
                echo "</tr>";
            echo "</tr>";
            $subTotal+=$fila['manoObra'];
            ?>
           
        </table>
    </section>
    <br>
    <section id= "final">
        <table>
            <tr>
                <td><b>Subtotal:</b> </td>
                <td> <?php echo $subTotal.'$'; ?></td>
            </tr>
            <tr>
                <td><b>Total IVA (22%):</b> </td>
                <td><?php $iva=$subTotal*0.22;
                echo $iva.'$'; ?></td>
            </tr>
            <tr>
                <td><b>TOTAL A PAGAR:</b> </td>
                <td><?php $tot=$subTotal+$iva;
                echo $tot.'$'; ?></td>
            </tr>
            <tr>
                <?php
                    $cht = "qr";
                    $chs = "100x100";
                    $chl = urlencode($codigoQr);
                    $choe = "UTF-8";

                    $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;

                ?>
                <td><img src="<?php echo $qrcode ?>" alt="My QR code"></td>
            </tr>
        </table>
    </section>
</body>
</html>