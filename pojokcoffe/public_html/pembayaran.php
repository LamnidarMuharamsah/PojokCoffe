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
			$setInIndexDotPhp = "Tambah, edit hapus pemesanan";
			// $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$menu=mysqli_query($con,"SELECT * FROM menu");
			$pemesanan=mysqli_query($con,"SELECT * FROM pemesanan where status != 3");
			$pembayaran=mysqli_query($con,"SELECT * FROM pembayaran");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Pembayaran',
				'menu' => $menu,
				'pemesanan' => $pemesanan,
				'pembayaran' => $pembayaran
			);
			
			renderLayoutWithContentFile("pembayaran.php", $variables);
		break;
		case "save_data":
			$id_pegawai		=$_POST['id_pegawai'];
			// $tgl_pesan		=date('Y-m-d');
			$diskon		=$_POST['diskon'];
			$total_bayar		=$_POST['jml_bayar'];
			$bayar		=$_POST['bayar'];
			$kembalian		=$_POST['kembalian'];
			$id = $_POST['id_pemesanan'];

			// if($id!=0){
			// 	// echo"asdasd";
				mysqli_query($con,"UPDATE pemesanan SET  
					`status` =  '3'
					WHERE id_pemesanan='".$id."'");
			// 	for ($i=0; $i <count($_POST['menu']) ; $i++) { 
			// 		$menu = $_POST['menu'][$i];
			// 		$jumlah = $_POST['jumlah'][$i];
			// 		if($_POST['id_detail_pemesanan'][$i]==0){
			// 		mysqli_query($con,"INSERT INTO detail_pemesanan VALUES (NULL, '$id','$menu', '$jumlah')");
			// 		}else{
			// 			mysqli_query($con,"UPDATE detail_pemesanan SET  
			// 		`id_pemesanan` =  '$id',
			// 		`id_menu` =  '$menu',
			// 		`jumlah` =  '$jumlah'
			// 		WHERE id_detail_pemesanan='".$_POST['id_detail_pemesanan'][$i]."'");
			// 		}
			// 		echo mysqli_error($con);
	  //       	}
			// 	// print($a);echo 
			// 	// echo mysqli_error($con);
			// }else{
			mysqli_query($con,"INSERT INTO pembayaran VALUES (NULL, '$id', '$diskon', '$total_bayar','$id_pegawai','$bayar','$kembalian')");
				// $last_id = mysqli_insert_id($con);
				// for ($i=0; $i <count($_POST['menu']) ; $i++) { 
				// 	$menu = $_POST['menu'][$i];
				// 	$jumlah = $_POST['jumlah'][$i];
				// 	mysqli_query($con,"INSERT INTO detail_pemesanan VALUES (NULL, '$last_id','$menu', '$jumlah')");
					echo mysqli_error($con);
	        	// }
			// }
			header("location:pembayaran.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM pemesanan where id_pemesanan='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "detail":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM pembayaran where id_pembayaran='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "get_menu_details":
			$id	=$_POST['id'];

			$pegawai=mysqli_query($con,"SELECT * FROM menu where id_menu='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "delete":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM pemesanan where id_pemesanan='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "delete_detail":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM detail_pemesanan where id_detail_pemesanan='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "get_menu":
			// $id	=$_POST['idx'];

			$bahan=mysqli_query($con,"SELECT * FROM menu");
			// print_r($bahan);
			$i=0;
			$b=[];
			while($a = mysqli_fetch_object($bahan)){
				$b[$i]=$a;
				$i++;
			}
			echo json_encode($b);
		break;
		case "edit_detail":
			$id	=$_POST['idx'];

			$bahan=mysqli_query($con,"SELECT * FROM detail_pemesanan Where id_pemesanan = '$id'");
			// print_r($bahan);
			$i=0;
			$b=[];
			while($a = mysqli_fetch_object($bahan)){
				$b[$i]=$a;
				$i++;
			}
			echo json_encode($b);
		break;
		case "search":
			$id	=$_POST['keyword'];

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