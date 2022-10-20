<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Wilayah extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Wilayah_model', 'w');
        $this->isLoggedIn();
        $this->module = 'Wilayah';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('wilayah/wilayahListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function wilayahListing()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->w->wilayahListingCount($searchText);

			$rePrns = $this->paginationCompress ( "wilayahListing", $count, 10 );
            
            $data['records'] = $this->w->wilayahListing($searchText, $rePrns["page"], $rePrns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Wilayah Puskesmas';
            
            $this->loadViews("wilayah/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'CodeInsect : Add New Data';

            $this->loadViews("wilayah/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewwilayah()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
           
            $this->form_validation->set_rules('pL','pL','trim|required|max_length[256]');
            $this->form_validation->set_rules('pP','pP','trim|required|max_length[1024]');
            $this->form_validation->set_rules('pmL','pmL','trim|required|max_length[1024]');
            $this->form_validation->set_rules('pmP','pmP','trim|required|max_length[1024]');
            $this->form_validation->set_rules('msL','msL','trim|required|max_length[1024]');
            $this->form_validation->set_rules('msP','msP','trim|required|max_length[1024]');
            $this->form_validation->set_rules('L','L','trim|required|max_length[1024]');
            $this->form_validation->set_rules('P','P','trim|required|max_length[1024]');
            $this->form_validation->set_rules('rumah','rumah','trim|required|max_length[1024]');
            $this->form_validation->set_rules('jumlah_kk','jumlah_kk','trim|required|max_length[1024]');
            $this->form_validation->set_rules('jumlah_total','jumlah_total','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all1','all1','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all2','all2','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all3','all3','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all4','all4','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all5','all5','trim|required|max_length[1024]');
                      
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $pL = $this->security->xss_clean($this->input->post('pL'));
                $pP = $this->security->xss_clean($this->input->post('pP'));
                $pmL = $this->security->xss_clean($this->input->post('pmL'));
                $pmP = $this->security->xss_clean($this->input->post('pmP'));
                $msL = $this->security->xss_clean($this->input->post('msL'));
                $msP = $this->security->xss_clean($this->input->post('msP'));
                $L = $this->security->xss_clean($this->input->post('L'));
                $P = $this->security->xss_clean($this->input->post('P'));
                $rumah = $this->security->xss_clean($this->input->post('rumah'));
                $jumlah_kk = $this->security->xss_clean($this->input->post('jumlah_kk'));
                $jumlah_total = $this->security->xss_clean($this->input->post('jumlah_total'));
                $all1 = $this->security->xss_clean($this->input->post('all1'));
                $all2 = $this->security->xss_clean($this->input->post('all2'));
                $all3 = $this->security->xss_clean($this->input->post('all3'));
                $all4 = $this->security->xss_clean($this->input->post('all4'));
                $all5 = $this->security->xss_clean($this->input->post('all5'));
                
                $wilayahInfo = array('pL'=>$pL, 'pP'=>$pP,'pmL'=>$pmL,'pmP'=>$pmP,'msL'=>$msL,'msP'=>$msP,
                'L'=>$L,'P'=>$P,'rumah'=>$rumah,'jumlah_kk'=>$jumlah_kk,'jumlah_total'=>$jumlah_total,'all1'=>$all1,'all2'=>$all2,
                'all3'=>$all3,'all4'=>$all4,'all5'=>$all5,'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                $result = $this->w->editwilayah($wilayahInfo, $taskId);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'New data created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Data creation failed');
                }
                
                redirect('wilayah/wilayahListing');
            }
        }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($wilayahId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($wilayahId == null)
            {
                redirect('wilayah/wilayahListing');
            }
            
            $data['WilayahInfo'] = $this->w->getWilayahInfo($wilayahId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Data';
            
            $this->loadViews("wilayah/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editwilayah()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $taskId = $this->input->post('id');
            
            $this->form_validation->set_rules('pL','pL','trim|required|max_length[256]');
            $this->form_validation->set_rules('pP','pP','trim|required|max_length[1024]');
            $this->form_validation->set_rules('pmL','pmL','trim|required|max_length[1024]');
            $this->form_validation->set_rules('pmP','pmP','trim|required|max_length[1024]');
            $this->form_validation->set_rules('msL','msL','trim|required|max_length[1024]');
            $this->form_validation->set_rules('msP','msP','trim|required|max_length[1024]');
            $this->form_validation->set_rules('L','L','trim|required|max_length[1024]');
            $this->form_validation->set_rules('P','P','trim|required|max_length[1024]');
            $this->form_validation->set_rules('rumah','rumah','trim|required|max_length[1024]');
            $this->form_validation->set_rules('jumlah_kk','jumlah_kk','trim|required|max_length[1024]');
            $this->form_validation->set_rules('jumlah_total','jumlah_total','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all1','all1','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all2','all2','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all3','all3','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all4','all4','trim|required|max_length[1024]');
            $this->form_validation->set_rules('all5','all5','trim|required|max_length[1024]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($taskId);
            }
            else
            {   
                $pL = $this->security->xss_clean($this->input->post('pL'));
                $pP = $this->security->xss_clean($this->input->post('pP'));
                $bidan = $this->security->xss_clean($this->input->post('pmL'));
                $pmP = $this->security->xss_clean($this->input->post('pmP'));
                $msL = $this->security->xss_clean($this->input->post('msL'));
                $msP = $this->security->xss_clean($this->input->post('msP'));
                $L = $this->security->xss_clean($this->input->post('L'));
                $P = $this->security->xss_clean($this->input->post('P'));
                $rumah = $this->security->xss_clean($this->input->post('rumah'));
                $jumlah_kk = $this->security->xss_clean($this->input->post('jumlah_kk'));
                $jumlah_total = $this->security->xss_clean($this->input->post('jumlah_total'));
                $all1 = $this->security->xss_clean($this->input->post('all1'));
                $all2 = $this->security->xss_clean($this->input->post('all2'));
                $all3 = $this->security->xss_clean($this->input->post('all3'));
                $all4 = $this->security->xss_clean($this->input->post('all4'));
                $all5 = $this->security->xss_clean($this->input->post('all5'));

                $wilayahInfo = array('pL'=>$pL, 'pP'=>$pP,'pmL'=>$pmL,'pmP'=>$pmP,'msL'=>$msL,'msP'=>$msP,
                'L'=>$L,'P'=>$P,'rumah'=>$rumah,'jumlah_kk'=>$jumlah_kk,'jumlah_total'=>$jumlah_total,'all1'=>$all1,'all2'=>$all2,
                'all3'=>$all3,'all4'=>$all4,'all5'=>$all5,'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                $result = $this->w->editwilayah($wilayahInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Data updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Data updation failed');
                }
                
                redirect('wilayah/wilayahListing');
            }
        }
    }
}

?>