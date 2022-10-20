<?php
$taskId = $wilayahInfo->id;
$regollaki = $wilayahInfo->L;
$regolperem = $wilayahInfo->P;
$pakuwonlaki = $wilayahInfo->pL;
$pakuwonperem = $wilayahInfo->pP;
$paminggirlaki = $wilayahInfo->pmL;
$paminggirperem = $wilayahInfo->pmP;
$muarasandinglaki = $wilayahInfo->msL;
$muarasandingperem = $wilayahInfo->msP;
$jumlah_kk = $wilayahInfo->jumlah_kk;
$jumlah_total = $wilayahInfo->jumlah_total;
$rumah = $wilayahInfo->rumah;
$all1 = $wilayahInfo->all1;
$all2 = $wilayahInfo->all2;
$all3 = $wilayahInfo->all3;
$all4 = $wilayahInfo->all4;
$all5 = $wilayahInfo->all5;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Zona Wilayah dan Penduduk
        <small>Add / Edit</small>
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
                   <?php echo form_open_multipart('wilayah/editwilayah');?>
                    <div class="box-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label rowspan="2" for="Regol">Regol</label>
                                        <textarea class="form-control required" id="L" name="L"><?php echo $L; ?>Laki-laki</textarea>
                                        <br>
                                        <textarea class="form-control required" id="P" name="P"><?php echo $P; ?>Perempuan</textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                               
                                    <div class="form-group">
                                        <label for="Pakuwon">Pakuwon</label>
                                        <textarea class="form-control required" id="pL" name="pL"><?php echo $pL; ?></textarea>
                                        <br>
                                        <textarea class="form-control required" id="pP" name="pP"><?php echo $pP; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="Paminggir">Paminggir</label>
                                        <textarea class="form-control required" id="pmL" name="pmL"><?php echo $pmL; ?></textarea>
                                        <br>
                                        <textarea class="form-control required" id="pmP" name="pmP"><?php echo $pmP; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="Muarasanding">Muara Sanding</label>
                                        <textarea class="form-control required" id="msL" name="msL"><?php echo $msL; ?></textarea>
                                        <br>
                                        <textarea class="form-control required" id="msP" name="msP"><?php echo $msP; ?></textarea>
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="Rumah">Rumah</label>
                                        <textarea class="form-control required" id="rumah" name="rumah"><?php echo $rumah; ?></textarea>     
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="JumlahKK">Jumlah KK</label>
                                        <textarea class="form-control required" id="jumlahkk" name="jumlahkk"><?php echo $jumlah_kk; ?></textarea>   
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="jumlahtotal">Jumlah Total</label>
                                        <textarea class="form-control required" id="jumlahtotal" name="jumlahtotal"><?php echo $jumlah_total; ?></textarea>    
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="all1">Jumlah Total Laki-Laki</label>
                                        <textarea class="form-control required" id="all1" name="all1"><?php echo $all1; ?></textarea>    
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="all2">Jumlah Total Perempuan</label>
                                        <textarea class="form-control required" id="all2" name="all2"><?php echo $all2; ?></textarea>    
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="all3">Jumlah Total</label>
                                        <textarea class="form-control required" id="all3" name="all3"><?php echo $all3; ?></textarea>    
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="all4">Jumlah Total KK</label>
                                        <textarea class="form-control required" id="all4" name="all4"><?php echo $all4; ?></textarea>    
                                    </div>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="all5">Jumlah Total KK</label>
                                        <textarea class="form-control required" id="all5" name="all5"><?php echo $all5; ?></textarea>    
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