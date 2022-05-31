<!doctype html>
<html lang="en">

<head>

	<?php $this->load->view('_parts/style') ?>
</head>


<body>
	<!-- Begin page -->
	<div id="layout-wrapper">



		<?php $this->load->view('_parts/header') ?>
		<?php $this->load->view('_parts/sidebar') ?>

		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="main-content" style="margin-top:100px;">
			<div class="page-content">
				<div class="container-fluid">
					<div class="page-content-wrapper">
						<div class="mt-3">

							<h3 class=""><strong>Add <?= $title ?></strong></h3>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="card">
									<div class="card-body">
										<div class="p-0">
											<p>Berikut adalah form user. silahkan lengkapi data-data dibawah ini dengan lengkap dan benar</p>
											<hr />
											<form action="<?= site_url('admin/user/add') ?>" method="POST" enctype="multipart/form-data">
												<div class="form-group">
													<label>Username</label>
													<input type="text" name="username" class="form-control" value="<?= set_value('username') ?>">
													<?= form_error('username') ?>
												</div>
												<div class="form-group">
													<label>password</label>
													<input type="text" name="password" class="form-control" value="<?= set_value('password') ?>">
													<?= form_error('password') ?>
												</div>

												<div class="form-group mt-3">
													<a href="<?= site_url('admin/user') ?>" class="btn btn-light">Kembali</a>
													<button class="btn btn-primary">Simpan</button>
												</div>

											</form>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div> <!-- container-fluid -->
			</div>
			<!-- End Page-content -->



			<?php $this->load->view('_parts/footer') ?>
		</div>
		<!-- end main content-->

	</div>
	<!-- END layout-wrapper -->

	<?php $this->load->view('_parts/js') ?>
	<script type="text/javascript">
	</script>
</body>

</html>
