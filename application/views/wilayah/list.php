<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Zona Wilayah dan Penduduk
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>task/add"><i class="fa fa-plus"></i> Masukan Data</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Zona Wilayah dan Penduduk</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>task/taskListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <?php
                    foreach($records as $record):
                    ?>
                  <table class="table table-hover">
                                        <tr> 
                                            <th rowspan="2" class="align-middle text-center">Nama Puskesmas</th>
                                            <th rowspan="2" class="align-middle text-center">Kecamatan</th>
                                            <th rowspan="2" class="align-middle text-center">Kelurahan</th>
                                            <th colspan="2" class="align-middle text-center">Jumlah Penduduk</th>
                                            <th rowspan="2" class="align-middle text-center">Jumlah Total</th>
                                            <th rowspan="2" class="align-middle text-center">Jumlah KK</th>
                                            <th rowspan="2" class="align-middle text-center">Rumah</th>
                                            <th rowspan="2" class="align-middle text-center">Edit</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center">L</th>
                                            <th class="align-middle text-center">P</th>
                                        </tr>
                                        <tr>
                                            <td rowspan="4">UPT PUSKESMAS SILIWANGI</td>
                                            <td rowspan="4">GARUT KOTA</td>
                                            <td>REGOL</td>
                                            <td><?=$record->L?></td>
                                            <td><?=$record->P?></td>
                                            <td><?=$record->jumlah_total?></td>
                                            <td><?=$record->jumlah_kk?></td>
                                            <td><?=$record->rumah?></td>
                                            <td  rowspan="5" class="text-center">
                                                <a class="btn btn-sm btn-info" href="<?php echo base_url().'wilayah/edit/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PAKUWON</td>
                                            <td><?=$record->pL?></td>
                                            <td><?=$record->pP?></td>
                                            <td>5.652</td>
                                            <td><?=$record->jumlah_kk?></td>
                                            <td>1.640</td>
                                        </tr>
                                        <tr>
                                            <td>PAMINGGIR</td>
                                            <td><?=$record->pmL?></td>
                                            <td><?=$record->pmP?></td>
                                            <td>9.184</td>
                                            <td><?=$record->jumlah_kk?></td>
                                            <td>2.664</td>
                                        </tr>
                                        <tr>
                                            <td>MUARA SANDING</td>
                                            <td><?=$record->msL?></td>
                                            <td><?=$record->msP?></td>
                                            <td>9.892</td>
                                            <td><?=$record->jumlah_kk?></td>
                                            <td>3.133</td>
                                        </tr>
                                        <tr>
                                        <td colspan="3" class="align-middle text-center">JUMLAH TOTAL</td>
                                            <td><?=$record->all1?></td>
                                            <td><?=$record->all2?></td>
                                            <td><?=$record->all3?></td>
                                            <td><?=$record->all4?></td>
                                            <td><?=$record->all5?></td>
                                        </tr>
                  </table>
                  <?php
                  endforeach;
                  ?>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "wilayah/wilayahListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
