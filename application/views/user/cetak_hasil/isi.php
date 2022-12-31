<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <?php 
    $penyakit =$_GET['penyakit1'];
    $metode =$_GET['metode'];
    $ket =$_GET['ket'];
    $solusi =$_GET['solusi'];
    $nilai =$_GET['nilai'];
    ?>
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
                <h3 align="center">Hasil Akhir :</h3>
                <table class="table table-bordered" id="example3" align="center">
                    <thead>
                        <tr>
                            <th>Penyakit / Hama Yang Diderita (Dempster Shafer)</th>
                            <td><?= $rank_ds['nama_penyakit']; ?></td>
                        </tr>
                        <tr>
                            <th>Penyakit / Hama Yang Diderita (Certainty Factor)</th>
                            <td><?= $rank_cf['nama_penyakit']; ?></td>
                        </tr>
                    </thead>
                </table>
                <div style="padding:0cm 0cm 1cm 0cm;">
                    <h3 align="center">Kesimpulan:</h3>
                    <p>Nilai tertinggi dari perhitungan Kedua Metode adalah <?php echo $penyakit; ?>, yang dihasilkan menggunakan metode <?php echo  $metode; ?>, dengan nilai = <?php echo $nilai; ?>, <label> <?php  echo $ket?></label></p>
                    <h4 align="center">Solusi :</h4>
                            <p>
                                <?php echo  $solusi; ?>
                            </p>
                </div>
            </div>
        </div>
    </body>

</html>