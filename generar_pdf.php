<?php
// Requerir la librería de Dompdf
require 'vendor/autoload.php';

// Crear una nueva instancia de Dompdf
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// Obtener solo una sección específica de la página
ob_start();
include('templates/reciboform.php'); // Reemplaza esto con la ruta a tu archivo de sección específica
$sectionContent = ob_get_clean();

// Generar el contenido HTML completo con la sección específica
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
    :root {
        --bs-breakpoint-xs: 0;
        --bs-breakpoint-sm: 576px;
        --bs-breakpoint-md: 768px;
        --bs-breakpoint-lg: 992px;
        --bs-breakpoint-xl: 1200px;
        --bs-breakpoint-xxl: 1400px;
    }
    :root, [data-bs-theme=light] {
        --bs-blue: #0d6efd;
        --bs-indigo: #6610f2;
        --bs-purple: #6f42c1;
        --bs-pink: #d63384;
        --bs-red: #dc3545;
        --bs-orange: #fd7e14;
        --bs-yellow: #ffc107;
        --bs-green: #198754;
        --bs-teal: #20c997;
        --bs-cyan: #0dcaf0;
        --bs-black: #000;
        --bs-white: #fff;
        --bs-gray: #6c757d;
        --bs-gray-dark: #343a40;
        --bs-gray-100: #f8f9fa;
        --bs-gray-200: #e9ecef;
        --bs-gray-300: #dee2e6;
        --bs-gray-400: #ced4da;
        --bs-gray-500: #adb5bd;
        --bs-gray-600: #6c757d;
        --bs-gray-700: #495057;
        --bs-gray-800: #343a40;
        --bs-gray-900: #212529;
        --bs-primary: #0d6efd;
        --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545;
        --bs-light: #f8f9fa;
        --bs-dark: #212529;
        --bs-primary-rgb: 13,110,253;
        --bs-secondary-rgb: 108,117,125;
        --bs-success-rgb: 25,135,84;
        --bs-info-rgb: 13,202,240;
        --bs-warning-rgb: 255,193,7;
        --bs-danger-rgb: 220,53,69;
        --bs-light-rgb: 248,249,250;
        --bs-dark-rgb: 33,37,41;
        --bs-primary-text-emphasis: #052c65;
        --bs-secondary-text-emphasis: #2b2f32;
        --bs-success-text-emphasis: #0a3622;
        --bs-info-text-emphasis: #055160;
        --bs-warning-text-emphasis: #664d03;
        --bs-danger-text-emphasis: #58151c;
        --bs-light-text-emphasis: #495057;
        --bs-dark-text-emphasis: #495057;
        --bs-primary-bg-subtle: #cfe2ff;
        --bs-secondary-bg-subtle: #e2e3e5;
        --bs-success-bg-subtle: #d1e7dd;
    }

    .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
        width: 100%;
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        margin-right: auto;
        margin-left: auto;
    }

    .container {
              width: 90%;
    }
    .container {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .btn-group-vertical>.btn-group:after, .btn-group-vertical>.btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
        display: table;
        content: " ";
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    *, ::after, ::before {
        box-sizing: border-box;
    }
    .btn-group-vertical>.btn-group:after, .btn-toolbar:after, .clearfix:after, .container-fluid:after, .container:after, .dl-horizontal dd:after, .form-horizontal .form-group:after, .modal-footer:after, .nav:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .pager:after, .panel-body:after, .row:after {
        clear: both;
    }
    .btn-group-vertical>.btn-group:after, .btn-group-vertical>.btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
        display: table;
        content: " ";
    }
    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    *, ::after, ::before {
        box-sizing: border-box;
    }
   .text-center{
        text-align: center!important;}
        row {
            margin-right: -15px;
            margin-left: -15px;
        }


        .p-2 {
            padding: 0.5rem!important;
        }
        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));
        }
        div {
            font-family: "Montserrat", sans-serif;
        }
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        * {
            font-family: "Montserrat", sans-serif;
            text-decoration: none;
            border: 0px;
            margin: 0px;
        }
        div {
            display: block;
        }
        .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-right: auto;
            margin-left: auto;
        }
        label {
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .col-5 {
            width: 41.66666667%;
        }
        .col-6 {
            width: 50%;
        }
        .col-12 {
            width: 100%;
        }.mt-2 {
            margin-top: 0.5rem!important;
        }.p-2 {
            padding: 0.5rem!important;
        }
        .mt-3 {
            margin-top: 1rem!important;
        }.d-inline {
            display: inline!important;
        }
        th {
            text-align: left;
        }
        td, th {
            padding: 0;
        }
        tbody, td, tfoot, th, thead, tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }
        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }
        th {
            display: table-cell;
            vertical-align: inherit;
            font-weight: bold;
            text-align: -internal-center;
        }
        .p-4 {
            padding: 1.5rem!important;
        }.h5, h5 {
            font-size: 14px;
            font-weight:300
        }
        .h4, .h5, .h6, h4, h5, h6 {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .print-section{
            background-image: url("img/logo-marca.jpg"); background-size:60px;
            background-position:center;
        }
    </style>
</head>
<body>
    <div class="contenido">
        ' . $sectionContent . '
    </div>
</body>
</html>';

// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);

// (Opcional) Configurar opciones de Dompdf
$dompdf->setPaper('A4', 'portrait'); // Establecer tamaño de papel y orientación

// Renderizar el contenido HTML en PDF
$dompdf->render();

// Enviar el PDF al navegador para su descarga
$dompdf->stream('liquidacion.pdf');
