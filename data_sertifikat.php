<?php include "header.php"; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container">

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading" style="display: flex; align-items: center; justify-content: space-between;">
                <h3 class="panel-title" style="margin: 0;">
                    Data Instansi Donor Tahun
                    <select name="tahun" id="tahun" style="color: black;">
                        <option value="Semua">Semua</option>
                        <?php
                        $currentYear = date('Y'); // Ambil tahun saat ini
                        $selectedYear = (isset($_GET['id_donor']) && isset($_GET['kategori'])) ? "Semua" : $currentYear;
                        $sql = mysqli_query($konek, "SELECT DISTINCT YEAR(tanggal) AS tahun FROM dsertifikat ORDER BY tahun DESC");
                        while ($d = mysqli_fetch_array($sql)) {
                            $selected = ($d['tahun'] == $selectedYear) ? "selected" : "";
                            echo "<option value='$d[tahun]' $selected>$d[tahun]</option>";
                        }
                        ?>
                    </select>
                </h3>
                <button class="btn btn-default btn-sm pull-right" style="margin-left: 10px;"
                    onclick="resetFilter()">Reset Filter</button>
            </div>

            <div class="panel-body">
                <div class="row" style="margin-bottom: 15px;">
                    <!-- Filter Kategori -->
                    <div class="col-md-6">
                        <select id="filter-kategori" class="form-control" style="width: auto; display: inline-block;">
                            <option value="">Semua Kategori</option>
                            <option value="10" <?= isset($_GET['kategori']) && $_GET['kategori'] == 10 ? 'selected' : '' ?>>10</option>
                            <option value="25" <?= isset($_GET['kategori']) && $_GET['kategori'] == 25 ? 'selected' : '' ?>>25</option>
                            <option value="50" <?= isset($_GET['kategori']) && $_GET['kategori'] == 50 ? 'selected' : '' ?>>50</option>
                            <option value="75" <?= isset($_GET['kategori']) && $_GET['kategori'] == 75 ? 'selected' : '' ?>>75</option>
                        </select>
                    </div>

                    <!-- Input Search -->
                    <div class="col-md-6 text-right">
                        <input type="text" id="search-input" class="form-control" placeholder="Search..."
                            style="width: auto; display: inline-block;"
                            value="<?= isset($_GET['id_donor']) ? $_GET['id_donor'] : '' ?>">
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
                            <th>Cetak Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="data-table">
                        <!-- Data akan dimuat melalui AJAX -->
                    </tbody>
                </table>
                <?php
                if (isset($_GET["id_donor"]) && isset($_GET["kategori"])) {
                    echo "<p class='text-center' style='color: red; font-size: 20px;' id='data-exist'>Data ini sudah ada cuy!</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function () {
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
                success: function (response) {
                    $('#data-table').html(response); // Menampilkan data dalam tabel
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }

        // Event untuk filter kategori
        $('#filter-kategori').on('change', function () {
            const kategori = $(this).val();
            const searchValue = $('#search-input').val().toLowerCase();
            const selectedYear = $('#tahun').val();
            loadData(selectedYear, kategori, searchValue); // Memuat data dengan filter kategori
        });

        // Event untuk pencarian
        $('#search-input').on('keyup', function () {
            const searchValue = $(this).val().toLowerCase();
            const kategori = $('#filter-kategori').val();
            const selectedYear = $('#tahun').val();
            loadData(selectedYear, kategori, searchValue); // Memuat data dengan pencarian
        });

        // Menangani perubahan tahun
        $('#tahun').change(function () {
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

        // Function to reset filter
        function resetFilter() {
            const currentYear = new Date().getFullYear();
            $('#tahun').val(currentYear);
            $('#filter-kategori').val('');
            $('#search-input').val('');
            loadData(currentYear, '', ''); // Memuat data setelah reset filter
            $('#data-exist').hide(); // Menyembunyikan pesan data sudah ada
        }

        // Attach resetFilter function to button click
        $('.btn-default').on('click', resetFilter);
    });
</script>