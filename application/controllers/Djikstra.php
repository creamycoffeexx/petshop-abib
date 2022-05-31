<?php


class Djikstra
{
	public $graf;
	public $grafName;
	public $lok_asal;
	public $lok_akhir;
	public $visited_node = array();
	public $current_node = '';
	public $shortest_distance = array();
	public $previous_node = array();
	public $detail_perhitungan = '';
	public $times = array();


	public function __construct($graf = '', $grafName = '', $lok_asal = '', $lok_akhir = '', $times = '')
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		
		if ($this->session->userdata('user') === null) {
			redirect('login');
		}

		$this->lok_asal = $lok_asal;
		$this->lok_akhir = $lok_akhir;

		$this->graf = $graf;
		$this->grafName = $grafName;
		$this->times = $times;


		foreach ($this->grafName as $ki => $vi) {
			foreach ($this->grafName as $kj => $vj) {
				if (isset($this->graf["$ki"]["$kj"])) {
					$this->graf["$ki"]["$kj"] = $this->graf["$ki"]["$kj"];
				} else {
					$this->graf["$ki"]["$kj"] = INF;
				}
			}
		}
		$this->run();
	}

	public function run()
	{

		$g_len = count($this->graf);
		while ($g_len--) {
			if ($this->current_node == '') {
				// Start by setting the starting node (A) as the current node.
				$this->current_node = $this->lok_asal;
				$this->shortest_distance[$this->current_node] = 0;
			}

			// Check all the nodes connected to A and update their “Distance from A” and set their “previous node” to “A”.
			$checkAllNodes = $this->checkAllNodes($this->current_node);

			$this->detail_perhitungan .= '<div class="">';
			$this->detail_perhitungan .= '<span class="m-2">Node: ' . $this->grafName[$this->current_node] . "</span><br/>";

			if ($checkAllNodes) {
				$this->detail_perhitungan .= '<span class="m-2">Suksesor: ' . "</span><br/>";
				foreach ($checkAllNodes as $key => $val) {

					if ($val != INF) {
						if (!in_array($key, $this->visited_node)) {
							if (isset($this->shortest_distance[$key])) {
								if (($this->shortest_distance[$this->current_node] + $val) < $this->shortest_distance[$key]) {
									$this->shortest_distance[$key] = $this->shortest_distance[$this->current_node] + $val;
									$this->previous_node[$key] = $this->current_node;

									$this->detail_perhitungan .= '<span class="m-2">fs(' . $this->grafName[$key] . ") = </span><br/>";
								}
							} else {
								$this->shortest_distance[$key] = $this->shortest_distance[$this->current_node] + $val;
								$this->previous_node[$key] = $this->current_node;

								$this->detail_perhitungan .= '<span class="m-2">f(' . $this->grafName[$key] . ') = g(' . $this->grafName[$key] . ')</span><br/>';
								$this->detail_perhitungan .= '<span class="m-2">f(' . $this->grafName[$key] . ") = {$this->shortest_distance[$this->current_node]} + " . round($val, 2) . "</span><br/>";
								$this->detail_perhitungan .= '<span class="m-2">f(' . $this->grafName[$key] . ") = " . ($this->shortest_distance[$key]) . "</span><br/>";
							}
						}
					}
				}

				// Set the current node (A) to “visited” and use the closest unvisited node to A as the current node (e.g. in this case: Node C).
				array_push($this->visited_node, $this->current_node);

				$prev = array_filter($this->previous_node, function ($e) {
					return $e == $this->current_node;
				});

				// use the closest unvisited node to A as the current node
				$prev = array_keys($prev);
				$temp = array();
				for ($i  = 0; $i < count($prev); $i++) {

					$temp[$prev[$i]] = $this->shortest_distance[$prev[$i]];
				}
				if (count($temp) > 0) {
					$min = array_keys($temp, min($temp));
					if (count($min) > 0) {
						$this->current_node = $min[0];
					} else {
						// -----------------------
						break;
					}
				} else {

					$temp = array();
					foreach ($this->shortest_distance as $k => $v) {
						if (!in_array($k, $this->visited_node)) {
							$temp[] = $k;
						}
					}
					$sisa_node_yang_blm_dikunjungi = array();

					for ($i  = 0; $i < count($temp); $i++) {

						$sisa_node_yang_blm_dikunjungi[$temp[$i]] = $this->shortest_distance[$temp[$i]];
					}
					if (count($sisa_node_yang_blm_dikunjungi) > 0) {
						$min = array_keys($sisa_node_yang_blm_dikunjungi, min($sisa_node_yang_blm_dikunjungi));
						if (count($min) > 0) {
							$this->current_node = $min[0];
						}
					}
				}
			}

			if ($this->current_node == $this->lok_akhir) {
				$this->detail_perhitungan .= "<span class='m-2'>Rute ditemukan</span><br/>";
				break;
			}
			$this->detail_perhitungan .= '<span class="m-2 fw-bolder">Best Node: ' . $this->grafName[$this->current_node] . "</span><br/>";

			$this->detail_perhitungan .= "<div/>";
			$this->detail_perhitungan .= "<hr/>";
		}
	}

	/**
	 * checkAllNodes
	 *
	 * @param  mixed $node
	 * @return void
	 */
	public function checkAllNodes($node)
	{
		if (array_key_exists($node, $this->graf)) {
			return $this->graf[$node];
		}
		return array();
	}

	/**
	 * getPath
	 *
	 * @return void
	 */
	public function getPath()
	{
		$node = $this->previous_node;
		$temp = '';
		$path = array();
		while (true) {
			if ($temp == '') $temp = $this->lok_akhir;
			array_push($path, $temp);
			if (!isset($node[$temp])) break;
			$temp = $node[$temp];
		}
		return $path;
	}

	public function getTime()
	{
		$path = $this->getPath();
		$path = array_reverse($path);
		$total = 0;
		for ($i = 0; $i < (count($path) - 1); $i++) {
			$total += $this->times[$path[$i]][$path[($i + 1)]];
		}
		return $total;
	}
	/**
	 * printPath
	 *
	 * @return void
	 */
	public function printPath()
	{

		if ($this->getDistance() > 0) {
			$path = array_map(function ($a) {
				return $this->grafName[$a];
			}, $this->getPath());
			return implode(' -> ', array_reverse($path));
		}
		return "PATH_NOT_FOUND";
	}

	/**
	 * getDistance
	 *
	 * @return void
	 */
	public function getDistance()
	{
		$path = $this->getPath();
		$path = array_reverse($path);
		$total = 0;
		for ($i = 0; $i < (count($path) - 1); $i++) {
			$total += $this->graf[$path[$i]][$path[($i + 1)]];
		}
		return $total;
	}
	public function getDetailPerhitungan()
	{
		return $this->detail_perhitungan;
	}
}


// $a = new Djikstra($graf = '', $grafName = '', "a", "z", 4);
// print $a->printPath() . ' ' . $a->getDistance();
