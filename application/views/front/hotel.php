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
							<h3 class=""><strong>Info Petshop<strong></h3>
						</div>


						<div class="row mb-4">

							
						</div>

						<div class="row ">
							<?php foreach ($objectResult as $gng) { ?>
								<div class="col-6 col-sm-3 d-flex align-items-stretch">
									<div class="card">
										<img class="card-img-top" style="height:200px;object-fit:cover;" src="<?= base_url('uploads/' . $gng->picture) ?>" alt="Card image cap">
										<div class="card-body">
											<h5 class="card-title"><?= $gng->name ?></h5>
											<p class="card-text text-sm"><?= substr($gng->desc, 0, 50) . '...' ?><br /><a href="<?= site_url('hotel/detail/' . $gng->id) ?>"><strong>Selengkapnya</strong></a></p>
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="col-12">
								<nav aria-label="Page navigation example">
									<?php
									echo $this->pagination->create_links();
									?>
								</nav>
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
<script>
	$('.carousel').carousel();
</script>

</html>
