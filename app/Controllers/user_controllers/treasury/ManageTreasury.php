<?php

namespace App\Controllers\user_controllers\treasury;

use App\Controllers\BaseController;
use App\Models\user_models\treasury\M_ManageTreasury;

class ManageTreasury extends BaseController 
{
    
    protected $modal;

	public function __construct()
	{

        // initiate school db connection
        $this->modal = new M_ManageTreasury();
    }

    public function listBankAccounts()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','List Bank Accounts');
        $data['bank_accounts'] = $this->modal->listBankAccounts();
        return view('user_pages/treasury/bank_accounts/index', $data);
    }

    public function listCashAccounts()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','List Cash Accounts');
        $data['cash_accounts'] = $this->modal->listCashAccounts();
        return view('user_pages/treasury/cash_accounts/index', $data);
    }

    public function listSafeAccounts()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','List Safe Accounts');
        $data['safe_accounts'] = $this->modal->listSafeAccounts();
        return view('user_pages/treasury/safe_accounts/index', $data);
    }

    public function listMMAccounts()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','List MM Accounts');
        $data['mm_accounts'] = $this->modal->listMMAccounts();
        return view('user_pages/treasury/mm_accounts/index', $data);
    }

    public function submitBankAccountForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $bankName = h_post('bank_name');
        $accountName = h_post('account_name');
        $bankAccount = h_post('bank_account');
        $bankCurrency = h_post('bank_currency');
        $registrationDate = h_post('registration_date');

        $data = [
            'bank_name' => ucwords($bankName),
            'account_number' =>  $bankAccount,
            'chart_id' => 0,
            'account_name' => ucwords($accountName),
            'currency' => $bankCurrency,
            'registration_date' => $registrationDate,
            'added_by' => h_session('current_user_id')
        ];

        $response = $this->modal->saveBankAccountData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Bank Account Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    
    public function submitCashAccount()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $name = h_post('name');
        $user = h_post('user');
        $currency = h_post('currency');
        $registrationDate = h_post('registration_date');

        $data = [
            'account_name' => ucwords($name),
            'user_id' =>  $user,
            'chart_id' => 0,
            'currency' => $currency,
            'registration_date' => $registrationDate,
            'added_by' => h_session('current_user_id')
        ];

        $response = $this->modal->saveCashAccountData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Cash Account Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitSafeAccount()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $name = h_post('name');
        $currency = h_post('currency');
        $registrationDate = h_post('registration_date');

        $data = [
            'safe_name' => ucwords($name),
            'chart_id' => 0,
            'currency' => $currency,
            'registration_date' => $registrationDate,
            'added_by' => h_session('current_user_id')
        ];

        $response = $this->modal->saveSafeAccountData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Safe Account Saved Successfully';
        }

        return $this->response->setJSON($results);
    }


    public function submitMMAccount()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $telecom = h_post('telecom');
        $mobileNumber = h_post('mobile_number');
        $currency = h_post('currency');
        $registrationDate = h_post('registration_date');

        $data = [
            'mm_number' => $mobileNumber,
            'telecom' => $telecom,
            'chart_id' => 0,
            'currency' => $currency,
            'registration_date' => $registrationDate,
            'added_by' => h_session('current_user_id')
        ];

        $response = $this->modal->saveMMAccountData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'MM Account Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function listAccountTypes()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','List Account Types');
        $data['accounts'] = $this->modal->listAccountTypes();
        return view('user_pages/treasury/account_types/index', $data);
    }

    public function submitStudentAccountType()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $name = h_post('name');
        $registrationDate = h_post('registration_date');
        $type = h_post('type');
        
        $data = [
            'name' => $name,
            'registration_date' => $registrationDate,
            'allow_withdraw' => $type,
            'added_by' => h_session('current_user_id')
        ];

        $response = $this->modal->saveAccountTypeData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Account Type Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

}
