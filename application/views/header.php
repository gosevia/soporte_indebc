<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Sistema de Solicitudes | INDE</title>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/datatables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('application/assets/css/main.css'); ?>" />
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/datatables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type='text/javascript'>
    //google.charts.load('current', {'packages':['bar']});
    $(document).ready( function () {
        $('#myTable').DataTable( {
            "language": lang_spanish
        });        
    });
    var lang_spanish = {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
</script>
</head>
<body>
    <div class="container-fluid">
        <div class="jumbotron">
            <p class="lead">
                <img src="<?php echo 'http://www.indebc.gob.mx/main/img/logoOficial.png'; ?>" width="300" />
            </p>    
        </div>
        <!-- Mensajes de Flash -->
        <?php if($this->session->flashdata('user_registered')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('user_registered').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('login_failed')): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('login_failed').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('reporte_guardado')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('reporte_guardado').'</div>'; ?>
        <?php elseif($this->session->flashdata('llenar_campos')): ?>
            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('llenar_campos').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('user_loggedout')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('user_loggedout').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('update_report')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('update_report').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('update_soporte')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('update_soporte').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('cleared_report')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('cleared_report').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('update_client')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('update_client').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('inactive_account')): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('inactive_account').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('password_change')): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('password_change').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('password_changed')): ?>
        <?php echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('password_changed').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('no_match')): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('no_match').'</div>'; ?>
        <?php endif; ?>
        <?php if($this->session->flashdata('wrong_password')): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'
            .$this->session->flashdata('wrong_password').'</div>'; ?>
        <?php endif; ?>
