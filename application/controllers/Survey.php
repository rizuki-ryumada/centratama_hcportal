<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jobpro_model');
    }
    

    public function index()
    {
        $data['departemen'] = $this->Jobpro_model->getDetails('*', 'survey_ses_departemen', array());
        $data['survey1'] = $this->Jobpro_model->getDetails('*', 'survey_ses', array('id_tipesurvey' => 'A'));
        $this->load->view('survey/engagement/srvy_enggage_v', $data);
    }

}

/* End of file Survey.php */
