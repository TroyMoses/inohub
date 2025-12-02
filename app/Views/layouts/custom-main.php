<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Inocrate SchoolHub">
		<meta name="Author" content="Inocrate">
		<meta name="Keywords" content="SchoolHub "/>

		<!-- Title -->
		<title> SchoolHub </title>

        <?= $this->include('layouts/components/custom-styles'); ?>

	</head>

	<body class="ltr error-page1 bg-primary">

    	<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url('assets/img/loader.svg'); ?>" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

        <div class="square-box">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
        <div class="page" >
            <?= $this->renderSection('content'); ?>

        </div>

        <?= $this->include('layouts/components/custom-scripts'); ?>

    </body>
</html>