<?php
include 'koneksi.php';

$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : 'Semua';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk memfilter data berdasarkan tahun, kategori, dan pencarian
$query = "SELECT * FROM dsertifikat WHERE 1 ";

// Filter berdasarkan tahun
if ($tahun != 'Semua') {
    $query .= " AND YEAR(tanggal) = '$tahun'";
}

// Filter berdasarkan kategori
if (!empty($kategori)) {
    $query .= " AND kategori = '$kategori'";
}

// Filter berdasarkan pencarian
if (!empty($search)) {
    $query .= " AND (nama LIKE '%$search%' OR no_hp LIKE '%$search%' OR no_sertifikat LIKE '%$search%' OR id_donor LIKE '%$search%' OR banyak_copy LIKE '%$search%')";
}

$query .= " ORDER BY id ASC"; // Urutkan berdasarkan ID

$sql = mysqli_query($konek, $query);
$no = 1;
while ($d = mysqli_fetch_array($sql)) {
    $tanggal = formatTanggalIndo($d['tanggal']); // Format tanggal
    $cetak = '';
    if ($d['kategori'] >= 10) {
        $cetak = "
            <a class='btn btn-success btn-sm' href='cetak_sertifikat.php?id=$d[id]' 
            target='_blank' id='cetak-btn-$d[id]'>Cetak</a>
        ";
    }
    echo "<tr>
        <td width='40px' align='center'>$no</td>
        <td>$tanggal</td>
        <td>$d[nama]</td>
        <td>$d[id_donor]</td>
        <td>$d[no_hp]</td>
        <td>$d[tanggal_lahir]</td>
        <td>$d[no_sertifikat]</td>
        <td>$d[kategori]</td>
        <td>$d[banyak_copy]</td>
        <td align='center'>$cetak <a href='aksi_sertifikat.php?act=delete&id=$d[id]' class='btn btn-danger btn-sm'>Hapus</a></td>
    </tr>";
    $no++;
}
?>
