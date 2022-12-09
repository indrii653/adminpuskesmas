<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Blog extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Blog_model', 'bl');
        $this->isLoggedIn();
        $this->module = 'Blog';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('blog/blogListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function blogListing()
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
            
            $count = $this->bl->blogListingCount($searchText);

			$returns = $this->paginationCompress ( "blogListing/", $count, 10 );
            
            $data['records'] = $this->bl->blogListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Blog';
            
            $this->loadViews("blog/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Blog';

            $this->loadViews("blog/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewblog()
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

            if (!$this->upload->do_upload('foto')) {
                // $ambilnama=$this->bl->getBlogInfo($taskId);                 
                // $namafile = $ambilnama->foto;
                echo $this->upload->display_errors();
            } else {
                $uploaded_data = $this->upload->data();
                $namafile = $uploaded_data['file_name'];
            }

            $judul = $this->security->xss_clean($this->input->post('judul'));
            $p1 = $this->security->xss_clean($this->input->post('p1'));
            $p2 = $this->security->xss_clean($this->input->post('p2'));
            
            $blogInfo = array('judul'=>$judul, 'p1'=>$p1,'p2'=>$p,'foto'=>$namafile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->bl->editBlog($blogInfo, $taskId);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Blog updated successfully');
                // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
            }
            else
            {
                $this->session->set_flashdata('error', 'Blog updation failed');
            }
            
            redirect('blog/blogListing');

            }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($blogId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($blogId == null)
            {
                redirect('blog/blogListing');
            }
            
            $data['blogInfo'] = $this->bl->getblogInfo($blogId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Blog';
            
            $this->loadViews("blog/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editblog()
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

                if (!$this->upload->do_upload('foto')) {
                    // $ambilnama=$this->bl->getBlogInfo($taskId);                 
                    // $namafile = $ambilnama->foto;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }

                $judul = $this->security->xss_clean($this->input->post('judul'));
                $p1 = $this->security->xss_clean($this->input->post('p1'));
                $p2 = $this->security->xss_clean($this->input->post('p2'));
                
                $blogInfo = array('judul'=>$judul, 'p1'=>$p1,'p2'=>$p,'foto'=>$namafile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->bl->editBlog($blogInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Blog updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Blog updation failed');
                }
                
                redirect('blog/blogListing');
        }
    }
}

?>