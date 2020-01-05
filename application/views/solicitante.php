        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseDatos" aria-expanded="false" aria-controls="collapseDatos">
                        <i class="fa fa-folder-open"></i> Mis Datos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/solicitante/iniciar/<?php echo $user->{'idUsuario'}; ?>">
                        <i class="fa fa-files-o"></i> Solicitudes
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
                    <!-- <div class="row center">
                        <div class="col">
                            <?php 
                                switch($user->{'direccion'}){
                                    case 1: echo "<p>Dirección General</p>"; break;
                                    case 2: echo "<p>Dirección Administrativa</p>"; break;
                                    case 3: echo "<p>DANC Y CF</p>"; break;
                                    case 4: echo "<p>Dirección Promoción e Imagen</p>"; break;
                                    case 5: echo "<p>Dirección de Desarrollo del Deporte</p>"; break;
                                    case 6: echo "<p>Dirección de Infraestructura Deportiva</p>"; break; 
                                }; ?>
                        </div>
                    </div> -->
                </div>
            </div>    
            <?php echo form_open_multipart('index.php/solicitante/solicitud'); ?>
                <div class="row center">
                    <div class="col">
                        <h4>Nueva Solicitud</h4>
                    </div>
                </div>
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
                                echo form_dropdown('problema', $options, $default_problema, 'class="form-control"');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>Describe brevemente tu problema</strong></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php 
                            $data_textarea = array(
                                'id' => 'textarea',
                                'name' => 'textarea',
                                'value' => $text,
                                'style' => 'width: 100%'
                                );
                            echo form_textarea($data_textarea);
                        ?>
                    </div>
                </div>
                <?php if($user->{'rol'}==1): ?>
                <br />
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
                                echo form_dropdown('instalacion', $options, $default_instalacion, 'class="form-control"');
                            ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <?php $options = array(
                        '' => 'Selecciona una instalación...',
                        '1' => 'CAR Tijuana',
                        '2' => 'CD Deportiva Mexicali',
                        '3' => 'CAR Ensenada',
                        '4' => 'KM43',
                        '5' => 'CAR San Felipe'
                    );
                    echo form_dropdown('instalacion', $options, $default_instalacion, 'class="form-control invisible"');
                    ?>
                <?php endif; ?>
                <br />
                <div class="row">
                    <div class="col">
                        <p><strong>Seleccione todos los archivos que desee adjuntar al reporte</strong>
                        <input type="file" class="form-control-file" name="files[]" multiple /></p> 
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" name="guardar" class="btn btn-success pull-left">
                            <i class="fa fa-floppy-o"></i> Guardar Reporte
                        </button>&nbsp
                        <button type="submit" name="nuevo" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Nueva Solicitud
                        </button>
                    </div>
                </div>
            <?php echo form_close(); ?>
            <?php if($reportes){  
                echo '<br />';
                echo '<div class="row center">';
                    echo '<div class="col">';
                        echo '<h4>Mis Solicitudes</h4>';
                    echo '</div>';
                echo '</div>';
                echo '<table id="myTable" class="table table-striped table-bordered">';
                    echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="col">Folio</th>';
                        echo '<th scope="col">Fecha de registro</th>';
                        echo '<th scope="col">Fecha de lectura por soporte</th>';
                        echo '<th scope="col">Fecha de solución</th>';
                        echo '<th scope="col">Estatus</th>';
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach($reportes as $row){
                        echo "<tr>";
                        echo "<td>".$row['idReporte']."</td>";
                        echo "<td>".$row['fechaReporte']."</td>";
                        echo "<td>".$row['fechaLecturaSoporte']."</td>";
                        echo "<td>".$row['fechaSolucion']."</td>";
                        switch($row['statusReporte']){
                            case 1: echo "<td>Sin seguimiento</td>"; break;
                            case 2: echo "<td>En proceso...</td>"; break;
                            case 3: echo "<td>Concluido</td>"; break;
                            default: echo "<td>Concluido</td>";
                        }
                        echo "</tr>";           
                        }
                    echo '</tbody>';
                echo '</table>';
            }
            ?>
        </div>
    </div>