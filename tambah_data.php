<?php include "header.php"; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Data Instansi Donor</h3>
			</div>
			<div class="panel-body">

				<form method="post" action="aksi_sertifikat.php?act=insert">
					<table class="table">
						<tr>
							<td width="160px">Nama Pendonor</td>
							<td>
								<div class="col-md-6"><input class="form-control" type="text" name="nama" required /></div>
							</td>
						</tr>
						<tr>
							<td>ID Donor</td>
							<td>
								<div class="col-md-6"><input class="form-control" type="text" name="id_donor" required /></div>
							</td>
						</tr>
						<tr>
							<td>Nomor Telepon</td>
							<td>
								<div class="col-md-6"><input class="form-control" type="text" name="no_hp" required /></div>
							</td>
						</tr>
						<tr>
							<td>Tanggal Lahir</td>
							<td>
								<div class="col-md-6"><input class="form-control" type="text" name="tanggal_lahir" id="tgl" required /></div>
							</td>
						</tr>
						<tr>
							<td>No. Sertifikat</td>
							<td>
								<div class="col-md-6">
									<?php
									// Ambil nilai MAX(id) dari tabel dsertifikat
									$sql = mysqli_query($konek, "SELECT LEFT(no_sertifikat, 3) AS last_sertifikat, RIGHT(no_sertifikat, 4) AS tahun FROM dsertifikat ORDER BY id DESC LIMIT 1");
									$row = mysqli_fetch_assoc($sql); // Ambil hasil sebagai array asosiatif
									$tahun = $row['tahun'] ?? '1';
									$last_sertifikat = $row['last_sertifikat'] ?? '1';

									if ($tahun == date('Y')) {
										// Tambahkan format tiga digit
										$formatted_sertifikat = sprintf('%03d', $last_sertifikat + 1);
									} else {
										// Reset menjadi 001
										$formatted_sertifikat = "001";
									}

									$bulanRomawi = '';

									// Menentukan bulan dalam Romawi
									switch (date('n')) {
										case 1:
											$bulanRomawi = 'I';
											break;
										case 2:
											$bulanRomawi = 'II';
											break;
										case 3:
											$bulanRomawi = 'III';
											break;
										case 4:
											$bulanRomawi = 'IV';
											break;
										case 5:
											$bulanRomawi = 'V';
											break;
										case 6:
											$bulanRomawi = 'VI';
											break;
										case 7:
											$bulanRomawi = 'VII';
											break;
										case 8:
											$bulanRomawi = 'VIII';
											break;
										case 9:
											$bulanRomawi = 'IX';
											break;
										case 10:
											$bulanRomawi = 'X';
											break;
										case 11:
											$bulanRomawi = 'XI';
											break;
										case 12:
											$bulanRomawi = 'XII';
											break;
									}
									?>
									<input class="form-control" type="text" name="nosertifikat"
										value="<?php echo htmlspecialchars($formatted_sertifikat); ?>/1.01.02/PK - SERT/DD/<?php echo $bulanRomawi ?>/<?php echo date('Y') ?>" required />
								</div>
							</td>
						</tr>
						<tr>
							<td>Kategori</td>
							<td>
								<div class="col-md-6">
									<select name="kategori" class="form-control">
										<option value="10">10 (Sepuluh)</option>
										<option value="25">25 (Dua Puluh Lima)</option>
										<option value="50">50 (Lima Puluh)</option>
										<option value="75">75 (Tujuh Puluh Lima)</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<div class="col-md-6">
									<input class="btn btn-primary" type="submit" value="Simpan" />
									<a class="btn btn-danger" href="data_sertifikat.php">Kembali</a>
								</div>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
	flatpickr("#tgl", {
		dateFormat: "Y-m-d",
	});
</script>

<?php include "footer.php"; ?>