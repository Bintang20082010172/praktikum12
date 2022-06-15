<?php
include('koneksi.php');
$covid = mysqli_query($koneksi,"select * from covid_case");
while($row = mysqli_fetch_array($covid)){
	$nama_negara[] = $row['Nama_negara'];
	
	$query = mysqli_query($koneksi,"select sum(New_sembuh) as New_sembuh from covid_case where New_sembuh='".$row['New_sembuh']."'");
	$row = $query->fetch_array();
	$New_sembuh[] = $row['New_sembuh'];
}
?>
<!doctype html>
<html>

<head>
	<title>latihan membuat Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>

<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($New_sembuh); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
                    'rgba(253, 95, 253, 1)',
                    'rgba(120, 255, 255, 1)',
                    'rgba(155, 252, 110, 1)',
                    'rgba(255, 108, 203, 0.53)',
                    'rgba(255, 171, 74, 0.53)',
                    'rgba(48, 48, 247, 0.53)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
                    'rgba(253, 95, 253, 1)',
                    'rgba(120, 255, 255, 1)',
                    'rgba(155, 252, 110, 1)',
                    'rgba(255, 108, 203, 0.53)',
                    'rgba(255, 171, 74, 0.53)',
                    'rgba(48, 48, 247, 0.53)',
					'rgba(75, 192, 192, 1)'
					],
					label: 'New sembuh Covid-19'
				}],
				labels: <?php echo json_encode($nama_negara); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>
