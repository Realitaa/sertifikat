<?php
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
}
include "koneksi.php";

// jika ada get act
if(isset($_GET['act'])){

	//proses simpan data
	if($_GET['act']=='insert'){
		//variabel dari elemen form
		$nama 	= $_POST['nama'];
		$id_donor 	= $_POST['id_donor'];
		$no_hp 	= $_POST['no_hp'];
		$tanggal_lahir 	= $_POST['tanggal_lahir'];
		$nosertifikat = $_POST['nosertifikat'];
		$kategori	= $_POST['kategori'];

		if($nama=='' || $nosertifikat=='' || $kategori==''){
			echo "<script>
			        alert('Data tidak lengkap');
			        window.location.href = 'data_sertifikat.php';
			    </script>";
				exit;
		}

		// Mengecek apakah id_donor dengan kategori yang sama sudah ada di database
		$cek = mysqli_query($konek, "SELECT id, id_donor, kategori FROM dsertifikat WHERE id_donor = '$id_donor'");
		$data = mysqli_fetch_array($cek);
		
		if($data){
			if ($data['id_donor'] == $id_donor && $data['kategori'] == $kategori) {
				header('location:data_sertifikat.php?id_donor='.$id_donor.'&kategori='.$kategori);
				exit;
			}
		} else{			
			//proses simpan data admin
			$simpan = mysqli_query($konek, "INSERT INTO dsertifikat(nama, id_donor, no_hp, tanggal_lahir, no_sertifikat,kategori) 
							VALUES ('$nama', '$id_donor', '$no_hp', '$tanggal_lahir','$nosertifikat','$kategori')");

			if ($simpan) {
				header('location:data_sertifikat.php');
				exit;
			}
		}

	} else if ($_GET['act']=='delete'){
	    $id = $_GET['id'];
	        
	    if ($id) {
	        $hapus = mysqli_query($konek, "DELETE FROM dsertifikat WHERE id = $id");
	        if ($hapus) {
	            header('location:data_sertifikat.php');
				exit;
	        }
	    } else {
	        header('location:data_sertifikat.php');
			exit;
	    }
	} else if ($_GET['act'] == 'afterprint') {
	    $id = $_POST['id'];

		if ($id) {
			$id = intval($id);

			$update = mysqli_query($konek, "UPDATE dsertifikat SET banyak_copy = banyak_copy + 1 WHERE id = $id");
		} else {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan jumlah cetak']);		
		}
	}

	else{
		header('location:data_sertifikat.php');
	}

} // akhir get act

else{
	header('location:data_sertifikat.php');
}
?>
