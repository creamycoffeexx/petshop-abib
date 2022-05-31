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



		<!-- Modal -->

		<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title mt-0">Membuat Graph</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">
						<form id="graphForm">
							<input type="hidden" id="id_graph" name="id_graph">
							<div class="row">
								<div class="col-12 col-sm-6">
									<label>Mulai</label>
									<select id="start" name="start" class="form-control">
										<option value="">Pilih Mulai</option>
										<?php foreach ($nodeResult as $n) { ?>
											<option lng="<?= $n->lat ?>" lat="<?= $n->lng ?>" value="<?= $n->id ?>"><?= $n->name ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-12 col-sm-6">
									<label>Tujuan</label>
									<select id="end" name="end" class="form-control">
										<option value="">Pilih tujuan</option>
										<?php foreach ($nodeResult as $n) { ?>
											<option lng="<?= $n->lat ?>" lat="<?= $n->lng ?>" value="<?= $n->id ?>"><?= $n->name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group mt-2">
								<label>Jarak</label>
								<input type="text" class="form-control" name="distance" id="distance" readonly>
								<small>Jarak ditampilkan dalam kilometer</small>
							</div>
							<!-- <div class="form-group mt-2">
								<label>Waktu tempuh</label>
								<input type="text" class="form-control" name="time" id="time">
								<small>Waktu tempuh dalam menit</small>
							</div> -->
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnSave" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="main-content" style="margin-top:100px;">
			<div class="page-content">
				<div class="container-fluid">
					<div class="page-content-wrapper">
						<div class="mt-3">
							<h3 class=""><strong>Gaprh Jalur </strong></h3>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="card">
									<div class="card-body">
										<button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">tambah graph</button>
										<div class="p-0 table-responsive"><br>
											<p>Berikut adalah data graph yang terdaftar.</p>
											<?= $this->session->flashdata('statusMessage') ?>
											<hr />
											<table id="datatable" class="table table-sm table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<thead>
													<tr>
														<th>Mulai</th>
														<th>Tujuan</th>
														<th>Jarak</th>
														<th>waktu</th>
														<th>aksi</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="card">
									<div class="card-body">
										<div id="map" style="height: 450px;width: 100%;"></div>
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
	<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
	<script type="text/javascript">
		mapboxgl.accessToken = 'pk.eyJ1IjoiZWZoYWwiLCJhIjoiY2ptOXRiZ3k2MDh4bzNrbnljMjk5Z2d5aSJ9.8dSNgeAjpdTlZ3x-b2vsog';
		var map = new mapboxgl.Map({
			container: 'map', // container id
			style: 'mapbox://styles/mapbox/streets-v9', // stylesheet location
			center: [122.514900, -3.972201], // starting position [lng, lat]
			zoom: 10, // starting zoom
			logoPosition: 'top-right',
		});

		var dtb_ = $("#datatable").DataTable({
			"serverSide": true,
			"responsive": true,
			"ajax": {
				"url": "<?= site_url('admin/graph/ajax/list') ?>",
				"type": "POST",
			}
		});

		var marker = [];

		$.ajax({
			'url': "<?= site_url('admin/graph/ajax/data') ?>",
			'type': 'POST',
			success: function(e) {
				var data_obj = JSON.parse(e);
				data_obj.forEach(function(i) {
					var color = i.type == '-' ? '#01f254' : '#015ff2';
					marker.push(new mapboxgl.Marker({
							color: color,
						})
						.setLngLat([i.lng, i.lat])
						.setPopup(new mapboxgl.Popup().setHTML(`
						<div class="card" style="width: 10rem;">
						<img src="<?= base_url('uploads/') ?>${i.picture}" class="card-img-top" alt="...">
							<div class="card-body">
								<h6 class="card-title">${i.name}</h6>
								${i.type == 'object' ? `<a href="<?= site_url('gunung/detail/') ?>${i.id}" class="btn btn-primary">Lihat detail</a>` : ''}
								</div>
							</div>
						`)) // add popup
						.addTo(map));
				})
			}

		});

		function deleteData(id) {
			var conf = confirm('Apaakah anda yakin untuk menghapus data ini ?');
			if (conf) {
				window.location = "<?= site_url('admin/graph/delete/') ?>" + id;
			}
		}

		$("#start,#end").on('change', function() {
			if ($("#start").val() != '' && $("#end").val() != '') {
				var distance = turf.distance(turf.point([$("#start").find(":selected").attr('lng'), $("#start").find(":selected").attr('lat')]), turf.point([$("#end").find(":selected").attr('lng'), $("#end").find(":selected").attr('lat')]), {
					units: 'kilometers'
				}).toFixed(2);
				$("#distance").val(distance);
			}
		})

		$("#btnSave").click(function(e) {
			e.preventDefault();

			var url = $("#id_graph").val() != '' ? "<?= site_url('admin/graph/edit/') ?>" + $("#id_graph").val() : "<?= site_url('admin/graph/add') ?>";

			$.ajax({
				url: url,
				type: 'POST',
				data: $("#graphForm").serialize(),
				success: function(e) {
					$(".bs-example-modal-center").modal('hide');
					dtb_.draw();
				}
			});
		})

		$(".bs-example-modal-center").on('hidden.bs.modal', function(e) {
			$("#id_graph").val("");
			$("#start").val("");
			$("#end").val("");
			$("#distance").val("");
			// $("#time").val("");
			// $("#time").val("");
		})

		function showModalEditGraph(id) {
			$(".bs-example-modal-center").modal('show');
			$.ajax({
				url: '<?= site_url('admin/graph/edit/') ?>' + id,
				type: 'POST',
				data: {
					'id': id
				},
				success: function(e) {
					var Obj = JSON.parse(e);
					$("#id_graph").val(Obj.id);
					$("#start").val(Obj.start);
					$("#end").val(Obj.end);
					$("#distance").val(Obj.distance);
					// $("#time").val(Obj.time);
				}
			})
		}

		map.on('load', function(e) {
			$.ajax({
				url: '<?= site_url('admin/graph/getGraphLine') ?>',
				success: function(e) {
					var obj = JSON.parse(e);
					obj.forEach(function(i) {
						map.addLayer({
							"id": "route" + i.g_id,
							"type": "line",
							"source": {
								"type": "geojson",
								"data": {
									"type": "Feature",
									"properties": {},
									"geometry": {
										"type": "LineString",
										"coordinates": [
											[i.n1_lng, i.n1_lat],
											[i.n2_lng, i.n2_lat],
										]
									}
								}
							},
							"layout": {
								"line-join": "round",
								"line-cap": "round"
							},
							"paint": {
								"line-color": "#2980b9",
								"line-width": 5
							}
						})
					})
				}
			});

		});
	</script>
</body>

</html>
