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

						<div class="row ">
							<div class="col-12">
								<div class="card text-center">
									<div class="card-header">
										Cara Penggunaan Aplikasi
									</div>
									<div class="card-body">
										<h5 class="card-title"> Aplikasi Pencarian Rute Terpendek <h5>
											<p>
											Aplikasi ini di rancang hanya untuk mencari lokasi destinasi yang di tuju. Aplikasi ini merepkan algoritma Dijkstra sebagai penentuan rute yang di lalui.
									<h2>Langkah Awal</h2>

									<div class="card" style="width: 50rem;">
									  <img src="<?= base_url() ?>assets/tutor/1.png " class="card-img-top" alt="...">
									  <div class="card-body">
									    <p class="card-text">Tahap awal dala melakukan pencarian adalah klik menu pencarian kemudin tentukan tujuan </p>
									  </div>
									</div>

									<h2>Langkah Ke 2</h2>
									<div class="card" style="width: 50rem;">
									  <img src="<?= base_url() ?>assets/tutor/2.png " class="card-img-top" alt="...">
									  <div class="card-body">
									    <p class="card-text">Tahap ke 2 adalah menentukan titik kordinat awal perjalan. pada aplikasi kali ini untuk titik awal sudah di tentukan jadi silahka pilih titik awal yg telah di sedikan.</p>
									  </div>
									</div>

									<h2>Langkah ke 3</h2>
									<div class="card" style="width: 50rem;">
									  <img src="<?= base_url() ?>assets/tutor/3.png " class="card-img-top" alt="...">
									  <div class="card-body">
									    <p class="card-text">Tahap ke 3 menentukan lokasi tujuan. jika sudah maka dapat menentukan atau menarik garis jalur untuk tombol membuat garis berda di sebelah kanan atas. klik dari awal kordinat yg di lambangkan marker warna merah dan biru untuk tujuan. tarik garis merah ke titik marker biru selanjutnya tap</p>
									  </div>
									</div>

									<h2>Langkah ke 4</h2>
									<div class="card" style="width: 50rem;">
									  <img src="<?= base_url() ?>assets/tutor/4.png " class="card-img-top" alt="...">
									  <div class="card-body">
									    <p class="card-text">Tahap 4 dari hasil penarikann garis akan terlihat jalur rute perjalan dan jumlah jarak dan waktu tempuh.</p>
									  </div>
									</div>

										<p class="card-text"><?= NAMA_APLIKASI ?> adalah sebuah algoritma yang dapat menentukan rute perjalan menuju tempat tujuan dengan baik</p>
									</div>
									
									<div class="card-footer text-muted">
										@<?= NAMA_APLIKASI ?>
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
<script>
	$('.carousel').carousel();
</script>

</html>
