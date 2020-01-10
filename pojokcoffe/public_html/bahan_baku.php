<?php
	include"../lib/koneksi.php";
	require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

	require_once(LIBRARY_PATH . "/templateFunctions.php");

	/*
		Now you can handle all your php logic outside of the template
		file which makes for very clean code!
	*/session_start();
	if(!isset($_GET['a'])){
		$_GET['a'] = 'asdasd';
	}
	switch ($_GET['a']) {
		default:
			$setInIndexDotPhp = "Tambah, edit hapus bahan baku";
			// $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$bahan_baku=mysqli_query($con,"SELECT * FROM bahan_baku");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Bahan Baku',
				// 'pegawai' => $pegawai,
				'bahan_baku' => $bahan_baku
			);
			
			renderLayoutWithContentFile("bahan_baku.php", $variables);
		break;
		case "save_data":
			$nama		=$_POST['nama'];
			$tgl_masuk		=$_POST['tgl_masuk'];
			$stok		=$_POST['stok'];
			$tgl_kadaluarsa		=$_POST['tgl_kadaluarsa'];
			$harga		=$_POST['harga'];
			$id = $_POST['id_bahan'];

			if($id!=0){
				// echo"asdasd";
				mysqli_query($con,"UPDATE bahan_baku SET  
					`nama` =  '$nama',
					`tgl_kadaluarsa` =  '$tgl_kadaluarsa',
					`stok` =  '$stok',
					`tgl_masuk` =  '$tgl_masuk',
					`harga` =  '$harga'
					WHERE id_bahan='".$id."'");
				// print($a);echo 
				// echo mysqli_error($con);
			}else{
			mysqli_query($con,"INSERT INTO bahan_baku VALUES (NULL, '$nama', '$tgl_masuk', '$stok', '$tgl_kadaluarsa', '$harga')");
			}
			header("location:bahan_baku.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM bahan_baku where id_bahan='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "delete":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM bahan_baku where id_bahan='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "search":
			$id	=$_POST['keyword'];

			$bahan=mysqli_query($con,"SELECT * FROM bahan_baku Where nama = '$id' or tgl_masuk = '$id' or tgl_kadaluarsa = '$id' or stok = '$id' or harga = '$id'");
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