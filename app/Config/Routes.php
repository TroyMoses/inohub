<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/dashboard', 'user_controllers\users\Login::client_dashboard');
$routes->post('/serviceAuth/login', 'user_controllers\users\Login::processLogin');
$routes->get('/serviceAuth/login', 'user_controllers\users\Login::processLogin');

$routes->get('/serviceAuth/logout', 'user_controllers\users\Login::processLogout');
$routes->post('/serviceAuth/logout', 'user_controllers\users\Login::processLogout');
$routes->post('/serviceAuth/switchBranch', 'user_controllers\users\Login::processSwitchBranch');
$routes->get('/serviceAuth/forgot', 'user_controllers\users\Login::forgot');

// schools 
$routes->get('/Sys/Schools/activeSchools', 'user_controllers\schools\SchoolSetup::activeApprovedSchools');
$routes->post('/Sys/Schools/submitNewSchoolForm', 'user_controllers\schools\SchoolSetup::submitNewSchoolForm');
$routes->get('/Sys/Schools/listBranches', 'user_controllers\schools\SchoolSetup::schoolBranches');
$routes->post('/Sys/Schools/submitNewBranchForm', 'user_controllers\schools\SchoolSetup::submitNewBranchForm');
$routes->post('/Sys/Schools/editBranchView', 'user_controllers\schools\SchoolSetup::editBranchView');
$routes->post('/Sys/Schools/updateBranch', 'user_controllers\schools\SchoolSetup::updateBranch');
$routes->get('/Sys/Schools/getHeaderFooter', 'user_controllers\schools\SchoolSetup::getHeaderFooter');
$routes->post('/Sys/Schools/viewSchoolInformation', 'user_controllers\schools\SchoolSetup::viewSchoolInfo');
$routes->post('/Sys/Schools/submitSchoolComponents', 'user_controllers\schools\SchoolSetup::submitSchoolComponents');
$routes->post('/Sys/Schools/submitGeneralSchoolSettingsForm', 'user_controllers\schools\SchoolSetup::submitGeneralSchoolSettings');

// staff
$routes->get('/Sys/Staff/listStaff', 'user_controllers\staff\ManageStaff::index');
$routes->post('/Sys/Staff/listStaff', 'user_controllers\staff\ManageStaff::index');
$routes->post('/Sys/Staff/submitNewStaffForm', 'user_controllers\staff\ManageStaff::submitNewStaffForm');
$routes->post('/Sys/Staff/submitNewDepartmentForm', 'user_controllers\staff\ManageStaff::submitNewDepartmentForm');
$routes->get('/Sys/Staff/submitNewDepartmentForm', 'user_controllers\staff\ManageStaff::submitNewDepartmentForm');
$routes->get('/Sys/Staff/listDepartments', 'user_controllers\staff\ManageStaff::listDepartments');
$routes->post('/Sys/Staff/editStaffView', 'user_controllers\staff\ManageStaff::editStaffView');
$routes->post('/Sys/Staff/editDepartmentView', 'user_controllers\staff\ManageStaff::editDepartmentView');
$routes->post('/Sys/Staff/submitEditStaffForm', 'user_controllers\staff\ManageStaff::submitEditStaffForm');
$routes->post('/Sys/Staff/submitEditDepartmentForm', 'user_controllers\staff\ManageStaff::submitEditDepartmentForm');

// users  
$routes->get('/Sys/Users/listUsers', 'user_controllers\users\ManageUsers::index');
$routes->post('/Sys/Users/submitNewUserForm', 'user_controllers\users\ManageUsers::submitNewUserForm');
$routes->post('/Sys/Users/submitEditUserAccountForm', 'user_controllers\users\ManageUsers::submitEditUserAccountForm');
$routes->get('/Sys/Users/listUserGroups', 'user_controllers\users\ManageUsers::listUserGroups');
$routes->post('/Sys/Users/submitNewUserGroupForm', 'user_controllers\users\ManageUsers::submitNewUserGroupForm');
$routes->post('Sys/Users/updateUserGroup', 'user_controllers\users\ManageUsers::updateUserGroup');
$routes->get('/Sys/Users/listUserGroupComponents', 'user_controllers\users\ManageUsers::listUserGroupComponents');
$routes->post('/Sys/Users/submitUserGroupComponents', 'user_controllers\users\ManageUsers::submitUserGroupComponents');
$routes->post('/Sys/Users/editUserAccountView', 'user_controllers\users\ManageUsers::editUserAccountView');
$routes->post('/Sys/Users/submitEditUserForm', 'user_controllers\users\ManageUsers::submitEditUserForm');


