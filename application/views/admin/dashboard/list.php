<!-- income order visit user Start -->
        <div class="income-order-visit-user-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3" onclick="myFunction(1)" style="cursor: pointer;">
                            <div class="income-dashone-total income-monthly shadow-reset nt-mg-b-30">
                                <div class="income-title">
                                    <div class="main-income-head">
                                        <h2>Data Penyakit</h2>
                                    </div>
                                </div>
                                <div class="income-dashone-pro">
                                    <div class="income-rate-total">
                                        <div class="price-adminpro-rate">
                                            <h3><span class="counter"><?= count($penyakit); ?></span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3" onclick="myFunction(2)" style="cursor: pointer;">
                            <div class="income-dashone-total orders-monthly shadow-reset nt-mg-b-30">
                                <div class="income-title">
                                    <div class="main-income-head">
                                        <h2>Data Hama</h2>
                                    </div>
                                </div>
                                <div class="income-dashone-pro">
                                    <div class="income-rate-total">
                                        <div class="price-adminpro-rate">
                                            <h3><span class="counter"><?= count($hama); ?></span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3" onclick="myFunction(3)" style="cursor: pointer;">
                            <div class="income-dashone-total visitor-monthly shadow-reset nt-mg-b-30">
                                <div class="income-title">
                                    <div class="main-income-head">
                                        <h2>Data Gejala</h2>
                                    </div>
                                </div>
                                <div class="income-dashone-pro">
                                    <div class="income-rate-total">
                                        <div class="price-adminpro-rate">
                                            <h3><span class="counter"><?= count($gejala); ?></span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3" onclick="myFunction(4)" style="cursor: pointer;">
                            <div class="income-dashone-total user-monthly shadow-reset nt-mg-b-30">
                                <div class="income-title">
                                    <div class="main-income-head">
                                        <h2>User Yang Telah Konsultasi</h2>
                                    </div>
                                </div>
                                <div class="income-dashone-pro">
                                    <div class="income-rate-total">
                                        <div class="price-adminpro-rate">
                                            <h3><span class="counter"><?= $jumlah_user_konsul; ?></span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- welcome Project, sale area start-->
            <div class="welcome-adminpro-area" id="data-user">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12">
                            <div class="welcome-wrapper shadow-reset res-mg-t mg-b-30">
                                <div class="welcome-adminpro-title">
                                    <h1>Data User Yang Telah Konsultasi</h1>
                                </div>
                                <div class="adminpro-message-list">
                                    <ul class="message-list-menu">
                                        <?php $no=1; foreach ($data_user as $row) {?>
                                            <li><span class="message-serial message-cl-one"><?= $no++; ?></span>
                                                <?= $row['nama']; ?>
                                            </li>
                                        <?php } ?>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="welcome-adminpro-area" id="data-penyakit">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12">
                            <div class="welcome-wrapper shadow-reset res-mg-t mg-b-30">
                                <div class="welcome-adminpro-title">
                                    <h1>Data Penyakit</h1>
                                </div>
                                <div class="adminpro-message-list">
                                    <ul class="message-list-menu">
                                        <?php $no=1; foreach ($penyakit as $row) {?>
                                            <li><span class="message-serial message-cl-three"><?= $no++; ?></span>
                                                <?= $row['nama_penyakit']; ?>
                                            </li>
                                        <?php } ?>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="welcome-adminpro-area" id="data-hama">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12">
                            <div class="welcome-wrapper shadow-reset res-mg-t mg-b-30">
                                <div class="welcome-adminpro-title">
                                    <h1>Data Hama</h1>
                                </div>
                                <div class="adminpro-message-list">
                                    <ul class="message-list-menu">
                                        <?php $no=1; foreach ($hama as $row) {?>
                                            <li><span class="message-serial message-cl-two"><?= $no++; ?></span>
                                                <?= $row['nama_penyakit']; ?>
                                            </li>
                                        <?php } ?>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="welcome-adminpro-area" id="data-gejala">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12">
                            <div class="welcome-wrapper shadow-reset res-mg-t mg-b-30">
                                <div class="welcome-adminpro-title">
                                    <h1>Data Gejala</h1>
                                </div>
                                <div class="adminpro-message-list">
                                    <ul class="message-list-menu">
                                        <?php $no=1; foreach ($gejala as $row) {?>
                                            <li><span class="message-serial message-cl-four"><?= $no++; ?></span>
                                                <?= $row['nama_gejala']; ?>
                                            </li>
                                        <?php } ?>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("data-penyakit").style.display = "none";
            document.getElementById("data-hama").style.display = "none";
            document.getElementById("data-gejala").style.display = "none";
            document.getElementById("data-user").style.display = "none";
            function myFunction(test) {
                
                    var w = document.getElementById("data-user");
                    var x = document.getElementById("data-penyakit");
                    var y = document.getElementById("data-hama");
                    var z = document.getElementById("data-gejala");
                if (test == 1) {
                    w.style.display = "none";
                    x.style.display = "block";
                    y.style.display = "none";
                    z.style.display = "none";
                } else if (test == 2) {
                    w.style.display = "none";
                    x.style.display = "none";
                    y.style.display = "block";
                    z.style.display = "none";
                } else if (test == 3) {
                    w.style.display = "none";
                    x.style.display = "none";
                    y.style.display = "none";
                    z.style.display = "block";
                } else if (test == 4) {
                    w.style.display = "block";
                    x.style.display = "none";
                    y.style.display = "none";
                    z.style.display = "none";
                } else {
                    w.style.display = "none";
                    x.style.display = "none";
                    y.style.display = "none";
                    z.style.display = "none";
                }
            }
        </script>

    </div>