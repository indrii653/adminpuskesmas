<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Zona extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('zona_model', 'b');
        $this->isLoggedIn();
        $this->module = 'zona';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('zona/zonaListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function zonaListing()
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
            
            $count = $this->b->zonaListingCount($searchText);

			$returns = $this->paginationCompress ( "zonaListing/", $count, 10 );
            
            $data['records'] = $this->b->zonaListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : zona';
            
            $this->loadViews("zona/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New zona';

            $this->loadViews("zona/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewzona()
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
                    // $ambilnama=$this->b->getzonaInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                $latar = $this->security->xss_clean($this->input->post('latar'));
                $tgl = $this->security->xss_clean($this->input->post('tgl'));
                $judul = $this->security->xss_clean($this->input->post('judul'));
                $deskripsi = $this->security->xss_clean($this->input->post('deskripsi'));
                
                $zonaInfo = array('latar'=>$namafile, 'tgl'=>$tgl,'judul'=>$judul,'deskripsi'=>$deskripsi, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->b->editzona($zonaInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Zona updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zona updation failed');
                }
                
                redirect('zona/zonaListing');
            }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($zonaId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($zonaId == null)
            {
                redirect('zona/zonaListing');
            }
            
            $data['zonaInfo'] = $this->b->getzonaInfo($zonaId);

            $this->global['pageTitle'] = 'CodeInsect : Edit zona';
            
            $this->loadViews("zona/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editzona()
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
                    // $ambilnama=$this->b->getzonaInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                $latar = $this->security->xss_clean($this->input->post('latar'));
                $tgl = $this->security->xss_clean($this->input->post('tgl'));
                $judul = $this->security->xss_clean($this->input->post('judul'));
                $deskripsi = $this->security->xss_clean($this->input->post('deskripsi'));

                $zonaInfo = array('latar'=>$namafile, 'tgl'=>$tgl,'judul'=>$judul,'deskripsi'=>$deskripsi, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->b->editzona($zonaInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Zona updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Zona updation failed');
                }
                
                redirect('zona/zonaListing');
        }
    }
}

?>