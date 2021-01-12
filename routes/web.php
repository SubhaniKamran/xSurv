<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmailsManagementController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\CompanyPackageController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;

Route::get('clear-cache', function () {

    Artisan::call('storage:link');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    //Create storage link on hosting
    $exitCode = Artisan::call('storage:link', [] );
    echo $exitCode; // 0 exit code for no errors.
});

Route::get('/cache-clear', [WelcomeController::class, 'clearcache'])->name('clearcache');

Route::get('/storage', function() {
    Artisan::call('storage:link');
    return "Storage linked";
});

Route::get('/migrate123', function(){
    Artisan::call('migrate:fresh');
    return "Migration Completed";
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/dropusaline', [WelcomeController::class, 'DropUsALine'])->name('DropUsALine');
Route::get('/logout', function() {
    return redirect(url('/'));
});

Auth::routes();
Route::group(['as' => 'admin.'], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('admin/company/ban/{user}', [CompanyController::class, 'ban'])->name('ban');
    Route::get('/admin/company/active/{user}', [CompanyController::class, 'active'])->name('active');
    Route::get('/admin/company/details/{companyid}', [CompanyController::class, 'CompanyDetails'])->name('companyDetails');
    Route::get('admin/survey/{survey}/ban', [SurveyController::class, 'ban'])->name('ban');
    Route::get('/admin/survey/{survey}/active', [SurveyController::class, 'active'])->name('active');
    Route::post('admin/survey/update', [SurveyController::class, 'AdminUpdateSurvey'])->name('adminUpdateSurvey');
    Route::resource('admin/company', CompanyController::class);
    Route::resource('admin/package', PackageController::class);
    Route::get('admin/package/ban/{packageid}', [PackageController::class, 'ban'])->name('packageBan');
    Route::get('/admin/package/active/{packageid}', [PackageController::class, 'active'])->name('packageActive');
    Route::get('/admin/profile/create', [ProfileController::class, 'ProfileEmailCreate'])->name('profileEmailCreate');
    Route::post('/admin/profile/email/update', [ProfileController::class, 'ProfileEmailUpdate'])->name('profileEmailUpdate');
    Route::get('/admin/profile/password', [ProfileController::class, 'ProfilePasswordCreate'])->name('profilePasswordCreate');
    Route::post('/admin/profile/password/update', [ProfileController::class, 'ProfilePasswordUpdate'])->name('profilePasswordUpdate');
    Route::get('/admin/termsconditions/create', [TermsConditionsController::class, 'create'])->name('termsConditionsCreate');
    Route::post('/admin/termsconditions/store', [TermsConditionsController::class, 'store'])->name('termsConditionsStore');
    Route::get('/admin/settings/logo', [GeneralSettingsController::class, 'GeneralSettingLogoCreate'])->name('generalSettingLogoCreate');
    Route::post('/admin/settings/logo/store', [GeneralSettingsController::class, 'GeneralSettingLogoStore'])->name('generalSettingLogoStore');
    Route::post('/admin/settings/logo/update', [GeneralSettingsController::class, 'GeneralSettingLogoUpdate'])->name('generalSettingLogoUpdate');
    Route::resource('admin/survey', SurveyController::class);
    Route::resource('profile', ProfileController::class);
    Route::post('/admin/profile/data/update', [ProfileController::class, 'UpdateAdminProfileData'])->name('updateAdminProfileData');
    Route::resource('client', ClientController::class);
    // Notification Setting
    Route::get('/admin/notification/setting', [NotificationSettingController::class, 'DisplayAdminNotificationSetting'])->name('DisplayAdminNotificationSetting');
    Route::get('/admin/notification/setting/enable/{id}', [NotificationSettingController::class, 'EnableAdminNotificationSetting'])->name('EnableAdminNotificationSetting');
    Route::get('/admin/notification/setting/disable/{id}', [NotificationSettingController::class, 'DisableAdminNotificationSetting'])->name('DisableAdminNotificationSetting');
    Route::post('/admin/unread/notifications', [NotificationSettingController::class, 'UnreadAdminNotifications'])->name('UnreadAdminNotifications');
    Route::get('/admin/all/notifications', [NotificationSettingController::class, 'AllAdminNotifications'])->name('AllAdminNotifications');
    Route::get('admin/logout', '\App\Http\Controllers\Auth\LoginController@logout');
});

// Company Routes
Route::middleware(['auth'])->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/survey/add', [SurveyController::class, 'CompanyNewSurvey'])->name('surveyAdd');
    Route::get('/survey/all', [SurveyController::class, 'CompanyAllSurveys'])->name('surveyAll');
    Route::post('/survey/store', [SurveyController::class, 'CompanyStoreSurvey'])->name('surveyStore');
    Route::get('/survey/edit/{id}', [SurveyController::class, 'CompanyEditSurvey'])->name('surveyEdit');
    Route::post('/survey/update', [SurveyController::class, 'CompanyUpdateSurvey'])->name('surveyUpdate');
    Route::get('/survey/ban/{id}', [SurveyController::class, 'CompanyBanSurvey'])->name('surveyBan');
    Route::get('/survey/active/{id}', [SurveyController::class, 'CompanyActiveSurvey'])->name('surveyActive');
    Route::get('/survey/delete/{id}', [SurveyController::class, 'CompanyDeleteSurvey'])->name('surveyDelete');
    Route::get('/survey/templates', [SurveyController::class, 'CompanyTemplatesSurveys'])->name('surveyTemplates');
    Route::get('/survey/templates/{id}', [SurveyController::class, 'CompanyEditTemplate'])->name('companyEditTemplate');
    Route::post('/survey/templates/store', [SurveyController::class, 'CompanyStoreTemplate'])->name('companyStoreTemplate');
    Route::get('admin/survey/companies/all', [SurveyController::class, 'CompaniesAllSurveys'])->name('companiesAllSurveys');
    // Service Routes
    Route::get('/service/add', [ServiceController::class, 'create'])->name('serviceCreate');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('serviceStore');
    Route::get('/service/all', [ServiceController::class, 'all'])->name('serviceAll');
    Route::post('/service/all', [ServiceController::class, 'AllServices'])->name('AllServices');
    Route::post('/services-all', [ServiceController::class, 'load'])->name('serviceLoad');
    Route::post('/service-delete', [ServiceController::class, 'delete'])->name('serviceDelete');
    Route::post('/service-active', [ServiceController::class, 'active'])->name('serviceActive');
    Route::post('/service-ban', [ServiceController::class, 'ban'])->name('serviceBan');
    Route::post('/service-edit', [ServiceController::class, 'editService'])->name('serviceEdit');
    Route::post('/service/update', [ServiceController::class, 'updateService'])->name('serviceUpdate');
    Route::post('/service-survey', [ServiceController::class, 'ServiceSurveyQuestion'])->name('serviceSurveyQuestion');
    // Customer Routes
    Route::get('/customer/add', [CustomerController::class, 'create'])->name('customerCreate');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('customerStore');
    Route::post('/customer/new/service/store', [CustomerController::class, 'NewCustomerServiceStore'])->name('NewCustomerServiceStore');
    Route::get('/customer/all', [CustomerController::class, 'all'])->name('customerAll');
    Route::post('/customers-all', [CustomerController::class, 'load'])->name('customersLoad');
    Route::post('/customer-delete', [CustomerController::class, 'delete'])->name('customerDelete');
    Route::post('/customer-active', [CustomerController::class, 'active'])->name('customerActive');
    Route::post('/customer-ban', [CustomerController::class, 'ban'])->name('customerBan');
    Route::post('/customer-edit', [CustomerController::class, 'editCustomer'])->name('customerEdit');
    Route::post('/customer/update', [CustomerController::class, 'updateCustomer'])->name('customerUpdate');
    Route::post('/customer-view', [CustomerController::class, 'viewCustomer'])->name('customerView');
    Route::post('/customerservice-view', [CustomerController::class, 'viewCustomerServices'])->name('customerServicesView');
    Route::post('/customer-survey', [CustomerController::class, 'CustomerSurveyDetails'])->name('customerSurveyDetails');
    // Setting Routes
    Route::get('/googlereview/add', [SettingController::class, 'GoogleReviewCreate'])->name('googleReviewCreate');
    Route::post('/googlereview/store', [SettingController::class, 'GoogleReviewStore'])->name('googleReviewStore');
    Route::post('/googlereview-all', [SettingController::class, 'GoogleReviewLoad'])->name('googleReviewLoad');
    Route::post('/googlereview/update', [SettingController::class, 'GoogleReviewUpdate'])->name('googleReviewUpdate');
    // Email Management Routes
    // Scheduling
    Route::get('/scheduling/view', [EmailsManagementController::class, 'DisplayScheduleEmails'])->name('displayScheduleEmails');
    Route::post('/scheduling/all', [EmailsManagementController::class, 'AllScheduleEmails'])->name('allScheduleEmails');
    Route::post('/scheduling/update', [EmailsManagementController::class, 'UpdateScheduleEmails'])->name('updateScheduleEmails');
    Route::post('/scheduling/update/all', [EmailsManagementController::class, 'UpdateAllScheduleEmails'])->name('updateAllScheduleEmails');
    // Pending
    Route::get('/pending/view', [EmailsManagementController::class, 'DisplayPendingEmails'])->name('DisplayPendingEmails');
    Route::post('/pending/all', [EmailsManagementController::class, 'AllPendingEmails'])->name('allPendingEmails');
    // Sent
    Route::get('/sent/view', [EmailsManagementController::class, 'DisplaySentEmails'])->name('DisplaySentEmails');
    Route::post('/sent/all', [EmailsManagementController::class, 'AllSentEmails'])->name('allSentEmails');
    // Record
    Route::get('/record/view', [EmailsManagementController::class, 'DisplayRecordEmails'])->name('DisplayRecordEmails');
    Route::post('/record/all', [EmailsManagementController::class, 'AllRecordEmails'])->name('allRecordEmails');
    // Company Packages
    Route::get('/packages/company/active', [CompanyPackageController::class, 'DisplayCompanyActivePackage'])->name('DisplayCompanyAcvtiveRecord');
    Route::get('/packages/company/history', [CompanyPackageController::class, 'DisplayCompanyHistoryInvoice'])->name('DisplayCompanyHistoryInvoice');
    Route::get('/packages/company/recommendation', [CompanyPackageController::class, 'DisplayCompanyRecommendation'])->name('DisplayCompanyRecommendation');
    Route::get('/packages/company/recommendation/store/{id}', [CompanyPackageController::class, 'PackageCompanyRecommendationStore'])->name('PackageCompanyRecommendationStore');
    Route::post('/company/packages/history', [CompanyPackageController::class, 'DisplayCompanyPackagesHistory'])->name('DisplayCompanyPackagesHistory');
    Route::post('/company/package/invoice', [CompanyPackageController::class, 'GenerateCompanyPackageInvoice'])->name('GenerateCompanyPackageInvoice');
    // Profile
    Route::get('/company/profile/create', [ProfileController::class, 'CompanyProfileCreate'])->name('CompanyProfileCreate');
    Route::post('/company/profile/email/update', [ProfileController::class, 'CompanyProfileEmailUpdate'])->name('CompanyProfileEmailUpdate');
    Route::post('/company/profile/password/update', [ProfileController::class, 'CompanyProfilePasswordUpdate'])->name('CompanyProfilePasswordUpdate');
    Route::post('/company/profile/card/update', [ProfileController::class, 'CompanyProfileCardUpdate'])->name('CompanyProfileCardUpdate');
    Route::post('/company/profile/data/update', [ProfileController::class, 'UpdateCompanyProfileData'])->name('UpdateCompanyProfileData');
    Route::get('company/logout', '\App\Http\Controllers\Auth\LoginController@logout');
    // Notification Setting
    Route::get('/company/notification/setting', [NotificationSettingController::class, 'DisplayCompanyNotificationSetting'])->name('DisplayCompanyNotificationSetting');
    Route::get('/company/notification/setting/enable/{id}', [NotificationSettingController::class, 'EnableCompanyNotificationSetting'])->name('EnableCompanyNotificationSetting');
    Route::get('/company/notification/setting/disable/{id}', [NotificationSettingController::class, 'DisableCompanyNotificationSetting'])->name('DisableCompanyNotificationSetting');
    Route::post('/company/unread/notifications', [NotificationSettingController::class, 'UnreadCompanyNotifications'])->name('UnreadCompanyNotifications');
    Route::get('/company/all/notifications', [NotificationSettingController::class, 'AllCompanyNotifications'])->name('AllCompanyNotifications');
});

    // Suvey Emails Management
    Route::get('/reaction/view/{service}/{customerid}', [EmailsManagementController::class, 'DisplayReactionPage'])->name('displayReactionPage');
    Route::get('/survey/form/{service}/{customerid}/{reaction}', [EmailsManagementController::class, 'DisplaySurveyForm'])->name('displaySurveyForm');
    Route::post('/survey/results', [EmailsManagementController::class, 'StoreSurveyResults'])->name('storeSurveyResults');
    Route::get('/terms_conditions', [TermsConditionsController::class, 'DisplayTermsConditions'])->name('displayTermsConditions');
