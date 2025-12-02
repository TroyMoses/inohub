<?= $this->extend('layouts/custom-main'); ?>

    <?= $this->section('custom-styles'); ?>

    <?= $this->endSection('custom-styles'); ?>

    <?= $this->section('content'); ?>

	        <div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
							<div class="card-sigin">
								 <!-- Demo content-->
								 <div class="main-card-signin d-md-flex">
									 <div class="wd-100p"><div class="d-flex mb-4"><a href="<?php echo base_url('index'); ?>"><img src="<?php echo base_url('assets/img/brand/favicon.png'); ?>" class="sign-favicon ht-40" alt="logo"></a></div>
										 <div class="">
											<div class="main-signup-header">
												<h2>Welcome back!</h2>
												<h6 class="font-weight-semibold mb-4">Please sign in to continue.</h6>
												<div class="panel panel-primary">
												   <div class=" tab-menu-heading mb-2 border-bottom-0">
													   <div class="tabs-menu1">
														   <ul class="nav panel-tabs">
															   <li class="me-2"><a href="#tab5" class="active" data-bs-toggle="tab">Email</a></li>
															   <li><a href="#tab6" data-bs-toggle="tab" class="">Mobile no</a></li>
														   </ul>
													   </div>
												   </div>
												   <div class="panel-body tabs-menu-body border-0 p-3">
													   <div class="tab-content">
														   <div class="tab-pane active" id="tab5">
															   <form action="#">
																   <div class="form-group">
																	   <label>Email</label> <input class="form-control" placeholder="Enter your email" type="text">
																   </div>
																   <div class="form-group">
																	   <label>Password</label> <input class="form-control" placeholder="Enter your password" type="password">
																   </div><button class="btn btn-primary btn-block">Sign In</button>
																</form>
														   </div>
														   <div class="tab-pane" id="tab6">
															   <div id="mobile-num" class="wrap-input100 validate-input input-group mb-2">
																   <a href="javascript:void(0);" class="input-group-text bg-white text-muted">
																	   <span>+256</span>
																   </a>
																   <input class="input100 form-control" type="mobile" placeholder="Mobile">
															   </div>
															   <div id="login-otp" class="justify-content-around mb-4">
																   <input class="form-control  text-center me-2" id="txt1" maxlength="1" onkeyup="move(event, '', 'txt1', 'txt2')">
																   <input class="form-control  text-center me-2" id="txt2" maxlength="1" onkeyup="move(event, 'txt1', 'txt2', 'txt3')">
																   <input class="form-control  text-center me-2" id="txt3" maxlength="1" onkeyup="move(event, 'txt2', 'txt3', 'txt4')">
																   <input class="form-control  text-center" id="txt4" maxlength="1" onkeyup="move(event, 'txt3', 'txt4', '')">
															   </div>
															   <span>Note : Login with registered mobile number to generate OTP.</span>
															   <div class="container-login100-form-btn mt-3">
																   <button class="btn btn-primary btn-block" id="generate-otp">Proceed</button>
															   </div>
														   </div>
													   </div>
												   </div>
											   </div>

												<div class="main-signin-footer text-center mt-3">
													<p><a href="<?php echo base_url('forgot'); ?>" class="mb-3">Forgot password?</a></p>
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

	    <!-- generate-otp js -->
		<script src="<?php echo base_url('assets/js/generate-otp.js'); ?>"></script>

    <?= $this->endSection('custom-scripts'); ?>






		

			
		



