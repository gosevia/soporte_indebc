        <button class="btn btn-outline-success" type="button" data-toggle="collapse" data-target="#collapseDatos" aria-expanded="false" aria-controls="collapseDatos">
            <i class="fa fa-folder-open"></i> Mis Datos
        </button>
        <a href="<?php echo base_url(); ?>index.php/admin/iniciar/<?php echo $user->{'idUsuario'}; ?>"><button type="button" class="btn btn-outline-primary">
            <i class="fa fa-files-o"></i> Solicitudes
        </button></a>
        <a href="<?php echo base_url(); ?>index.php/admin/solicitantes/<?php echo $user->{'idUsuario'}; ?>"><button type="button" class="btn btn-outline-primary">
            <i class="fa fa-files-o"></i> Solicitantes
        </button></a>
        <a href="<?php echo base_url(); ?>index.php/users/password/<?php echo $user->{'idUsuario'}; ?>"><button type="button" class="btn btn-outline-secondary">
            <i class="fa fa-lock"></i> Cambiar contraseña
        </button></a>
        <a href="<?php echo base_url(); ?>index.php/admin/logout"><button type="button" class="btn btn-outline-danger">
            <i class="fa fa-sign-out"></i> Cerrar Sesión
        </button></a>
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
            <h4 style="text-align: center">Historial de Seguimiento</h4>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Solicitud</th>
                    <th scope="col">Soporte</th>
                    <th scope="col">Fecha de seguimiento</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach($seguimiento as $row){
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['folio']."</td>";
                    foreach($admin as $ad){
                        if($ad['idUsuario']==$row['soporte']){
                            $name = $ad['displayName'];
                            $arr = explode(' ',trim($name));
                            echo "<td>".$arr[0]."</td>";
                        }
                    }
                    echo "<td>".$row['fechaSeguimiento']."</td>";
                    echo '<td>';
                    echo form_open('index.php/admin/detalleReporte');
                    echo "<input type='hidden' id='detalle' name='detalle' value='".$row['folio']."' />";
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