// students
$routes->get('/Sys/Students/listStudents', 'user_controllers\students\ManageStudents::index');
$routes->get('/Sys/Students/addStudentForm', 'user_controllers\students\ManageStudents::addStudentForm');
$routes->post('/Sys/Students/submitStudentForm', 'user_controllers\students\ManageStudents::submitStudentForm');
$routes->post('/Sys/Students/submitUpdateStudentForm', 'user_controllers\students\ManageStudents::submitUpdateStudentForm');
$routes->post('/Sys/Students/listStudentsView', 'user_controllers\students\ManageStudents::listStudentsView');
$routes->post('/Sys/Students/submitDeleteStudent', 'user_controllers\students\ManageStudents::submitDeleteStudent');

// student profile  
$routes->post('/Sys/Students/studentBasicProfile', 'user_controllers\students\ManageStudents::studentBasicProfile');
$routes->post('/Sys/Students/searchStudents', 'user_controllers\students\ManageStudents::searchStudents');
$routes->post('/Sys/Students/studentBasicProfileView', 'user_controllers\students\ManageStudents::studentBasicProfileView');
$routes->post('/Sys/Students/studentTermReportingView', 'user_controllers\students\ManageStudents::studentTermReportingView');
$routes->post('/Sys/Students/submitStudentReportingForm', 'user_controllers\students\ManageStudents::submitStudentReportingForm');

// academic years
$routes->get('/Sys/AcademicSettings/listAcademicYears', 'user_controllers\academics_settings\ManageAcademicYears::index');
$routes->post('/Sys/AcademicSettings/submitAcademicYearForm', 'user_controllers\academics_settings\ManageAcademicYears::submitAcademicYearForm');
$routes->post('/Sys/AcademicSettings/submitUpdateAcademicYearForm', 'user_controllers\academics_settings\ManageAcademicYears::submitUpdateAcademicYearForm');
$routes->post('/Sys/AcademicSettings/submitAcademicYearTermForm', 'user_controllers\academics_settings\ManageAcademicYears::submitAcademicYearTermForm');
$routes->post('/Sys/AcademicSettings/submitEditAcademicYearTermForm', 'user_controllers\academics_settings\ManageAcademicYears::submitEditAcademicYearTermForm');


$routes->get('/Sys/AcademicSettings/listAcademicYearTerms', 'user_controllers\academics_settings\ManageAcademicYears::listAcademicYearTerms');
$routes->post('/Sys/AcademicSettings/submitSchoolClassForm', 'user_controllers\academics_settings\ManageAcademicYears::submitSchoolClassForm');
$routes->get('/Sys/AcademicSettings/listSchoolClasses', 'user_controllers\academics_settings\ManageAcademicYears::listSchoolClasses');
$routes->post('/Sys/AcademicSettings/viewClassInfo', 'user_controllers\academics_settings\ManageAcademicYears::viewClassInfo');
$routes->post('/Sys/AcademicSettings/updateSchoolClass', 'user_controllers\academics_settings\ManageAcademicYears::updateSchoolClass');
$routes->post('/Sys/AcademicSettings/deleteClass', 'user_controllers\academics_settings\ManageAcademicYears::deleteClass');
$routes->post('/Sys/AcademicSettings/submitClassStreamForm', 'user_controllers\academics_settings\ManageAcademicYears::submitClassStreamForm');
$routes->post('/Sys/AcademicSettings/viewStreamInfo', 'user_controllers\academics_settings\ManageAcademicYears::viewStreamInfo');
$routes->post('/Sys/AcademicSettings/updateClassStreamForm', 'user_controllers\academics_settings\ManageAcademicYears::updateClassStreamForm');
$routes->post('/Sys/AcademicSettings/deleteStream', 'user_controllers\academics_settings\ManageAcademicYears::deleteStream');

