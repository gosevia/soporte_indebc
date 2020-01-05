        <?php echo validation_errors(); ?>
        <br />
        <div class="login-container">
            <h3 class="montserrat">Sistema de Órdenes de Servicio TI</h3>
            <?php echo form_open('index.php/users/login'); ?>
                <div class="row">
                    <div class="col-md col-md-offset-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text user"><i class="fa fa-user"></i></span>   
                            <input type="text" class="form-control" name="rfc" placeholder="RFC (solicitante) o Correo Electrónico (soporte)" value="<?php echo set_value('rfc');?>">
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fa fa-lock fa-lg"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Contraseña">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col padding">
                        <button type="submit" style="background-color: #691b33; border: #691b33 2px solid" name="iniciar" class="btn btn-primary">
                            <i class="fa fa-sign-in"></i> Iniciar Sesión
                        </button>
                    </div>
                    <!--
                    <div class="col-sm-6">
                        <button type="submit" name="registro" class="btn btn-default pull-right">
                            <i class="fa fa-arrow-circle-o-up"></i> Alta Usuario
                        </button>
                    </div>
                    -->
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
