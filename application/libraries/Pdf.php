<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF {
    function __construct(){
        parent::__construct();
    }

    //Page header
    public function Header(){
        //logo
        $image_file = base_url().'assets/img/logo.png';

        //Image(<IMAGE_LOCATION>, x-location, y-location, size icon)
        $this->Image($image_file, 15, 10, 45, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        //set Font
        $this->SetFont('helvetica', 'B', 20);
        //Title
        // $this->Cell(0, 15, 'Title', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
}

/* End of file Pdf.php */
/* Location: .application/libraries/Pdf.php */