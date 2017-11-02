
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>SB Admin - Bootstrap Admin Template</title>

<!-- Bootstrap Core CSS -->
<link href="<?= asset('../css/bootstrap.min.css') ?>" rel="stylesheet">

<link href="<?= asset('../js/metisMenu/metisMenu.min.css') ?>" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?= asset('../css/sb-admin-2.css') ?>" rel="stylesheet">

<!--custom btns css-->
<link href="<?= asset('../css/custombtns.css') ?>" rel="stylesheet">


<!-- Morris Charts CSS -->
<link href="<?= asset('../css/plugins/morris.css') ?>" rel="stylesheet">

<!-- Custom Fonts -->
<link href="<?= asset('../font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

<link href="<?= asset('../css/angular-growl.css" rel="stylesheet') ?>" type="text/css">

<link rel='stylesheet' href="<?= asset('../css/loading-bar.min.css') ?>" type='text/css' media='all' />

<link href="<?= asset('../css/select2.min.css') ?>" rel="stylesheet" />

<link rel="stylesheet" href="<?= asset('../css/select.css') ?>" />

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<style type="text/css">
    .ui-select-dropdown { opacity: 1 !important; }

    .modal-xl {
        width: 1000px;
    }

    .col-centered{
        float: none;
        margin: 0 auto;
    }

    .popover{
        max-width: 400px;
    }

    .center-block {
        float: none !important
    }

    #loading-bar {
        pointer-events: all;
        z-index: 99999;
        border: none;
        width: 100%;
        height: 100%;
        cursor: wait;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: fixed;
        background-color: rgba(0, 0, 0, 0.28);
        /*background-color: rgba(38, 38, 38, 1);*/
    }

    #loading-bar img{
        position: absolute;
        margin: auto;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak],
    .ng-cloak, .x-ng-cloak,
    .ng-hide {
        display: none !important;
    }
</style>


