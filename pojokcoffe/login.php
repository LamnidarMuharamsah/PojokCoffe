<?php
include"lib/koneksi.php";
switch ($_GET['a']) {
	case 'input_petugas':
		
		$nama		=$_POST['nama'];
		$alamat		=$_POST['alamat'];
		$tlp		=$_POST['tlp'];
		$tmp		=$_POST['tmp'];
		$tgl		=$_POST['tgl'];
		$ket		=$_POST['ket'];
		$username	=$_POST['username'];
		$password	=md5($_POST['password']);

		mysql_query("INSERT INTO petugas VALUES (NULL, '$nama', '$alamat', '$tlp', '$tmp', '$tgl', '$ket', '$username', '$password', '0')");
		header("location:../pgw/petugas");

		break;

	case 'login':
		
		$username		=$_POST['user'];
		$password		=md5($_POST['pass']);

		$p=mysqli_query($con,"SELECT * FROM pegawai where username='".$username."' and password='".$password."'");
		$yu=mysqli_num_rows($p);
		if($yu==0){
			header("location:index.php");
			// print_r($yu);
		}
		else{
			$u=mysqli_fetch_array($p);
			session_start();
			$_SESSION['petugas_id'] = $u['id_pegawai'];
			$_SESSION['jabatan'] = $u['id_jabatan'];
			header("location:public_html/index.php");
			// print_r($_SESSION);
		}

		break;

	case 'logout':
		
		session_start();
		session_destroy();
		header("location:index.php");

		break;

	case 'hapus_petugas':
		
		mysql_query("DELETE FROM petugas WHERE id_petugas='$_GET[id]'");
		header("location:view.php?a=input_petugas");

		break;

	case 'edit_petugas':
		
		$id 		=$_POST['id'];
		$nama		=$_POST['nama'];
		$alamat		=$_POST['alamat'];
		$tlp		=$_POST['tlp'];
		$tmp		=$_POST['tmp'];
		$tgl		=$_POST['tgl'];
		$ket		=$_POST['ket'];

		mysql_query("UPDATE  petugas SET  
					`nama` =  '$nama',
					`alamat` =  '$alamat',
					`no_tlp` =  '$tlp',
					`tmp_lhr` =  '$tmp',
					`tgl_lhr` =  '$tgl',
					`ket` =  '$ket' WHERE  id_petugas ='$id'");
		header("location:../pgw/petugas");
		break;
	
	default:
		# code...
		break;
}
?>