$routes->get('/Sys/AcademicSettings/listClassStreams', 'user_controllers\academics_settings\ManageAcademicYears::listClassStreams');
$routes->get('/Sys/AcademicSettings/listSubjects', 'user_controllers\academics_settings\ManageAcademicYears::listSubjects');
$routes->post('/Sys/AcademicSettings/submitNewSubjectForm', 'user_controllers\academics_settings\ManageAcademicYears::submitNewSubjectForm');
$routes->post('/Sys/AcademicSettings/viewSubjectInfo', 'user_controllers\academics_settings\ManageAcademicYears::viewSubjectInfo');
$routes->post('/Sys/AcademicSettings/updateSubjectForm', 'user_controllers\academics_settings\ManageAcademicYears::updateSubjectForm');


// academics 
$routes->get('/Sys/Academics/listStudentSubjects', 'user_controllers\academics\ManageTerms::listStudentSubjects');
$routes->get('/Sys/Academics/listClassStreamStudents', 'user_controllers\academics\ManageClassStudents::listClassStreamStudents');
$routes->get('/Sys/Academics/listTermClasses', 'user_controllers\academics\ManageTerms::listTermClasses');
$routes->get('/Sys/Academics/listTermSubjects', 'user_controllers\academics\ManageTerms::listTermSubjects');
$routes->get('/Sys/Academics/listTermExaminations', 'user_controllers\academics\ManageTerms::listTermExaminations');
$routes->post('/Sys/Academics/listTermClassExams', 'user_controllers\academics\ManageTerms::listTermClassExams');
$routes->post('/Sys/Academics/listTermClassExamEdit', 'user_controllers\academics\ManageTerms::listTermClassExamEdit');
$routes->post('/Sys/Academics/submitTermClassExam', 'user_controllers\academics\ManageTerms::submitTermClassExam');

// marksheet  
$routes->get('/Sys/Academics/termClassMarksheet', 'user_controllers\academics\ManageTerms::termClassMarksheetsIndex');
$routes->post('/Sys/Academics/termClassMarksheetView', 'user_controllers\academics\ManageTerms::termClassMarksheetView');
$routes->post('/Sys/Academics/submitTermClassMarksheet', 'user_controllers\academics\ManageTerms::submitTermClassMarksheet');

$routes->get('/Sys/Academics/listTermOtherSettings', 'user_controllers\academics\ManageTerms::listTermOtherSettingsIndex');
$routes->post('/Sys/Academics/termOtherSettingsView', 'user_controllers\academics\ManageTerms::termOtherSettingsView');
$routes->post('/Sys/Academics/submitTermGradingForm', 'user_controllers\academics\ManageTerms::submitTermGradingForm');
$routes->post('/Sys/Academics/generateStudentReportCard', 'user_controllers\academics\ManageTerms::generateStudentReportCard');
$routes->get('/Sys/Academics/generateSingleStudentReportCard', 'user_controllers\academics\ManageTerms::generateSingleStudentReportCard');
$routes->get('/Sys/Academics/generateClassReportCard', 'user_controllers\academics\ManageTerms::generateClassReportCard');
$routes->post('/Sys/Academics/generateStudentReportCardpdf', 'user_controllers\academics\ManageTerms::generateStudentReportCardpdf');


