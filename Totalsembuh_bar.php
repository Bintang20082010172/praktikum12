<?php
include('koneksi.php');
$covid = mysqli_query($koneksi,"select * from covid");
while($row = mysqli_fetch_array($covid)){
	$nama_negara[] = $row['negara'];
	
	$query = mysqli_query($koneksi,"select sum(total_sembuh) as total_sembuh from covid where total_sembuh='".$row['total_sembuh']."'");
	$row = $query->fetch_array();
	$jumlah_sembuh[] = $row['total_sembuh'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Latihan membuat chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>


	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_negara); ?>,
				datasets: [{
					label: 'Grafik Total sembuh dari covid',
					data: <?php echo json_encode($jumlah_sembuh); ?>,
					backgroundColor: 'rgba(255, 91, 255, 1)',
					borderColor: 'rgba(242, 0, 242, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>