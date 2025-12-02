<?= $this->extend('layouts/custom-main'); ?>

    <?= $this->section('custom-styles'); ?>

    <?= $this->endSection('custom-styles'); ?>

    <?= $this->section('content'); ?>

            <div class="cover-image" data-image-src="<?php echo base_url('assets/img/backgrounds/1.jpg'); ?>">
			<div class="page">
				<div class="page-single">
					<div class="container">
						<div class="row">
							<div class="col mx-auto">
								<div class="row py-4 justify-content-center">
									 <div class="col-xl-5 card-sigin-main ">
									   <div class="card-sigin">
											<div class="">
												<div>
													<h2 class="tx-30 text-center">Under Maintenance</h2>
													<p class="tx-12 text-muted text-center">Our website is currently undergoing scheduled maintenance. We Should be back shortly. Thank you for your patience!</p>
													<div class="row row-sm mx-auto">
														<div id="count-down" class="center-block mt-3 mb-3 mx-auto">
															<div class="clock-presenter days_dash">
																<div class="digit"></div>
																<div class="digit"></div>
																<p class="mt-2">Days</p>
															</div>
															<div class="clock-presenter hours_dash">
																<div class="digit"></div>
																<div class="digit"></div>
																<p class="mt-2">Hours</p>
															</div>
															<div class="clock-presenter minutes_dash">
																<div class="digit"></div>
																<div class="digit"></div>
																<p class="mt-2">Minutes</p>
															</div>
															<div class="clock-presenter seconds_dash">
																<div class="digit"></div>
																<div class="digit"></div>
																<p class="mt-2">Seconds</p>
															</div>
														</div>
													</div>
													<div class="input-group mt-5 text-center sub-input mt-1 ms-auto me-auto mt-6">
														<input type="text" class="form-control input-lg " placeholder="Enter your Email">
														<div class="input-group-append ">
															<button type="button" class="btn Sub  btn-primary btn-lg bd-te-3  bd-be-3">
																Subscribe
															</button>
														</div>
													</div>
													<div class="mt-4 d-flex text-center justify-content-center">
														<button class="btn btn-icon btn-facebook me-3" type="button">
															<span class="btn-inner--icon"> <i class="bx bxl-facebook tx-18 tx-prime"></i> </span>
														</button>
														<button class="btn btn-icon me-3" type="button">
															<span class="btn-inner--icon"> <i class="bx bxl-twitter tx-18 tx-prime"></i> </span>
														</button>
														<button class="btn btn-icon me-3" type="button">
															<span class="btn-inner--icon"> <i class="bx bxl-linkedin tx-18 tx-prime"></i> </span>
														</button>
														<button class="btn  btn-icon me-3" type="button">
															<span class="btn-inner--icon"> <i class="bx bxl-instagram tx-18 tx-prime"></i> </span>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
		</div>

    <?= $this->endSection('custom-content'); ?>

    <?= $this->section('custom-scripts'); ?>

	    <!--- JQuery sparkline js --->
		<script src="<?php echo base_url('assets/plugins/jquery-sparkline/jquery.sparkline.min.js'); ?>"></script>
		
		<!--- Jquery.Coutdown js --->
		<script src="<?php echo base_url('assets/plugins/jquery-countdown/jquery.lwtCountdown-1.0.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery-countdown/count-down.js'); ?>"></script>

    <?= $this->endSection('custom-scripts'); ?>
	
		
		
		

	