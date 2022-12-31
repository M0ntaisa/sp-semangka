<!-- start banner Area -->
<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								<?= $title; ?>
							</h1>	
							<!-- <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="elements.html"> Elements</a></p> -->
						</div>											
					</div>
				</div>
			</section>
			<!-- End banner Area -->	

            <!-- Start Consult Result -->
                <section class="sample-text-area">
                    <div class="container">
						<h3 class="text-heading">Hasil Konsultasi</h3>
						<nav>
							<h4>Gejala Yang Dipilih :</h4>
							<br>
							<?php $no=1; foreach ($data_cf['gejala'] as $row) { ?>
								<ol><?= $no++.". ".$row; ?></ol>
							<?php } ?>

							<br>
							<h4>Kemungkinan Penyakit / Hama :</h4>
							<br>
							<?php $no=1; foreach ($data_cf['list_penyakit'] as $row) { ?>
								<ol><?= $no++.". ".$row['nama_penyakit']; ?></ol>
							<?php } ?>
								<br><br>
							<table>
								<tr>
									<th>Hasil Dempster Shafer</th>
									<th>Hasil Certainty Factor</th>
								</tr>
								<tr>
									<td width=310px>
										<?php 
											if( $this->session->flashdata('gagal') ) {
												echo '<div class="alert-wrap2 shadow-reset wrap-alert-b">';
												echo    '<div class="alert alert-danger">';
												echo        "<strong>Proses gagal! </strong>".$this->session->flashdata('gagal')."</div></div>";
											} else {
												$this->Konsultasi_model->proses();
											}
										?>
									</td>
									<td width=310px>
										<?php $this->Konsultasi_model->prosesCF(); ?>
									</td>
								</tr>
							</table>
							
							<hr>
							<h4>Kesimpulan :</h4>
							<?php foreach ($rank_penyakit as $key => $value) : 
								$penyakit=$value['penyakit'];
								$metode=$value['metode'];
								$nilai=$value['nilai'];
								$ket=$value['ket'];
								$solusi=$value['solusi'];

								?>
								<h5>
								<?php
								if (isset($value['kett'])) {
									echo "Dikarenakan Nilai dari perhitungan kedua metode sama, maka penyakit ";
								}
								else {
									echo "Nilai tertinggi dari perhitungan Kedua Metode adalah ";
								}
								?>
								<?= $value['penyakit']; ?>, 
								<?php
								if (isset($value['kett'])) {
									echo "dijadikan sebagai dioagnosa akhir ";
								}	
								else {
									echo "yang dihasilkan menggunakan metode ".$value['metode'];
								}
								?>
								 , dengan nilai = <?= $value['nilai']; ?>, </h5>
								<br>
							<p>
								<?= $value['ket']; ?>
							</p>
							
							<br>

							<h4>Solusi :</h4>
							<p>
								<?= $value['solusi']; ?>
							</p>

							<?php endforeach; ?>
						<br>
						<a href="<?= base_url('konsultasi') ?>" class="genric-btn warning">Ulangi Konsultasi</a>
						<a href="<?= base_url('konsultasi/cetak/') ?>?id=<?= $this->session->userdata('id_user')?>&penyakit1=<?php echo $penyakit?>&metode=<?php echo $metode?>&nilai=<?php echo $nilai?>&ket=<?php echo $ket?>&solusi=<?php echo $solusi?>" class="genric-btn primary" target="_blank">Print Hasil Konsultasi</a>
					</div>
                </section>

            <!-- End Consult Result -->


			