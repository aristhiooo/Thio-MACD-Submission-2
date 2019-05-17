<?php
if (isset($_POST['submit'])) {
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
	} else {
		header("Location: upload.php");
	}
} else {
	header("Location: upload.php");
}
?>

<!DOCTYPE html>
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
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
					<h1>Submission 2 - Cognition Service</h1>
					<p>Melakukan analisis gambar menggunakan Cognitive Services.</p>
					<span class="border-top my-3"></span>
				</div>
				
				<script type="text/javascript">
					$(document).ready(function () {
						var subscriptionKey = "b46a9076d5ab4e539c43ff00d63413c4";
						var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
						
						// Request parameters.
						var params = {
							"visualFeatures": "Categories,Description,Color",
							"details": "",
							"language": "en",
						};
						
						// Display the image.
						var sourceImageUrl = "<?php echo $url ?>";
						document.querySelector("#sourceImage").src = sourceImageUrl;
						
						// Make the REST API call.
						$.ajax({
							url: uriBase + "?" + $.param(params),
							
							// Request headers.
							beforeSend: function(xhrObj){
								xhrObj.setRequestHeader("Content-Type","application/json");
								xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
							},
							type: "POST",
							
							// Request body.
							data: '{"url": ' + '"' + sourceImageUrl + '"}',
						})
							.done(function(data) {
							
							// Show formatted JSON on webpage.
							$("#responseTextArea").val(JSON.stringify(data, null, 2));
							$("#description").text(data.description.captions[0].text);
						})
							.fail(function(jqXHR, textStatus, errorThrown) {
							
							// Display error message.
							var errorString = (errorThrown === "") ? "Error. " :
							errorThrown + " (" + jqXHR.status + "): ";
							errorString += (jqXHR.responseText === "") ? "" :
							jQuery.parseJSON(jqXHR.responseText).message;
							alert(errorString);
						});
					});
				</script>
				<br>
				
				<div id="wrapper" style="width:1020px; display:table;">
					<div id="jsonOutput" style="width:600px; display:table-cell;">
						<b>Response:</b><br><br>
						<textarea id="responseTextArea" class="UIInput"
							  style="width:580px; height:400px;" readonly=""></textarea>
					</div>
					<div id="imageDiv" style="width:420px; display:table-cell;">
						<b>Source Image:</b><br><br>
						<img id="sourceImage" width="400" /><br>
						<h3 id="description">Sedang Memuat Gambar...</h3>
					</div>
				</div>
	</body>
</html>
