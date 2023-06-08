<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item active">Użytkownik</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<!-- Form Element sizes -->
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Kalkulator kosztów</h3>
						</div>
						<div class="card-body">
							<input id="averageConsumption" class="form-control" type="text" inputmode="decimal" pattern="[0-9]*" placeholder="Średnie spalanie [l/100km]">
							<br>
							<input id="fuelPrice" class="form-control" type="text" inputmode="decimal" pattern="[0-9]*" placeholder="Cena Paliwa [zł]">
							<br>
							<input id="distance" class="form-control" type="text" inputmode="decimal" pattern="[0-9]*" placeholder="Długość trasy [km]">
							<br>
							<input id="extraCosts" class="form-control" type="text" inputmode="decimal" pattern="[0-9]*" placeholder="Dodatkowe koszty przejazdu [zł]">
							<br>
							<label for="exampleInputBorder">Wynik: <span id="costResult"></span></label>
							<br>
							<button id="calculateCost" class="btn btn-primary">Oblicz</button> <!-- Przycisk obliczania -->
						</div>
						<!-- /.card-body -->
					</div>
				</div><!--/. container-fluid -->
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<!-- Form Element sizes -->
						<div class="card card-success">
							<div class="card-header">
								<h3 class="card-title">Kalkulator średniego spalania</h3>
							</div>
							<div class="card-body">
								<input id="fuelConsumed" class="form-control" type="text" inputmode="decimal" pattern="[0-9]*" placeholder="Spalone paliwo w litrach [l]">
								<br>
								<input id="distanceTraveled" class="form-control" type="text" inputmode="decimal" pattern="[0-9]*" placeholder="Ilość przejechanych kilometrów [km]">
								<br>
								<label for="exampleInputBorder">Wynik: <span id="consumptionResult"></span></label>
								<br>
								<button id="calculateConsumption" class="btn btn-primary">Oblicz</button> <!-- Przycisk obliczania -->
							</div>
							<!-- /.card-body -->
						</div>
					</div><!--/. container-fluid -->
				</div>
			</div>
		</div>
	</section>
</div>

<script>
	// Kalkulator kosztów
	const calculateCostButton = document.getElementById('calculateCost');
	calculateCostButton.addEventListener('click', calculateCost);

	function calculateCost() {
		const averageConsumptionInput = document.getElementById('averageConsumption');
		const fuelPriceInput = document.getElementById('fuelPrice');
		const distanceInput = document.getElementById('distance');
		const extraCostsInput = document.getElementById('extraCosts');
		const costResultLabel = document.getElementById('costResult');

		const averageConsumption = parseFloat(averageConsumptionInput.value);
		const fuelPrice = parseFloat(fuelPriceInput.value);
		const distance = parseFloat(distanceInput.value);
		const extraCosts = parseFloat(extraCostsInput.value);

		const totalCost = (averageConsumption * distance / 100 * fuelPrice) + extraCosts;

		costResultLabel.textContent = totalCost.toFixed(2) + ' zł';
	}

	// Kalkulator średniego spalania
	const calculateConsumptionButton = document.getElementById('calculateConsumption');
	calculateConsumptionButton.addEventListener('click', calculateConsumption);

	function calculateConsumption() {
		const fuelConsumedInput = document.getElementById('fuelConsumed');
		const distanceTraveledInput = document.getElementById('distanceTraveled');
		const consumptionResultLabel = document.getElementById('consumptionResult');

		const fuelConsumed = parseFloat(fuelConsumedInput.value);
		const distanceTraveled = parseFloat(distanceTraveledInput.value);

		const averageConsumption = (fuelConsumed / distanceTraveled) * 100;

		consumptionResultLabel.textContent = averageConsumption.toFixed(2) + ' l/100km';
	}

	// Sprawdzenie wprowadzanych danych na bieżąco
	const numericInputs = document.querySelectorAll('input[type="text"][inputmode="decimal"]');

	numericInputs.forEach((input) => {
		input.addEventListener('input', (event) => {
			const value = event.target.value;
			event.target.value = value.replace(/[^0-9\.]/g, ''); // Usuwanie znaków niebędących liczbami
		});
	});
</script>
