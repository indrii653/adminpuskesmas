<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Kepuasan extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Kepuasan_model', 'k');
        $this->isLoggedIn();
        $this->module = 'Kepuasan';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('kepuasan/kepuasanListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function kepuasanListing()
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
            
            $count = $this->k->kepuasanListingCount($searchText);

			$returns = $this->paginationCompress ( "kepuasanListing/", $count, 10 );
            
            $data['records'] = $this->k->kepuasanListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Kepuasan';
            
            $this->loadViews("kepuasan/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New IKM';

            $this->loadViews("kepuasan/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewkepuasan()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        { 
           
            $this->load->library('form_validation');
            
                $taskId = $this->input->post('taskId');
                $config['upload_path']          = './../public_html/img';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
                $config['overwrite']            = true;
                $config['max_size']             = 1024; // 1MB

                $this->load->library('upload', $config);                
                $this->upload->initialize($config);

                $data['error'] = $this->upload->display_errors();

                if (!$this->upload->do_upload('img')) {
                    // $ambilnama=$this->k->getkepuasanInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                $kepuasanInfo = array('puas'=>$namafile,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->k->addNewkepuasan($kepuasanInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Kepuasan updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Kepuasan updation failed');
                }
                
                redirect('kepuasan/kepuasanListing');
        }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($kepuasanId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($kepuasanId == null)
            {
                redirect('kepuasan/kepuasanListing');
            }
            
            $data['kepuasanInfo'] = $this->k->getkepuasanInfo($kepuasanId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Kepuasan';
            
            $this->loadViews("kepuasan/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editkepuasan()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
                $taskId = $this->input->post('taskId');
                $config['upload_path']          = './../public_html/img';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
                $config['overwrite']            = true;
                $config['max_size']             = 1024; // 1MB

                $this->load->library('upload', $config);                
                $this->upload->initialize($config);

                $data['error'] = $this->upload->display_errors();

                if (!$this->upload->do_upload('img')) {
                    // $ambilnama=$this->k->getkepuasanInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                $kepuasanInfo = array('puas'=>$namafile,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->k->editkepuasan($kepuasanInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Kepuasan updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Kepuasan updation failed');
                }
                
                redirect('kepuasan/kepuasanListing');
        }
    }

    function deletekepuasan()
    {
        if(!$this->hasUpdateAccess())
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $taskId = $this->input->post('id');
            $kepuasanInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->k->deletekepuasan($taskId, $kepuasanInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

       /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function delete($kepuasanId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($kepuasanId == null)
            {
                redirect('kepuasan/kepuasanListing');
            }
            $result = $this->k->deletekepuasan($kepuasanId);
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Data updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Data updation failed');
            }
        }
        redirect('kepuasan/kepuasanListing');
    }
}

?>