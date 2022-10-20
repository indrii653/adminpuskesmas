<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Tenagakerja extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tenagakerja_model', 'tk');
        $this->isLoggedIn();
        $this->module = 'Tenagakerja';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('tenagakerja/tenagaListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function tenagaListing()
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
            
            $count = $this->tk->tenagaListingCount($searchText);

			$returns = $this->paginationCompress ( "tenagaListing", $count, 10 );
            
            $data['records'] = $this->tk->tenagaListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Tenaga Kerja';
            
            $this->loadViews("tenagakerja/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Tenaga';

            $this->loadViews("tenagakerja/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewtenaga()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('dokter','dokter','trim|required|max_length[256]');
            $this->form_validation->set_rules('perawat','perawat','trim|required|max_length[1024]');
            $this->form_validation->set_rules('bidan','bidan','trim|required|max_length[1024]');
            $this->form_validation->set_rules('farmasi','farmasi','trim|required|max_length[1024]');
            $this->form_validation->set_rules('gizi','gizi','trim|required|max_length[1024]');
            $this->form_validation->set_rules('laboratorium','laboratorium','trim|required|max_length[1024]');
            $this->form_validation->set_rules('keling','keling','trim|required|max_length[1024]');
            $this->form_validation->set_rules('tu','tu','trim|required|max_length[1024]');
            $this->form_validation->set_rules('promotor','promotor','trim|required|max_length[1024]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $dokter = $this->security->xss_clean($this->input->post('dokter'));
                $perawat = $this->security->xss_clean($this->input->post('perawat'));
                $bidan = $this->security->xss_clean($this->input->post('bidan'));
                $farmasi = $this->security->xss_clean($this->input->post('farmasi'));
                $gizi = $this->security->xss_clean($this->input->post('gizi'));
                $laboratorium = $this->security->xss_clean($this->input->post('laboratorium'));
                $keling = $this->security->xss_clean($this->input->post('keling'));
                $tu = $this->security->xss_clean($this->input->post('tu'));
                $promotor = $this->security->xss_clean($this->input->post('promotor'));
                
                $tenagaInfo = array('dokter'=>$dokter, 'perawat'=>$perawat,'bidan'=>$bidan,'farmasi'=>$farmasi,'gizi'=>$gizi,'laboratorium'=>$laboratorium,'keling'=>$keling,'tu'=>$tu,'promotor'=>$promotor, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                $result = $this->tk->addNewtenaga($tenagaInfo);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Data created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Data creation failed');
                }
                
                redirect('tenagakerja/tenagaListing');
            }
        }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($tenagakerjaId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($tenagakerjaId == null)
            {
                redirect('tenagakerja/tenagaListing');
            }
            
            $data['tenagaInfo'] = $this->tk->gettenagaInfo($tenagakerjaId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Tenaga';
            
            $this->loadViews("tenagakerja/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function edittenaga()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $taskId = $this->input->post('id');
            
            $this->form_validation->set_rules('dokter','dokter','trim|required|max_length[256]');
            $this->form_validation->set_rules('perawat','perawat','trim|required|max_length[1024]');
            $this->form_validation->set_rules('bidan','bidan','trim|required|max_length[1024]');
            $this->form_validation->set_rules('farmasi','farmasi','trim|required|max_length[1024]');
            $this->form_validation->set_rules('gizi','gizi','trim|required|max_length[1024]');
            $this->form_validation->set_rules('laboratorium','laboratorium','trim|required|max_length[1024]');
            $this->form_validation->set_rules('keling','keling','trim|required|max_length[1024]');
            $this->form_validation->set_rules('tu','tu','trim|required|max_length[1024]');
            $this->form_validation->set_rules('promotor','promotor','trim|required|max_length[1024]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($taskId);
            }
            else
            {   
                $dokter = $this->security->xss_clean($this->input->post('dokter'));
                $perawat = $this->security->xss_clean($this->input->post('perawat'));
                $bidan = $this->security->xss_clean($this->input->post('bidan'));
                $farmasi = $this->security->xss_clean($this->input->post('farmasi'));
                $gizi = $this->security->xss_clean($this->input->post('gizi'));
                $laboratorium = $this->security->xss_clean($this->input->post('laboratorium'));
                $keling = $this->security->xss_clean($this->input->post('keling'));
                $tu = $this->security->xss_clean($this->input->post('tu'));
                $promotor = $this->security->xss_clean($this->input->post('promotor'));

                $tenagaInfo = array('dokter'=>$dokter, 'perawat'=>$perawat,'bidan'=>$bidan,'farmasi'=>$farmasi,'gizi'=>$gizi,'laboratorium'=>$laboratorium,'keling'=>$keling,'tu'=>$tu,'promotor'=>$promotor, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->tk->edittenaga($tenagaInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Data updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Data updation failed');
                }
                
                redirect('tenagakerja/tenagaListing');
            }
        }
    }

    function deletetenaga()
    {
        if(!$this->hasUpdateAccess())
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $taskId = $this->input->post('id');
            $tenagaInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->tk->deletetenaga($taskId, $tenagaInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

       /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function delete($tenagakerjaId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($tenagakerjaId == null)
            {
                redirect('tenagakerja/tenagaListing');
            }
            $result = $this->tk->deletetenaga($tenagakerjaId);
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Data updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Data updation failed');
            }
        }
        redirect('tenagakerja/tenagaListing');
    }
}

?>