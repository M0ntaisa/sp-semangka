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
        <div class="row">
            <div class="cetak">
                <br>
                <div style="padding:0cm 0cm 1cm 0cm;">
                    <h3 align="center">Daftar User :</h3>
                    <table align="center">
                        <tr>
                            <th align="center">Nama User</th>
                            <th align="center">Tanggal Registrasi</th>
                            <th align="center">Jumlah Konsul</th>
                        </tr>
                        <?php foreach ($data_user as $row) { ?>
                        <tr>
                            <td style="text-align:center;"><?= $row['nama']; ?></td>
                            <td style="text-align:center;"><?= date('d / m / Y', $row['tanggal_dibuat']);; ?></td>
                            <td style="text-align:center;"><?= $row['konsul_count']; ?>x</td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <h3 align="center">Detail :</h3>
                <table class="table table-bordered" id="example3" align="center">
                    <thead>
                        <tr>
                            <th>Jumlah User Terdaftar</th>
                            <td><?= $jumlah_user; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah User Yang Telah Konsultasi</th>
                            <td><?= $jumlah_user_konsul; ?></td>
                        </tr>
                        <tr>
                            <th>Persentase</th>
                            <td><?= $persentase; ?>%</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </body>

</html>