$routes->post('/Sys/Academics/listClassStreamStudentsView', 'user_controllers\academics\ManageClassStudents::listClassStreamStudentsView');
$routes->post('/Sys/Academics/listTermClassStreamsView', 'user_controllers\academics\ManageTerms::listTermClassStreamsView');
$routes->post('/Sys/Academics/submitTermClassesForm', 'user_controllers\academics\ManageTerms::submitTermClassesForm');
$routes->post('/Sys/Academics/listTermClassSubjectsView', 'user_controllers\academics\ManageTerms::listTermClassSubjectsView');
$routes->post('/Sys/Academics/submitTermClassSubjectForm', 'user_controllers\academics\ManageTerms::submitTermClassSubjectForm');
$routes->post('/Sys/Academics/termClassesList', 'user_controllers\academics\ManageTerms::listTermClassesList');
$routes->post('/Sys/Academics/listTermClassStreams', 'user_controllers\academics\ManageTerms::listTermClassStreams');
$routes->post('/Sys/Academics/termStudentSubjectsView', 'user_controllers\academics\ManageTerms::termStudentSubjectsView');
$routes->post('/Sys/Academics/submitTermStudentSubjects', 'user_controllers\academics\ManageTerms::submitTermStudentSubjects');
$routes->post('/Sys/Academics/generateBulkStudentReportCardspdf', 'user_controllers\academics\ManageTerms::generateBulkStudentReportCardspdf');
$routes->post('/Sys/Academics/removeTermClassSubjects', 'user_controllers\academics\ManageTerms::removeTermClassSubjects');

// grades 
$routes->get('/Sys/AcademicSettings/listClassGrades', 'user_controllers\academics_settings\ManageGrading::index');
$routes->post('/Sys/AcademicSettings/submitClassesGrading', 'user_controllers\academics_settings\ManageGrading::submitClassesGrading');

// grade edit
$routes->post('/Sys/AcademicSettings/viewGradeInfo', 'user_controllers\academics_settings\ManageGrading::viewGradeInfo');
$routes->post('/Sys/AcademicSettings/updateClassGrade', 'user_controllers\academics_settings\ManageGrading::updateClassGrade');

$routes->get('/Sys/AcademicSettings/listExaminations', 'user_controllers\academics_settings\ManageGrading::listExaminations');
$routes->post('/Sys/AcademicSettings/submitExaminationForm', 'user_controllers\academics_settings\ManageGrading::submitExaminationForm');
$routes->post('/Sys/AcademicSettings/viewExaminationInfo', 'user_controllers\academics_settings\ManageGrading::viewExaminationInfo');
$routes->post('/Sys/AcademicSettings/updateExaminationForm', 'user_controllers\academics_settings\ManageGrading::updateExaminationForm');
$routes->post('/Sys/AcademicSettings/deleteExam', 'user_controllers\academics_settings\ManageGrading::deleteExam');

// Accounting - ledgers
$routes->get('/Sys/Accounting/Ledgers/listCoa', 'user_controllers\accounting\ledgers\ManageLedgers::listSchoolCOA');
$routes->get('/Sys/Accounting/Ledgers/listIncomes', 'user_controllers\accounting\ledgers\ManageLedgers::listLedgerIncomes');
$routes->get('/Sys/Accounting/Ledgers/listExpenses', 'user_controllers\accounting\ledgers\ManageLedgers::listLedgerExpenses');
$routes->get('/Sys/Accounting/Ledgers/listLiabilities', 'user_controllers\accounting\ledgers\ManageLedgers::listLedgerLiabilities');
$routes->get('/Sys/Accounting/Ledgers/listAssets', 'user_controllers\accounting\ledgers\ManageLedgers::listLedgerAssets');
$routes->get('/Sys/Accounting/Ledgers/listTransactions', 'user_controllers\accounting\ledgers\ManageLedgers::listLedgerTransactions');
$routes->get('/Sys/Accounting/Ledgers/listTransactionalCOA', 'user_controllers\accounting\ledgers\ManageLedgers::schoolChartOfAccounts');
$routes->post('/Sys/Accounting/Ledgers/listTransactionalAccounts', 'user_controllers\accounting\ledgers\ManageLedgers::listTransactionalAccounts');

$routes->post('/Sys/Accounting/Ledgers/submitLedgerIncomesForm', 'user_controllers\accounting\ledgers\ManageLedgers::submitLedgerIncomesForm');
$routes->post('/Sys/Accounting/Ledgers/submitLedgerAssetsForm', 'user_controllers\accounting\ledgers\ManageLedgers::submitLedgerAssetsForm');
$routes->post('/Sys/Accounting/Ledgers/submitLedgerExpensesForm', 'user_controllers\accounting\ledgers\ManageLedgers::submitLedgerExpensesForm');
$routes->post('/Sys/Accounting/Ledgers/submitLedgerLiabilityForm', 'user_controllers\accounting\ledgers\ManageLedgers::submitLedgerLiabilityForm');

