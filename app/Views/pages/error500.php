<?= $this->extend('layouts/custom-main'); ?>

    <?= $this->section('custom-styles'); ?>

    <?= $this->endSection('custom-styles'); ?>

    <?= $this->section('content'); ?>

			
				<!-- Main-error-wrapper -->
				<div class="main-error-wrapper page page-h">
					<h1 class="text-white">500<span class="tx-20">error</span></h1>
					<h2 class="text-white">Oopps. The page you were looking for doesn't exist.</h2>
					<h6 class="tx-white-6">You may have mistyped the address or the page may have moved.</h6><a class="btn btn-light" href="<?php echo base_url('index'); ?>">Back to Home</a>
				</div>
				<!-- /Main-error-wrapper -->

    <?= $this->endSection('custom-content'); ?>

    <?= $this->section('custom-scripts'); ?>

    <?= $this->endSection('custom-scripts'); ?>
				
		