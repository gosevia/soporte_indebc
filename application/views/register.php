        <?php echo validation_errors(); ?>
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
        <div class="register-container">
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
            <h4 style="text-align: center">Crear Usuario</h4>
            <?php echo form_open('index.php/admin/registrar'); ?>
                <div class="row">
                    <div class="col-md col-md-offset-4">
                        <?php $estatus = 1; $tipoUsuario = 3; ?>
                        <div class="input-group mb-3">   
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" value="<?php echo set_value('nombre');?>">
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" name="apellido" placeholder="Apellido(s)" value="<?php echo set_value('apellido');?>">
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" name="correo" placeholder="Correo Electrónico" value="<?php echo set_value('correo');?>">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="password" placeholder="Contraseña">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="confirm" placeholder="Confirmar Contraseña">
                        </div>
                        <div class="input-group mb-4">
                            <?php $options = array(
                                    '1' => 'CAR Tijuana',
                                    '2' => 'CD Deportiva Mexicali',
                                    '3' => 'CAR Ensenada',
                                    '4' => 'KM43',
                                    '5' => 'CAR San Felipe'
                                );
                                echo form_dropdown('instalaciones', $options, '', 'class="form-control"');
                            ?>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" name="telefono" placeholder="Teléfono" value="<?php echo set_value('telefono');?>">
                        </div>
                        <input type="hidden" class="form-control" name="estatus" value="1">
                        <input type="hidden" class="form-control" name="tipoUsuario" value="3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" name="guardar" class="btn btn-primary pull-left">
                        <i class="fa fa-floppy-o"></i> Guardar Usuario
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" name="cancelar" class="btn btn-default pull-right">
                        <i class="fa fa-times"></i> Cancelar
                        </button>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>