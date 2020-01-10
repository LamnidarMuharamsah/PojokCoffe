<!-- Homepage content -->
<script type="text/javascript">
$(document).ready(function() {
    $('#dataTables-export').DataTable({
            responsive: true
        });
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    });
    $(".select2").select2();
    // localStorage.clear();
    // get_bahan();
});
$(document).on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$(document).on('click','.add',function(){
  $('.transaksi-row').remove();
  tambahBahan();
});
$(document).on('click','.update',function(){
    $('#myForm').trigger("reset");
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    $('.transaksi-row').remove();
    $.post("kuisioner.php?a=edit", {idx: idx}).done(function( data1 ) {
      var json = $.parseJSON(data1);
      console.log(json)
      $('[name="id_kuisioner"]').val(json.id_kuisioner);
      $('[name="judul_kuisioner"]').val(json.judul_kuisioner);
      $('[name="tgl_selesai"]').val(json.tgl_selesai);
      $('[name="id_pegawai"]').val(json.id_pegawai);
      $.post("kuisioner.php?a=edit_detail", {idx: json.id_kuisioner}).done(function( data ) {
    // var json = $.parseJSON(data1.detail);
        var json = $.parseJSON(data);
        for (var i = 0; i < json.length; i++) {
             $('#tableBahan').append(
            '<tr class="transaksi-row"><td><input type="text" class="form-control" name="pertanyaan[]" value="'+json[i].pertanyaan+'" disabled required><input type="hidden" class="form-control" value="'+json[i].id_pertanyaan+'" name="id_pertanyaan[]"></td>'+
            '<td><input type="radio" name="'+json[i].id_pertanyaan+'" value="1"></td>'+
            '<td><input type="radio" name="'+json[i].id_pertanyaan+'" value="2"></td>'+
            '<td><input type="radio" name="'+json[i].id_pertanyaan+'" value="3"></td>'+
            '<td><input type="radio" name="'+json[i].id_pertanyaan+'" value="4"></td>'+
            '<td><input type="radio" name="'+json[i].id_pertanyaan+'" value="5"></td>'+
            '</tr>'
          );
        }
      });
        // $('[name="requester_institution"]').val(json.requester_institution);
       
    });
});
$(document).on('click','.delete',function(){
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    
    bootbox.confirm("Apakan anda yakin akan menghapus "+$(tr).find('td').eq(1).html()+"?", function(result){
        if (result) {
            $.post("kuisioner.php?a=delete", {idx : idx}).done(function( data ) {
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

function hapusBahan(el){
  var idx = $(el).closest('tr').find('[name="id_pertanyaan[]"]').val();
  // var kode = $(el).closest('tr').find('[name="bahan[]"]').val();
  if(idx == 0){
    $(el).parent().parent().remove();
  }else{
    bootbox.confirm("Apakan anda yakin akan menghapus pertanyaan?", function(result){
      if (result) {
        $.post("kuisioner.php?a=delete_detail", {idx : idx}).done(function( data ) {
          if (data == '1'){
            bootbox.alert("Data berhasil dihapus.", function(){
              $(el).parent().parent().remove();
            })
          } else {
            bootbox.alert('Data gagal dihapus.');
          }
        });
      }else{
      }
    });
  }
}
function tambahBahan(){
  // $(".select2").select2();
  // var bahan = localStorage.getItem('data_bahan');
  $('#tableBahan').append(
    '<tr class="transaksi-row"><td><input type="text" class="form-control" name="pertanyaan[]" required><input type="hidden" class="form-control" value="0" name="id_pertanyaan[]"></td>'+
    '<td>'+
    '<a class="btn btn-sm btn-white text-black" onclick="tambahBahan();"><i class="fa fa-plus-square-o fa-lg"></i></a>'+ 
    '<a class="btn btn-sm btn-white text-black" onclick="hapusBahan(this);"><i class="fa fa-minus-square-o fa-lg"></i></a>'+ 
    '</td></tr>'
  );
  $(".select2").select2({
    placeholder: "pilih bahan"
  });
}
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
                        
                         <br><br>
                        <div class="table-responsive">
                            <table name="asd" class='table table-bordered table-hover table-striped' width="100%" id="dataTables-export">
                                <thead>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th></th>
                                    
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    while($a=mysqli_fetch_array($kuisioner)){
                                ?>
                                    <tr idx='<?=$a['id_kuisioner']?>'><td><?=$i?></td><td><?=$a['judul_kuisioner']?></td><td><?=$a['tgl_kuisioner']?></td><td><?=$a['tgl_selesai']?></td><td>
                                        <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" class="update btn btn-sm btn-white text-black"><i class="fa fa-pencil fa-lg"></i></a>  
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
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><?php echo $pageTitle; ?> Form<br>
            <small>Tambah, Ubah dan hapus <?php echo $pageTitle; ?></small>
          </h4>

          </div>
          <div class="modal-body">
            <form name="form-<?php echo $title; ?>" id="myForm" method="POST" action="../public_html/kuisioner.php?a=save_data_jawaban" class=" form-horizontal">
            <div class="row">
                <div class="form-group required" style="margin-bottom: 20px">
                  <div class="col-sm-8">
                  <input type="hidden" class="form-control" maxlength="50" required name="id_pegawai" value="<?=$_SESSION['petugas_id']?>">
                  <input type="hidden" class="form-control" required id="id" name="id_kuisioner" value=0>
                  
                  </div>
                </div>
               
               
                 <div class="form-group required">
                  <label class="col-sm-3 control-label">Judul</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" disabled="" maxlength="50" required name="judul_kuisioner" placeholder="Judul">
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Tanggal Selesai</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control datepicker" disabled="" maxlength="50" required name="tgl_selesai" placeholder="Tanggal Selesai">
                  </div>
                </div>
                
                <div class="col-lg-12">
                  <table class="table table-striped table-bordered" id="tableBahan" width="100%">
                    <tr><td width="80%">Pertanyaan</td><td>Sangat Baik</td><td> Baik</td><td>Cukup Baik</td><td>Buruk</td><td>Sangat Buruk</td></tr>
                    
                  </table>
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
