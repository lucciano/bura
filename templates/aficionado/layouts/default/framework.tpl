<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
			<title>Aficionado - home page</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta name="description" content="">
			<meta name="author" content="">
			<!-- Le styles -->
			<link href="{=const(BURA_TEMPLATE_PATH)}media/bootstrap/css/bootstrap.css" rel="stylesheet">
			<link href="{=const(BURA_TEMPLATE_PATH)}media/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
			<style type="text/css">
				body {
					padding-top: 40px;
					padding-bottom: 40px;
				}

				.aficionado-content{
					padding:5px;
				}

				/*
				 * Small Bootstrap hack to disable scrolling on widgets
				 */
				.modal-body{
					overflow-y: none !important;
				}
			</style>
			<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
				<!--[if lt IE 9]>
				  <script src="js/html5shiv.js"></script>
				<![endif]-->
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<h1>{WEB_NAME}</h1>
					<h2>{WEB_SLOGAN}</h2>
				</div>
			</div>
			<div class="container">
				<div class="row-fluid">
					<div class="span12 aficionado-content">
						<div class="alert alert-block alert-success fade in">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<h4 class="alert-heading">Hey you!</h4>
							<p>This is the first time you are running Bura, and you still didn't set your package repository.</p>
							<p><a href="#" class="btn btn-success">Choose now</a> <a href="#" class="btn">Admin pannel</a></p>
						</div>

						<h2>Welcome to Bura!</h2>
						<p>This is an example page.</p>
					</div>
				</div>
			</div>
		</div>

			<!-- Le javascript
			================================================== -->
			<!-- Placed at the end of the document so the pages load faster -->
			<script type="text/javascript" src="{=const(BURA_TEMPLATE_PATH)}media/bootstrap/js/jquery.js"></script>
			<script type="text/javascript" src="{=const(BURA_TEMPLATE_PATH)}media/bootstrap/js/bootstrap.js"></script>

	</body>
</html>

