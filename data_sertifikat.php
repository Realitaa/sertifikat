<?php include "header.php"; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container">

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Data Instansi Donor Tahun
                    <select name="tahun" id="tahun" style="color: black;">
                        <option value="Semua">Semua</option>
                        <?php
                        $currentYear = date('Y'); // Ambil tahun saat ini
                        $sql = mysqli_query($konek, "SELECT DISTINCT YEAR(tanggal) AS tahun FROM dsertifikat ORDER BY tahun DESC");
                        while ($d = mysqli_fetch_array($sql)) {
                            $selected = ($d['tahun'] == $currentYear) ? "selected" : "";
                            echo "<option value='$d[tahun]' $selected>$d[tahun]</option>";
                        }
                        ?>
                    </select>
                </h3>
            </div>
            <div class="panel-body">
                <div class="row" style="margin-bottom: 15px;">
                    <!-- Filter Kategori -->
                    <div class="col-md-6">
                        <select id="filter-kategori" class="form-control" style="width: auto; display: inline-block;">
                            <option value="">Semua Kategori</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                        </select>
                    </div>
                    <!-- Input Search -->
                    <div class="col-md-6 text-right">
                        <input type="text" id="search-input" class="form-control" placeholder="Search..." style="width: auto; display: inline-block;">
                    </div>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pendonor</th>
                            <th>ID Donor</th>
                            <th>Nomor Telepon</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor Sertifikat</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="data-table">
                        <!-- Data akan dimuat melalui AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        // Fungsi untuk memfilter dan memuat data
        function loadData(tahun, kategori, searchValue) {
            $.ajax({
                url: 'get_sertifikat_data.php', // Buat file PHP terpisah untuk mengambil data
                type: 'GET',
                data: {
                    tahun: tahun,
                    kategori: kategori,
                    search: searchValue
                },
                success: function(response) {
                    $('#data-table').html(response); // Menampilkan data dalam tabel
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }

        // Event untuk filter kategori
        $('#filter-kategori').on('change', function() {
            const kategori = $(this).val();
            const searchValue = $('#search-input').val().toLowerCase();
            const selectedYear = $('#tahun').val();
            loadData(selectedYear, kategori, searchValue); // Memuat data dengan filter kategori
        });

        // Event untuk pencarian
        $('#search-input').on('keyup', function() {
            const searchValue = $(this).val().toLowerCase();
            const kategori = $('#filter-kategori').val();
            const selectedYear = $('#tahun').val();
            loadData(selectedYear, kategori, searchValue); // Memuat data dengan pencarian
        });

        // Menangani perubahan tahun
        $('#tahun').change(function() {
            const selectedYear = $(this).val();
            const kategori = $('#filter-kategori').val();
            const searchValue = $('#search-input').val().toLowerCase();
            loadData(selectedYear, kategori, searchValue); // Memuat data berdasarkan tahun
        });

        // Memuat data pertama kali dengan tahun default
        let selectedYear = $('#tahun').val();
        let kategori = $('#filter-kategori').val();
        let searchValue = $('#search-input').val().toLowerCase();
        loadData(selectedYear, kategori, searchValue);
    });
</script>
