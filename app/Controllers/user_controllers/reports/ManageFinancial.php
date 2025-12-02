<?php

namespace App\Controllers\user_controllers\reports;

use App\Controllers\BaseController;
use App\Models\user_models\reports\M_FinancialReports;

class ManageFinancial extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_FinancialReports();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');

        h_set_session('current_page','GENERAL TRIAL BALANCE');
        $data['transactions'] = $this->modal->get_reports_transaction($startDate, $endDate);
        return view('user_pages/reports/financial/trial-balance/index', $data);
    }

    function generalTrialBalance() {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $startDate = h_post('start_date');
        $endDate = h_post('end_date');

        $data['transactions'] = $this->modal->get_reports_transaction($startDate, $endDate);

        $page = 'user_pages/reports/financial/trial-balance/trial-balance-view';
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

    public function balancesheet()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','BALANCE SHEET');
        return view('user_pages/reports/financial/balance-sheet/index');
    }

    public function income_statment()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Profit & Loss (P&L) Statement');
        // $data['staff_list'] = $this->modal->listStaff();
        return view('user_pages/reports/financial/income-statement/index');
    }

    function getTransactionDetails() {

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $startDate = h_post('start_date');
        $endDate = h_post('end_date');
        $id = h_post('id');

        $data['transactions'] = $this->modal->get_transaction_details($id, $startDate, $endDate);

        $page = 'user_pages/reports/financial/details-view-table';
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

}