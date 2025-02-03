<?php
    include "koneksi.php";
    ob_start();
    if (!isset($_SESSION['login'])) {
        echo '<link rel="stylesheet" href="watermark.css">';
    } else {
        $style = ''; 
    }

    if (!($_GET['id'])) {
        header('location:data_sertifikat.php');
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Cetak Sertifikat</title>
        <link rel="icon" href="./assets/img/logo.png">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f9f9f9;
            }

            .container {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                background: white;
                padding: 20mm;
                box-sizing: border-box;
                border: 1px solid #ddd;
                position: relative;
                overflow: hidden;
                z-index: 0;
            }

            .container > * {
                position: relative;
                z-index: 1; /* Pastikan konten tetap di atas watermark */
            }

            .top-border {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: auto;
                max-height: 50px;
            }

            .header {
                text-align: center;
                margin-top: 50px;
                margin-bottom: 20px;
            }

            .header img {
                max-width: 250px;
            }

            .header h1 {
                font-size: 24px;
                font-weight: bold;
                margin: 50px;
            }

            .content {
                text-align: center;
                margin-top: 50px;
            }

            .content p {
                font-size: 18px;
                margin: 10px 0;
            }

            .footer {
                text-align: center;
                margin-top: 80px;
            }

            .footer p {
                margin: 5px 0;
            }

            .signature {
                margin-top: 40px;
                text-align: center;
            }

            .signature img {
                max-height: 60px;
                margin: 10px 0;
            }

            .barcode {
                text-align: center; 
                position: absolute; 
                right: 40px; 
                padding: 40px;
            }

            .print-btn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            @media print {
                .print-btn {
                    display: none;
                }

                body {
                    margin: 0;
                }


                .container {
                    border: none;
                    padding: 0;
                    width: 210mm;
                    height: 297mm;
                    overflow: hidden;
                    page-break-inside: avoid;
                }

                .top-border {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 210mm;
                    height: auto;
                    max-height: 50px;
                }

                .header img {
                    margin-top: 50px;
                    margin-bottom: 20px;
                    
    }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php
            $sql = mysqli_query($konek, "SELECT * FROM dsertifikat WHERE id='$_GET[id]'");
            $d = mysqli_fetch_array($sql);
            ?>
            <img src="assets/img/top-border.jpg" alt="Top Border" class="top-border">
            <div class="header">
                <img src="assets/img/logo.png" alt="Logo PMI">
                <h1 style="font-size: 40px ;">SERTIFIKAT PENGHARGAAN</h1>
            </div>

            <div class="content">
                <p>No: <?php echo $d['no_sertifikat']; ?></p>
                <p style="margin-bottom: 30px;">Diberikan Kepada:</p>
                <h2 style="margin: 0; font-size: 30px ;"><u><?php echo $d['nama']; ?></u></h2>
                <p style="margin-bottom: 30px; font-size: 15px;">ID: <?php echo $d['id_donor']; ?></p>
                <p>yang Dengan Sukarela Telah Menyumbangkan Darahnya</p>
                <h1>
                    <?php
                        switch ($d['kategori']) {
                            case 10:
                                echo '10 (Sepuluh) Kali';
                            break;
                            case 25:
                                echo '25 (Dua Puluh Lima) Kali';
                            break;
                            case 50:
                                echo '50 (Lima Puluh) Kali';
                            break;
                            case 75:
                                echo '75 (Tujuh Puluh Lima) Kali';
                            break;
                        }
                    ?>
                </h1>
                <p>untuk Kepentingan Kemanusiaan.</p>
            </div>

            <div class="footer">
                <div class="signature">
                    <p>Medan, <?php echo formatTanggalIndo($d['tanggal']); ?></p>
                    <?php 
                    switch ($d['kategori']) {
                        case 10:
                            echo '<p>Kepala</p>
                                    <p>UTD PALANG MERAH INDONESIA</p>
                                    <p>KOTA MEDAN</p>
                                    <img src="assets/img/signature.png" alt="Signature" />
                                    <p><b>( dr. Harry Butar butar, Sp.B. )</b></p>';
                        break;
                        case 25:
                            echo '<p>Ketua Umum</p>
                                    <p>PALANG MERAH INDONESIA</p>
                                    <p>KOTA MEDAN</p>
                                    <img src="assets/img/signature02.png" alt="Signature" />
                                    <p><b>( Dr. H. Musa Rajekshah M.Hum )</b></p>';
                        break;
                        case 50:
                            echo '<p>Ketua Umum</p>
                                    <p>PALANG MERAH INDONESIA</p>
                                    <p style="margin-bottom: 100px ;">PROVINSI SUMATERA UTARA</p>
                                    <p><b>( Dr. Rahmad Shah )</b></p>';
                        break;
                        case 75:
                            echo '<p>Pengurus Pusat</p>
                                    <p>PALANG MERAH INDONESIA</p>
                                    <p style="margin-bottom: 100px ;">Ketua Umum</p>
                                    <p><b>( M. Jusuf Kalla )</b></p>';
                        break;
                    }
                    ?>
                    
                </div>
            </div>
            
            <div class="barcode">
                <p>CEK KEASLIAN</p>
                <?php  
                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                        $url = "https://";   
                    else  
                        $url = "http://";   
                    // Append the host(domain name, ip) to the URL.   
                    $url.= $_SERVER['HTTP_HOST'];   
                    
                    // Append the requested resource location to the URL   
                    $url.= $_SERVER['REQUEST_URI'];    
                    echo "<img src='https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=$url' alt='Barcode Keaslian Sertifikat'>";
                ?>   
            </div>
        </div>

        <?php
            ob_start();
            if (isset($_SESSION['login'])) {
                echo '<button class="print-btn" onclick="window.print()">Print</button>';
            }
        ?>
    </body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.onbeforeprint = function() {
            let watermark = document.createElement("img");
            watermark.src = "assets/img/valid-stemp.png";
            watermark.style.position = "absolute";
            watermark.style.top = "50%";
            watermark.style.left = "50%";
            watermark.style.transform = "translate(-50%, -50%) rotate(-15deg)";
            watermark.style.width = "678px";
            watermark.style.height = "255px";
            watermark.style.opacity = "0.5";
            watermark.style.zIndex = "-1";
            
            document.body.appendChild(watermark);
        };

        window.onafterprint = function() {
            let watermarks = document.querySelectorAll("img[src='assets/img/valid-stemp.png']");
            watermarks.forEach(wm => wm.remove());
        };

        window.addEventListener("afterprint", function() {
            $.ajax({
                url: 'aksi_sertifikat.php?act=afterprint', 
                type: 'POST',
                data: {
                    id : <?php echo $_GET['id']; ?>
                },
                success: function(response) {
                    // console.log('banyak copy sudah diperbarui');
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        });
    </script>
    </html>

<?php
?>