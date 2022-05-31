<!doctype html>
<html lang="en">

<head>

	<?php $this->load->view('_parts/style') ?>

	<link href="<?= base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<a href="<?= site_url('admin/user/add') ?>" class="btn btn-primary mb-3">tambah user</a>
										<div class="p-0 table-responsive">
											<p>Berikut adalah data user yang terdaftar.</p>
											<?= $this->session->flashdata('statusMessage') ?>
											<hr />
											<table id="datatable" class="table table-sm table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<thead>
													<tr>
														<th>Username</th>
														<th>password</th>
														<th>diinsert pada</th>
														<th>aksi</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
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
	<script src="<?= base_url() ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
		var dtb_ = $("#datatable").DataTable({
			"serverSide": true,
			"responsive": true,
			"ajax": {
				"url": "<?= site_url('admin/user/ajax/list') ?>",
				"type": "POST",
			}
		});


		function deleteData(id) {
			var conf = confirm('Apaakah anda yakin untuk menghapus data ini ?');
			if (conf) {
				window.location = "<?= site_url('admin/user/delete/') ?>" + id;
			}
		}
	</script>
</body>

</html>
