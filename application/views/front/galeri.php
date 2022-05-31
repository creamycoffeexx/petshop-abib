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


		<!-- modal -->
		<!-- Modal -->
		<div class="modal fade" id="modalGaleri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<img id="imageModal" src="" style="object-fit:center;width:100%;">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /modal -->
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


						<div class="row mb-4">

							<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
								<div class="carousel-indicators">
									<?php $no = 0;
									foreach ($objectResult as $gng) { ?>
										<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $no++; ?>" class="active" aria-current="true" aria-label="Slide 1"></button>
									<?php } ?>
								</div>
								<div class="carousel-inner">
									<?php $carsoulStatus = true;
									foreach ($objectResult as $gng) { ?>
										<div class="carousel-item 
										<?php if ($carsoulStatus) {
											echo "active";
											$carsoulStatus = false;
										} ?> ">
											<img src="<?= base_url('uploads/' . $gng->picture) ?>" style="object-fit:cover;height:300px;" class="d-block w-100" alt="...">
											<div class="carousel-caption">
												<h3 class="text-light"><?= $gng->name ?></h3>
											</div>
										</div>
									<?php } ?>
								</div>
								<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Previous</span>
								</button>
								<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="visually-hidden">Next</span>
								</button>
							</div>
						</div>


						<div class="row ">
							<?php foreach ($objectResult as $gng) { ?>
								<div class="col-6 col-sm-3 d-flex align-items-stretch">
									<div class="card">
										<img class="card-img-top" style="height:200px;object-fit:cover;" onclick="showModalGaleri('<?= $gng->picture ?>')" src="<?= base_url('uploads/' . $gng->picture) ?>" alt="Card image cap">
										<div class="card-body">
											<h5 class="card-title"><?= $gng->name ?></h5>
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
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
<script>
	$('.carousel').carousel()

	function showModalGaleri(pic) {
		$("#imageModal").attr('src', '<?= base_url('uploads/') ?>' + pic)
		$("#modalGaleri").modal('show');
	}
</script>

</html>
