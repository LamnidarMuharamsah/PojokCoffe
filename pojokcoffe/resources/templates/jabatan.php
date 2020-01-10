<!-- Homepage content -->
<script type="text/javascript">
$(document).ready(function() {
    $('#dataTables-export').DataTable({
            responsive: true
        });
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    });
});
$(document).on('click','.update',function(){
    $('#myForm').trigger("reset");
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    
    $.post("jabatan.php?a=edit", {idx: idx}).done(function( data1 ) {
        var json = $.parseJSON(data1);
        console.log(json)
        $('[name="id_jabatan"]').val(json.id_jabatan);
        $('[name="deskripsi"]').val(json.deskripsi);
       $('[name="jabatan"]').val(json.jabatan);
       
        // $('[name="requester_institution"]').val(json.requester_institution);
       
    });
});
$(document).on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$(document).on('click','.delete',function(){
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    
    bootbox.confirm("Apakan anda yakin akan menghapus "+$(tr).find('td').eq(1).html()+"?", function(result){
        if (result) {
            $.post("jabatan.php?a=delete", {idx : idx}).done(function( data ) {
                if (data == '1'){
                    bootbox.alert("Data berhasil dihapus.", function(){
                        location.reload();
                    })
                } else {
                    bootbox.alert('Data gagal dihapus.');
                }
            });
        }else{
        }
    });
});
</script>
<div id="page-content-wrapper">
<h2><?=$pageTitle?></h2>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
              							echo $setInIndexDotPhp;

              						?>
                          <hr>
                        <br><br>
                         <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" style="padding: 4px" class="btn btn-sm btn-primary text-black">Tambah Jabatan</a>
                         <br><br>
                        <div class="table-responsive">
                            <table name="asd" class='table table-bordered table-hover table-striped' width="100%" id="dataTables-export">
                                <thead>
                                    <th>#</th>
                                    <th>Jabatan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    while($a=mysqli_fetch_array($jabatan)){
                                ?>
                                    <tr idx='<?=$a['id_jabatan']?>'><td><?=$i?></td><td><?=$a['jabatan']?></td><td><?=$a['deskripsi']?></td><td>
                                        <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" class="update btn btn-sm btn-white text-black"><i class="fa fa-pencil-square-o fa-lg"></i></a>  
                                        <a class="delete btn btn-sm btn-white text-red" href="javascript:;"><i class="fa fa-trash-o fa-lg"></i></a>
                                    </td></tr>
                                <?php
                                $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-admin" class="modal fade" role="dialog" style="display:none">
      <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><?php echo $pageTitle; ?> Form<br>
            <small>Tambah, Ubah dan hapus <?php echo $pageTitle; ?></small>
          </h4>

          </div>
          <div class="modal-body">
            <form name="form-<?php echo $title; ?>" id="myForm" method="POST" action="../public_html/jabatan.php?a=save_data" class=" form-horizontal">
            <div class="row">
                <div class="form-group required" style="margin-bottom: 20px">
                  <label class="col-sm-3 control-label">Jabatan</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="50" required name="jabatan" placeholder="Jabatan">
                  <input type="hidden" class="form-control" required id="id" name="id_jabatan" value=0>
                  
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Deskripsi</label>
                  <div class="col-sm-8">
                    <textarea name="deskripsi" class="form-control"></textarea>
                  </div>
                </div>
                
                
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Save"></button>
          </div>
          </form>
        </div>

      </div>
    </div>
