        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseDatos" aria-expanded="false" aria-controls="collapseDatos">
                        <i class="fa fa-folder-open"></i> Mis Datos
                    </a>
                </li>
                <?php if($user[0]->{'tipoUsuario'}==1 | $user[0]->{'tipoUsuario'}==3): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/iniciar/<?php echo $user[0]->{'idUsuario'}; ?>">
                            <i class="fa fa-files-o"></i> Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/solicitantes/<?php echo $user[0]->{'idUsuario'}; ?>">
                            <i class="fa fa-user"></i> Solicitantes
                        </a>
                    </li>
                <?php endif; ?>
                <?php if($user[0]->{'tipoUsuario'}==1): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/data/<?php echo $user[0]->{'idUsuario'}; ?>">
                            <i class="fa fa-bar-chart"></i> Estadísticas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/soporte/<?php echo $user[0]->{'idUsuario'}; ?>">
                            <i class="fa fa-users"></i> Soporte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/admin/crear/<?php echo $user[0]->{'idUsuario'}; ?>">
                            <i class="fa fa-plus"></i> Crear Usuario
                        </a>
                    </li>    
                <?php endif; ?>
                <?php if($user[0]->{'tipoUsuario'}==2): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/solicitante/iniciar/<?php echo $user[0]->{'idUsuario'}; ?>">
                            <i class="fa fa-files-o"></i> Solicitudes
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/users/password/<?php echo $user[0]->{'idUsuario'}; ?>">
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
        <div class="password-container">
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
                            <p><?php echo $user[0]->{'accountName'}; ?></p>
                        </div>                  
                        <div class="col">
                            <p><?php echo $user[0]->{'displayName'}; ?></p>
                        </div>
                        <div class="col">
                            <?php 
                                switch($user[0]->{'idInstalacion'}){
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
            <h4 style="text-align: center">Cambiar Contraseña</h4>
            <?php echo form_open('index.php/users/verify'); ?>
                <div class="row">
                    <div class="col-md col-md-offset-4">
                        <div class="input-group mb-3">   
                            <input type="password" class="form-control" name="actual" placeholder="Contraseña actual">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="nuevo" placeholder="Nueva contraseña">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="confirmar" placeholder="Confirmar nueva contraseña">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col padding">
                        <button type="submit" name="guardar" class="btn btn-primary">
                        <i class="fa fa-floppy-o"></i> Guardar
                        </button>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>