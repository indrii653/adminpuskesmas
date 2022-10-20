<?php
$taskId = $mediaInfo->id;
$facebook = $mediaInfo->facebook;
$instagram = $mediaInfo->instagram;
$youtube = $mediaInfo->youtube;
$kantor = $mediaInfo->kantor;
$layanan = $mediaInfo->layanan;
$email = $mediaInfo->email;
$website = $mediaInfo->website;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Media UPT Puskesmas Siliwangi Garut
        <small>Add / Edit </small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Masukan Data</h3>
                    </div><!-- /.box-header -->
                   <!-- form start -->
                   <?php $this->load->helper("form"); ?>
                     
                   <form role="form" action="<?php echo base_url() ?>media/editmedia" method="post" id="editmedia" role="form">                       
                   <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                               
                                    <div class="form-group">
                                        <label for="facebook">Facebook</label>
                                        <textarea class="form-control required" id="facebook" name="facebook"><?php echo $facebook; ?></textarea>
                                        <input type="hidden" value="<?php echo $taskId; ?>" name="id" id="id" />
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="instagram">Instagram</label>
                                        <input type="text" class="form-control required" value="<?php echo $instagram; ?>" id="instagram" name="instagram" maxlength="256" />
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="youtube">Youtube</label>
                                        <input type="text" class="form-control required" value="<?php echo $youtube; ?>" id="youtube" name="youtube" maxlength="256" />
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="kantor">Nomor Kantor</label>
                                        <input type="text" class="form-control required" value="<?php echo $kantor; ?>" id="kantor" name="kantor" maxlength="256" />
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="layanan">Layanan Pengaduan</label>
                                        <input type="text" class="form-control required" value="<?php echo $layanan; ?>" id="layanan" name="layanan" maxlength="256" />
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="text" class="form-control required" value="<?php echo $email; ?>" id="email" name="email" maxlength="256" />
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" class="form-control required" value="<?php echo $website; ?>" id="website" name="website" maxlength="256" />
                                    </div>   
                                </div>
                            </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>