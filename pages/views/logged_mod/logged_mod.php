<?php
session_start();
$conn = new mysqli("localhost", "root", "", "baza_danych");
?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item active">Moderator
						</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Lista użytkowników</h3>

					<div class="card-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search" class="form-control float-right" placeholder="Search">

							<div class="input-group-append">
								<button type="submit" class="btn btn-default">
									<i class="fas fa-search"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body table-responsive p-0">
					<table class="table table-hover text-nowrap">
						<thead>
							<tr>
								<th>ID</th>
								<th>Email</th>
								<th>Imie</th>
								<th>Nazwisko</th>
								<th>Rola</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Wykonaj zapytanie do bazy danych, aby pobrać dane użytkowników
							$sql = "SELECT * FROM users";
							$result = mysqli_query($conn, $sql);

							// Generuj wiersze tabeli na podstawie danych z bazy danych
							while ($row = mysqli_fetch_assoc($result)) {
								echo '<tr>';
								echo '<td>' . $row['id'] . '</td>';
								echo '<td>' . $row['email'] . '</td>';
								echo '<td>' . $row['firstName'] . '</td>';
								echo '<td>' . $row['lastName'] . '</td>';
                				echo '<td>' . $row['role_id'] . '</td>';
								echo '<td><a href="logged_admin/edit_user.php?id=' . $row['id'] . '">Edytuj</a></td>'; // Przycisk edycji
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	</div>