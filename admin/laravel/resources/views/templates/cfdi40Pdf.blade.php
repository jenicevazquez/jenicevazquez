<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <style>
        @page {
            size: letter;
            margin: 1.0cm;
        }
        *{
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
        }
        body{
            font-size: 12px;
            color: black;
        }
        .title{
            text-align: center;
            background: #a4b0bf;
        }
        .title h1{
            font-size: 24px;
            margin: 5px;
            font-weight: bold;
        }
        .bg-gray{
            background: #e7e7e7;
            padding: 5px 10px;
        }
        .detailsFactura{
            font-size: 10px;
        }
        .detailsFactura > div{
            margin-bottom: 5px;
        }
        th,td{
            border:none !important;
        }
        .fieldname{
            font-weight: bold;
        }
        .titleSmall{
            font-size: 10px;
            font-weight: bold;
        }
        .small{
            font-size: 10px;
        }
        #tablaconceptos th{
            background:#a4b0bf;
            border: 1px solid #0c0c0c !important;
        }
        hr {
            width: 100%;
            border: 1px solid black;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .cadenas > div{
            margin: 5px;
            word-wrap: break-word !important;
        }
        .wrapword {
            white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            white-space: pre-wrap;       /* css-3 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
            word-break: break-all;
            white-space: normal;
        }
    </style>
</head>
<body>
@include("templates.cfdi40")
</body>
</html>