// ex-services
$routes->get('/Sys/ExServices/dataImporter', 'user_controllers\ex_services\data_importer\ManageDataImporter::index');
$routes->post('/Sys/ExServices/DataImporter/submitStudentsUpload', 'user_controllers\ex_services\data_importer\ManageDataImporter::submitStudentsUpload');
$routes->post('/Sys/ExServices/DataImporter/downloadImportTemplate', 'user_controllers\ex_services\data_importer\ManageDataImporter::downloadImportTemplate');
$routes->post('/Sys/ExServices/DataImporter/downloadMarksTemplate', 'user_controllers\ex_services\data_importer\ManageDataImporter::downloadMarksTemplate');
$routes->post('/Sys/ExServices/DataImporter/submitStudentMarksUpload', 'user_controllers\ex_services\data_importer\ManageDataImporter::submitStudentMarksUpload');
$routes->post('/Sys/ExServices/DataImporter/importTermStudents', 'user_controllers\ex_services\data_importer\ManageDataImporter::importTermStudents');

// treasury
$routes->get('/Sys/Treasury/listBankAccounts', 'user_controllers\treasury\ManageTreasury::listBankAccounts');
$routes->get('/Sys/Treasury/listCashAccounts', 'user_controllers\treasury\ManageTreasury::listCashAccounts');
$routes->get('/Sys/Treasury/listSafeAccounts', 'user_controllers\treasury\ManageTreasury::listSafeAccounts');
$routes->get('/Sys/Treasury/listMMAccounts', 'user_controllers\treasury\ManageTreasury::listMMAccounts');
$routes->post('/Sys/Treasury/submitBankAccount', 'user_controllers\treasury\ManageTreasury::submitBankAccountForm');
$routes->post('/Sys/Treasury/submitCashAccount', 'user_controllers\treasury\ManageTreasury::submitCashAccount');
$routes->post('/Sys/Treasury/submitSafeAccount', 'user_controllers\treasury\ManageTreasury::submitSafeAccount');
$routes->post('/Sys/Treasury/submitMMAccount', 'user_controllers\treasury\ManageTreasury::submitMMAccount');
$routes->get('/Sys/Treasury/listAccountTypes', 'user_controllers\treasury\ManageTreasury::listAccountTypes');
$routes->post('/Sys/Treasury/submitStudentAccountType', 'user_controllers\treasury\ManageTreasury::submitStudentAccountType');

// fees payment
$routes->post('/Sys/FeesPayment/feesPaymentForm', 'user_controllers\fees_payment\ManageFeesPayment::feesPaymentForm');
$routes->post('/Sys/FeesPayment/collectMMFeesPayment', 'user_controllers\fees_payment\ManageFeesPayment::collectMMFeesPayment');
$routes->get('/Sys/FeesPayment/listFeesPaymentsLedger', 'user_controllers\fees_payment\ManageFeesPayment::feesLedger');
$routes->get('/Sys/FeesPayment/listFeesTypes', 'user_controllers\fees_payment\ManageFeesPayment::feesTypes');
$routes->get('/Sys/FeesPayment/listBursaries', 'user_controllers\fees_payment\ManageFeesPayment::listBursaries');
$routes->post('/Sys/FeesPayment/submitBursaryForm', 'user_controllers\fees_payment\ManageFeesPayment::submitBursaryForm');
$routes->get('/Sys/FeesPayment/getAddBursaryForm', 'user_controllers\fees_payment\ManageFeesPayment::getAddBursaryForm');
$routes->post('/Sys/FeesPayment/submitFeesTypesForm', 'user_controllers\fees_payment\ManageFeesPayment::submitFeesTypesForm');
$routes->get('/Sys/FeesPayment/listFeesStructure', 'user_controllers\fees_payment\ManageFeesPayment::feesStructureIndex');
$routes->get('/Sys/FeesPayment/addFeesStructureForm', 'user_controllers\fees_payment\ManageFeesPayment::addFeesStructureForm');
$routes->post('/Sys/FeesPayment/submitFeesStructureForm', 'user_controllers\fees_payment\ManageFeesPayment::submitFeesStructureForm');
$routes->post('/Sys/FeesPayment/submitEditFeesStructureForm', 'user_controllers\fees_payment\ManageFeesPayment::submitEditFeesStructureForm');
$routes->post('/Sys/FeesPayment/submitFeesPaymentForm', 'user_controllers\fees_payment\ManageFeesPayment::submitFeesPaymentForm');
$routes->post('/api/FeesPayment/validateStudent', 'user_controllers\fees_payment\ManageFeesPayment::validateStudentByCode');
$routes->post('/api/FeesPayment/payStudentFees', 'user_controllers\fees_payment\ManageFeesPayment::payStudentFeesByCode');
$routes->post('/Sys/FeesPayment/generateToken', 'user_controllers\fees_payment\ManageFeesPayment::generateToken');
$routes->post('/Sys/FeesPayment/feesLedger', 'user_controllers\fees_payment\ManageFeesPayment::feesLedgerView');

