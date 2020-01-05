        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseDatos" aria-expanded="false" aria-controls="collapseDatos">
                        <i class="fa fa-folder-open"></i> Mis Datos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/iniciar/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-files-o"></i> Solicitudes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/solicitantes/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-user"></i> Solicitantes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/data/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-bar-chart"></i> Estadísticas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/soporte/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-users"></i> Soporte
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/crear/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-plus"></i> Crear Usuario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/users/password/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-lock"></i> Cambiar Contraseña
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/logout">
                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </nav>
        <div class="data-container">
            <div class="collapse" id="collapseDatos">
                <div class="card card-body">
                    <div class="row center">
                        <div class="col">
                            <strong>RFC / Correo</strong>
                        </div>
                        <div class="col">
                            <strong>Nombre</strong>
                        </div>
                        <div class="col">    
                            <strong>Instalación</strong>
                        </div>
                    </div>
                    <div class="row center">
                        <div class="col">
                            <p><?php echo $user->{'accountName'}; ?></p>
                        </div>                  
                        <div class="col">
                            <p><?php echo $user->{'displayName'}; ?></p>
                        </div>
                        <div class="col">
                            <?php 
                                switch($user->{'idInstalacion'}){
                                    case 1: echo "<p>CAR Tijuana</p>"; break;
                                    case 2: echo "<p>CD Deportiva Mexicali</p>"; break;
                                    case 3: echo "<p>CAR Ensenada</p>"; break;
                                    case 4: echo "<p>KM43</p>"; break;
                                    case 5: echo "<p>CAR San Felipe</p>"; break; 
                                }; ?>    
                        </div>
                    </div>
                </div>
            </div> 
            <h4>Filtro de Datos</h4>
            <?php echo form_open('index.php/admin/filtrar'); ?>
                <div class="row center">
                    <div class="col-md col-md-offset-4">
                        <p><strong>Filtrar reportes por: </strong>
                        <?php $options = array(
                                '1' => 'Fecha de resolución',
                                '2' => 'Fecha de creación'
                            );
                            echo form_dropdown('filtrar', $options);
                        ?>
                        </p>
                    </div>
                    <div class="col-md col-md-offset-4">
                        <p><strong>Instalación: </strong>
                        <?php $options = array(
                                '0' => 'TODO',
                                '1' => 'CAR Tijuana',
                                '2' => 'CD Deportiva Mexicali',
                                '3' => 'CAR Ensenada',
                                '4' => 'KM43',
                                '5' => 'CAR San Felipe'
                            );
                            echo form_dropdown('instalaciones', $options);
                        ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md col-md-offset-4">
                        <div class="start_date input-group mb-4">
                            <input class="form-control start_date" type="text" name="start" placeholder="fecha inicial" id="startdate_datepicker">
                                <div class="input-group-append">
                            <span class="fa fa-calendar input-group-text start_date_calendar" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md col-md-offset-4">
                        <div class="end_date input-group mb-4">
                            <input class="form-control end_date" type="text" name="end" placeholder="fecha final" id="enddate_datepicker">
                            <div class="input-group-append">
                                <span class="fa fa-calendar input-group-text end_date_calendar" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col padding" style="text-align:center;">
                        <button type="submit" name="guardar" class="btn btn-primary">
                            <i class="fa fa-list"></i> Generar Reporte
                        </button>                       
                    </div>
                </div>
            <?php echo form_close(); ?>
            <?php $attributes = array('target' => '_blank'); echo form_open('index.php/admin/html_to_pdf/'.$p1.'/'.$p2.'/'.$p3.'/'.$p4, $attributes); ?>
                <?php if($filtro != null): ?>
                    <div class="row">
                        <div class="col padding" style="text-align:center;">
                            <input type="hidden" id="imgC" name="imgCode" value="">
                            <button type="submit" name="pdfView" class="btn btn-danger">
                                <i class="fa fa-file-pdf-o"></i> Ver PDF
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php echo form_close(); ?>
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
                <table id="reporte" class="table">
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
                    ?>
                        <tr>
                            <td><?php echo $startDate; ?></td>
                            <td><?php echo $endDate; ?></td>
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
                        <div id="bar_chart"></div>
                    </div>  
                </div>
                <table id="myTable" class="table table-striped table-bordered">
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
            <?php endif; ?>
        </div>
        <script>
            //google.load("visualization", "1", {packages:["corechart"]});
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
                var data = new google.visualization.arrayToDataTable([
                    ['Instalaciones', 'Total', 'Sin seguimiento', 'En proceso...', 'Concluido'],
                    ['CAR Tijuana', <?php echo $tj; ?>, <?php echo $tj1; ?>, <?php echo $tj2; ?>, <?php echo $tj3; ?>], 
                    ['CD Deportiva Mexicali', <?php echo $mx; ?>, <?php echo $mx1; ?>, <?php echo $mx2; ?>, <?php echo $mx3; ?>], 
                    ['CAR Ensenada', <?php echo $en; ?>, <?php echo $en1; ?>, <?php echo $en2; ?>, <?php echo $en3; ?>], 
                    ['KM43', <?php echo $km; ?>, <?php echo $km1; ?>, <?php echo $km2; ?>, <?php echo $km3; ?>], 
                    ['CAR San Felipe', <?php echo $sf; ?>, <?php echo $sf1; ?>, <?php echo $sf2; ?>, <?php echo $sf3; ?>]
                ]);

                var options = {
                legend: { position: 'top'},
                chart: { title: 'Reportes por Instalación',
                        subtitle: '' },
                bars: 'horizontal',
                bar: { groupWidth: "80%" },
                colors: ['#0000ff','#ff0000', '#ff6600', '#009933']
                };
                //var chart_div = document.getElementById('bar_chart');
                var chart = new google.visualization.BarChart(document.getElementById('bar_chart'));
                google.visualization.events.addListener(chart, 'ready', function () {
                    //chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    //console.log(chart_div.innerHTML);
                    document.getElementById("imgC").value = chart.getImageURI();
                        
                });
                chart.draw(data, options);
            }
        </script>
        <script>
            $(document).ready(function() {
                $("#startdate_datepicker").datepicker();
                $("#enddate_datepicker").datepicker();
            });
        </script>