<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'AdminPanel','middleware'=>['isAdmin','auth']], function(){
    Route::get('/','admin\AdminPanelController@index')->name('admin.index');

    Route::get('/read-all-notifications','admin\AdminPanelController@readAllNotifications')->name('admin.notifications.readAll');
    Route::get('/notification/{id}/details','admin\AdminPanelController@notificationDetails')->name('admin.notification.details');

    Route::get('/my-salary','admin\AdminPanelController@mySalary')->name('admin.mySalary');

    Route::get('/my-profile','admin\AdminPanelController@EditProfile')->name('admin.myProfile');
    Route::post('/my-profile','admin\AdminPanelController@UpdateProfile')->name('admin.myProfile.update');
    Route::get('/my-password','admin\AdminPanelController@EditPassword')->name('admin.myPassword');
    Route::post('/my-password','admin\AdminPanelController@UpdatePassword')->name('admin.myPassword.update');
    Route::get('/notifications-settings','admin\AdminPanelController@EditNotificationsSettings')->name('admin.notificationsSettings');
    Route::post('/notifications-settings','admin\AdminPanelController@UpdateNotificationsSettings')->name('admin.notificationsSettings.update');

    Route::group(['prefix'=>'admins'], function(){
        Route::get('/','admin\AdminUsersController@index')->name('admin.adminUsers');
        Route::get('/create','admin\AdminUsersController@create')->name('admin.adminUsers.create');
        Route::post('/create','admin\AdminUsersController@store')->name('admin.adminUsers.store');
        Route::get('/{id}/block/{action}','admin\AdminUsersController@blockAction')->name('admin.adminUsers.block');
        Route::get('/{id}/edit','admin\AdminUsersController@edit')->name('admin.adminUsers.edit');
        Route::post('/{id}/edit','admin\AdminUsersController@update')->name('admin.adminUsers.update');
        Route::get('/{id}/delete','admin\AdminUsersController@delete')->name('admin.adminUsers.delete');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\AdminUsersController@DeleteuserPhoto')->name('admin.users.deletePhoto');
    });

    Route::group(['prefix'=>'clients'], function(){
        Route::get('/','admin\ClientUsersController@index')->name('admin.clientUsers');
        Route::post('/create','admin\ClientUsersController@store')->name('admin.clientUsers.store');
        Route::post('/{id}/edit','admin\ClientUsersController@update')->name('admin.clientUsers.update');
        Route::get('/{id}/delete','admin\ClientUsersController@delete')->name('admin.clientUsers.delete');
    });


    Route::group(['prefix'=>'services'], function(){
		Route::get('/', 'admin\ServiceController@index')->name('admin.services.index');
		Route::post('/', 'admin\ServiceController@store')->name('admin.services.store');
		Route::post('{id}/Edit', 'admin\ServiceController@update')->name('admin.services.update');
		Route::get('{id}/Delete', 'admin\ServiceController@delete')->name('admin.services.delete');
    });
    Route::group(['prefix'=>'offers'], function(){
        Route::get('/', 'admin\OfferController@index')->name('admin.offers.index');
        Route::post('/', 'admin\OfferController@store')->name('admin.offers.store');
        Route::post('{id}/Edit', 'admin\OfferController@update')->name('admin.offers.update');
        Route::get('{id}/Delete', 'admin\OfferController@delete')->name('admin.offers.delete');
    });
    Route::group(['prefix'=>'fields'], function(){
        Route::get('/', 'admin\FieldController@index')->name('admin.fields.index');
        Route::post('/', 'admin\FieldController@store')->name('admin.fields.store');
        Route::post('{id}/Edit', 'admin\FieldController@update')->name('admin.fields.update');
        Route::get('{id}/Delete', 'admin\FieldController@delete')->name('admin.fields.delete');
    });
    Route::group(['prefix'=>'settings'], function(){
        Route::get('/','admin\SettingsController@generalSettings')->name('admin.settings.general');
        Route::post('/','admin\SettingsController@updateSettings')->name('admin.settings.update');
        Route::get('/{key}/deletePhoto','admin\SettingsController@deleteSettingPhoto')->name('admin.settings.deletePhoto');
    });


    Route::group(['prefix'=>'payments'], function(){
        Route::get('/','App\Http\Controllers\admin\payments\PaymentController@index')->name('admin.payments');
        Route::get('/{id}/details', 'App\Http\Controllers\admin\payments\PaymentController@details')->name('admin.payments.details');
        Route::post('/create','App\Http\Controllers\admin\payments\PaymentController@store')->name('admin.payments.store');
        Route::post('/{id}/edit','App\Http\Controllers\admin\payments\PaymentController@update')->name('admin.payments.update');
        Route::get('/{id}/delete','App\Http\Controllers\admin\payments\PaymentController@delete')->name('admin.payments.delete');
    });

    Route::group(['prefix'=>'clients'], function(){
        Route::get('/','admin\ClientUsersController@index')->name('admin.clientUsers');
        Route::post('/create','admin\ClientUsersController@store')->name('admin.clientUsers.store');
        Route::post('/{id}/edit','admin\ClientUsersController@update')->name('admin.clientUsers.update');
        Route::get('/{id}/delete','admin\ClientUsersController@delete')->name('admin.clientUsers.delete');
    });

    Route::group(['prefix'=>'roles'], function(){
        Route::post('/CreatePermission','admin\RoleController@CreatePermission')->name('admin.CreatePermission');

        Route::get('/','admin\RoleController@index')->name('admin.roles');
        Route::post('/create','admin\RoleController@store')->name('admin.roles.store');
        Route::post('/{id}/edit','admin\RoleController@update')->name('admin.roles.update');
        Route::get('/{id}/delete','admin\RoleController@delete')->name('admin.roles.delete');
    });


    Route::group(['prefix'=>'governorates'], function(){
        Route::get('/','admin\GovernoratesController@index')->name('admin.governorates');
        Route::post('/create','admin\GovernoratesController@store')->name('admin.governorates.store');
        Route::post('/{governorateId}/edit','admin\GovernoratesController@update')->name('admin.governorates.update');
        Route::get('/{governorateId}/delete','admin\GovernoratesController@delete')->name('admin.governorates.delete');

        Route::group(['prefix'=>'{governorateId}/cities'], function(){
            Route::get('/','admin\CitiesController@index')->name('admin.cities');
            Route::post('/create','admin\CitiesController@store')->name('admin.cities.store');
            Route::post('/{cityId}/edit','admin\CitiesController@update')->name('admin.cities.update');
            Route::get('/{cityId}/delete','admin\CitiesController@delete')->name('admin.cities.delete');
        });
    });

    Route::group(['prefix'=>'settings'], function(){
        Route::get('/','admin\SettingsController@generalSettings')->name('admin.settings.general');
        Route::post('/','admin\SettingsController@updateSettings')->name('admin.settings.update');
        Route::get('/{key}/deletePhoto','admin\SettingsController@deleteSettingPhoto')->name('admin.settings.deletePhoto');
    });

    Route::group(['prefix'=>'branches'], function(){
		Route::get('/', 'admin\BranchesController@index')->name('admin.branches.index');
		Route::post('/', 'admin\BranchesController@store')->name('admin.branches.store');
		Route::post('{id}/Edit', 'admin\BranchesController@update')->name('admin.branches.update');
		Route::get('{id}/Delete', 'admin\BranchesController@delete')->name('admin.branches.delete');
    });

    Route::group(['prefix'=>'services'], function(){
		Route::get('/', 'admin\ServiceController@index')->name('admin.services.index');
		Route::post('/', 'admin\ServiceController@store')->name('admin.services.store');
		Route::post('{id}/Edit', 'admin\ServiceController@update')->name('admin.services.update');
		Route::get('{id}/Delete', 'admin\ServiceController@delete')->name('admin.services.delete');
    });

    Route::group(['prefix'=>'SalariesControl'], function(){
        //HR Dep. -> Salaries Managment
        Route::get('/', 'admin\hr\SalariesController@index')->name('admin.salaries');
        Route::get('/{id}/Salaries', 'admin\hr\SalariesController@EmployeeSalary')->name('admin.EmployeeSalary');
        Route::post('/{id}/payOutSalary', 'admin\hr\SalariesController@payOutSalary')->name('admin.payOutSalary');

        Route::post('/{id}/AddPermission', 'admin\hr\AttendanceController@AddPermission')->name('admin.AddPermission');
        Route::get('/{id}/DeletePermission', 'admin\hr\AttendanceController@DeletePermission')->name('admin.DeletePermission');
        Route::post('/{id}/AddVacation', 'admin\hr\AttendanceController@AddVacation')->name('admin.AddVacation');
        Route::get('/Vacations/{id}/delete', 'admin\hr\AttendanceController@DeleteVacation')->name('admin.DeleteVacation');

        Route::get('/AttendanceList', 'admin\hr\AttendanceController@index')->name('admin.attendance');
        Route::post('/NewAttendance', 'admin\hr\AttendanceController@SubmitNewAttendance')->name('admin.attendace.excel');

        //HR Dep. -> Salaries Managment -> Records
        Route::group(['prefix'=>'{UID}/Attendance'], function(){
            Route::get('/{Date}/EditVacation', 'admin\hr\AttendanceController@EmployeeEditVacation')->name('EmployeeEditVacation');
            Route::post('/{Date}/EditVacation', 'admin\hr\AttendanceController@EmployeePostEditVacation')->name('EmployeePostEditVacation');
        });

        //HR Dep. -> Salaries Managment -> Add Deduction
        Route::group(['prefix'=>'deductions'], function(){
            Route::post('/store', 'admin\hr\DeductionsController@store')->name('admin.deductions.store');
            Route::post('/{id}/Edit', 'admin\hr\DeductionsController@update')->name('admin.deductions.update');
            Route::get('/{id}/Delete', 'admin\hr\DeductionsController@delete')->name('admin.deductions.delete');
        });

        //test
        Route::post('/{EID}/PaySalary/{Type}', 'HRDepController@PaySalary')->name('SalaryPay');
        Route::get('/{EID}/PaySalary/{Type}', 'HRDepController@PaySalaryRequest')->name('SalaryPayRequest');
    });


    /**
	 * Safes Control
	 */
    Route::group(['prefix'=>'Safes'], function(){
		//Safes Control
		Route::get('/', 'admin\accounts\SafesController@index')->name('admin.safes');
		Route::post('/', 'admin\accounts\SafesController@store')->name('admin.safes.store');
		Route::post('/{id}/Edit', 'admin\accounts\SafesController@update')->name('admin.safes.update');
		Route::get('/{id}/Delete', 'admin\accounts\SafesController@delete')->name('admin.safes.delete');
		Route::get('/{id}/Stats', 'admin\accounts\SafesController@Stats')->name('admin.safes.Stats');
    });

    Route::group(['prefix'=>'ExpensesTypes'], function(){
        Route::get('/', 'admin\accounts\ExpensesTypesController@index')->name('admin.expensesTypes');
        Route::post('/create', 'admin\accounts\ExpensesTypesController@store')->name('admin.expensesTypes.store');
        Route::post('/{id}/Edit', 'admin\accounts\ExpensesTypesController@update')->name('admin.expensesTypes.update');
        Route::get('/{id}/Delete', 'admin\accounts\ExpensesTypesController@delete')->name('admin.expensesTypes.delete');
    });

    Route::group(['prefix'=>'webservices'], function(){
        Route::get('/', 'admin\webservices\WebServicesController@index')->name('admin.webservices');
        Route::post('/create', 'admin\webservices\WebServicesController@store')->name('admin.webservices.store');
        Route::post('/{id}/Edit', 'admin\webservices\WebServicesController@update')->name('admin.webservices.update');
        Route::get('/{id}/Delete', 'admin\webservices\WebServicesController@delete')->name('admin.webservices.delete');
    });


    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [App\Http\Controllers\admin\BlogController::class, 'index'])->name('admin.blogs');
        Route::get('/{id}', [App\Http\Controllers\admin\BlogController::class, 'show'])->name('admin.blogs.show');
        Route::post('/create', [App\Http\Controllers\admin\BlogController::class, 'store'])->name('admin.blogs.store');
        Route::post('/{id}/edit', [App\Http\Controllers\admin\BlogController::class, 'update'])->name('admin.blogs.update');
        Route::get('/{id}/delete', [App\Http\Controllers\admin\BlogController::class, 'delete'])->name('admin.blogs.delete');

    });

    Route::group(['prefix' => 'doctors'], function () {
        Route::get('/', [App\Http\Controllers\admin\DoctorController::class, 'index'])->name('admin.doctors');
        Route::get('/{id}', [App\Http\Controllers\admin\DoctorController::class, 'show'])->name('admin.doctors.show');
        Route::post('/create', [App\Http\Controllers\admin\DoctorController::class, 'store'])->name('admin.doctors.store');
        Route::post('/{id}/edit', [App\Http\Controllers\admin\DoctorController::class, 'update'])->name('admin.doctors.update');
        Route::get('/{id}/delete', [App\Http\Controllers\admin\DoctorController::class, 'delete'])->name('admin.doctors.delete');

    });

    Route::group(['prefix' => 'contact-us'], function () {
        Route::get('/', [App\Http\Controllers\admin\ContactUsController::class, 'index'])->name('admin.contactus');
        Route::get('/{id}/details', [App\Http\Controllers\admin\ContactUsController::class, 'details'])->name('admin.contactus.details');
        Route::get('/{id}/delete', [App\Http\Controllers\admin\ContactUsController::class, 'delete'])->name('admin.contactus.delete');
    });

    Route::group(['prefix'=>'places'], function(){
        Route::get('/', 'admin\Places\PlacesController@index')->name('admin.places');
        Route::post('/create', 'admin\Places\PlacesController@store')->name('admin.places.store');
        Route::post('/{id}/Edit', 'admin\Places\PlacesController@update')->name('admin.places.update');
        Route::get('/{id}/Delete', 'admin\Places\PlacesController@delete')->name('admin.places.delete');
    });
    Route::group(['prefix'=>'results'], function(){
        Route::get('/', 'admin\result\ResultController@index')->name('admin.results');
        Route::post('/create', 'admin\result\ResultController@store')->name('admin.results.store');
        Route::post('/{id}/Edit', 'admin\result\ResultController@update')->name('admin.results.update');
        Route::get('/{id}/Delete', 'admin\result\ResultController@delete')->name('admin.results.delete');
    });

    Route::group(['prefix'=>'expenses'], function(){
        Route::get('/', 'admin\accounts\ExpensesController@index')->name('admin.expenses');
        Route::post('/NewExpense', 'admin\accounts\ExpensesController@store')->name('admin.expenses.store');
        Route::post('/{id}/Edit', 'admin\accounts\ExpensesController@update')->name('admin.expenses.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\accounts\ExpensesController@deletePhoto')->name('admin.expenses.deletePhoto');
        Route::get('/{id}/Delete', 'admin\accounts\ExpensesController@delete')->name('admin.expenses.delete');
    });

    Route::group(['prefix'=>'revenues'], function(){
        Route::get('/', 'admin\accounts\RevenuesController@index')->name('admin.revenues');
        Route::post('/NewExpense', 'admin\accounts\RevenuesController@store')->name('admin.revenues.store');
        Route::post('/{id}/Edit', 'admin\accounts\RevenuesController@update')->name('admin.revenues.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\accounts\RevenuesController@deletePhoto')->name('admin.revenues.deletePhoto');
        Route::get('/{id}/Delete', 'admin\accounts\RevenuesController@delete')->name('admin.revenues.delete');
    });



	/**
	 * Projects & Units Control
	 */
    Route::group(['prefix'=>'locations'], function(){
		Route::get('/', 'admin\projectsUnits\LocationsController@index')->name('admin.locations');
		Route::post('/', 'admin\projectsUnits\LocationsController@store')->name('admin.locations.store');
		Route::post('/{id}/Edit', 'admin\projectsUnits\LocationsController@update')->name('admin.locations.update');
		Route::get('/{id}/Delete', 'admin\projectsUnits\LocationsController@delete')->name('admin.locations.delete');
	});

    Route::group(['prefix'=>'companies'], function(){
		Route::get('/', 'admin\projectsUnits\CompaniesController@index')->name('admin.companies');
		Route::post('/', 'admin\projectsUnits\CompaniesController@store')->name('admin.companies.store');
		Route::post('/{id}/Edit', 'admin\projectsUnits\CompaniesController@update')->name('admin.companies.update');
		Route::get('/{id}/Delete', 'admin\projectsUnits\CompaniesController@delete')->name('admin.companies.delete');
	});


    Route::group(['prefix'=>'projects'], function(){
		Route::get('/', 'admin\projectsUnits\ProjectsController@index')->name('admin.projects');
		Route::post('/', 'admin\projectsUnits\ProjectsController@store')->name('admin.projects.store');
		Route::get('/{id}/view', 'admin\projectsUnits\ProjectsController@view')->name('admin.projects.view');
		Route::get('/{id}/edit', 'admin\projectsUnits\ProjectsController@edit')->name('admin.projects.edit');
		Route::post('/{id}/edit', 'admin\projectsUnits\ProjectsController@update')->name('admin.projects.update');
		Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\projectsUnits\ProjectsController@deletePhoto')->name('admin.projects.deletePhoto');
		Route::get('/{id}/delete', 'admin\projectsUnits\ProjectsController@delete')->name('admin.projects.delete');
    });

    Route::group(['prefix'=>'units'], function(){
        Route::get('/', 'admin\projectsUnits\UnitsController@index')->name('admin.units');
        Route::post('/', 'admin\projectsUnits\UnitsController@store')->name('admin.units.store');
		Route::get('/{id}/view', 'admin\projectsUnits\UnitsController@view')->name('admin.units.view');
		Route::get('/{id}/edit', 'admin\projectsUnits\UnitsController@edit')->name('admin.units.edit');
        Route::post('/{id}/edit', 'admin\projectsUnits\UnitsController@update')->name('admin.units.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\projectsUnits\UnitsController@DeleteUnitPhoto')->name('admin.units.deletePhoto');
        Route::get('/{id}/Delete', 'admin\projectsUnits\UnitsController@delete')->name('admin.units.delete');
    });

    	/**
	 *
	 * ClientsControl
	 */
	Route::group(['prefix'=>'clients'], function(){
		Route::get('/', 'admin\ClientsFollowUps\ClientsController@index')->name('admin.clients');
		Route::post('/store', 'admin\ClientsFollowUps\ClientsController@store')->name('admin.clients.store');
		Route::post('/createExcelClient', 'admin\ClientsFollowUps\ClientsController@storeExcelClient')->name('admin.clients.storeExcelClient');
		Route::post('/{id}/Edit', 'admin\ClientsFollowUps\ClientsController@update')->name('admin.clients.update');
		Route::get('/{id}/status/{action}', 'admin\ClientsFollowUps\ClientsController@changeStatus')->name('admin.clients.changeStatus');
		Route::get('/{id}/Delete', 'admin\ClientsFollowUps\ClientsController@delete')->name('admin.clients.delete');
		Route::get('/noAgentClients', 'admin\ClientsFollowUps\ClientsController@noAgentClients')->name('admin.noAgentClients');
		Route::post('/NoAgent/changeAgent', 'admin\ClientsFollowUps\ClientsController@changeAgent')->name('admin.noAgentClients.asignAgent');
    });

	Route::group(['prefix'=>'followups'], function(){
		Route::get('/nextFollowups', 'admin\ClientsFollowUps\FollowUpsController@nextFollowups')->name('admin.nextFollowups');
		Route::get('/', 'admin\ClientsFollowUps\FollowUpsController@index')->name('admin.followups');
		Route::post('/NewFollowUp', 'admin\ClientsFollowUps\FollowUpsController@store')->name('admin.followups.store');
		Route::get('/{id}/view', 'admin\ClientsFollowUps\FollowUpsController@view')->name('admin.followups.details');
		Route::post('/{id}/Edit', 'admin\ClientsFollowUps\FollowUpsController@update')->name('admin.followups.update');
		Route::get('/{id}/delete', 'admin\ClientsFollowUps\FollowUpsController@delete')->name('admin.followups.delete');
	});

	Route::group(['prefix'=>'reports'], function(){
		Route::get('/userFollowUpsReport', 'admin\ReportsController@userFollowUpsReport')->name('admin.userFollowUpsReport');
		Route::get('/teamFollowUpsReport', 'admin\ReportsController@teamFollowUpsReport')->name('admin.teamFollowUpsReport');
		Route::get('/branchFollowUpsReport', 'admin\ReportsController@branchFollowUpsReport')->name('admin.branchFollowUpsReport');
		Route::get('/accountsReport', 'admin\ReportsController@accountsReport')->name('admin.accountsReport');
	});

});
