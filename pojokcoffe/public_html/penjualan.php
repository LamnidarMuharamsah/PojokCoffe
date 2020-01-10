<?php
  include"../lib/koneksi.php";
  require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

  require_once(LIBRARY_PATH . "/templateFunctions.php");

  /*
    Now you can handle all your php logic outside of the template
    file which makes for very clean code!
  */
    session_start();
  if(!isset($_GET['a'])){
    $_GET['a'] = 'asdasd';
  }
  switch ($_GET['a']) {
    default:
      $setInIndexDotPhp = "";
      // $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
      $menu=mysqli_query($con,"SELECT * FROM menu");
      // $pemesanan=mysqli_query($con,"SELECT * FROM pemesanan where status != 3");
      $pembayaran=mysqli_query($con,"SELECT pembayaran.*,pemesanan.tgl_pesan FROM pembayaran,pemesanan where pemesanan.id_pemesanan = pembayaran .id_pemesanan");
      // Must pass in variables (as an array) to use in template
      $variables = array(
        'setInIndexDotPhp' => $setInIndexDotPhp,
        'pageTitle' => 'Penjualan',
        'menu' => $menu,
        // 'pemesanan' => $pemesanan,
        'pembayaran' => $pembayaran
      );
      
      renderLayoutWithContentFile("penjualan.php", $variables);
    break;
    case "search":
      $id =$_POST['keyword'];

      $bahan=mysqli_query($con,"SELECT * FROM pembayaran Where id_pemesanan = '$id' or tgl_pesan = '$id'");
      // print_r($bahan);
      $i=0;
      $b=[];
      while($a = mysqli_fetch_object($bahan)){
        $b[$i]=$a;
        $i++;
      }
      echo json_encode($b);
    break;

  }

?>