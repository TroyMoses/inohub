<?= $this->extend('layouts/custom-main'); ?>

    <?= $this->section('custom-styles'); ?>

    <?= $this->endSection('custom-styles'); ?>

    <?= $this->section('content'); ?>

	        <div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
							<div class="card-sigin">
								 <!-- Demo content-->
								 <div class="main-card-signin d-md-flex">
									 <div class="wd-100p"><div class="d-flex mb-4"><a href="<?php echo base_url('index'); ?>"><img src="<?php echo base_url('assets/img/brand/logo.png'); ?>" class="sign-favicon ht-70" alt="logo"></a></div>
										 <div class="">
											<div class="main-signup-header">
												<h2>Schoolhub MIS!</h2>
												<h6 class="font-weight-semibold mb-4">Please login in to continue.</h6>

												<?php 
												  $username ='';
												  $session = \Config\Services::session();
												  $message = $session->getFlashdata('login_error') ? '<div class="alert alert-danger alert-dismissible fade show" role="alert">
													<strong>Sorry!</strong> '. $session->getFlashdata('login_error') .'
													<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
											  		</div>':'';
													
												   $username = $session->getFlashdata('username')? $session->getFlashdata('username') :'';
												   
													echo $message;
												?>
												<div class="panel panel-primary">
													<form action="<?=base_url();?>serviceAuth/login" role="login" id="form-login" method="POST" >
														<div class="form-group">
															<label>Username</label> <input class="form-control" value="<?php echo $username ?>" name="username" placeholder="Enter your Username"  autocomplete="off"  type="text" required autofocus="true">
														</div>
														<div class="form-group">
															<label>Password</label> <input class="form-control" name="password" placeholder="Enter your password" type="password"  autocomplete="off" required>
														</div>
														<button type="submit" class="btn btn-primary btn-block">Login</button>
													</form>
											   </div>

												<div class="main-signin-footer text-center mt-3">
													<p><a href="<?php echo base_url('/serviceAuth/forgot'); ?>" class="mb-3">Forgot password?</a></p>
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






		

			
		



