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
                            <p>ID: <?php echo $detalle[0]['idUsuario']; ?></p>
                        </div>
                        <div class="col-sm header">
                            <p>RFC: <?php echo $detalle[0]['accountName']; ?></p>
                        </div>
                    </div>
                </div>
                <?php echo form_open('index.php/admin/editarSolicitante'); ?>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Rol del solicitante:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '0' => 'Usuario General',
                                        '1' => 'Director'
                                    );
                                    echo form_dropdown('rol', $options, $detalle[0]['rol'], 'class="form-control prop"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Estatus de cuenta:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '0' => 'NO ACTIVO',
                                        '1' => 'ACTIVO'
                                    );
                                    echo form_dropdown('estatus', $options, $detalle[0]['estatus'], 'class="form-control prop"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type='hidden' id='detalle' name='detalle' value='<?php echo $detalle[0]['idUsuario']; ?>' />
                            <button type="submit" name="seguimiento" class="btn btn-success pull-left">
                                <i class="fa fa-bookmark"></i> Editar datos
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            <?php endif; ?>
            <?php if($seguimiento): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm header">
                            <p>ID: <?php echo $seguimiento[0]['idUsuario']; ?></p>
                        </div>
                        <div class="col-sm header">
                            <p>RFC: <?php echo $seguimiento[0]['accountName']; ?></p>
                        </div>
                    </div>
                </div>
                <?php echo form_open('index.php/admin/actualizarSolicitante'); ?>
                <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Rol del solicitante:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '0' => 'Usuario General',
                                        '1' => 'Director'
                                    );
                                    echo form_dropdown('rol', $options, $seguimiento[0]['rol'], 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Estatus de cuenta:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '0' => 'NO ACTIVO',
                                        '1' => 'ACTIVO'
                                    );
                                    echo form_dropdown('estatus', $options, $seguimiento[0]['estatus'], 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type='hidden' id='detalle' name='detalle' value='<?php echo $seguimiento[0]['idUsuario']; ?>' />
                            <button type="submit" name="guardar" class="btn btn-success pull-left">
                                <i class="fa fa-bookmark"></i> Guardar
                            </button>&nbsp
                            <button type="submit" name="cancelar" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            <?php endif; ?>
            <h4 style="text-align: center">Solicitantes</h4>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">RFC</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Último inicio de sesión</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach($solicitantes as $row){
                    $newcell = 0;
                    echo "<td>".$row['idUsuario']."</td>";
                    echo "<td>".$row['accountName']."</td>";
                    echo "<td>".$row['displayName']."</td>";
                    echo "<td>";
                    if($row['estatus'] == 1){
                        echo "ACTIVO</td>";
                    }else{
                        echo "NO ACTIVO</td>";
                    }
                    echo "<td>";
                    switch($row['rol']){
                        case 0: echo "Usuario General</td>"; break;
                        case 1: echo "Director</td>"; break;
                    }
                    echo "<td>".$row['ultimoInicioSesion']."</td>";
                    echo '<td>';
                    echo form_open('index.php/admin/detalleSolicitante');
                    echo "<input type='hidden' id='detalle' name='detalle' value='".$row['idUsuario']."' />";
                    echo '<button class="btn btn-outline-primary" type="submit" value=""><i class="fa fa-search" id="submit"></i></button>';
                    echo form_close();
                    echo "</td>";
                    echo "</tr>";           
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>