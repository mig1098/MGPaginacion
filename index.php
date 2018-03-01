<?php
define('FCPATH',__DIR__);
require_once './bootstrap.php';

$paginacion = MGPaginacion::instancia();
$paginacion->url = 'http://localhost/paginacion/index.php';
$paginacion->totalRegistros=667;
$paginacion->porPagina = 10;
$paginacion->paginaActual = !empty($_GET['p']) ? $_GET['p'] : 1;
$paginacion->mostrar();
