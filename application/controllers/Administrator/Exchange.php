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

    public function addExchange()
    {
        $res = array('success' => 'false', 'message' => '');
        try {
            $this->db->trans_begin();

            $exchangeObj = json_decode($this->input->post('exchange'));
            $carts = json_decode($this->input->post('carts'));
            $sales = json_decode($this->input->post('sales'));

            $exchangeData = array(
                'invoice'        => $sales->SaleMaster_InvoiceNo,
                'date'           => $exchangeObj->date,
                'sale_id'        => $sales->SaleMaster_SlNo,
                'sale_id'        => $sales->SaleMaster_SlNo,
                'saletotal'      => $exchangeObj->saletotal,
                'exchangeAmount' => $exchangeObj->exchangeAmount,
                'total'          => $exchangeObj->total,
                'cashPaid'       => $exchangeObj->cashPaid,
                'bankPaid'       => $exchangeObj->bankPaid,
                'bank_id'        => $exchangeObj->bank_id ?? NULL,
                'AddBy'          => $this->session->userdata('FullName'),
                'AddTime'        => date('Y-m-d H:i:s'),
                'branchId'       => $this->cbrunch,
            );

            $this->db->insert('tbl_exchange', $exchangeData);
            $exchangeId = $this->db->insert_id();

            foreach ($carts as $key => $cartProduct) {
                $saledetail = $this->db->where('SaleDetails_SlNo', $cartProduct->sale_detail_id)->get('tbl_saledetails')->row();
                $cartData = array(
                    'exchange_id'       => $exchangeId,
                    'sale_detail_id'    => $cartProduct->sale_detail_id,
                    'detail_product_id' => $saledetail->Product_IDNo,
                    'product_id'        => $cartProduct->product_id,
                    'quantity'          => $cartProduct->quantity,
                    'purchase_rate'     => $cartProduct->purchase_rate,
                    'sale_rate'         => $cartProduct->sale_rate,
                    'total'             => $cartProduct->total,
                    'AddBy'             => $this->session->userdata('FullName'),
                    'AddTime'           => date('Y-m-d H:i:s'),
                    'branchId'          => $this->cbrunch,
                );
                $this->db->insert('tbl_exchange_detail', $cartData);

                $this->db->query("
                        update tbl_currentinventory 
                        set sales_quantity = sales_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$saledetail->SaleDetails_TotalQuantity, $saledetail->Product_IDNo, $this->session->userdata('BRANCHid')]);
                $this->db->query("
                        update tbl_currentinventory 
                        set sales_quantity = sales_quantity + ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$cartProduct->quantity, $cartProduct->product_id, $this->session->userdata('BRANCHid')]);
            }
            $this->db->trans_commit();

            $res = array('success' => 'true', 'message' => 'Exchange added successfully!');
        } catch (\Throwable $e) {
            $this->db->trans_rollback();
            $res = array('success' => 'false', 'message' => $e->getMessage());
        }

        echo json_encode($res);
    }

    function exchange_record()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Exchange Record";
        $data['content'] = $this->load->view('Administrator/exchange/exchange_record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
}
