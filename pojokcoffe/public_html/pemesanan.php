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
			$menu=mysqli_query($con,"select * from (select menu.id_menu as id_menu,menu.nama,detail_bahan_baku.jumlah_bahan as jumlah_bahan,count(detail_bahan_baku.id_menu) as jumlah,bahan_baku.stok as stok from bahan_baku,menu,detail_bahan_baku where bahan_baku.id_bahan = detail_bahan_baku.id_bahan and menu.id_menu = detail_bahan_baku.id_menu GROUP by menu.id_menu) main INNER JOIN ( select menu.id_menu as id_menu,count(detail_bahan_baku.id_menu)as sub_jumlah from bahan_baku,menu,detail_bahan_baku where bahan_baku.id_bahan = detail_bahan_baku.id_bahan and menu.id_menu = detail_bahan_baku.id_menu and detail_bahan_baku.jumlah_bahan < bahan_baku.stok GROUP by menu.id_menu ) subquery on main.id_menu = subquery.id_menu where main.jumlah = subquery.sub_jumlah");
			if($_SESSION['jabatan'] == 6){
				$pemesanan=mysqli_query($con,"SELECT * FROM pemesanan where status = 1");	
			}else{
				$pemesanan=mysqli_query($con,"SELECT * FROM pemesanan");
			}
			// Must pass in variables (as an array) to use in template
			$variables = array(
				'setInIndexDotPhp' => $setInIndexDotPhp,
				'pageTitle' => 'Pemesanan',
				'menu' => $menu,
				'pemesanan' => $pemesanan
			);
			
			renderLayoutWithContentFile("pemesanan.php", $variables);
		break;
		case "save_data":
			$id_pegawai		=$_POST['id_pegawai'];
			$tgl_pesan		=date('Y-m-d');
			$no_meja		=$_POST['no_meja'];
			
			$id = $_POST['id_pemesanan'];

			if($id!=0){
				// echo"asdasd";
				mysqli_query($con,"UPDATE pemesanan SET  
					`id_pegawai` =  '$id_pegawai',
					`tgl_pesan` =  '$tgl_pesan',
					`no_meja` =  '$no_meja'
					WHERE id_pemesanan='".$id."'");
				for ($i=0; $i <count($_POST['menu']) ; $i++) { 
					$menu = $_POST['menu'][$i];
					$jumlah = $_POST['jumlah'][$i];
					if($_POST['id_detail_pemesanan'][$i]==0){
					mysqli_query($con,"INSERT INTO detail_pemesanan VALUES (NULL, '$id','$menu', '$jumlah')");
					}else{
						mysqli_query($con,"UPDATE detail_pemesanan SET  
					`id_pemesanan` =  '$id',
					`id_menu` =  '$menu',
					`jumlah` =  '$jumlah'
					WHERE id_detail_pemesanan='".$_POST['id_detail_pemesanan'][$i]."'");
					}
					echo mysqli_error($con);
	        	}
				// print($a);echo 
				// echo mysqli_error($con);
			}else{
			mysqli_query($con,"INSERT INTO pemesanan VALUES (NULL, '$id_pegawai', '$tgl_pesan', '$no_meja',1)");
				$last_id = mysqli_insert_id($con);
				for ($i=0; $i <count($_POST['menu']) ; $i++) { 
					$menu = $_POST['menu'][$i];
					$jumlah = $_POST['jumlah'][$i];
					mysqli_query($con,"INSERT INTO detail_pemesanan VALUES (NULL, '$last_id','$menu', '$jumlah')");
					echo mysqli_error($con);
	        	}
			}
			header("location:pemesanan.php");

		break;
		case "edit":
			$id	=$_POST['idx'];

			$pegawai=mysqli_query($con,"SELECT * FROM pemesanan where id_pemesanan='".$id."'");
			// print_r($pegawai);
			$a = mysqli_fetch_array($pegawai);
			echo json_encode($a);
		break;
		case "ganti_status":
			$id	=$_GET['b'];
			$pegawai=mysqli_query($con,"SELECT * FROM detail_pemesanan where id_pemesanan='".$id."'");
			while ($a = mysqli_fetch_array($pegawai)) {
				$menu = mysqli_query($con,"SELECT * FROM detail_bahan_baku where id_menu='".$a['id_menu']."'");
				while ($b = mysqli_fetch_array($menu)) {
					$jumlah = $b['jumlah_bahan'] * $a['jumlah'];
					mysqli_query($con,"UPDATE bahan_baku SET  
					`stok` =  `stok` - '$jumlah'
					WHERE id_bahan='".$b['id_bahan']."'");
				}
			}
			echo mysqli_error($con);
			mysqli_query($con,"UPDATE pemesanan SET  
					`status` =  '2'
					WHERE id_pemesanan='".$id."'");
			header("location:pemesanan.php");
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

			$bahan=mysqli_query($con,"select * from (select menu.id_menu as id_menu,menu.nama,detail_bahan_baku.jumlah_bahan as jumlah_bahan,count(detail_bahan_baku.id_menu) as jumlah,bahan_baku.stok as stok from bahan_baku,menu,detail_bahan_baku where bahan_baku.id_bahan = detail_bahan_baku.id_bahan and menu.id_menu = detail_bahan_baku.id_menu GROUP by menu.id_menu) main INNER JOIN ( select menu.id_menu as id_menu,count(detail_bahan_baku.id_menu)as sub_jumlah from bahan_baku,menu,detail_bahan_baku where bahan_baku.id_bahan = detail_bahan_baku.id_bahan and menu.id_menu = detail_bahan_baku.id_menu and detail_bahan_baku.jumlah_bahan < bahan_baku.stok GROUP by menu.id_menu ) subquery on main.id_menu = subquery.id_menu where main.jumlah = subquery.sub_jumlah");
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

			$bahan=mysqli_query($con,"SELECT * FROM pemesanan Where id_pemesanan = '$id' or tgl_pesan = '$id' or no_meja = '$id'");
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