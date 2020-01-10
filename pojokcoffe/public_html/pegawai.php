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
			$setInIndexDotPhp = "Tambah, edit hapus pegawai";
			$pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$jabatan=mysqli_query($con,"SELECT * FROM jabatan");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Pegawai',
				'pegawai' => $pegawai,
				'jabatan' => $jabatan
			);
			
			renderLayoutWithContentFile("pegawai.php", $variables);
		break;
		case "save_data":
			$nama		=$_POST['nama'];
			$alamat		=$_POST['alamat'];
			$tempat_lahir		=$_POST['tempat_lahir'];
			$tgl_lahir		=$_POST['tgl_lahir'];
			$jk		=$_POST['jk'];
			$jabatan		=$_POST['jabatan'];
			$username	=$_POST['username'];
			if(isset($_POST['password'])){
				$password	=md5($_POST['password']);
			}
			$id = $_POST['id_pegawai'];

			if($id!=0){
				// echo"asdasd";
				mysqli_query($con,"UPDATE pegawai SET  
					`nama` =  '$nama',
					`alamat` =  '$alamat',
					`tempat_lahir` =  '$tempat_lahir',
					`tgl_lahir` =  '$tgl_lahir',
					`jk` =  '$jk',
					`id_jabatan` =  '$jabatan',
					`username` =  '$username' WHERE id_pegawai='".$id."'");
				// print($a);echo 
				// echo mysqli_error($con);
			}else{
			mysqli_query($con,"INSERT INTO pegawai VALUES (NULL, '$nama', '$alamat', '$tempat_lahir', '$tgl_lahir', '$jk', '$jabatan','$password', '$username')");
			}
			header("location:pegawai.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM pegawai where id_pegawai='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "delete":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM pegawai where id_pegawai='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "search":
			$id	=$_POST['keyword'];

			$bahan=mysqli_query($con,"SELECT * FROM pegawai Where id_pegawai = '$id' or nama = '$id' or tempat_lahir = '$id' or tgl_lahir = '$id' or alamat = '$id'");
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