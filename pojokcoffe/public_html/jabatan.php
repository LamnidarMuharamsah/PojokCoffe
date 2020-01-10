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
			$setInIndexDotPhp = "Tambah, edit hapus jabatan";
			// $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$jabatan=mysqli_query($con,"SELECT * FROM jabatan");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Jabatan',
				// 'pegawai' => $pegawai,
				'jabatan' => $jabatan
			);
			
			renderLayoutWithContentFile("jabatan.php", $variables);
		break;
		case "save_data":
			$jabatan		=$_POST['jabatan'];
			$deskripsi		=$_POST['deskripsi'];
			$id = $_POST['id_jabatan'];

			if($id!=0){
				// echo"asdasd";
				mysqli_query($con,"UPDATE jabatan SET  
					`jabatan` =  '$jabatan',
					`deskripsi` =  '$deskripsi'
					WHERE id_jabatan='".$id."'");
				// print($a);echo 
				// echo mysqli_error($con);
			}else{
			mysqli_query($con,"INSERT INTO jabatan VALUES (NULL, '$jabatan', '$deskripsi')");
			}
			header("location:jabatan.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM jabatan where id_jabatan='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "delete":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM jabatan where id_jabatan='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "search":
			$id	=$_POST['keyword'];

			$bahan=mysqli_query($con,"SELECT * FROM jabatan Where jabatan = '$id' or deskripsi = '$id'");
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