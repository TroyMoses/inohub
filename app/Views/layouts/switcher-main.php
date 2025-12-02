<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Inocrate SchoolHub">
		<meta name="Author" content="Inocrate">
		<meta name="Keywords" content="SchoolHub"/>

		<!-- Title -->
		<title> SchoolHub </title>

        <?= $this->include('layouts/components/switcher-styles'); ?>

		<!-- load components/page css -->
		<?= $this->include('layouts/components/app-styles'); ?>

	</head>

	<body class="ltr main-body app sidebar-mini">

		<!-- add switcher side bar -->
		<?= $this->include('layouts/components/switcher'); ?>

    	<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url('assets/img/loader.svg'); ?>" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

        <!-- Page -->
		<div class="page">

            <div>

            <?= $this->include('layouts/components/app-header-switcher'); ?>

            <?= $this->include('layouts/components/app-sidebar'); ?>

            </div>
			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

					<?= $this->include('layouts/components/bread-crum-header'); ?>

                    <?= $this->renderSection('content'); ?>

					<!-- add shortcuts -->
					<?= $this->include('layouts/components/app-shortcuts'); ?>

                </div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

            <?= $this->include('layouts/components/sidebar-right'); ?>

           
            <?= $this->include('layouts/components/modal'); ?>
            

            <?= $this->include('layouts/components/footer'); ?>

		</div>
		<!-- End Page -->

		<?= $this->include('layouts/components/switcher-scripts'); ?>

		<!-- load components/pages JS -->
		<?= $this->include('layouts/components/app-scripts'); ?>
		
	</body>
</html>