// reports
$routes->get('/Sys/Reports/listStudentsEnrollment', 'user_controllers\students\ManageStudents::studentsEnrollmentReport');
$routes->get('/Sys/Reports/FinancialStatements/generalTrialBalance', 'user_controllers\reports\ManageFinancial::index');
$routes->post('/Sys/Reports/FinancialStatements/generalTrialBalance', 'user_controllers\reports\ManageFinancial::generalTrialBalance');
$routes->get('/Sys/Reports/FinancialStatements/balanceSheet', 'user_controllers\reports\ManageFinancial::balancesheet');
$routes->get('/Sys/Reports/FinancialStatements/incomeStatement', 'user_controllers\reports\ManageFinancial::income_statment');
$routes->get('/Sys/Reports/listBoardingStudents', 'user_controllers\students\ManageStudents::listBoardingStudents');
$routes->post('/Sys/Reports/listBoardingStudentsView', 'user_controllers\students\ManageStudents::listBoardingStudentsView');
$routes->get('/Sys/Reports/listTeachers', 'user_controllers\reports\ManageReports::listTeachers');
$routes->post('/Sys/Reports/listTeachers', 'user_controllers\reports\ManageReports::getTermTeachersList');
$routes->get('/Sys/Reports/listFees', 'user_controllers\reports\ManageReports::getListFees');
$routes->post('/Sys/Reports/FinancialStatements/transactionDetails', 'user_controllers\reports\ManageFinancial::getTransactionDetails');
$routes->post('/Sys/Reports/listStudentsEnrollmentView', 'user_controllers\students\ManageStudents::listStudentsEnrollmentView');

$routes->get('/Sys/MessageCenter/listSMSTypes', 'user_controllers\message_center\ManageMessageCenter::smsTypes');
$routes->get('/Sys/MessageCenter/listOutBoxMessages', 'user_controllers\message_center\ManageMessageCenter::sentMessages');
$routes->post('/Sys/MessageCenter/submitUpdateSMSTypes', 'user_controllers\message_center\ManageMessageCenter::submitUpdateSMSTypes');
$routes->post('/Sys/MessageCenter/submitSendSMS', 'user_controllers\message_center\ManageMessageCenter::submitSendSMS');
$routes->get('/Sys/MessageCenter/composeNewMessageForm', 'user_controllers\message_center\ManageMessageCenter::composeNewMessageForm');
$routes->post('/Sys/MessageCenter/submitPurchaseSMS', 'user_controllers\message_center\ManageMessageCenter::submitPurchaseSMS');
$routes->post('/Sys/MessageCenter/listSMSPurchase', 'user_controllers\message_center\ManageMessageCenter::listSMSPurchase');
$routes->get('/Sys/MessageCenter/listSMSRequests', 'user_controllers\message_center\ManageMessageCenter::listSMSRequests');
$routes->post('/Sys/MessageCenter/approveSMSPurchaseRequest', 'user_controllers\message_center\ManageMessageCenter::approveSMSPurchaseRequest');

