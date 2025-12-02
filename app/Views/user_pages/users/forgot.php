<?= $this->extend('layouts/custom-main'); ?>

    <?= $this->section('custom-styles'); ?>

    <?= $this->endSection('custom-styles'); ?>

    <?= $this->section('content'); ?>

	<div class="page">
		<div class="page-single">
			<div class="container">
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 col-xs-10 card-sigin-main py-4 justify-content-center mx-auto">
						<div class="card-sigin">
								<!-- Demo content-->
								<div class="main-card-signin d-md-flex">
									<div class="wd-100p">
										<div class="mb-3 d-flex"> <a href="<?php echo base_url('index'); ?>"><img src="<?php echo base_url('assets/img/brand/logo.png'); ?>" class="sign-favicon ht-70" alt="logo"></a></div>
											<div class="main-card-signin d-md-flex bg-white">
												<div class="wd-100p">
													<div class="main-signin-header">
														<h2>Forgot Password!</h2>
														<h4>Please Enter Your Phone</h4>
														<form action="#">
															<div class="form-group">
																<label>Phone</label> <input class="form-control" placeholder="Enter your Phone" type="text">
															</div>
															<button class="btn btn-primary btn-block">Send</button>
														</form>
													</div>
													<div class="main-signup-footer mg-t-20 text-center">
														<p>Forget it, <a href="<?php echo base_url('/serviceAuth/login'); ?>"> Send me back</a> to the sign in screen.</p>
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

    <?= $this->endSection('custom-scripts'); ?>
		
