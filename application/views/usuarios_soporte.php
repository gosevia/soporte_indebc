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
        <div class="usuarios-container">
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
                    </div>
                </div>
                <?php echo form_open('index.php/admin/editarSoporte'); ?>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Correo electrónico:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-3">   
                                <input type="text" class="form-control prop" name="correo" placeholder="<?php echo $detalle[0]['accountName']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Nombre de usuario:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-3">   
                                <input type="text" class="form-control prop" name="nombre" placeholder="<?php echo $detalle[0]['displayName']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Instalación:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
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
                        <div class="col-md col-md-offset-4">
                            <p><strong>Teléfono:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-3">   
                                <input type="text" class="form-control prop" name="telefono" placeholder="<?php echo $detalle[0]['telefono']; ?>">
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
            <?php if($editar): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm header">
                            <p>ID: <?php echo $editar[0]['idUsuario']; ?></p>
                        </div>
                    </div>
                </div>
                <?php echo form_open('index.php/admin/actualizarSoporte'); ?>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Correo electrónico:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-3">   
                                <input type="text" class="form-control" name="correo" value="<?php echo $editar[0]['accountName']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Nombre de usuario:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-3">   
                                <input type="text" class="form-control" name="nombre" value="<?php echo $editar[0]['displayName']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Instalación:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-4">      
                                <?php $options = array(
                                        '1' => 'CAR Tijuana',
                                        '2' => 'CD Deportiva Mexicali',
                                        '3' => 'CAR Ensenada',
                                        '4' => 'KM43',
                                        '5' => 'CAR San Felipe'
                                    );
                                    echo form_dropdown('instalacion', $options, $editar[0]['idInstalacion'], 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <p><strong>Teléfono:</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md col-md-offset-4">
                            <div class="input-group mb-3">   
                                <input type="text" class="form-control" name="telefono" value="<?php echo $editar[0]['telefono']; ?>">
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
                                    echo form_dropdown('estatus', $options, $editar[0]['estatus'], 'class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type='hidden' id='detalle' name='detalle' value='<?php echo $editar[0]['idUsuario']; ?>' />
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
            <h4 style="text-align: center">Usuarios de Soporte</h4>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Último inicio de sesión</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach($soporte as $row){
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
                    echo "<td>".$row['telefono']."</td>";
                    echo "<td>".$row['ultimoInicioSesion']."</td>";
                    echo '<td>';
                    echo form_open('index.php/admin/detalleSoporte');
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