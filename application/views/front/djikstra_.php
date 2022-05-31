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


		<!-- Modal detail perhitungan-->
		<!-- Modal -->
		<div class="modal fade" id="modalDetailPerhitungan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Perhitungan</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<span id="resDetailPerhitungan"></span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Modal detail perhitungan-->
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
							<div class="col-12 col-sm-4">
								<form id="graphForm" class="mb-4 mb-sm-2">
									<input type="hidden" id="id_graph" name="id_graph">
									<div class="row">
										<div class="col-12 col-sm-6 mb-3">
											<select id="start" name="start" class="form-control select2">
												<option value="">Pilih Titi Kamu</option>
												<?php foreach ($nodeResult as $n) { ?>
													<?php if ($n->type == '-') { ?>
														<option lng="<?= $n->lat ?>" lat="<?= $n->lng ?>" value="<?= $n->id ?>"><?= $n->name ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</div>
										<div class="col-12 col-sm-6">
											<select id="end" name="end" class="form-control select2">
												<option value="">Pilih Hotel</option>
												<?php foreach ($nodeResult as $n) { ?>
													<?php if ($n->type == 'object') { ?>
														<option lng="<?= $n->lat ?>" lat="<?= $n->lng ?>" value="<?= $n->id ?>"><?= $n->name ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
								</form>

								<div id="res" class="mt-1 mb-2 d-none">

									<div class="card">
										<div class="card-body">

											<div class="d-flex align-items-center justify-content-evenly">
												<div class="">
													<i class="mdi mdi-ray-start"></i>&nbsp;&nbsp;&nbsp;<span class="badge bg-primary" id="lAsal"></span>
												</div>
												<div class="text-muted">|</div>
												<div>
													<i class="mdi mdi-ray-start-arrow"></i>&nbsp;&nbsp;&nbsp;<span class="badge bg-primary" id="lAkhir"></span>
												</div>
												<div class="text-muted">|</div>
												<div>
													<i class="mdi mdi-map-marker-distance"></i>&nbsp;&nbsp;&nbsp;<span class="badge bg-primary" id="lJarak"></span>
												</div>
												<div class="text-muted">|</div>
												<!-- <div>
													<i class="mdi mdi-timer-outline"></i>&nbsp;&nbsp;&nbsp;<span class="badge bg-primary" id="lWaktu"></span>
												</div> -->
											</div>
											<hr />
											<div class="d-flex align-items-center justify-content-evenly mt-2">
												<div>
													<i class="mdi mdi-map-marker-path"></i>&nbsp;&nbsp;&nbsp;<span class="" id="lPath"></span> <button id="btnShowModalDetailPerhitungan" class="btn btn-sm btn-link">Detail perhitungan</button>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
							<div class="col-12 col-sm-12 mb-5">
								<div id="map" style="height: 550px;width: 100%;"></div>
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
	<script src="<?= base_url() ?>assets/libs/select2/js/select2.min.js"></script>
	<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
	<script type="text/javascript">
		mapboxgl.accessToken = 'pk.eyJ1IjoiZWZoYWwiLCJhIjoiY2ptOXRiZ3k2MDh4bzNrbnljMjk5Z2d5aSJ9.8dSNgeAjpdTlZ3x-b2vsog';
		var map = new mapboxgl.Map({
			container: 'map', // container id
			style: 'mapbox://styles/mapbox/satellite-v9', // stylesheet location
			center: [122.514900, -3.972201], // starting position [lng, lat]
			zoom: 10, // starting zoom
			logoPosition: 'top-right',
		});

		if (!navigator.geolocation) {
			console.log('Geolocation is not supported by your browser');
		} else {
			console.log('Locating…');
			navigator.geolocation.getCurrentPosition(success, error);
		}

		var current_latitude = '';
		var current_longitude = '';

		function success(position) {
			current_latitude = position.coords.latitude;
			current_longitude = position.coords.longitude;

		}

		function error() {
			console.log('Geolocation error !');
		}


		map.addControl(
			new mapboxgl.GeolocateControl({
				positionOptions: {
					enableHighAccuracy: true
				},
				// When active the map will receive updates to the device's location as it changes.
				trackUserLocation: true,
				// Draw an arrow next to the location dot to indicate which direction the device is heading.
				showUserHeading: true
			})
		);

		$('#start').select2();
		$('#end').select2();
		var marker = [];

		$.ajax({
			'url': "<?= site_url('admin/graph/ajax/data') ?>",
			'type': 'POST',
			success: function(e) {
				var data_obj = JSON.parse(e);
				data_obj.forEach(function(i) {
					if (i.type != '-') {
						var color = i.type == '-' ? '#01f254' : '#015ff2';
						marker.push(new mapboxgl.Marker({
								color: color,
							})
							.setLngLat([i.lng, i.lat])
							.setPopup(new mapboxgl.Popup().setHTML(`
						<div class="card" style="width: 10rem;">
						<img src="<?= base_url('uploads/') ?>${i.picture}" class="card-img-top" alt="...">
						<div class="card-body">
							<h5 class="card-title">${i.name}</h5>
							<a href="<?= site_url('hotel/detail/') ?>${i.id}" class="btn btn-primary">Lihat detail</a>
						</div>
						</div>
						`)) // add popup
							.addTo(map));
					}
				})
			}

		});


		var marker_start;
		$("#start").change(function(e) {
			e.preventDefault();
			var start_atribute = $('#start').select2('data')[0].element.attributes;
			if (marker_start) {
				marker_start.remove();
			}

			if ($("#start").val() == 'current_location') {
				lng = current_latitude;
				lat = current_longitude;

				// marker dengan posisi terdekat dari current location
				$.ajax({
					url: '<?= site_url('getMarker') ?>',
					success: function(e) {
						var markers = JSON.parse(e);
						var distance = [];
						markers.forEach(function(i) {
							distance.push({
								id: i.id,
								distance: turf.distance(turf.point([lng, lat]), turf.point([i.lat, i.lng]), {
									units: 'kilometers'
								})
							});
						});
						distance.sort((a, b) => a.distance - b.distance);
						console.log(distance);
						$("#start").val(distance[0].id);
					}
				})

			} else {
				lng = start_atribute.lng.value;
				lat = start_atribute.lat.value;
			}

			map.flyTo({
				center: [
					lat,
					lng
				],
				essential: true // this animation is considered essential with respect to prefers-reduced-motion
			});

			marker_start = new mapboxgl.Marker({
					color: "#ff0000",
				})
				.setLngLat([lat, lng])
				.addTo(map)

		})

		// map.on('load',()=>{


		// })

		var lineMapLayer;

		// function buatLine(Obj) {
		// 	if (lineMapLayer) {
		// 		map.removeLayer("route");
		// 		map.removeSource("route");
		// 	}
		// 	var cor = [];
		// 	Obj.forEach(function(i) {
		// 		cor.push([i.lng, i.lat]);
		// 	});
		// 	console.log(cor);
		// 	lineMapLayer = map.addLayer({
		// 		"id": "route",
		// 		"type": "line",
		// 		"source": {
		// 			"type": "geojson",
		// 			"data": {
		// 				"type": "Feature",
		// 				"properties": {},
		// 				"geometry": {
		// 					"type": "LineString",
		// 					"coordinates": cor
		// 				}
		// 			}
		// 		},
		// 		"layout": {
		// 			"line-join": "round",
		// 			"line-cap": "round"
		// 		},
		// 		"paint": {
		// 			"line-color": "#FF0000",
		// 			"line-width": 6,
		// 			"line-offset": -3
		// 		}
		// 	});
		// }


		

		$("#end").change(function(e) {
			e.preventDefault();
			$.ajax({
				url: "<?= site_url('Front/getShortestPath') ?>",
				type: 'POST',
				data: {
					start: $("#start").val(),
					end: $("#end").val()
				},
				success: function(e) {
					var astar = JSON.parse(e);

					console.log(astar);

					if (astar.path_ == 'PATH_NOT_FOUND') {
						alert('Rute tidak ditemukan');
						$("#res").addClass('d-none');
						buatLine([]);
					} else {
						buatLine(astar.path_cor);
						$("#res").removeClass('d-none');

						// $("#lWaktu").text(astar.time);
						$("#lAsal").text(astar.from_);
						$("#lAkhir").text(astar.to_);
						$("#lJarak").text(astar.distance);
						$("#lPath").html(astar.path_);
						$("#resDetailPerhitungan").html(astar.detail_perhitungan);
					}

					console.log(astar.path_cor);
					// map.fitBounds([
					// 	[astar.path_cor[0].lng, astar.path_cor[0].lat], // southwestern corner of the bounds
					// 	[astar.path_cor[(astar.path_cor.length - 1)].lng, astar.path_cor[(astar.path_cor.length - 1)].lat], // southwestern corner of the bounds
					// ]);

					const bounds = new mapboxgl.LngLatBounds(
						[astar.path_cor[0].lng, astar.path_cor[0].lat], // southwestern corner of the bounds
						[astar.path_cor[(astar.path_cor.length - 1)].lng, astar.path_cor[(astar.path_cor.length - 1)].lat], // southwestern corner of the bounds
					);
					map.fitBounds(bounds, {
						padding: 20
					});

				}
			})
		})
		$("#btnShowModalDetailPerhitungan").click(function() {
			$("#modalDetailPerhitungan").modal("show");
		})
	</script>
</body>

</html>
