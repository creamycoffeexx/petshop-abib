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
									
									</div>
								</form>

							</div>
							<div class="col-12 col-sm-12 mb-5">
								<div id="map" style="height: 550px;width: 100%;"></div>
								<!-- left side instructions -->
								<div id='keterangan' style=" position:absolute;
													        height: 100px;
													        margin:9px;
													        width: 20%;
													        top:0;
													        bottom:0;
													        padding: 20px;
													        background-color: rgba(255,255,255,0.9);
													        font-family: sans-serif;">
								<div id="calculated-line"></div>
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
	<script src="<?= base_url() ?>assets/libs/select2/js/select2.min.js"></script>
	<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
	

	<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
	
	<script type="text/javascript">
		mapboxgl.accessToken = 'pk.eyJ1IjoiZWZoYWwiLCJhIjoiY2ptOXRiZ3k2MDh4bzNrbnljMjk5Z2d5aSJ9.8dSNgeAjpdTlZ3x-b2vsog';
		var map = new mapboxgl.Map({
			container: 'map', // id wadah
			style: 'mapbox://styles/mapbox/satellite-v9', // lokasi lembar gaya
			center: [<?= DEFAULT_LNG ?>, <?= DEFAULT_LAT ?>], // posisi awal [lng, lat]
			zoom: 9, // mulai zoom
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

		//tombol kontrol
		map.addControl(new mapboxgl.NavigationControl());
		map.addControl(
			new mapboxgl.GeolocateControl({
				positionOptions: {
					enableHighAccuracy: true
				},
				// Saat aktif, peta akan menerima pembaruan ke lokasi perangkat saat berubah.
				trackUserLocation: true,
				// Gambar panah di sebelah titik lokasi untuk menunjukkan arah yang dituju perangkat.
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
							<a href="<?= site_url('hotel/detail/') ?>${i.id}" target="blank" class="btn btn-primary">Lihat detail</a>
						</div>
						</div>
						`)) // tambahkan munculan
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

				// penanda dengan posisi terdekat dari lokasi sekarang
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
				essential: true // animasi ini dianggap penting sehubungan dengan gerakan yang lebih disukai-dikurangi
			});

			marker_start = new mapboxgl.Marker({
					color: "#ff0000",
				})
				.setLngLat([lat, lng])
				.addTo(map)

		});


	var draw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            line_string: true,
            trash: true
        },
        styles: [
            // tarik garis
            {
                "id": "gl-draw-line",
                "type": "line",
                "filter": ["all", ["==", "$type", "LineString"], ["!=", "mode", "static"]],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#FF0000",
                    "line-dasharray": [0.2, 2],
                    "line-width": 4,
                    "line-opacity": 0.7
                }
            },
            // titik simpul
            {
                "id": "gl-draw-polygon-and-line-vertex-halo-active",
                "type": "circle",
                "filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
                "paint": {
                    "circle-radius": 10,
                    "circle-color": "#FFF"
                }
            },
            // Disini Titik
            {
                "id": "gl-draw-polygon-and-line-vertex-active",
                "type": "circle",
                "filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
                "paint": {
                    "circle-radius": 6,
                    "circle-color": "#3b9ddd",
                }
            },
        ]
    });
    // Alat gambar peta
    map.addControl(draw);

    // buat, perbarui, atau hapus tindakan
    map.on('draw.create', updateRoute);
    map.on('draw.update', updateRoute);
    map.on('draw.delete', removeRoute);

    // gunakan koordinat yang baru saja Anda gambar untuk membuat permintaan arah Anda
    function updateRoute() {
        removeRoute(); // menimpa lapisan
        var data = draw.getAll();
        var lastFeature = data.features.length - 1;
        var coords = data.features[lastFeature].geometry.coordinates;
        var newCoords = coords.join(';');
        getMatch(newCoords);
    }

    // membuat permintaan arah
    function getMatch(e) {
        var url = 'https://api.mapbox.com/directions/v5/mapbox/cycling/' + e
            +'?geometries=geojson&steps=true&access_token=' + mapboxgl.accessToken;
        var req = new XMLHttpRequest();
        req.responseType = 'json';
        req.open('GET', url, true);
        req.onload  = function() {
            var jsonResponse = req.response;
            var distance = jsonResponse.routes[0].distance*0.001;
            var duration = jsonResponse.routes[0].duration/60;
            var steps = jsonResponse.routes[0].legs[0].steps;
            var coords = jsonResponse.routes[0].geometry;
          //  console.log(steps);
        console.log(coords);
         //  console.log(distance);
          // console.log(duration);

            // dapatkan jarak dan durasi
            keterangan.insertAdjacentHTML('beforeend', '<p>' +  'Jarak Rute: ' + distance.toFixed(2) + ' km<br>Durasi Waktu: ' + duration.toFixed(2) + ' minutes' + '</p>');

            // tambahkan rute ke peta
            addRoute(coords);
          //  console.log(coordinates);

        };
        req.send();
    }

    // menambahkan rute sebagai lapisan di peta
    function addRoute (coords) {
        // periksa apakah rute sudah dimuat
        if (map.getSource('route')) {
            map.removeLayer('route');
            map.removeSource('route')
        } else{
            map.addLayer({
                "id": "route",
                "type": "line",
                "source": {
                    "type": "geojson",
                    "data": {
                        "type": "Feature",
                        "properties": {},
                        "geometry": coords
                    }
                },
                "layout": {
                    "line-join": "round",
                    "line-cap": "round"
                },
                "paint": {
                    "line-color": "#1db7dd",
                    "line-width": 8,
                    "line-opacity": 0.8
                }
            });
        };
    }

    // hapus layer jika ada
    function removeRoute () {
        if (map.getSource('route')) {
            map.removeLayer('route');
            map.removeSource('route');
            // instructions.innerHTML = '';
            console.log("cek");
        } else  {
            return;
        }
    }
    document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
	</script>
</body>

</html>
