<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title; ?></title>
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
    
    <div class="cetak">
        <h1>Detail Transaksi <?= $ternak['nama_peternakan']; ?></h1>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th  width="25%">NAMA PELANGGAN</th>
                    <th>: <?= $transaksi['nama_pelanggan']; ?></th>
                </tr>       
                <tr>
                    <th>KODE TRANSAKSI</th>
                    <th>: <?= $transaksi['kode_transaksi']; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Status Pembayaran</td>
                    <td>: <?= $transaksi['status_pelanggan']; ?></td>
                </tr>      
                <tr>
                    <td>Total Bayar</td>
                    <td>: Rp. <?= number_format($transaksi['total_bayar'], '0',',','.'); ?>,-</td>
                </tr>  
                <tr>
                    <td>Bukti Pembayaran</td>
                    <td>: <img src="<?= base_url('assets/upload/image/bukti_pembayaran/thumbs/'.$transaksi['gambar']); ?>" alt="Struk Belum Ada" class="img img-responsive img-thumbnail" width="60"></td>
                </tr>       
                <tr>
                    <td>Tanggal Pembayaran</td>
                    <td>: <?= date('d-M-Y', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                </tr>
                <tr>
                    <td>Status Transaksi</td>
                    <td>: <?= $transaksi['status_pesanan']; ?></td>
                </tr>  
                <tr>
                    <td>Tanggal Produk Diterima</td>
                    <td>: <?= date('d-M-Y', strtotime($transaksi['tanggal_update'])); ?></td>
                </tr> 
            </tbody>
        </table>

        <table class="table table-bordered" id="example3">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width:300px;">NAMA PRODUK</th>
                    <th>JUMLAH (rak)</th>
                    <th>TOTAL HARGA</th>
                    <th>PENGIRIMAN</th>
                    <th>TOTAL BAYAR</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>1.</td>
                        <td><?= $transaksi['nama_produk']; ?></td>
                        <td><?= $transaksi['jumlah']; ?></td>
                        <td>IDR <?= number_format($transaksi['total_harga'], '0',',','.'); ?>,-</td>
                        <td>IDR <?= number_format($transaksi['pengiriman'], '0',',','.'); ?>,-</td>
                        <td>IDR <?= number_format($transaksi['total_bayar'], '0',',','.'); ?>,-</td>
                    </tr>
            </tbody>
        </table>
    </div>
</body>
</html>