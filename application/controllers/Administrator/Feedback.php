<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends CI_Controller
{

    public function index()
    {
   
        $data['title'] = "Feedback";
        $data['content'] = $this->load->view('Administrator/feedback/index', $data, TRUE);
        $this->load->view('Administrator/index', $data);

  
    }

    public function getFeedback(){
        $this->load->model('Feedback_model');
        $feedbacks = $this->Feedback_model->get_feedbacks();
        echo json_encode($feedbacks);
    }



}
