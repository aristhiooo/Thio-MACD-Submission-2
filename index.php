<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Formulir Calon Anggota UKM Seni UNM</title>
		<link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">
		<!-- Bootstrap core CSS -->
		<link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="starter-template.css" rel="stylesheet">
	</head>
	
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="https://thio-webapps.azurewebsites.net/">Submission 1</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="https://thio-webapps.azurewebsites.net/upload.php">Submission 2<span class="sr-only">(current)</span></a>
					</li>
					</div>
				</nav>
			
			<main role="main" class="container">
				<div class="starter-template">
					<br><br><br>
					<h1>Formulir Calon Anggota UKM Seni UNM</h1>
					<p class="lead">Silahkan isi formulir di bawah ini, Kemudian Click <b>Submit</b> untuk menjadi makhluk manis.</p>
					<br>
					<span class="border-top my-3"></span>
				</div>
				
				<form action="index.php" method="POST">
					<div class="form-group">
						<label for="name">Nama Lengkap: </label>
						<input type="text" class="form-control" name="nama" id="nama" required="" >
					</div>
					
					<div class="form-group">
						<label for="email">Nomor Induk Mahasiswa (NIM): </label>
						<input type="text" class="form-control" name="nim" id="nim" required=""maxlength="10">
					</div>
					
					<div class="form-group">
						<label for="NPK">Program Studi: </label>
						<input type="text" class="form-control" name="prodi" id="prodi" required="">
					</div>
					
					<div class="form-group">
						<label for="name">Nomor Handphone (Whatsapp): </label>
						<input type="text" class="form-control" name="hp" id="hp" required="" >
					</div>
					
        <!-- <div class="form-group" action="index.php" method="post" enctype="multipart/form-data">
            <label for="upload">Upload Foto Alat Musik : </label> <br>
            <input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required="">
            <br><br> -->
					<input type="submit" class="btn btn-success" name="submit" value="DAFTAR">
				</form>
				
				<form action="index.php" method="post">
					<div class="form-group">
						<input type="submit" class="btn btn-info" name="load_data" value="LIHAT YANG TELAH MENDAFTAR">
					</div>
				</form>

 <?php
$host = "thiosqldatabase.database.windows.net";
$user = "aristhiooo";
$pass = "PAKUsadew0";
$db = "thio-webapps";

try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch(Exception $e) {
        echo "Failed: " . $e;}

if (isset($_POST['submit'])) {
	try {
		$nama = $_POST['nama'];
		$nim = $_POST['nim'];
		$prodi = $_POST['prodi'];
		$hp = $_POST['hp'];
		$date = date("Y-m-d");
		
		// Tulis data ke database
		$sql_insert = "INSERT INTO Daftar (nama, nim, prodi, hp, date) 
		VALUES (?,?,?,?,?)";
		$stmt = $conn->prepare($sql_insert);
		$stmt->bindValue(1, $nama);
		$stmt->bindValue(2, $nim);
		$stmt->bindValue(3, $prodi);
		$stmt->bindValue(4, $hp);
		$stmt->bindValue(5, $date);
		$stmt->execute();
	} catch(Exception $e) {
		echo "Failed: " . $e;
	}
	echo "<h3>Terima Kasih sudah mendaftar. Tunggu info selajutnya atau lihat teman-teman kamu yang telah mendaftar</h3>";
} else if (isset($_POST['load_data'])) {
	try {
		$sql_select = "SELECT * FROM Daftar";
		$stmt = $conn->query($sql_select);
		$registrants = $stmt->fetchAll(); 
		
		if(count($registrants) > 0) {
			echo "<h2>Ini dia orang-orang yang sudah mendaftar.</h2>";
			echo "<table class='table table-hover'>";
			echo "<tr><th>Nama Lengkap</th>";
			echo "<th>NIM</th>";
			echo "<th>Program Studi</th>";
			echo "<th>No. HP</th>";
			echo "<th>Tanggal daftar</th></tr>";
			
			foreach($registrants as $registrant) {
				echo "<tr><td>".$registrant['nama']."</td>";
				echo "<td>".$registrant['nim']."</td>";
				echo "<td>".$registrant['prodi']."</td>";
				echo "<td>".$registrant['hp']."</td>";
				echo "<td>".$registrant['date']."</td></tr>";
			} echo "</table>";
		} else {
			echo "<h3>Belumpi ada yang mendaftar :(</h3>";
		}
	} catch(Exception $e) {
		echo "Failed: " . $e;
	}
}
?>
				</div>
			</main><!-- /.container -->
		</tbody>
	</table>
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
<script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
	</body>
</html>
