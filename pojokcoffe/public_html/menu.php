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
			$setInIndexDotPhp = "Tambah, edit hapus menu";
			// $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$menu=mysqli_query($con,"SELECT * FROM menu");
			$bahan_baku=mysqli_query($con,"SELECT * FROM bahan_baku");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Menu',
				'menu' => $menu,
				'bahan_baku' => $bahan_baku
			);
			
			renderLayoutWithContentFile("menu.php", $variables);
		break;
		case "save_data":
			$nama		=$_POST['nama'];
			$jenis		=$_POST['jenis'];
			$harga		=$_POST['harga'];
			
			$id = $_POST['id_menu'];

			if($id!=0){
				// echo"asdasd";
				mysqli_query($con,"UPDATE menu SET  
					`nama` =  '$nama',
					`jenis` =  '$jenis',
					`harga` =  '$harga'
					WHERE id_menu='".$id."'");
				for ($i=0; $i <count($_POST['bahan']) ; $i++) { 
					$bahan = $_POST['bahan'][$i];
					$ket = $_POST['ket'][$i];
					$jumlah = $_POST['jumlah'][$i];
					if($_POST['id_detail_bahan'][$i]==0){
					mysqli_query($con,"INSERT INTO detail_bahan_baku VALUES (NULL, '$id','$bahan', '$jumlah', '$ket')");
					}else{
						mysqli_query($con,"UPDATE detail_bahan_baku SET  
					`id_menu` =  '$id',
					`id_bahan` =  '$bahan',
					`jumlah_bahan` =  '$jumlah',
					`ket` =  '$ket'
					WHERE id_detail_bahan='".$_POST['id_detail_bahan'][$i]."'");
					}
					echo mysqli_error($con);
	        	}
				// print($a);echo 
				// echo mysqli_error($con);
			}else{
			mysqli_query($con,"INSERT INTO menu VALUES (NULL, '$nama', '$jenis', '$harga')");
				$last_id = mysqli_insert_id($con);
				for ($i=0; $i <count($_POST['bahan']) ; $i++) { 
					$bahan = $_POST['bahan'][$i];
					$ket = $_POST['ket'][$i];
					$jumlah = $_POST['jumlah'][$i];
					mysqli_query($con,"INSERT INTO detail_bahan_baku VALUES (NULL, '$last_id','$bahan', '$jumlah', '$ket')");
					echo mysqli_error($con);
	        	}
			}
			header("location:menu.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM menu where id_menu='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "delete":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM menu where id_menu='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "delete_detail":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM detail_bahan_baku where id_detail_bahan='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "get_bahan":
			// $id	=$_POST['idx'];

			$bahan=mysqli_query($con,"SELECT * FROM bahan_baku");
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

			$bahan=mysqli_query($con,"SELECT * FROM detail_bahan_baku Where id_menu = '$id'");
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

			$bahan=mysqli_query($con,"SELECT * FROM menu Where jenis = '$id' or nama = '$id' or harga = '$id'");
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