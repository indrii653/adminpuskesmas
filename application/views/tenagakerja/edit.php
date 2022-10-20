<?php
$taskId = $tenagaInfo->id;
$dokter = $tenagaInfo->dokter;
$perawat = $tenagaInfo->perawat;
$bidan = $tenagaInfo->bidan;
$farmasi = $tenagaInfo->farmasi;
$gizi = $tenagaInfo->gizi;
$laboratorium = $tenagaInfo->laboratorium;
$keling = $tenagaInfo->keling;
$tu = $tenagaInfo->tu;
$promotor = $tenagaInfo->promotor;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Jumlah Data Pegawai UPT Puskesmas Siliwangi
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
                   <form role="form" action="<?php echo base_url() ?>tenagakerja/edittenaga" method="post" id="edittenaga" role="form">                       
                       <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="dokter">Dokter</label>
                                        <textarea class="form-control required" id="dokter" name="dokter"><?php echo $dokter; ?></textarea>
                                        <input type="hidden" value="<?php echo $taskId; ?>" name="id" id="id" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="perawat">Perawat</label>
                                        <textarea class="form-control required" id="perawat" name="perawat"><?php echo $perawat; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="bidan">Bidan</label>
                                        <textarea class="form-control required" id="bidan" name="bidan"><?php echo $bidan; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="farmasi">Farmasi</label>
                                        <textarea class="form-control required" id="farmasi" name="farmasi"><?php echo $farmasi; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="gizi">Gizi</label>
                                        <textarea class="form-control required" id="gizi" name="gizi"><?php echo $gizi; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="laboratorium">Laboratorium</label>
                                        <textarea class="form-control required" id="laboratorium" name="laboratorium"><?php echo $laboratorium; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="keling">Kesehatan Keliling</label>
                                        <textarea class="form-control required" id="keling" name="keling"><?php echo $keling; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="tu">Tata Usaha</label>
                                        <textarea class="form-control required" id="tu" name="tu"><?php echo $tu; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="promotor">Promotor Kesehatan</label>
                                        <textarea class="form-control required" id="promotor" name="promotor"><?php echo $promotor; ?></textarea>
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
                    <div class="col-md-3">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>