$routes->get('/Sys/AcademicSettings/listReportCardsTemplates', 'user_controllers\academics_settings\ManageGrading::listReportCardsTemplatesIndex');
$routes->post('/Sys/AcademicSettings/listReportCardsTemplatesView', 'user_controllers\academics_settings\ManageGrading::listReportCardsTemplatesView');
$routes->post('/Sys/AcademicSettings/reportCardsTemplates', 'user_controllers\academics_settings\ManageGrading::listReportCardsTemplates');
$routes->post('/Sys/AcademicSettings/submitReportCardsTemplate', 'user_controllers\academics_settings\ManageGrading::submitReportCardsTemplate');
$routes->post('/Sys/AcademicSettings/updateReportCardsTemplateView', 'user_controllers\academics_settings\ManageGrading::updateReportCardsTemplateView');

$routes->get('/Sys/Settings/otherSettings', 'user_controllers\settings\ManageSettings::index');
$routes->post('/Sys/Settings/submitNewDormitryForm', 'user_controllers\settings\ManageSettings::submitNewDormitryForm');
$routes->post('/Sys/Settings/submitSchRequirementsForm', 'user_controllers\settings\ManageSettings::submitSchRequirementsForm');
$routes->post('/Sys/Settings/listSchoolTermRequirements', 'user_controllers\settings\ManageSettings::listSchoolTermRequirements');
$routes->post('/Sys/Settings/submitThemeSettings', 'user_controllers\settings\ManageSettings::submitThemeSettings');
$routes->get('/Sys/Settings/themeSettings', 'user_controllers\settings\ManageSettings::themeSettings');

