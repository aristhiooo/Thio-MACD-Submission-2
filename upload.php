<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

# Mengatur instance dari Azure::Storage::Client
$connectionString = "DefaultEndpointsProtocol=https;AccountName=thiowebapps;AccountKey=kElcHq/CRZFxSp+7Rl+6mV0JZ7ZOV9jLo16R7YGH8047g9XIXKxyJeVe+uXqiTeWD6AiVzE/E8Vim7CxqNNdag==;EndpointSuffix=core.windows.net;"

// Membuat blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);


// Membuat BlobService yang merepresentasikan Blob service untuk storage account
$createContainerOptions = new CreateContainerOptions();
$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// Menetapkan metadata dari container.
$createContainerOptions->addMetaData("key1", "value1");
$createContainerOptions->addMetaData("key2", "value2");
$containerName = "blokblobs".generateRandomString();

try {
	// Membuat container.
	$blobClient->createContainer($containerName, $createContainerOptions);
	
	// Upload File.
	if (isset($_POST['submit'])) {
		$fileToUpload = strtolower($_FILES["fileToUpload"]["name"]);
		$content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
	}
	
	echo fread($content, filesize($fileToUpload));
	$blobClient->createBlockBlob($containerName, $fileToUpload, $content);
	header("Location: upload.php");
	
	// List Blobs.
	
	// Mendapatkan Blob
	$blob = $blobClient->getBlobs($containerName, $fileToUpload);
	fpassthru($blob->getContentStream());
}

catch(ServiceException $e){
$code = $e->getCode();
$error_message = $e->getMessage();
echo $code.": ".$error_message."<br />";
}

catch(InvalidArgumentTypeException $e){
$code = $e->getCode();
$error_message = $e->getMessage();
echo $code.": ".$error_message."<br />";
}

?>

<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://raw.githubusercontent.com/muhrizky/Smart-Parkir/master/parking_meter__2__Mrq_icon.ico">

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
			<li class="nav-item">
				<a class="nav-link" href="https://thio-webapps.azurewebsites.net/">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="https://thio-webapps.azurewebsites.net/upload.php">Lihat Analisis Gambar.<span class="sr-only">(current)</span></a>
			</li>
		</div>
		</nav>
		
		<main role="main" class="container">
    		<div class="starter-template"> <br><br><br>
        		<h1>Analisis Alat Musik</h1>
				<p class="lead">Pilih foto alat musik anda<br> Kemudian klik <b>Upload</b>. Untuk menganlisa foto, pilih <b>analyze</b> pada tabel.</p>
				<span class="border-top my-3"></span>
			</div>
			
		<div class="mt-4 mb-2">
			<form class="d-flex justify-content-lefr" action="upload.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required="">
				<input type="submit" name="submit" value="Upload">
			</form>
		</div>
		
		<br>
		<br>
		
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>File Name</th>
					<th>File URL</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
	    			$listBlobsOptions = new ListBlobsOptions();
				$listBlobsOptions->setPrefix("");
				do {
					$result = $blobClient->listBlobs($containerName, $listBlobsOptions);
					foreach ($result->getBlobs() as $blob)
					{
						?>
						<tr>
							<td><?php echo $blob->getName() ?></td>
							<td><?php echo $blob->getUrl() ?></td>
							<td>
								<form action="computervision.php" method="post">
									<input type="hidden" name="url" value="<?php echo $blob->getUrl()?>">
									<input type="submit" name="submit" value="Analyze!" class="btn btn-primary">
								</form>
							</td>
						</tr>
						<?php
					}
					$listBlobsOptions->setContinuationToken($result->getContinuationToken());
				} while($result->getContinuationToken());
				?>
			</tbody>
		</table>

	</div>

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
 </body>
</html>
