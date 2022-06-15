<?php 

include ('koneksi.php');

$label = ["India", "S.Korea", "Turkey", "Vietnam", "Japan", "Iran", "Indonesia", "Malaysia", "Thailand", "Israel"];

for ($count=1; $count < 11 ; $count++) 
{ 
	$query = mysqli_query($koneksi, "SELECT SUM(Total_sembuh) as Total_sembuh from covid_case WHERE id='$count'");
	$query1 = mysqli_query($koneksi, "SELECT SUM(Total_death) as Total_death from covid_case WHERE id='$count'");
	$query2 = mysqli_query($koneksi, "SELECT SUM(New_sembuh) as New_sembuh from covid_case WHERE id='$count'");
	$query3 = mysqli_query($koneksi, "SELECT SUM(New_case) as New_case from covid_case WHERE id='$count'");
	$query4 = mysqli_query($koneksi, "SELECT SUM(New_death) as New_death from covid_case WHERE id='$count'");

	$row = $query->fetch_array();
	$row1 = $query1->fetch_array();
	$row2 = $query2->fetch_array();
	$row3 = $query3->fetch_array();
	$row4 = $query4->fetch_array();

	$Total_sembuh[] = $row['Total_sembuh'];
	$Total_death[] = $row1['Total_death'];
	$New_sembuh[] = $row2['New_sembuh'];
	$New_case[] = $row3['New_case'];
	$New_death[] = $row4['New_death'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Latihan membuat chart</title>
	<script type="text/javascript" src="chart2.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>
	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
				data: {
					labels: <?php echo json_encode($label); ?>,
					datasets:[{
						type: 'line',
						label: 'Total_sembuh',
						data: <?php echo json_encode($Total_sembuh); ?>,
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255, 99, 132, 1)',
						borderWidth: 1
					}, {
						type: 'line',
						label: 'Total_death',
						data: <?php echo json_encode($Total_death); ?>,
						backgroundColor: 'rgba(90, 50, 300, 0.2)',
						borderColor: 'rgba(90, 50, 300, 1)',
						borderWidth: 1
					}, {
						type: 'line',
						label: 'New_sembuh',
						data: <?php echo json_encode($New_sembuh); ?>,
						backgroundColor: 'rgba(300, 99, 132, 0.8)',
						borderColor: 'rgba(300, 99, 132, 1)',
						borderWidth: 1
					}, {
						type: 'line',
						label: 'New_case',
						data: <?php echo json_encode($New_case); ?>,
						backgroundColor: 'rgba(150, 350, 82, 0.8)',
						borderColor: 'rgba(150, 350, 82, 1)',
						borderWidth: 1
					}, {
						type: 'line',
						label: 'New_death',
						data: <?php echo json_encode($New_death); ?>,
						backgroundColor: 'rgba(90, 50, 350, 0.8)',
						borderColor: 'rgba(90, 50, 350, 1)',
						borderWidth: 1
					}]
				},
				options:{
					scales:{
						yAxes:[{
							ticks:{
								beginAtZero:true
							}
						}]
					}
				}
			});

		</script>

</body>
</html>