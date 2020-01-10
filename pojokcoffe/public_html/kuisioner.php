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
			$setInIndexDotPhp = "Tambah, edit hapus kuisioner";
			// $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$kuisioner=mysqli_query($con,"SELECT * FROM kuisioner");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Kuisioner',
				'kuisioner' => $kuisioner
			);
			
			renderLayoutWithContentFile("kuisioner.php", $variables);
		break;
		case "save_data":
			$id_pegawai		=$_POST['id_pegawai'];
			$tgl_kuisioner		=date('Y-m-d');
			$tgl_selesai		=$_POST['tgl_selesai'];
			$judul = $_POST['judul_kuisioner'];
			$id = $_POST['id_kuisioner'];

			if($id!=0){
				// echo"asdasd";
				mysqli_query($con,"UPDATE kuisioner SET  
					`id_pegawai` =  '$id_pegawai',
					`tgl_kuisioner` =  '$tgl_kuisioner',
					`tgl_selesai` =  '$tgl_selesai',
					`judul_kuisioner` =  '$judul'
					WHERE id_kuisioner='".$id."'");
				for ($i=0; $i <count($_POST['pertanyaan']) ; $i++) { 
					$pertanyaan = $_POST['pertanyaan'][$i];
					if($_POST['id_pertanyaan'][$i]==0){
					mysqli_query($con,"INSERT INTO pertanyaan VALUES (NULL, '$pertanyaan','$id')");
					}else{
						mysqli_query($con,"UPDATE pertanyaan SET  
					`id_kuisioner` =  '$id',
					`pertanyaan` =  '$pertanyaan'
					WHERE id_pertanyaan='".$_POST['id_pertanyaan'][$i]."'");
					}
					echo mysqli_error($con);
	        	}
				// print($a);echo 
				// echo mysqli_error($con);
			}else{
			mysqli_query($con,"INSERT INTO kuisioner VALUES (NULL, '$id_pegawai', '$tgl_kuisioner', '$tgl_selesai', '$judul','1')");
				$last_id = mysqli_insert_id($con);
				for ($i=0; $i <count($_POST['pertanyaan']) ; $i++) { 
					$pertanyaan = $_POST['pertanyaan'][$i];
					mysqli_query($con,"INSERT INTO pertanyaan VALUES (NULL,'$pertanyaan', '$last_id')");
					echo mysqli_error($con);
	        	}
			}
			header("location:kuisioner.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM kuisioner where id_kuisioner='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "delete":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM kuisioner where id_kuisioner='".$id."'");
			// print_r($pegawai);
			echo 1;
		break;
		case "delete_detail":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"DELETE FROM pertanyaan where id_pertanyaan='".$id."'");
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

			$bahan=mysqli_query($con,"SELECT * FROM pertanyaan Where id_kuisioner = '$id'");
			// print_r($bahan);
			$i=0;
			$b=[];
			while($a = mysqli_fetch_object($bahan)){
				$b[$i]=$a;
				$i++;
			}
			echo json_encode($b);
		break;
		case "edit_detail_jawaban":
			$id	=$_POST['idx'];

			$bahan=mysqli_query($con,"SELECT * FROM pertanyaan Where id_kuisioner = '$id'");
			// print_r($bahan);
			$i=0;
			$b=[];
			while($a = mysqli_fetch_array($bahan)){
				$sangat_baik=mysqli_query($con,"SELECT * FROM jawaban Where pertanyaan = '".$a['id_pertanyaan']."' and jawaban = 1");
				$a['sangat_baik'] = mysqli_num_rows($sangat_baik);
				$baik=mysqli_query($con,"SELECT * FROM jawaban Where pertanyaan = '".$a['id_pertanyaan']."' and jawaban = 2");
				$a['baik'] = mysqli_num_rows($baik);
				$cukup_baik=mysqli_query($con,"SELECT * FROM jawaban Where pertanyaan = '".$a['id_pertanyaan']."' and jawaban = 3");
				$a['cukup_baik'] = mysqli_num_rows($cukup_baik);
				$buruk=mysqli_query($con,"SELECT * FROM jawaban Where pertanyaan = '".$a['id_pertanyaan']."' and jawaban = 4");
				$a['buruk'] = mysqli_num_rows($buruk);
				$sangat_buruk=mysqli_query($con,"SELECT * FROM jawaban Where pertanyaan = '".$a['id_pertanyaan']."' and jawaban = 5");
				echo mysqli_error($con);
				$a['sangat_buruk'] = mysqli_num_rows($sangat_buruk);
				
				$b[$i]=$a;
				$i++;
			}
			echo json_encode($b);
		break;
		case "isi_kuisioner":
			$setInIndexDotPhp = "isi kuisioner";
			// $pegawai=mysqli_query($con,"SELECT * FROM pegawai");
			$kuisioner=mysqli_query($con,"SELECT * FROM kuisioner");
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Kuisioner',
				'kuisioner' => $kuisioner
			);
			
			renderLayoutWithContentFile("isi_kuisioner.php", $variables);
		break;
		case "save_data_jawaban":
			for ($i=0; $i <count($_POST['id_pertanyaan']) ; $i++) { 
					$pertanyaan = $_POST['id_pertanyaan'][$i];
					$jawaban =  $_POST[$_POST['id_pertanyaan'][$i]];
					mysqli_query($con,"INSERT INTO jawaban VALUES (NULL,'$jawaban', '$pertanyaan')");
					echo mysqli_error($con);
	        	}
	        header("location:kuisioner.php?a=isi_kuisioner");
		break;
		case "search":
			$id	=$_POST['keyword'];

			$bahan=mysqli_query($con,"SELECT * FROM kuisioner Where judul = '$id' or tgl_selesai = '$id' or tgl_kuisioner = '$id'");
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