<?php

namespace App\Controllers\user_controllers\accounting\ledgers;

use App\Controllers\BaseController;
use App\Models\user_models\accounting\ledgers\M_ManageLedgers;
use App\Models\user_models\treasury\M_ManageTreasury;

class ManageLedgers extends BaseController
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageLedgers();
        $this->modal2 = new M_ManageTreasury();
    }

    public function listSchoolCOA()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredCOA();
        $data['coa'] = $results;

        h_set_session('current_page','Chart Of Accounts');
        return view('user_pages/accounting/ledgers/coa', $data);
    }

    public function listLedgerIncomes()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['income_charts'] = [];

        $response = $this->modal->schoolChartOfAccounts('income');
        if ($response->success) {
            $data['income_charts'] = $response->data;
        }
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $transactions = $this->modal->schoolListChartLineTransactions('income', $startDate, $endDate );
        $data['transactions'] = $transactions;

        h_set_session('current_page','List Of Incomes');
        return view('user_pages/accounting/ledgers/incomes/index', $data);
    }

    public function listLedgerExpenses()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['income_charts'] = [];

        $response = $this->modal->schoolChartOfAccounts('expenses');
        if ($response->success) {
            $data['income_charts'] = $response->data;
        }
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $transactions = $this->modal->schoolListChartLineTransactions('expenses', $startDate, $endDate );
        $data['transactions'] = $transactions;

        h_set_session('current_page','List Of Expenses');
        return view('user_pages/accounting/ledgers/expenses/index', $data);
    }

    public function listLedgerLiabilities()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['income_charts'] = [];

        $response = $this->modal->schoolChartOfAccounts('liabilities');
        if ($response->success) {
            $data['income_charts'] = $response->data;
        }
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $transactions = $this->modal->schoolListChartLineTransactions('liabilities', $startDate, $endDate );
        $data['transactions'] = $transactions;

        h_set_session('current_page','List Of Liabilities');
        return view('user_pages/accounting/ledgers/liabilities/index', $data);
    }

    public function listLedgerAssets()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['income_charts'] = [];

        $response = $this->modal->schoolChartOfAccounts('assets');
        if ($response->success) {
            $data['income_charts'] = $response->data;
        }
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $transactions = $this->modal->schoolListChartLineTransactions('assets', $startDate, $endDate );
        $data['transactions'] = $transactions;

        h_set_session('current_page','List Of Assets');
        return view('user_pages/accounting/ledgers/assets/index', $data);
    }

    public function listLedgerTransactions()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['income_charts'] = [];

        $response = $this->modal->schoolChartOfAccounts('assets,expenses,income,liabilities,capital');
        if ($response->success) {
            $data['income_charts'] = $response->data;
        }

        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');
        $transactions = $this->modal->schoolListAccountTransactions($startDate, $endDate );
        $data['transactions'] = $transactions;

        h_set_session('current_page','List Of Transactions');
        return view('user_pages/accounting/ledgers/list-transactions', $data);
    }

    public function schoolChartOfAccounts()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $lineChart = h_get('chart_line');
        $response = $this->modal->schoolChartOfAccounts($lineChart);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Results';
            $results['data'] = $response->data;
        }

        return $this->response->setJSON($results);
    }

    public function listTransactionalAccounts()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $paymentMethod = h_post('payment_method');
        $response = $this->modal->schoolPaymentAccounts($paymentMethod);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Results';
            $results['data'] = $response->data;
        }

        return $this->response->setJSON($results);
    }

    public function submitLedgerIncomesForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $description = h_post('description');
        $amount = h_post('amount');
        $recordDate = h_post('record_date');
        $account = h_post('account');
        $paymentMethod = h_post('payment_method');
        $paymentMethodAccount = h_post('payment_method_account');
        $referenceNumber = h_post('reference_no');

        $data = [
            'heading' => ucwords($description),
            'amount' => $amount,
            'record_date' => $recordDate,
            'transaction_status' => 'normal',
            'credit_chart_id' => $account,
            'debit_chart_id' => $paymentMethodAccount,
            'reference_number' => $this->modal2->generate_reference_no('income'),
            'branch_id' => h_session('branch_id'),
            'added_by'  => h_session('current_user_id'),
            'voucher_number' => $referenceNumber,
            'payment_method' => $paymentMethod
        ];

        $response = $this->modal->submitLedgerTransaction($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitLedgerAssetsForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $description = h_post('description');
        $amount = h_post('amount');
        $recordDate = h_post('record_date');
        $account = h_post('account');
        $paymentMethod = h_post('payment_method');
        $paymentMethodAccount = h_post('payment_method_account');
        $referenceNumber = h_post('reference_no');

        $data = [
            'heading' => ucwords($description),
            'amount' => $amount,
            'record_date' => $recordDate,
            'transaction_status' => 'normal',
            'credit_chart_id' => $account,
            'debit_chart_id' => $paymentMethodAccount,
            'reference_number' => $this->modal2->generate_reference_no('assets'),
            'branch_id' => h_session('branch_id'),
            'added_by'  => h_session('current_user_id'),
            'voucher_number' => $referenceNumber,
            'payment_method' => $paymentMethod
        ];

        $response = $this->modal->submitLedgerTransaction($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }


    public function submitLedgerExpensesForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $description = h_post('description');
        $amount = h_post('amount');
        $recordDate = h_post('record_date');
        $account = h_post('account');
        $paymentMethod = h_post('payment_method');
        $paymentMethodAccount = h_post('payment_method_account');
        $referenceNumber = h_post('reference_no');

        $data = [
            'heading' => ucwords($description),
            'amount' => $amount,
            'record_date' => $recordDate,
            'transaction_status' => 'normal',
            'credit_chart_id' => $paymentMethodAccount,
            'debit_chart_id' => $account,
            'reference_number' => $this->modal2->generate_reference_no('expenses'),
            'branch_id' => h_session('branch_id'),
            'added_by'  => h_session('current_user_id'),
            'voucher_number' => $referenceNumber,
            'payment_method' => $paymentMethod
        ];

        $response = $this->modal->submitLedgerTransaction($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitLedgerLiabilityForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $description = h_post('description');
        $amount = h_post('amount');
        $recordDate = h_post('record_date');
        $account = h_post('account');
        $paymentMethod = h_post('payment_method');
        $paymentMethodAccount = h_post('payment_method_account');
        $referenceNumber = h_post('reference_no');

        $data = [
            'heading' => ucwords($description),
            'amount' => $amount,
            'record_date' => $recordDate,
            'transaction_status' => 'normal',
            'credit_chart_id' => $account,
            'debit_chart_id' => $paymentMethodAccount,
            'reference_number' => $this->modal2->generate_reference_no('liabilities'),
            'branch_id' => h_session('branch_id'),
            'added_by'  => h_session('current_user_id'),
            'voucher_number' => $referenceNumber,
            'payment_method' => $paymentMethod
        ];

        $response = $this->modal->submitLedgerTransaction($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

}
