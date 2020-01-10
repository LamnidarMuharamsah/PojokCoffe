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
    localStorage.clear();
    get_bahan();
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
    var bahan = localStorage.getItem('data_bahan');
    $('.transaksi-row').remove();
    $.post("menu.php?a=edit", {idx: idx}).done(function( data1 ) {
      var json = $.parseJSON(data1);
      console.log(json)
      $('[name="id_menu"]').val(json.id_menu);
      $('[name="nama"]').val(json.nama);
      $('[name="jenis"]').val(json.jenis);
      $('[name="harga"]').val(json.harga);
      $.post("menu.php?a=edit_detail", {idx: json.id_menu}).done(function( data ) {
    // var json = $.parseJSON(data1.detail);
        var json = $.parseJSON(data);
        for (var i = 0; i < json.length; i++) {
             $('#tableBahan').append(
            '<tr class="transaksi-row"><td><select class="select2 form-control" style="width:100%" name="bahan[]"><option value="">select bahan</option>'+bahan+'</select></td>'+
            '<td><input type="text" class="form-control" name="jumlah[]" value="'+json[i].jumlah_bahan+'" required><input type="hidden" class="form-control" value="'+json[i].id_detail_bahan+'" name="id_detail_bahan[]"></td><td><input type="text" class="form-control" value="'+json[i].ket+'" name="ket[]"></td>'+
            '<td>'+
            '<a class="btn btn-sm btn-white text-black" onclick="tambahBahan();"><i class="fa fa-plus-square-o fa-lg"></i></a>'+ 
            '<a class="btn btn-sm btn-white text-black" onclick="hapusBahan(this);"><i class="fa fa-minus-square-o fa-lg"></i></a>'+ 
            '</td></tr>'
          );
          $('[name^="bahan"]').eq(i).val(json[i].id_bahan).trigger('change');
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
            $.post("menu.php?a=delete", {idx : idx}).done(function( data ) {
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
function get_bahan(){
  var list="";
  $.ajax({ type:'POST',url:"menu.php?a=get_bahan"}).done(function( data ) {
    var json = $.parseJSON(data);
      // json = response.student_list;
    // var ipkRange = "IPK Range "+response.total_sow['min_ipk']+" - "+response.total_sow['max_ipk'];
    // $('label[for=working_hour_in]').text(ipkRange);
    // var list="";
    // console.log(json);
    console.log(data)
    for (var i = 0; i < json.length; i++) {
      // console.log(json[i].id);
      list = list + '<option value="'+json[i].id_bahan+'">'+json[i].nama+' - '+json[i].stok+'</option>';
    }
    localStorage.setItem('data_bahan', list);

    // initStudentList();
  });
}
function hapusBahan(el){
  var idx = $(el).closest('tr').find('[name="id_detail_bahan[]"]').val();
  var kode = $(el).closest('tr').find('[name="bahan[]"]').val();
  if(idx == 0){
    $(el).parent().parent().remove();
  }else{
    bootbox.confirm("Apakan anda yakin akan menghapus bahan?", function(result){
      if (result) {
        $.post("menu.php?a=delete_detail", {idx : idx}).done(function( data ) {
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
  var bahan = localStorage.getItem('data_bahan');
  $('#tableBahan').append(
    '<tr class="transaksi-row"><td><select class="select2 form-control" style="width:100%" name="bahan[]"><option value="">select bahan</option>'+bahan+'</select></td>'+
    '<td><input type="text" class="form-control" name="jumlah[]" required><input type="hidden" class="form-control" value="0" name="id_detail_bahan[]"></td><td><input type="text" class="form-control" name="ket[]"></td>'+
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
                         <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" style="padding: 4px" class="btn btn-sm btn-primary text-black add">Tambah Menu</a>
                         <br><br>
                        <div class="table-responsive">
                            <table name="asd" class='table table-bordered table-hover table-striped' width="100%" id="dataTables-export">
                                <thead>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th></th>
                                    
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    while($a=mysqli_fetch_array($menu)){
                                ?>
                                    <tr idx='<?=$a['id_menu']?>'><td><?=$i?></td><td><?=$a['nama']?></td><td><?=$a['jenis']?></td><td><?=$a['harga']?></td><td>
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
            <form name="form-<?php echo $title; ?>" id="myForm" method="POST" action="../public_html/menu.php?a=save_data" class=" form-horizontal">
            <div class="row">
                <div class="form-group required" style="margin-bottom: 20px">
                  <label class="col-sm-3 control-label">Nama</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" maxlength="50" required name="nama" placeholder="Nama">
                  <input type="hidden" class="form-control" required id="id" name="id_menu" value=0>
                  
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label">Jenis</label>
                  <div class="col-sm-8">
                    <select name="jenis" class="form-control" required="">
                      <option value="Minuman">Minuman</option>
                      <option value="Dessert">Dessert</option>
                      <option value="Main Course">Main Course</option>
                      <option value="Appetizer">Appetizer</option>
                    </select>
                  </div>
                </div>
               
               
                 <div class="form-group required">
                  <label class="col-sm-3 control-label">Harga</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" maxlength="50" required name="harga" placeholder="Harga">
                  </div>
                </div>
                
                <div class="col-lg-12">
                  <table class="table table-striped table-bordered" id="tableBahan" width="100%">
                    <tr><td width="40%">Bahan Baku</td><td width="10%">Jumlah</td><td width="30%">Keterangan</td><td></td></tr>
                    
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
