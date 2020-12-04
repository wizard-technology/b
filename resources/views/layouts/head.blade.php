<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{config('app.name') }} | {{ $title ?? 'Dashboard'}}</title>
    <meta content="mhamad kamaran" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <link rel="stylesheet" href="{{asset('assets/plugins/metro/MetroJs.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">
    <link href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>

    <link href="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" /> 
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<style>
    .feather {
        display: inline-block;
        line-height: 17px;
        margin-left: 3px;
        margin-right: 5px;
        text-align: center;
        vertical-align: middle;
        width: 18px;
    }
</style>