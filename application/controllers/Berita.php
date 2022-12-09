<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Berita extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Berita_model', 'b');
        $this->isLoggedIn();
        $this->module = 'Berita';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('berita/beritaListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function beritaListing()
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
            
            $count = $this->b->beritaListingCount($searchText);

			$returns = $this->paginationCompress ( "beritaListing/", $count, 10 );
            
            $data['records'] = $this->b->beritaListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Berita';
            
            $this->loadViews("berita/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Berita';

            $this->loadViews("berita/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewberita()
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

                if (!$this->upload->do_upload('latar')) {
                    // $ambilnama=$this->b->getBeritaInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }
                $tgl = $this->security->xss_clean($this->input->post('tgl'));
                $judul = $this->security->xss_clean($this->input->post('judul'));
                $deskripsi = $this->security->xss_clean($this->input->post('deskripsi'));
                
                $beritaInfo = array('latar'=>$namafile, 'tgl'=>$tgl,'judul'=>$judul,'deskripsi'=>$deskripsi, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->b->addNewberita($beritaInfo);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Berita updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Berita updation failed');
                }
                
                redirect('berita/beritaListing');
            }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($beritaId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($beritaId == null)
            {
                redirect('berita/beritaListing');
            }
            
            $data['beritaInfo'] = $this->b->getBeritaInfo($beritaId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Berita';
            
            $this->loadViews("berita/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editberita()
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
                    // $ambilnama=$this->b->getBeritaInfo($taskId);                 
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

                $beritaInfo = array('latar'=>$namafile, 'tgl'=>$tgl,'judul'=>$judul,'deskripsi'=>$deskripsi, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->b->editberita($beritaInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Berita updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Berita updation failed');
                }
                
                redirect('berita/beritaListing');
        }
    }
}

?>