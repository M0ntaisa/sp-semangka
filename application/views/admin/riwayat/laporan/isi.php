<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style type="text/css" media="print">
        body {
            font-family : Arial;
            font-size : 12px;
        }

        .cetak {
            width : 19cm;
            height : 27cm;
            padding : 1cm;
        }
        
        table {
            border : solid thin #000;
            border-collapse : collapse;
        }

        td, th {
            padding : 3mm 6mm;
            text-align : left;
            vertical-align : top;
        }

        th {
            background-color : #f5f5f5;
            font-weight : bold;
        }

        h1 {
            text-align : center;
            font-size : 18px;
            text-transform : uppercase;
        }
    </style>
    <style type="text/css" media="screen">
        body {
            font-family : Arial;
            font-size : 12px;
        }

        .cetak {
            width : 19cm;
            height : 27cm;
            padding : 1cm;
        }
        
        table {
            border : solid thin #000;
            border-collapse : collapse;
        }

        td, th {
            padding : 3mm 6mm;
            text-align : left;
            vertical-align : top;
        }

        th {
            background-color : #f5f5f5;
            font-weight : bold;
        }

        h1 {
            text-align : center;
            font-size : 18px;
            text-transform : uppercase;
        }

    </style>
</head>
<body onload="print()">
    <div style="text-align: center; font-weight: bold; font-size: 20px;">
        LAPORAN SISTEM PAKAR DIAGNOSA HAMA/PENYAKIT <br>
        PADA TUMBUHAN SEMANGKA <br>
            <!-- <span style="font-size:12px;">Desa Baruga Kec. Bantimurung Kabupaten Maros Sulawesi Selatan</span> -->
            <hr style="height:2px;background-color: #333;">
    </div>
    <div class="cetak">
        <div style="padding:0cm 0cm 1cm 0cm;">
            <h2>Nama : <?= $riwayat[0]['nama']; ?></h2>
            <h2>Tanggal Konsultasi : <?= date('d - m - Y', $riwayat[0]['tanggal_konsul']); ?></h2>
        </div>
        <h3>Daftar Gejala Yang Dipilih</h3>
        <table class="table table-bordered" id="example3">
            <thead>
                <tr>
                    <th>Kode Gejala</th>
                    <th align="center">Nama Gejala</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($gejala_terpilih as $row) { ?>
                    <tr>
                        <td><?= $row['kode_gejala']; ?></td>
                        <td><?= $row['nama_gejala']; ?></td>
                    </tr>
                <?php }  ?>
            </tbody>
        </table>
        <br><br>
        <h3>Hasil Metode Dempster Shafer</h3>
        <table class="table table-bordered" id="example3">
            <thead>
                <tr>
                    <th>Kode Penyakit</th>
                    <th align="center">Nama Penyakit</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($penyakit_ds as $row) { ?>
                    <tr>
                        <td><?= $row['kode_penyakit']; ?></td>
                        <td><?= $row['nama_penyakit']; ?></td>
                    </tr>
                <?php }  ?>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered" id="example3">
            <tbody>
                <?php $no=1; foreach ($penyakit_ds as $row) { ?>
                    <tr>
                        <th>Keterangan</th>
                        <td><?= $row['ket']; ?></td>
                    </tr>
                    <tr>
                        <th>Solusi</th>
                        <td><?= $row['solusi']; ?></td>
                    </tr>
                <?php }  ?>
            </tbody>
        </table>
        <br><br>
        <h3>Hasil Metode Certainty Factor</h3>
        <table class="table table-bordered" id="example3">
            <thead>
                <tr>
                    <th>Kode Penyakit</th>
                    <th align="center">Nama Penyakit</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($penyakit_cf as $row) { ?>
                    <tr>
                        <td><?= $row['kode_penyakit']; ?></td>
                        <td><?= $row['nama_penyakit']; ?></td>
                    </tr>
                <?php }  ?>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered" id="example3">
            <tbody>
                <?php $no=1; foreach ($penyakit_cf as $row) { ?>
                    <tr>
                        <th>Keterangan</th>
                        <td><?= $row['ket']; ?></td>
                    </tr>
                    <tr>
                        <th>Solusi</th>
                        <td><?= $row['solusi']; ?></td>
                    </tr>
                <?php }  ?>
            </tbody>
        </table>
            <!-- <br />
    
    
            <br /><br />
            <br /><br />
    
            <table style="border:0px;">
            <tr>
                <td width="400"></td>
                <td>
                <p>Makassar, </p>
                <p>SEMEN BOSOWA<br/>Jabatan yg bertandatangan</p>
                <br />
                <br />
                <br />
                <br />
                <p class="nama">yang bertandatangan</p>
                </td>
            </tr>
        </table> -->
    </div>
</body>
</html>