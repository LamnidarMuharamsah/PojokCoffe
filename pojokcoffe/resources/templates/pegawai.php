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
$(document).on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$(document).on('click','.update',function(){
    $('#myForm').trigger("reset");
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    $('#active').show();
    $('.password').hide();
    
    $.post("pegawai.php?a=edit", {idx: idx}).done(function( data1 ) {
        var json = $.parseJSON(data1);
        console.log(json)
        $('[name="id_pegawai"]').val(json.id_pegawai);
        $('[name="username"]').val(json.username);
        $('[name="nama"]').val(json.nama);
        $('[name="email"]').val(json.email);
        $('[name="tempat_lahir"]').val(json.tempat_lahir);
        $('[name="jabatan"]').val(json.id_jabatan).trigger('change');

        $('[name="tgl_lahir"]').val(json.tgl_lahir);
        $('[name="image_name"]').val(json.foto);
        $('[name="alamat"]').val(json.alamat);
        $('[name="password"]').val(json.password);
        // $('[name="requester_institution"]').val(json.requester_institution);
       
    });
});
$(document).on('click','.delete',function(){
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    
    bootbox.confirm("Apakan anda yakin akan menghapus "+$(tr).find('td').eq(1).html()+"?", function(result){
        if (result) {
            $.post("pegawai.php?a=delete", {idx : idx}).done(function( data ) {
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
                         <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" style="padding: 4px" class="btn btn-sm btn-primary text-black">Tambah Pegawai</a>
                         <br><br>
                        <div class="table-responsive">
                            <table name="asd" class='table table-bordered table-hover table-striped' width="100%" id="dataTables-export">
                                <thead>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Tempat Lahir</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    while($a=mysqli_fetch_array($pegawai)){
                                ?>
                                    <tr idx='<?=$a['id_pegawai']?>'><td><?=$i?></td><td><?=$a['nama']?></td><td><?=$a['tgl_lahir']?></td><td><?=$a['tempat_lahir']?></td><td><?=$a['alamat']?></td><td>
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
            <form name="form-<?php echo $title; ?>" id="myForm" method="POST" action="../public_html/pegawai.php?a=save_data" class=" form-horizontal">
            <div class="row">
                <div class="form-group required" style="margin-bottom: 20px">
                  <label class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="50" required name="nama" placeholder="Nama">
                  <input type="hidden" class="form-control" required id="id" name="id_pegawai" value=0>
                  
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Alamat</label>
                  <div class="col-sm-8">
                    <textarea name="alamat" class="form-control"></textarea>
                  </div>
                </div>
                <!-- <div class="form-group required">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                  <input type="email" class="form-control" maxlength="50" required name="email" placeholder="Email">
                  </div>
                </div> -->
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Tempat Lahir</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="50" required name="tempat_lahir" placeholder="Tempat Lahir">
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Tanggal Lahir</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control datepicker" maxlength="50" required name="tgl_lahir" placeholder="Tanggal Lahir (yyyy-mm-dd)">
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Jenis Kelamin</label>
                  <div class="col-sm-8">
                  <select name="jk" class="form-control" required="">
                   <option value="L">Laki - laki</option>
                   <option value="P">Perempuan</option>
                  </select>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Jabatan</label>
                  <div class="col-sm-8">
                  <select name="jabatan" class="form-control" required="">
                  <option value="">Pilih Jabatan</option>
                  <?php
                    while($b=mysqli_fetch_array($jabatan)){
                    ?>
                   <option value="<?=$b['id_jabatan']?>"><?=$b['jabatan']?></option>
                  <?php } ?>
                  </select>
                  </div>
                </div>
                 <div class="form-group required">
                  <label class="col-sm-3 control-label">Username</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="50" required name="username" placeholder="Username">
                  </div>
                </div>
                 <div class="form-group password required">
                  <label class="col-sm-3 control-label">Password</label>
                  <div class="col-sm-8">
                  <input type="password" class="form-control" maxlength="50" required name="password" id="password" placeholder="Password">
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
