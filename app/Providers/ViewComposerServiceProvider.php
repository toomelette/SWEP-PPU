<?php

namespace App\Providers;


use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider{

    
    public function boot(){

        
        // USERMENU
        View::composer('*', 'App\Swep\ViewComposers\UserMenuComposer');


        // MENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Swep\ViewComposers\MenuComposer');
        

        // SUBMENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Swep\ViewComposers\SubmenuComposer');


        // PROJECT
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index',
                        'dashboard.employee.create',
                        'dashboard.employee.edit'], 'App\Swep\ViewComposers\ProjectComposer');


        // FUND SOURCE
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index'], 'App\Swep\ViewComposers\FundSourceComposer');


        // MODE OF PAYMENT
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit', 
                        'printables.disbursement_voucher'], 'App\Swep\ViewComposers\ModeOfPaymentComposer');


        // DEPARTMENT
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index',
                        'dashboard.department_unit.create',
                        'dashboard.department_unit.edit',
                        'dashboard.project_code.create',
                        'dashboard.project_code.edit',
                        'dashboard.employee.create',
                        'dashboard.employee.edit'], 'App\Swep\ViewComposers\DepartmentComposer');


        // DEPARTMENT UNITS
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index',
                        'dashboard.employee.create',
                        'dashboard.employee.edit'], 'App\Swep\ViewComposers\DepartmentUnitComposer');


        // PROJECT CODES
        View::composer(['dashboard.disbursement_voucher.create', 
                        'dashboard.disbursement_voucher.edit',
                        'dashboard.disbursement_voucher.index',
                        'dashboard.disbursement_voucher.user_index'], 'App\Swep\ViewComposers\ProjectCodeComposer');
        

        //SIGNATORY
        View::composer(['printables.disbursement_voucher',
                        'dashboard.leave_application.create',
                        'dashboard.leave_application.edit'], 'App\Swep\ViewComposers\SignatoryComposer');


        //SIGNATORY TYPE
        View::composer(['dashboard.signatory.create',
                        'dashboard.signatory.edit'], 'App\Swep\ViewComposers\SignatoryTypeComposer');

        
    }

    
    
    public function register(){

      
    
    }




}
