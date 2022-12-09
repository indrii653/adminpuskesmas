<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Task (TaskController)
 * Task Class to control task related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 19 Jun 2022
 */
class Penghargaan extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Penghargaan_model', 'p');
        $this->isLoggedIn();
        $this->module = 'Penghargaan';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('penghargaan/penghargaanListing');
    }
    
    /**
     * This function is used to load the task list
     */
    function penghargaanListing()
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
            
            $count = $this->p->penghargaanListingCount($searchText);

			$returns = $this->paginationCompress ( "penghargaanListing/", $count, 10 );
            
            $data['records'] = $this->p->penghargaanListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : Penghargaan';
            
            $this->loadViews("penghargaan/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'CodeInsect : Add New Penghargaan';

            $this->loadViews("penghargaan/add", $this->global, NULL, NULL);
        }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewpenghargaan()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            
            $config['upload_path']          = './../public_html/img/blog/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
            $config['overwrite']            = true;
            $config['max_size']             = 1024; // 1MB

            $this->load->library('upload', $config);                
            $this->upload->initialize($config);

            $data['error'] = $this->upload->display_errors();

            if (!$this->upload->do_upload('img')) {
                // $ambilnama=$this->p->getpenghargaanInfo($taskId);                 
                // $namafile = $ambilnama->img;
                echo $this->upload->display_errors();
            } else {
                $uploaded_data = $this->upload->data();
                $namafile = $uploaded_data['file_name'];
            }
                $judul1 = $this->security->xss_clean($this->input->post('judul1'));
                $p1 = $this->security->xss_clean($this->input->post('p1'));
                
                $penghargaanInfo = array('penghargaan'=>$namafile, 'judul1'=>$judul1,'p1'=>$p1,'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                $result = $this->p->addNewpenghargaan($penghargaanInfo);

                if($result > 0) {
                    $this->session->set_flashdata('success', 'New penghargaan created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Penghargaan creation failed');
                }
                
                redirect('penghargaan/penghargaanListing');
            }
    }

    
    /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function edit($penghargaanId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($penghargaanId == null)
            {
                redirect('penghargaan/penghargaanListing');
            }
            
            $data['penghargaanInfo'] = $this->p->getpenghargaanInfo($penghargaanId);

            $this->global['pageTitle'] = 'CodeInsect : Edit Penghargaan';
            
            $this->loadViews("penghargaan/edit", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editpenghargaan()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
                $taskId = $this->input->post('taskId');
                $config['upload_path']          = './../public_html/img/blog/';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['file_name']            = md5(date('Y-m-d H:i:s:u'));
                $config['overwrite']            = true;
                $config['max_size']             = 1024; // 1MB

                $this->load->library('upload', $config);                
                $this->upload->initialize($config);

                $data['error'] = $this->upload->display_errors();

                if (!$this->upload->do_upload('img')) {
                    // $ambilnama=$this->p->getpenghargaanInfo($taskId);                 
                    // $namafile = $ambilnama->img;
                    echo $this->upload->display_errors();
                } else {
                    $uploaded_data = $this->upload->data();
                    $namafile = $uploaded_data['file_name'];
                }
                
                $penghargaan = $this->security->xss_clean($this->input->post('penghargaan'));
                $judul1 = $this->security->xss_clean($this->input->post('judul1'));
                $p1 = $this->security->xss_clean($this->input->post('p1'));
                
                $penghargaanInfo = array('penghargaan'=>$namafile, 'judul1'=>$judul1,'p1'=>$p1, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->p->editpenghargaan($penghargaanInfo, $taskId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Penghargaan updated successfully');
                    // $this->session->set_flashdata('success', $this->upload->display_errors().$config['upload_path']);
                }
                else
                {
                    $this->session->set_flashdata('error', 'Penghargaan updation failed');
                }
                
                redirect('penghargaan/penghargaanListing');
        }
    }

    
    function deletepenghargaan()
    {
        if(!$this->hasUpdateAccess())
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $taskId = $this->input->post('id');
            $penghargaanInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->p->deletepenghargaan($taskId, $penghargaanInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

       /**
     * This function is used load task edit information
     * @param number $taskId : Optional : This is task id
     */
    function delete($penghargaanId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($penghargaanId == null)
            {
                redirect('penghargaan/penghargaanListing');
            }
            $result = $this->p->deletepenghargaan($penghargaanId);
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Data updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Data updation failed');
            }
        }
        redirect('penghargaan/penghargaanListing');
    }
}


?>