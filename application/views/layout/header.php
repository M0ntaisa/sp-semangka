<body>

<style>
	a.disabled {
		pointer-events: none;
		cursor: default;
		padding-left: 150%;
		font-size: 15px;
		font-weight: bold;
	}
</style>

			  <header id="header" id="home">
			  <br>
			    <div class="container">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/templates/users/img/logo3.png" alt="" title="" width="200px" /></a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
							<li class="menu-active"><a href="<?= base_url() ?>">Home</a></li>
							<li><a href="<?= base_url('about') ?>">About</a></li>
							<?php if ($this->session->userdata('role_id') == 2) { ?>
								<li><a href="<?= base_url('konsultasi') ?>">Konsultasi</a></li>
							<?php } ?>   
							
							
							<?php if ($this->session->userdata('role_id') == 2) { ?>
								<li><a href="" class="disabled"><?= $user['nama']; ?></a></li> 
							<?php } else { ?>   	    		
								<li><a href="" class="disabled"><img src="<?= base_url() ?>assets/templates/form/images/gowa.png" alt="logo" width="50" style="display: block;margin-left: auto;margin-right: auto;"></a></li> 
							<?php } ?>
				        </ul>
				      </nav><!-- #nav-menu-container -->
						<?php if ($this->session->userdata('role_id') == 2) { ?>
							<a href="<?= base_url('auth/logout') ?>" class="primary-btn">Logout</a>
						<?php } else { ?>   	    		
							<a href="<?= base_url('auth/login') ?>" class="primary-btn">Login</a>
						<?php } ?>
			    	</div>
			    </div>
			  </header><!-- #header -->