<!doctype html>
<html lang="en">

<head>


	<meta charset="utf-8" />
	<title><?= $title ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
	<meta content="Themesdesign" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/icon.jpg">

	<!-- Bootstrap Css -->
	<link href="<?= base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />


</head>


<body class="bg-primary mt-5" >
	<div class="home-center">
		<div class="home-desc-center">

			<div class="container">

				<div class="row justify-content-center mt-3">
					<div class="col-md-8 col-lg-6 col-xl-5">
						<div class="card">
							<div class="card-body">
								<div class="px-2 py-3">

									<div class="text-center">
										<a href="<?= site_url() ?>">
											<img src="assets/maps.png" height="75" alt="logo">
										</a>

										<h5 class="text-primary mb-2 mt-4">Welcome Back Apk Djikstra  !</h5>
									</div>


									<form class="form-horizontal mt-4 pt-2" method="POST" action="<?= site_url('login') ?>">

										<div class="mb-3">
											<label for="username">Username</label>
											<input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Masukan username">
											<?= form_error('username') ?>
										</div>

										<div class="mb-3">
											<label for="userpassword">Password</label>
											<input type="password" class="form-control" id="userpassword" name="password" value="<?= set_value('password') ?>" placeholder="Masukan password">
											<?= form_error('password') ?>
										</div>

										<div>
											<button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
										</div>

										<div class="mt-3">
											<?= $this->session->flashdata('loginError') ?>
										</div>
									</form>


								</div>
							</div>
						</div>

					</div>
				</div>

			</div>


		</div>
		<!-- End Log In page -->
	</div>

	<!-- JAVASCRIPT -->
	<script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

	<script src="<?= base_url() ?>assets/js/app.js"></script>

</body>

</html>
