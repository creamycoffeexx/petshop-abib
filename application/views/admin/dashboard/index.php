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


							<h3 class=""><strong><?= $title ?></strong></h3>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="p-4">
											<div class="d-flex justify-content-between">
												<div>
													<h5 class="text-muted">Total</h5>
													<h4><strong>Petshop </strong></h4>
												</div>
												<h1 class=""><span class=""><?= $countRS ?></span> <span class="text-muted h3"></span></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="p-4">
											<div class="d-flex justify-content-between">
												<div>
													<h5 class="text-muted">Total</h5>
													<h4><strong>Simpul</strong></h4>
												</div>
												<h1 class=""><span class=""><?= $countSimpul ?></span> <span class="text-muted h3">Unit</span></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="p-4">
											<div class="d-flex justify-content-between">
												<div>
													<h5 class="text-muted">Total</h5>
													<h4><strong>Graph</strong></h4>
												</div>
												<h1 class=""><span class=""><?= $countGraph ?></span> <span class="text-muted h3">Unit</span></h1>
											</div>
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

</body>

</html>
