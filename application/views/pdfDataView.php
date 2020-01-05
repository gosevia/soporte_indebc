<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Sistema de Solicitudes INDEBC</title>
<!--<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/datatables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">
-->
<link rel="stylesheet" href="<?php echo base_url('application/assets/css/main.css'); ?>" />
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/datatables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
-->
</head>
<body>      
    <div class="container-PDF">
        <?php if($filtro != null): ?>
            <?php 
                $total = 0;
                $tj = 0; $tj1 = 0; $tj2 = 0; $tj3 = 0;
                $mx = 0; $mx1 = 0; $mx2 = 0; $mx3 = 0;
                $en = 0; $en1 = 0; $en2 = 0; $en3 = 0;
                $km = 0; $km1 = 0; $km2 = 0; $km3 = 0;
                $sf = 0; $sf1 = 0; $sf2 = 0; $sf3 = 0;
            ?>
            <h4>Resultados</h4>
            <table class="outputPDFtableHeader">
                <thead>
                    <tr>
                    <th scope="col">Fecha Inicial</th>
                    <th scope="col">Fecha Final</th>
                    <th scope="col">Total</th>
                    <th scope="col">CAR Tijuana</th>
                    <th scope="col">CD Deportiva Mexicali</th>
                    <th scope="col">CAR Ensenada</th>
                    <th scope="col">KM43</th>
                    <th scope="col">CAR San Felipe</th>
                </thead>
                <tbody>
                <?php 
                foreach($filtro as $row){
                    switch($row['idInstalacion']){
                        case 1: $tj += 1; 
                                if($row['statusReporte']==1){ $tj1 += 1; }
                                if($row['statusReporte']==2){ $tj2 += 1; }
                                if($row['statusReporte']==3){ $tj3 += 1; } break;
                        case 2: $mx += 1;
                                if($row['statusReporte']==1){ $mx1 += 1; }
                                if($row['statusReporte']==2){ $mx2 += 1; }
                                if($row['statusReporte']==3){ $mx3 += 1; } break;
                        case 3: $en += 1;
                                if($row['statusReporte']==1){ $en1 += 1; }
                                if($row['statusReporte']==2){ $en2 += 1; }
                                if($row['statusReporte']==3){ $en3 += 1; } break;
                        case 4: $km += 1; 
                                if($row['statusReporte']==1){ $km1 += 1; }
                                if($row['statusReporte']==2){ $km2 += 1; }
                                if($row['statusReporte']==3){ $km3 += 1; } break;
                        case 5: $sf += 1;
                                if($row['statusReporte']==1){ $sf1 += 1; }
                                if($row['statusReporte']==2){ $sf2 += 1; }
                                if($row['statusReporte']==3){ $sf3 += 1; } break; 
                    }
                    $total += 1;           
                }
                $sD = explode("%2", $startDate);
                $eD = explode("%2", $endDate);
                ?>
                    <tr>
                        <td><?php echo $sD[0]; ?></td>
                        <td><?php echo $eD[0]; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $tj; ?></td>
                        <td><?php echo $mx; ?></td>
                        <td><?php echo $en; ?></td>
                        <td><?php echo $km; ?></td>
                        <td><?php echo $sf; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="row center">
                <div class="col-md col-md-offset-4">
                    <div id="bar_chart"><img src="uploads/files/chartReporte.png" width="750px"></div>
                </div>  
            </div>
            <div class="table-container">
                <table class="outputPDFtable">
                    <thead>
                        <tr>
                        <th scope="col">Estatus</th>
                        <th scope="col">Folio</th>
                        <th scope="col">Fecha de creación</th>
                        <th scope="col">Fecha de resolución</th>
                        <th scope="col">Instalación</th>
                        <th scope="col">Tipo de servicio</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($filtro as $row){
                        echo "<tr>";
                        switch($row['statusReporte']){
                            case 1: echo "<td id='estado1'>Sin seguimiento</td>"; break;
                            case 2: echo "<td id='estado2'>En proceso...</td>"; break;
                            case 3: echo "<td id='estado3'>Concluido</td>"; break; 
                        }
                        echo "<td>".$row['idReporte']."</td>";
                        echo "<td>".$row['fechaReporte']."</td>";
                        echo "<td>".$row['fechaSolucion']."</td>";
                        switch($row['idInstalacion']){
                            case 1: echo "<td>CAR Tijuana</td>"; break;
                            case 2: echo "<td>CD Deportiva Mexicali</td>"; break;
                            case 3: echo "<td>CAR Ensenada</td>"; break;
                            case 4: echo "<td>KM43</td>"; break;
                            case 5: echo "<td>CAR San Felipe</td>"; break;
                        }
                        switch($row['idtipoDeServicio']){
                            case 1: echo "<td>SIP</td>"; break;
                            case 2: echo "<td>HARDWARE</td>"; break;
                            case 3: echo "<td>SOFTWARE</td>"; break;
                            case 4: echo "<td>COMPRAS</td>"; break;
                            case 5: echo "<td>CAJA</td>"; break;
                        }
                        echo "</tr>";           
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>