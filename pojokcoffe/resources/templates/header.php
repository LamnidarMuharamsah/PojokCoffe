<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SI Pojok Coffee</title>

    <!-- Bootstrap Core CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/plugin/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../assets/plugin/datatables-plugins/buttons.dataTables.min.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="../assets/plugin/datatables-responsive/dataTables.responsive.css" rel="stylesheet"><link href="../assets/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="../assets/plugin/select2/css/select2.min.css" rel="stylesheet">
    
    <link href="../assets/css/simple-sidebar.css" rel="stylesheet">
    <script src="../assets/js/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<?php
// session_start();
// print_r($_SESSION);
if(isset($_SESSION['petugas_id'])){

}else{
	header('location:../login.php?a=login');
}
?>
<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Pojok Coffe
                    </a>
                </li>
                <li>
                    <a href="index.php">Beranda</a>
                </li>
                <?php
                if($_SESSION['jabatan'] == 1){
                ?>
                <li>
                    <a href="pegawai.php">Pegawai</a>
                </li>
                <li>
                    <a href="jabatan.php">Jabatan</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 6){
                ?>
                <li>
                    <a href="menu.php">Menu</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 7){
                ?>
                <li>
                    <a href="Bahan_baku.php">Bahan Baku</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 8 || $_SESSION['jabatan'] == 3){
                ?>

                <li>
                    <a href="kuisioner.php">Kuisioner</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 8){
                ?>
                <li>
                    <a href="kuisioner.php?a=isi_kuisioner">Isi Kuisioner</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 4 || $_SESSION['jabatan'] == 6){
                ?>
                <li>
                    <a href="pemesanan.php">Pemesanan</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 2){
                ?>
                <li>
                    <a href="pembayaran.php">Pembayaran</a>
                </li>
                <?php } ?>
                 <?php
                if($_SESSION['jabatan'] == 1 || $_SESSION['jabatan'] == 3){
                ?>
                <li>
                    <a href="penjualan.php">Laporan Penjualan</a>
                </li>
                <?php } ?>
                <li>
                    <a href="../login.php?a=logout">Logout</a>
                </li>
            </ul>
        </div>