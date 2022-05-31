<header id="page-topbar">
	<div class="navbar-header">
		<div class="d-flex">

			<!-- LOGO -->
			<div class="navbar-brand-box">
				<a href="<?= site_url() ?>" class="logo logo-dark">
				
					<span class="logo-lg">
						<img src="<?= base_url() ?>assets/maps.png" alt="" height="60">  
					</span>
					<span class="logo-lg">
						<img src="<?= base_url() ?>assets/djk.png" alt="" height="25">  
					</span>
					
				</a>

				<a href="<?= site_url() ?>" class="logo logo-light">
					<span class="logo-sm">
						<img src="<?= base_url() ?>assets/maps.png" alt="" height="70"> 
					</span>
					<span class="logo-sm">
						<img src="<?= base_url() ?>assets/maps.png" alt="" height="70"> 
					</span>
					
					
				</a>
			</div>

			<button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
				<i class="mdi mdi-menu"></i>
			</button>



		</div>

		<!-- Search input -->
		<div class="search-wrap" id="search-wrap">
			<div class="search-bar">
				<input class="search-input form-control" placeholder="Search" />
				<a href="#" class="close-search toggle-search" data-target="#search-wrap">
					<i class="mdi mdi-close-circle"></i>
				</a>
			</div>
		</div>

		<div class="d-flex">
			<div class="dropdown d-none d-lg-inline-block">
				<button type="button" class="btn header-item toggle-search noti-icon waves-effect" data-target="#search-wrap">
					<i class="mdi mdi-magnify"></i>
				</button>
			</div>

			<?php if ($this->session->has_userdata('user')) { ?>
				<div class="dropdown d-inline-block">
					<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="mdi mdi-account-circle-outline font-size-20 align-middle me-1"></i>
						<span class="d-none d-xl-inline-block ms-1"><?= $this->session->userdata('user')->username ?></span>
						<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-end">
					
						<a class="dropdown-item d-block" href="#"><span class="badge badge-success float-end">11</span><i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Settings</a>
						
						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout</a>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
</header>