// template views 
$routes->get('/aboutus', 'Pages::aboutus');
$routes->get('/accordion', 'Pages::accordion');
$routes->get('/alerts', 'Pages::alerts');
$routes->get('/avatar', 'Pages::avatar');
$routes->get('/background', 'Pages::background');
$routes->get('/badge', 'Pages::badge');
$routes->get('/blog-details', 'Pages::blog-details');
$routes->get('/blog', 'Pages::blog');
$routes->get('/border', 'Pages::border');
$routes->get('/breadcrumbs', 'Pages::breadcrumbs');
$routes->get('/buttons', 'Pages::buttons');
$routes->get('/calendar', 'Pages::calendar');
$routes->get('/cards', 'Pages::cards');
$routes->get('/carousel', 'Pages::carousel');
$routes->get('/chart-chartjs', 'Pages::chart-chartjs');
$routes->get('/chart-echart', 'Pages::chart-echart');
$routes->get('/chart-flot', 'Pages::chart-flot');
$routes->get('/chart-morris', 'Pages::chart-morris');
$routes->get('/chart-peity', 'Pages::chart-peity');
$routes->get('/chart-sparkline', 'Pages::chart-sparkline');
$routes->get('/chat', 'Pages::chat');
$routes->get('/check-out', 'Pages::check-out');
$routes->get('/collapse', 'Pages::collapse');
$routes->get('/contacts', 'Pages::contacts');
$routes->get('/counters', 'Pages::counters');
$routes->get('/display', 'Pages::display');
$routes->get('/draggablecards', 'Pages::draggablecards');
$routes->get('/dropdown', 'Pages::dropdown');
$routes->get('/edit-post', 'Pages::edit-post');
$routes->get('/empty', 'Pages::empty');
$routes->get('/error404', 'Pages::error404');
$routes->get('/error500', 'Pages::error500');
$routes->get('/error501', 'Pages::error501');
$routes->get('/extras', 'Pages::extras');
$routes->get('/faq', 'Pages::faq');
$routes->get('/file-attached-tags', 'Pages::file-attached-tags');
$routes->get('/file-details', 'Pages::file-details');
$routes->get('/file-manager', 'Pages::file-manager');
$routes->get('/file-manager1', 'Pages::file-manager1');
$routes->get('/flex', 'Pages::flex');
$routes->get('/forgot', 'Pages::forgot');
$routes->get('/form-advanced', 'Pages::form-advanced');
$routes->get('/form-editor', 'Pages::form-editor');
$routes->get('/form-elements', 'Pages::form_elements');
$routes->get('/form-spinners', 'Pages::form-spinners');
$routes->get('/form-layouts', 'Pages::form-layouts');
$routes->get('/form-sizes', 'Pages::form-sizes');
$routes->get('/form-validation', 'Pages::form-validation');
$routes->get('/form-wizards', 'Pages::form-wizards');
$routes->get('/gallery', 'Pages::gallery');
$routes->get('/height', 'Pages::height');
$routes->get('/icons', 'Pages::icons');
$routes->get('/icons2', 'Pages::icons2');
$routes->get('/icons3', 'Pages::icons3');
$routes->get('/icons4', 'Pages::icons4');
$routes->get('/icons5', 'Pages::icons5');
$routes->get('/icons6', 'Pages::icons6');
$routes->get('/icons7', 'Pages::icons7');
$routes->get('/icons8', 'Pages::icons8');
$routes->get('/icons9', 'Pages::icons9');
$routes->get('/icons10', 'Pages::icons10');
$routes->get('/icons11', 'Pages::icons11');
$routes->get('/icons12', 'Pages::icons12');
$routes->get('/image-compare', 'Pages::image-compare');
$routes->get('/images', 'Pages::images'); 
$routes->get('/index', 'Pages::index');
$routes->get('/index1', 'Pages::index1');
$routes->get('/index2', 'Pages::index2');
$routes->get('/invoice', 'Pages::invoice');
$routes->get('/list-group', 'Pages::list-group');
$routes->get('/lockscreen', 'Pages::lockscreen');
$routes->get('/mail', 'Pages::mail');
$routes->get('/mail-compose', 'Pages::mail-compose');
$routes->get('/mail-read', 'Pages::mail-read');
$routes->get('/mail-settings', 'Pages::mail-settings');
$routes->get('/mail-php', 'Pages::mail-php');
$routes->get('/map-leaflet', 'Pages::map-leaflet');
$routes->get('/map-vector', 'Pages::map-vector');
$routes->get('/margin', 'Pages::margin');
$routes->get('/media-object', 'Pages::media-object');
$routes->get('/modals', 'Pages::modals');
$routes->get('/navigation', 'Pages::navigation');
$routes->get('/notification', 'Pages::notification');
$routes->get('/padding', 'Pages::padding');
$routes->get('/pagination', 'Pages::pagination');
$routes->get('/popover', 'Pages::popover');
$routes->get('/position', 'Pages::position');
$routes->get('/pricing', 'Pages::pricing');
$routes->get('/product-cart', 'Pages::product-cart');
$routes->get('/product-details', 'Pages::product-details');
$routes->get('/profile-notifications', 'Pages::profile-notifications');
$routes->get('/profile', 'Pages::profile');
$routes->get('/progress', 'Pages::progress');
$routes->get('/rangeslider', 'Pages::rangeslider');
$routes->get('/rating', 'Pages::rating');
$routes->get('/reset', 'Pages::reset');
$routes->get('/search', 'Pages::search');
$routes->get('/settings', 'Pages::settings');
$routes->get('/shop', 'Pages::shop');
$routes->get('/signin', 'Pages::signin');
$routes->get('/signup', 'Pages::signup');
$routes->get('/spinners', 'Pages::spinners');
$routes->get('/sweet-alert', 'Pages::sweet-alert');
$routes->get('/switcher-1', 'Pages::switcher-1');
$routes->get('/table-basic', 'Pages::table-basic');
$routes->get('/table-data', 'Pages::table-data');
$routes->get('/tabs', 'Pages::tabs');
$routes->get('/tags', 'Pages::tags');
$routes->get('/thumbnails', 'Pages::thumbnails');
$routes->get('/timeline', 'Pages::timeline');
$routes->get('/toast', 'Pages::toast');
$routes->get('/todotask', 'Pages::todotask');
$routes->get('/tooltip', 'Pages::tooltip');
$routes->get('/treeview', 'Pages::treeview');
$routes->get('/typography', 'Pages::typography');
$routes->get('/underconstruction', 'Pages::underconstruction');
$routes->get('/userlist', 'Pages::userlist');
$routes->get('/widget-notification', 'Pages::widget-notification');
$routes->get('/widgets', 'Pages::widgets');
$routes->get('/width', 'Pages::width');
$routes->get('/wish-list', 'Pages::wish-list');