<!-- start banner Area -->
<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Konsultasi
							</h1>	
							<!-- <p class="text-white link-nav"><a href="index.html">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="elements.html"> Elements</a></p> -->
						</div>											
					</div>
				</div>
			</section>
            <!-- End banner Area -->	

            <script type="text/javascript">
                function checkAll(ele) {
                    var checkboxes = document.getElementsByTagName('input');
                    if (ele.checked) {
                        for (var i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i].type == 'checkbox' ) {
                                checkboxes[i].checked = true;
                            }
                        }
                    } else {
                        for (var i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i].type == 'checkbox') {
                                checkboxes[i].checked = false;
                            }
                        }
                    }
                }
            </script>

            <!-- Start The Real Konsultasi Page -->
                <section class="sample-text-area">
                    <div class="container">
                    <h3 class="text-heading">Pilih Gejala</h3>
                    <?php 
                        if( $this->session->flashdata('failed') ) {
                            echo '<div class="alert-wrap2 shadow-reset wrap-alert-b">';
                            echo    '<div class="alert alert-danger">';
                            echo        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            echo        "<strong>Proses gagal! </strong>".$this->session->flashdata('failed')."</div></div>";
                        }
                        if( $this->session->flashdata('warning') ) {
                            echo '<div class="alert-wrap2 shadow-reset wrap-alert-b">';
                            echo    '<div class="alert alert-warning">';
                            echo        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            echo        "<strong>Warning! </strong>".$this->session->flashdata('warning')."</div></div>";
                        }
                    ?>
                    <div class="switch-wrap d-flex">
                        <input type="checkbox" style="height:20px;" onchange="checkAll(this)" name="chk[]">
                        <p style="font-size:15px;"> &nbsp; Pilih Semua Gejala</p>
                    </div> 
                    <?= form_open(base_url('konsultasi/proses')); ?>
                        <?php
                        //-- menampilkan daftar gejala
                        foreach ($gejala as $row) { ?>
                            <div class="switch-wrap d-flex">
                                <input type="checkbox" style="height:20px;" id="foo" name="gejala[]" value="<?= $row['id_gejala'] ?>">
                                <p style="font-size:15px;"> &nbsp; <?= $row['kode_gejala']; ?> - <?= $row['nama_gejala']; ?></p>
                            </div> 
                        <?php } ?>
                        <br>
                        <input class="genric-btn primary" type="submit" value="proses">
                        <?= form_close(); ?>
                    </div>
                    
                </section>
            <!-- End The Real Konsultasi Page -->

			