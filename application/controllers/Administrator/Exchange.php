<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cbrunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->model('SMS_model', 'sms', true);
    }

    public function index()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Sales Exchange";
        $data['content'] = $this->load->view('Administrator/exchange/add_exchange', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
}
