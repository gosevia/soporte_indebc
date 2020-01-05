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
                <?php if($user->{'tipoUsuario'}==1): ?>
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
                <?php endif; ?>
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
        <div class="solicitud-container">
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
            <?php if($detalle): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm header">
                            <p>Folio: <?php echo $detalle[0]['idReporte']; ?></p>
                        </div>
                        <div class="col-sm header">
                            <p>Fecha de creación: <?php echo $detalle[0]['fechaReporte']; ?>
                        </div>
                    </div>
                </div>
                <?php echo form_open('index.php/admin/seguimientoReporte'); ?>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Tipo de servicio:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '' => 'Selecciona un problema...',
                                        '1' => 'SIP',
                                        '2' => 'HARDWARE (Equipo físico)',
                                        '3' => 'SOFTWARE (Programas)',
                                        '4' => 'COMPRAS',
                                        '5' => 'CAJA'
                                    );
                                    echo form_dropdown('problema', $options, $detalle[0]['idtipoDeServicio'], 'class="form-control prop"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><strong>Describe brevemente tu problema</strong></p>
                        </div>
                        <div class="col">
                            <p><strong>Diagnóstico realizado por soporte</strong></p>
                        </div>
                        <div class="col">
                            <p><strong>Solución del reporte</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php 
                                $data_reporte = array(
                                    'id' => 'textreporte',
                                    'name' => 'textreporte',
                                    'value' => $detalle[0]['reporteUsuario'],
                                    'style' => 'width: 100%',
                                    'disabled' => TRUE
                                    );
                                echo form_textarea($data_reporte);
                            ?>
                        </div>
                        <div class="col">
                            <?php 
                                $data_diagnostico = array(
                                    'id' => 'textdiagnostico',
                                    'name' => 'textdiagnostico',
                                    'value' => $detalle[0]['diagnosticoSoporte'],
                                    'style' => 'width: 100%',
                                    'disabled' => TRUE
                                    );
                                echo form_textarea($data_diagnostico);
                            ?>
                        </div>
                        <div class="col">
                            <?php 
                                $data_solucion = array(
                                    'id' => 'textsolucion',
                                    'name' => 'textsolucion',
                                    'value' => $detalle[0]['solucionSoporte'],
                                    'style' => 'width: 100%',
                                    'disabled' => TRUE
                                    );
                                echo form_textarea($data_solucion);
                            ?>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <ul style="list-style-type:none">
                            <?php if(!empty($files)){ foreach($files as $file){ ?>
                            <li>
                                <img class="imagen-soporte" src="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" >
                            </li>
                            <?php } }else{ ?>
                            <p>Sin imágenes...</p>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Instalación donde se encuentra actualmente:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '' => 'Selecciona una instalación...',
                                        '1' => 'CAR Tijuana',
                                        '2' => 'CD Deportiva Mexicali',
                                        '3' => 'CAR Ensenada',
                                        '4' => 'KM43',
                                        '5' => 'CAR San Felipe'
                                    );
                                    echo form_dropdown('instalacion', $options, $detalle[0]['idInstalacion'], 'class="form-control prop"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type='hidden' id='detalle' name='detalle' value='<?php echo $detalle[0]['idReporte']; ?>' />
                            <button type="submit" name="seguimiento" class="btn btn-success pull-left">
                                <i class="fa fa-bookmark"></i> Dar Seguimiento
                            </button>
                            &nbsp
                            <button type="submit" name="cerrar" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cerrar Ventana
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
                <h4 style="text-align: center">Historial de Seguimiento</h4>
                    <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Seguimiento realizado por</th>
                        <th scope="col">Fecha de seguimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($historial as $row){
                        if($row['folio'] == $detalle[0]['idReporte']){
                            echo "<td>".$row['id']."</td>";
                            foreach($admin as $ad){
                                if($ad['idUsuario']==$row['soporte']){
                                    $name = $ad['displayName'];
                                    echo "<td>".$name."</td>";
                                }
                            }
                            echo "<td>".$row['fechaSeguimiento']."</td>";
                            echo "</tr>";
                        }           
                    }
                    ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if($seguimiento): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm header">
                            <p>Folio: <?php echo $seguimiento[0]['idReporte']; ?></p>
                        </div>
                        <div class="col-sm header">
                            <?php echo date('Y-m-d H:i:s'); ?>
                        </div>
                    </div>
                </div>
                <?php echo form_open('index.php/admin/actualizarReporte'); ?>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Tipo de servicio:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '' => 'Selecciona un problema...',
                                        '1' => 'SIP',
                                        '2' => 'HARDWARE (Equipo físico)',
                                        '3' => 'SOFTWARE (Programas)',
                                        '4' => 'COMPRAS',
                                        '5' => 'CAJA'
                                    );
                                    echo form_dropdown('problema', $options, $seguimiento[0]['idtipoDeServicio'], 'class="form-control prop"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><strong>Describe brevemente tu problema</strong></p>
                        </div>
                        <div class="col">
                            <p><strong>Diagnóstico realizado por soporte</strong></p>
                        </div>
                        <div class="col">
                            <p><strong>Solución del reporte</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php 
                                $data_reporte = array(
                                    'id' => 'textreporte',
                                    'name' => 'textreporte',
                                    'value' => $seguimiento[0]['reporteUsuario'],
                                    'style' => 'width: 100%',
                                    'disabled' => TRUE
                                    );
                                echo form_textarea($data_reporte);
                            ?>
                        </div>
                        <div class="col">
                            <?php 
                                $data_diagnostico = array(
                                    'id' => 'textdiagnostico',
                                    'name' => 'textdiagnostico',
                                    'value' => $seguimiento[0]['diagnosticoSoporte'],
                                    'style' => 'width: 100%'
                                    );
                                echo form_textarea($data_diagnostico);
                            ?>
                        </div>
                        <div class="col">
                            <?php 
                                $data_solucion = array(
                                    'id' => 'textsolucion',
                                    'name' => 'textsolucion',
                                    'value' => $seguimiento[0]['solucionSoporte'],
                                    'style' => 'width: 100%'
                                    );
                                echo form_textarea($data_solucion);
                            ?>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <ul style="list-style-type:none">
                            <?php if(!empty($files)){ foreach($files as $file){ ?>
                            <li>
                                <img class="imagen-soporte" src="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" >
                            </li>
                            <?php } }else{ ?>
                            <p>Sin imágenes...</p>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Instalación donde se encuentra actualmente:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '' => 'Selecciona una instalación...',
                                        '1' => 'CAR Tijuana',
                                        '2' => 'CD Deportiva Mexicali',
                                        '3' => 'CAR Ensenada',
                                        '4' => 'KM43',
                                        '5' => 'CAR San Felipe'
                                    );
                                    echo form_dropdown('instalacion', $options, $seguimiento[0]['idInstalacion'], 'class="form-control prop"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type='hidden' id='detalle' name='detalle' value='<?php echo $seguimiento[0]['idReporte']; ?>' />
                            <button type="submit" name="guardar" class="btn btn-success pull-left">
                                <i class="fa fa-bookmark"></i> Guardar
                            </button>&nbsp
                            <button type="submit" name="cancelar" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
                <h4 style="text-align: center">Historial de Seguimiento</h4>
                    <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Seguimiento realizado por</th>
                        <th scope="col">Fecha de seguimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($historial as $row){
                        if($row['folio'] == $seguimiento[0]['idReporte']){
                            echo "<td>".$row['id']."</td>";
                            foreach($admin as $ad){
                                if($ad['idUsuario']==$row['soporte']){
                                    $name = $ad['displayName'];
                                    echo "<td>".$name."</td>";
                                }
                            }
                            echo "<td>".$row['fechaSeguimiento']."</td>";
                            echo "</tr>";
                        }           
                    }
                    ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if($historial == null): ?>
                <h4 style="text-align: center">Solicitudes</h4>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                    <th scope="col" id='estado1'>Sin seguimiento</th>
                    <th scope="col" id='estado2'>En proceso...</th>
                    <th scope="col" id='estado3'>Concluido</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td style="width: 33%">Esta orden necesita la atención de soporte.</td>
                    <td style="width: 33%">Esta orden ya está recibiendo atención de soporte.</td>
                    <td style="width: 33%">Esta orden ya fue solucionada. No requiere de seguimiento adicional.</td>
                    </tr>
                    </tbody>
                </table>
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">Estatus</th>
                        <th scope="col">Folio</th>
                        <th scope="col">Fecha de Solicitud</th>
                        <th scope="col">Solicitante</th>
                        <th scope="col">Instalación</th>
                        <th scope="col">Última Actualización</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($reportes as $row){
                        $newcell = 0;
                        echo "<tr>";
                        switch($row['statusReporte']){
                            case 1: echo "<td id='estado1'>Sin seguimiento</td>"; break;
                            case 2: echo "<td id='estado2'>En proceso...</td>"; break;
                            case 3: echo "<td id='estado3'>Concluido</tc>"; break; 
                        }
                        echo "<td>".$row['idReporte']."</td>";
                        echo "<td>".$row['fechaReporte']."</td>";
                        foreach($solicitantes as $sol){
                            if($sol['idUsuario']==$row['idUsuario']){
                                echo "<td>".$sol['displayName']."</td>";
                            }
                        }
                        switch($row['idInstalacion']){
                            case 1: echo "<td>CAR Tijuana</td>"; break;
                            case 2: echo "<td>CD Deportiva Mexicali</td>"; break;
                            case 3: echo "<td>CAR Ensenada</td>"; break;
                            case 4: echo "<td>KM43</td>"; break;
                            case 5: echo "<td>CAR San Felipe</td>"; break;
                        }
                        echo "<td>".$row['ultimaActualizacion']."</td>";
                        echo '<td>';
                        echo form_open('index.php/admin/detalleReporte');
                        echo "<input type='hidden' id='detalle' name='detalle' value='".$row['idReporte']."' />";
                        echo '<button class="btn btn-outline-primary" type="submit" value=""><i class="fa fa-search" id="submit"></i></button>';
                        echo form_close();
                        echo "</td>";
                        echo "</tr>";           
                    }
                    ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>