<div class="col-12 col-lg-4 col-xxl-4 d-flex">
	<div class="card flex-fill w-100">
		<div class="card-header">
			<h5 class="card-title mb-0">Monthly revenue</h5>
		</div>
		<div class="card-body d-flex w-100">
			<div class="align-self-center chart chart-lg">
				<canvas id="monthly-revenue"></canvas>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		new Chart(document.getElementById("monthly-revenue"), {
			type: "bar",
			data: {
				labels: [{!!implode(', ', array_map(fn($month) => '"' . $month['formatted'] . '"', array_slice($data['dashboard']::months(), 0, -1)))!!}],
				
				datasets: [{
					label: "This month",
					backgroundColor: [{!!implode(', ', array_map(fn($month) => $data['dashboard']::getrevenue($month)>0?"window.theme.success":"window.theme.danger", array_slice($data['dashboard']::months(), 0, -1)))!!}],
					borderColor: window.theme.primary,
					hoverBackgroundColor: window.theme.primary,
					hoverBorderColor: window.theme.primary,
					data: [{!!implode(', ', array_map(fn($month) => abs($data['dashboard']::getrevenue($month)), array_slice($data['dashboard']::months(), 0, -1)))!!}],
					barPercentage: .75,
					categoryPercentage: .5
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false
						},
						stacked: false,
						ticks: {
							stepSize: 20
						}
					}],
					xAxes: [{
						stacked: false,
						gridLines: {
							color: "transparent"
						}
					}]
				}
			}
		});
	});
</script>