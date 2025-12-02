				<?php 
				  $accessRightsKeys = h_session('access_rights_keys') ? h_session('access_rights_keys') : [];
				?>
				<!-- main-sidebar -->
				<div class="sticky">
					<aside class="app-sidebar">
						<div class="main-sidebar-header active">
							<a class="header-logo active" href="<?php echo base_url('index'); ?>">
								<img src="<?php echo base_url('assets/img/brand/logo.png'); ?>" class="main-logo  desktop-logo" alt="logo">
								<img src="<?php echo base_url('assets/img/brand/logo-white.png'); ?>" class="main-logo  desktop-dark" alt="logo">
								<img src="<?php echo base_url('assets/img/brand/favicon.png'); ?>" class="main-logo  mobile-logo" alt="logo">
								<img src="<?php echo base_url('assets/img/brand/favicon-white.png'); ?>" class="main-logo  mobile-dark" alt="logo">
							</a>
						</div>
						<div class="main-sidemenu">
							<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
							<ul class="side-menu">
								<li class="side-item side-item-category">Dashboard</li>
								<li class="slide">
									<a class="side-menu__item" href="<?php echo base_url('dashboard'); ?>"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/></svg><span class="side-menu__label">Dashboard</span></a>
								</li>

								<?php if(in_array('STUDENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
									<li class="side-item side-item-category">Students</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg><span class="side-menu__label">Students</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Students</a></li>
											
											<?php if(in_array('SEARCH_STUDENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" data-bs-target="#school-search-student" data-bs-toggle="modal" href="">Search Student &nbsp;&nbsp;<span class="badge bg-success">New</span></a></li>
											<?php endif ?>

											<?php if(in_array('ADD_STUDENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item"  href="<?php echo base_url('/Sys/Students/addStudentForm'); ?>">Student Admission</a></li>
											<?php endif ?>

											<?php if(in_array('STUDENT_REPORTING', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" data-bs-target="#school-search-student-reporting-modal" data-bs-toggle="modal" href="">Student Enrollment</a></li>
											<?php endif ?>

											<?php if(in_array('LIST_STUDENTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Students/listStudents'); ?>">List Students &nbsp;&nbsp;<span class="badge bg-success">New</span></a></li>
											<?php endif ?>

											<!-- <?php if(in_array('TRANSFER_STUDENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="">Student Transfer</a></li>
											<?php endif ?> -->
										</ul>
									</li>
								<?php endif ?>

								<!-- users -->
								<?php if(in_array('USERS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="side-item side-item-category">Users</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg><span class="side-menu__label">Users</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Users</a></li>
											<?php if(in_array('ADD_USER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" id="btn-add-new-branch-user" href="">Add User</a></li>
											<?php endif ?>
											<?php if(in_array('LIST_USERS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Users/listUsers'); ?>">List Users</a></li>
											<?php endif ?>
											<?php if(in_array('ADD_USER_GROUP', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" data-bs-target="#user-add-new-user-group" data-bs-toggle="modal" href="">Add User Group</a></li>
											<?php endif ?>
											<?php if(in_array('LIST_USER_GROUPS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Users/listUserGroups'); ?>">List User Group</a></li>
											<?php endif ?>
											<?php if(in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('contacts'); ?>">Add Extra Time</a></li>
												<li><a class="slide-item" href="<?php echo base_url('image-compare'); ?>">User Audit Trail</a></li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>
								
								<!-- staff -->
								<?php if(in_array('STAFF', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="side-item side-item-category">Staff</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20 17V7c0-2.168-3.663-4-8-4S4 4.832 4 7v10c0 2.168 3.663 4 8 4s8-1.832 8-4zM12 5c3.691 0 5.931 1.507 6 1.994C17.931 7.493 15.691 9 12 9S6.069 7.493 6 7.006C6.069 6.507 8.309 5 12 5zM6 9.607C7.479 10.454 9.637 11 12 11s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2V9.607zM6 17v-2.393C7.479 15.454 9.637 16 12 16s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2z"/></svg><span class="side-menu__label">Staff</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Staff</a></li>
											<?php if(in_array('ADD_STAFF', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" id="register-new-staff-href" href="">Add Staff</a></li>
											<?php endif ?>
											<?php if(in_array('LIST_STAFF', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Staff/listStaff'); ?>">List Staff</a></li>
											<?php endif ?>
											<?php if(in_array('ADD_DEPARTMENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" id="register-new-department-href" href="">Add Department</a></li>
											<?php endif ?>
											<?php if(in_array('LIST_DEPARTMENTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Staff/listDepartments'); ?>">List Departments</a></li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>
								
								<!-- s-settings -->
								<?php if(in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
									<li class="side-item side-item-category">S-settings</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 22c4.879 0 9-4.121 9-9s-4.121-9-9-9-9 4.121-9 9 4.121 9 9 9zm0-16c3.794 0 7 3.206 7 7s-3.206 7-7 7-7-3.206-7-7 3.206-7 7-7zm5.284-2.293 1.412-1.416 3.01 3-1.413 1.417zM5.282 2.294 6.7 3.706l-2.99 3-1.417-1.413z"/><path d="M11 9h2v5h-2zm0 6h2v2h-2z"/></svg><span class="side-menu__label">S-settings</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">S-settings</a></li>
											<li class="sub-slide">
												<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Schools</span><i class="sub-angle fe fe-chevron-right"></i></a>
												<ul class="sub-slide-menu">
													<li><a class="sub-side-menu__item" data-bs-target="#register-new-school" data-bs-toggle="modal" href="">Register School</a></li>
													<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Schools/activeSchools'); ?>">Active Schools</a></li>
												</ul>
											</li>
											<li class="sub-slide">
												<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Licensing</span><i class="sub-angle fe fe-chevron-right"></i></a>
												<ul class="sub-slide-menu">
													<li><a class="sub-side-menu__item" href="">View All Licenses</a></li>
													<li><a class="sub-side-menu__item" href="">Due Licenses</a></li>
													<li><a class="sub-side-menu__item" href="">Expired Licenses</a></li>
												</ul>
											</li>
											<li class="sub-slide">
												<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Manage Users</span><i class="sub-angle fe fe-chevron-right"></i></a>
												<ul class="sub-slide-menu">
													<li><a class="sub-side-menu__item" href="">List System Users</a></li>
													<li><a class="sub-side-menu__item" href="">Notify All Users</a></li>
													<li><a class="sub-side-menu__item" href="">Logout All Users</a></li>
													<li><a class="sub-side-menu__item" href="">Destroy Old Sessions</a></li>
												</ul>
											</li>
										</ul>
									</li>
								<?php endif ?>
								
								<!-- Academics -->
								<?php if(in_array('ACADEMICS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="side-item side-item-category">Academics</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M22 7.999a1 1 0 0 0-.516-.874l-9.022-5a1.003 1.003 0 0 0-.968 0l-8.978 4.96a1 1 0 0 0-.003 1.748l9.022 5.04a.995.995 0 0 0 .973.001l8.978-5A1 1 0 0 0 22 7.999zm-9.977 3.855L5.06 7.965l6.917-3.822 6.964 3.859-6.918 3.852z"/><path d="M20.515 11.126 12 15.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/><path d="M20.515 15.126 12 19.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/></svg><span class="side-menu__label">Academics</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Academics</a></li>
											<?php if( in_array('MARK_SHEETS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/termClassMarksheet'); ?>">Mark Sheets</a></li>
											<?php endif ?>
											<?php if(in_array('STREAM_STUDENTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/listClassStreamStudents'); ?>">Stream Students</a></li>
											<?php endif ?>
											<?php if(in_array('TERM_CLASSES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/listTermClasses'); ?>">Term Classes</a></li>
											<?php endif ?>
											<?php if(in_array('TERM_SUBJECTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/listTermSubjects'); ?>">Term Subjects</a></li>
											<?php endif ?>
											<?php if(in_array('STUDENT_SUBJECTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/listStudentSubjects'); ?>">Student Subjects</a></li>
											<?php endif ?>
											<?php if(in_array('TERM_EXAMINATIONS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/listTermExaminations'); ?>">Term Exams</a></li>
											<?php endif ?>
											<?php if(in_array('ACADEMICS_OTHER_SETTINGS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Academics/listTermOtherSettings'); ?>">Other Settings</a></li>
											<?php endif ?>
											<?php if(in_array('REPORT_CARDS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?> 
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Report Cards</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('SINGLE_REPORT_CARD', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?> 
															<li><a class="sub-side-menu__item"  href="<?php echo base_url('/Sys/Academics/generateSingleStudentReportCard'); ?>">One Report Card</a></li>
														<?php endif ?>
														<?php if(in_array('CLASS_REPORT_CARDS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?> 
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Academics/generateClassReportCard'); ?>">Class Report Cards</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>
								
								<!-- academics settings -->
								<?php if(in_array('ACADEMIC_SETTINGS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
									<li class="side-item side-item-category">Academics Settings</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M22 7.999a1 1 0 0 0-.516-.874l-9.022-5a1.003 1.003 0 0 0-.968 0l-8.978 4.96a1 1 0 0 0-.003 1.748l9.022 5.04a.995.995 0 0 0 .973.001l8.978-5A1 1 0 0 0 22 7.999zm-9.977 3.855L5.06 7.965l6.917-3.822 6.964 3.859-6.918 3.852z"/><path d="M20.515 11.126 12 15.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/><path d="M20.515 15.126 12 19.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/></svg><span class="side-menu__label">Academics Settings</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Academics Settings</a></li>
											<?php if(in_array('ACADEMIC_YEARS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Acad Years</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('ADD_ACADEMIC_YEAR', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#add-new-academic-year" data-bs-toggle="modal" href="">Register Years</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_ACADEMIC_YEARS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listAcademicYears'); ?>">List Years</a></li>
														<?php endif ?>
														<?php if(in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
															<li><a class="sub-side-menu__item" href="">Import Settings</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>

											<?php if(in_array('ACADEMIC_YEAR_TERMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Acad Terms</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('ADD_ACADEMIC_YEAR_TERM', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="register-new-term-href" href="">Register Term</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_ACADEMIC_YEAR_TERMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listAcademicYearTerms'); ?>">List Terms</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('CLASSES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Classes</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('ADD_CLASS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#add-new-school-class" data-bs-toggle="modal" href="">Register Class</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_CLASSES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listSchoolClasses'); ?>">List Class</a></li>
														<?php endif ?>
														<?php if(in_array('ADD_STREAM', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="add-new-class-stream-href" href="">Add Stream</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_STREAMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listClassStreams'); ?>">List Streams</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('SUBJECTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Subjects</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('ADD_SUBJECT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#add-new-academic-subject" data-bs-toggle="modal" href="">Register Subject</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_SUBJECTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listSubjects'); ?>">List Subjects</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>

											<?php if(in_array('GRADING', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Grading</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('ADD_GRADING', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="register-new-classes-grades-href" href="">Register Grade</a></li> 
														<?php endif ?>
														<?php if(in_array('LIST_GRADINGS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listClassGrades'); ?>">List Grades</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											<?php if( in_array('MANAGE_EXAMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Exams</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if( in_array('REGISTER_EXAMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#add-new-academic-exam-modal" data-bs-toggle="modal" href="">Register Exam</a></li> 
														<?php endif ?>
														<?php if( in_array('LIST_EXAMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/AcademicSettings/listExaminations'); ?>">List Exams</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											<?php if( in_array('REPORT_CARDS_TEMPLATE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/AcademicSettings/listReportCardsTemplates'); ?>">Report Card Temp</a></li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>

								<!-- payments -->
								<?php if(in_array('FEES_PAYMENTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
									<li class="side-item side-item-category">Fees Payments</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M22 7.999a1 1 0 0 0-.516-.874l-9.022-5a1.003 1.003 0 0 0-.968 0l-8.978 4.96a1 1 0 0 0-.003 1.748l9.022 5.04a.995.995 0 0 0 .973.001l8.978-5A1 1 0 0 0 22 7.999zm-9.977 3.855L5.06 7.965l6.917-3.822 6.964 3.859-6.918 3.852z"/><path d="M20.515 11.126 12 15.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/><path d="M20.515 15.126 12 19.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/></svg><span class="side-menu__label">Fees Payments</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Fees Payments</a></li>
											<?php if(in_array('ADD_FEES_PAYMENT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" data-bs-target="#school-pay-fees-search-student" data-bs-toggle="modal" href="">Add Fees Payment</a></li>
											<?php endif ?>
											<?php if(in_array('FEES_LEDGER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/FeesPayment/listFeesPaymentsLedger'); ?>">Fees Ledger</a></li>
											<?php endif ?>
											<?php if(in_array('FEES_STRUCTURE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/FeesPayment/listFeesStructure'); ?>">Fees Structure</a></li> 
											<?php endif ?>
											<?php if(in_array('FEES_BURSARIES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Bursaries</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if( in_array('ADD_BURSARY', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="add-new-bursary-href" href="">Add Bursary</a></li>
														<?php endif ?>
														<?php if( in_array('LIST_BURSARIES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/FeesPayment/listBursaries'); ?>">List Bursaries</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											<?php if(in_array('FEES_REMINDERS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" href="">Fees Reminders</a></li>
											<?php endif ?>
											<?php if( in_array('FEES_TYPES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Fees Types</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if( in_array('ADD_FEES_TYPES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="add-new-fees-type-href" href="">Add Fees Type</a></li>
														<?php endif ?>
														<?php if( in_array('LIST_FEES_TYPES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/FeesPayment/listFeesTypes'); ?>">List Fees Types</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>
								<!-- reports -->
								<?php if(in_array('REPORTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="side-item side-item-category">Reports</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M22 7.999a1 1 0 0 0-.516-.874l-9.022-5a1.003 1.003 0 0 0-.968 0l-8.978 4.96a1 1 0 0 0-.003 1.748l9.022 5.04a.995.995 0 0 0 .973.001l8.978-5A1 1 0 0 0 22 7.999zm-9.977 3.855L5.06 7.965l6.917-3.822 6.964 3.859-6.918 3.852z"/><path d="M20.515 11.126 12 15.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/><path d="M20.515 15.126 12 19.856l-8.515-4.73-.971 1.748 9 5a1 1 0 0 0 .971 0l9-5-.97-1.748z"/></svg><span class="side-menu__label">Reports</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Reports</a></li>
											<?php if( in_array('FINANCIAL_REPORTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Financials</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if( in_array('TRIAL_BALANCE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Reports/FinancialStatements/generalTrialBalance'); ?>">Trail Balance</a></li>
														<?php endif ?>
														<?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Reports/FinancialStatements/balanceSheet'); ?>">Balance Sheet</a></li> 
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Reports/FinancialStatements/incomeStatement'); ?>">Income Statement</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											<?php if( in_array('STUDENT_REPORTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Students</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Reports/listStudentsEnrollment'); ?>">Enrollment</a></li>
														<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Reports/listBoardingStudents'); ?>">Boarding Students</a></li>
													</ul>
												</li>
											<?php endif ?>
											<?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Consolidated</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<li><a class="sub-side-menu__item" href="">Trail Balance</a></li>
														<li><a class="sub-side-menu__item" href="">Balance Sheet</a></li>
														<li><a class="sub-side-menu__item" href="">Income Statement</a></li>
													</ul>
												</li>
											<?php endif ?>

											<?php if(in_array('TEACHERS_REPORT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Reports/listTeachers'); ?>">Teachers &nbsp;&nbsp;<span class="badge bg-success">New</span></a></li>
											<?php endif ?>

											<?php if(in_array('FEES_REPORT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Reports/listFees'); ?>">Fees Collection &nbsp;&nbsp;<span class="badge bg-success">New</span></a></li>
											<?php endif ?>

										</ul>
									</li>
								<?php endif ?>

								<!-- ledgers -->
								<?php if(in_array('LEDGER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="side-item side-item-category">Ledgers</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 22c4.879 0 9-4.121 9-9s-4.121-9-9-9-9 4.121-9 9 4.121 9 9 9zm0-16c3.794 0 7 3.206 7 7s-3.206 7-7 7-7-3.206-7-7 3.206-7 7-7zm5.284-2.293 1.412-1.416 3.01 3-1.413 1.417zM5.282 2.294 6.7 3.706l-2.99 3-1.417-1.413z"/><path d="M11 9h2v5h-2zm0 6h2v2h-2z"/></svg><span class="side-menu__label">Ledgers</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Ledgers</a></li>
											<?php if(in_array('INCOME', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Income</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_INCOME', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="ledger-income-reg-href" href="">Register Income</a></li>
														<?php endif ?>
														<?php if(in_array('VIEW_INCOME_LEDGER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Accounting/Ledgers/listIncomes'); ?>">View Ledger</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>

											<?php if(in_array('EXPENSE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Expenses</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_EXPENSE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="ledger-expense-reg-href" href="">Register Expense</a></li> 
														<?php endif ?>
														<?php if(in_array('VIEW_EXPENSE_LEDGER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Accounting/Ledgers/listExpenses'); ?>">View Ledger</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('LIABILITY', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Liabilities</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_LIABILITY', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="ledger-liability-reg-href" href="">Register Liability</a></li>
														<?php endif ?>
														<?php if(in_array('VIEW_LIABILITY_LEDGER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Accounting/Ledgers/listLiabilities'); ?>">View Ledger</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('ASSETS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Assets</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_ASSET', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="ledger-assets-reg-href" href="">Register Asset</a></li> 
														<?php endif ?>
														<?php if(in_array('VIEW_ASSETS_LEDGER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Accounting/Ledgers/listAssets'); ?>">View Ledger</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Payable</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<li><a class="sub-side-menu__item" href="">Register Payable</a></li>
														<li><a class="sub-side-menu__item" href="">Register Creditors</a></li>
														<li><a class="sub-side-menu__item" href="">View Ledger</a></li>
													</ul>
												</li>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Receivables</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<li><a class="sub-side-menu__item" href="">Register Receivable</a></li>
														<li><a class="sub-side-menu__item" href="">Register Debtors</a></li>
														<li><a class="sub-side-menu__item" href="">View Ledger</a></li>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('LIST_TRANSACTIONS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Accounting/Ledgers/listTransactions'); ?>">List Transactions</a></li>
											<?php endif ?>
											<?php if(in_array('COA', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Accounting/Ledgers/listCoa'); ?>">View COA</a></li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>

								<!-- treasury -->
								<?php if(in_array('TREASURY', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="side-item side-item-category">Treasury</li>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 22c4.879 0 9-4.121 9-9s-4.121-9-9-9-9 4.121-9 9 4.121 9 9 9zm0-16c3.794 0 7 3.206 7 7s-3.206 7-7 7-7-3.206-7-7 3.206-7 7-7zm5.284-2.293 1.412-1.416 3.01 3-1.413 1.417zM5.282 2.294 6.7 3.706l-2.99 3-1.417-1.413z"/><path d="M11 9h2v5h-2zm0 6h2v2h-2z"/></svg><span class="side-menu__label">Treasury</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Treasury</a></li>
											<?php if(in_array('BANK_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Bank Accounts</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_BANK_ACCOUNT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#treasury-bank-add-modal" data-bs-toggle="modal" href="">Register Account</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_BANK_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Treasury/listBankAccounts'); ?>">List Accounts</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('CASH_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Cash Accounts</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_CASH_ACCOUNT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" id="register-new-cash-acct-href" href="">Register Account</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_CASH_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Treasury/listCashAccounts'); ?>">List Accounts</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('SAFE_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Safe Accounts</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_SAFE_ACCOUNT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#treasury-safe-account-add" data-bs-toggle="modal" href="">Register Account</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_SAFE_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Treasury/listSafeAccounts'); ?>">List Accounts</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>

										    <?php if(in_array('MOBILE_MONEY_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">MM Accounts</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_MM_ACCOUNT', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#treasury-mm-account-add" data-bs-toggle="modal" href="">Register Account</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_MM_ACCOUNTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Treasury/listMMAccounts'); ?>">List Accounts</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('ACCOUNT_TYPES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Account Types</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<?php if(in_array('REGISTER_ACCOUNT_TYPE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" data-bs-target="#student-account--type-add" data-bs-toggle="modal" href="">Register Type</a></li>
														<?php endif ?>
														<?php if(in_array('LIST_ACCOUNT_TYPES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
															<li><a class="sub-side-menu__item" href="<?php echo base_url('/Sys/Treasury/listAccountTypes'); ?>">List Types</a></li>
														<?php endif ?>
													</ul>
												</li>
											<?php endif ?>
											
											<?php if(in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('chart-flot'); ?>">Till Sheet</a></li>
												<li class="sub-slide">
													<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Cash Trasfer</span><i class="sub-angle fe fe-chevron-right"></i></a>
													<ul class="sub-slide-menu">
														<li><a class="sub-side-menu__item" href="">Cash to Bank</a></li>
														<li><a class="sub-side-menu__item" href="">Bank to Cash</a></li>
														<li><a class="sub-side-menu__item" href="">MM to Cash</a></li>
														<li><a class="sub-side-menu__item" href="">Cash to MM</a></li>
														<li><a class="sub-side-menu__item" href="">Bank to Bank</a></li>
														<li><a class="sub-side-menu__item" href="">MM to MM</a></li>
														<!-- <li><a class="sub-side-menu__item" href="">Branch to Branch</a></li> -->
													</ul>
												</li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>
								
								<?php if(in_array('SETTINGS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20.995 6.9a.998.998 0 0 0-.548-.795l-8-4a1 1 0 0 0-.895 0l-8 4a1.002 1.002 0 0 0-.547.795c-.011.107-.961 10.767 8.589 15.014a.987.987 0 0 0 .812 0c9.55-4.247 8.6-14.906 8.589-15.014zM12 19.897C5.231 16.625 4.911 9.642 4.966 7.635L12 4.118l7.029 3.515c.037 1.989-.328 9.018-7.029 12.264z"/><path d="m11 12.586-2.293-2.293-1.414 1.414L11 15.414l5.707-5.707-1.414-1.414z"/></svg><span class="side-menu__label">Settings</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Settings</a></li>
											<?php if(in_array('ORGANISATION_SETTINGS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" data-id="<?= esc(h_session('school_id')); ?>" id="view-school-profile-href" href="">Organisation Settings</a></li>
											<?php endif ?>
											<?php if(in_array('SET_UP_NEW_BRANCH', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" data-bs-target="#register-new-branch" data-bs-toggle="modal" href="">Set up new Branch</a></li>
											<?php endif ?>
											<?php if(in_array('LIST_BRANCHES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Schools/listBranches'); ?>">List Branches</a></li>
											<?php endif ?>
											<?php if(in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" href="">Working Hours</a></li>
												<li><a class="slide-item" href="">Subscription Licensing</a></li>
											<?php endif ?>
											<?php if(in_array('OTHER_SETTINGS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys )): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/Settings/otherSettings'); ?>">Other Settings</a></li>
											<?php endif ?>
										</ul> 
									</li>
								<?php endif ?>
								<?php if(in_array('EX_SERVICES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20.995 6.9a.998.998 0 0 0-.548-.795l-8-4a1 1 0 0 0-.895 0l-8 4a1.002 1.002 0 0 0-.547.795c-.011.107-.961 10.767 8.589 15.014a.987.987 0 0 0 .812 0c9.55-4.247 8.6-14.906 8.589-15.014zM12 19.897C5.231 16.625 4.911 9.642 4.966 7.635L12 4.118l7.029 3.515c.037 1.989-.328 9.018-7.029 12.264z"/><path d="m11 12.586-2.293-2.293-1.414 1.414L11 15.414l5.707-5.707-1.414-1.414z"/></svg><span class="side-menu__label">Ex-Services</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Ex-Services</a></li>
											<?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="">Inter Branch Connectivity</a></li>
											<?php endif ?>
											<li><a class="slide-item" href="<?php echo base_url('/Sys/ExServices/dataImporter'); ?>">Data Importer</a></li>
											<?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="">Data Reserves</a></li>
											<?php endif ?>
										</ul>
									</li>
								<?php endif ?>
								<?php if(in_array('MESSAGE_CENTER', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
									<li class="slide">
										<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M20.995 6.9a.998.998 0 0 0-.548-.795l-8-4a1 1 0 0 0-.895 0l-8 4a1.002 1.002 0 0 0-.547.795c-.011.107-.961 10.767 8.589 15.014a.987.987 0 0 0 .812 0c9.55-4.247 8.6-14.906 8.589-15.014zM12 19.897C5.231 16.625 4.911 9.642 4.966 7.635L12 4.118l7.029 3.515c.037 1.989-.328 9.018-7.029 12.264z"/><path d="m11 12.586-2.293-2.293-1.414 1.414L11 15.414l5.707-5.707-1.414-1.414z"/></svg><span class="side-menu__label">Message Center</span><i class="angle fe fe-chevron-right"></i></a>
										<ul class="slide-menu">
											<li class="side-menu__label1"><a href="javascript:void(0);">Message Center</a></li>
											<?php if(in_array('MESSAGE_CENTER_SMS_PURCHASE', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" id="view-sms-purchase-href" href="">SMS Purchase</a></li>
											<?php endif ?>
											<?php if(in_array('MESSAGE_CENTER_OUTBOX', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/MessageCenter/listOutBoxMessages'); ?>">OutBox</a></li>
											<?php endif ?>
											<?php if(in_array('MESSAGE_CENTER_SENDSMS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" id="register-new-sms-message-btn" data-bs-target="#register-new-sms-message-modal" data-bs-toggle="modal" href="">Send SMS</a></li>
											<?php endif ?>
											<?php if(in_array('MESSAGE_CENTER_SMSTYPES', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/MessageCenter/listSMSTypes'); ?>">SMS Types</a></li>
											<?php endif ?>
											<?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
												<li><a class="slide-item" href="<?php echo base_url('/Sys/MessageCenter/listSMSRequests'); ?>">SMS Requests</a></li>
											<?php endif ?>
										</ul>
									</li> 
								<?php endif ?>
							</ul>
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
						</div>
					</aside>
				</div>
				<!-- main-sidebar -->
				<input id="general-app-current-page" type="hidden" value="<?php echo h_session('current_page') ? h_session('current_page') :'' ?>">
				<input id="general-app-organisation-page" type="hidden" value="<?php echo h_session('school_name') ? h_session('school_name') :'' ?>">

				<!-- load add school modal -->
				<?= view('user_pages/modals') ?>
				
				<?= view('user_pages/number-display') ?>
				