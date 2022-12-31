<!-- CSS -->
<style media="screen">

.judul {
    padding: 4mm;
    text-align: center;
}

.nama {
    text-decoration: underline;
    font-weight: bold;
}

h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    margin-bottom: 5px;
}

h3 {
    font-family: times;
}

p {
    margin: 0;
}

</style>
<!-- CSS -->

<div class="judul">
<table align="center">
    <tr>
    <td width="600" align="center">
        <h3>PT SEMEN BOSOWA MAROS</h3>
        <h3>KABUPATEN MAROS</h3>
        <p>Desa Baruga Kec. Bantimurung Kabupaten Maros Sulawesi Selatan</p>
    </td>
    </tr>
</table>
<hr>
<br>
<p>Jenis Material</p>
<table>
    <tr>
        <th>Material</th>
    </tr>
    <tr>
        <td>*nama material</td>
    </tr>
</table>
</div>

<br /><br />

<table>
    <tr>
        <th>Nama Suplier</th>
        <th>Nilai Akhir</th>
        <th>Peringkat</th>
    </tr>
    <tr>
        <td>Suplier-n</td>
        <td>Nilai-n</td>
        <td>Peringkat-n</td>
    </tr>
</table>

<table align="center">

<tr>
    <td width="600" align="justify">
    <p>
        Berdasarkan hasil perhitungan yang telah dilakukan, didapatlah hasil akhir "SUPLIER-1" yang memiliki nilai tertinggi diantara suplier yang lainnya untuk pemilihan bahan material "NAMA MATERIAL".
    </p>
    </td>
</tr>
</table>
<br />


<br /><br />
<br /><br />

<table>
<tr>
    <td width="450"></td>
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
</table>

<?php

// proses untuk menampilkan file pdf
$content = ob_get_clean();
include_once "./assets/templates/admin/js/html2pdf/html2pdf.class.php";
$html2pdf = new HTML2PDF('P', 'A4', 'en', 'utf-8');
$html2pdf->WriteHTML($content);
$html2pdf->Output('Undangan Penguji.pdf');

?>
