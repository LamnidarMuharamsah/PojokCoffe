<!-- Homepage content -->
<script type="text/javascript">
$(document).ready(function() {
    $('#dataTables-export').DataTable({
            responsive: true
        });
     var table= $('#dataTables-export2').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                
                {
                    extend:'print'
                  }
                
            ],

        } );
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    });
    $(".select2").select2();
    localStorage.clear();
    get_menu();
});
$(document).on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$(document).on('click','.add',function(){
   $('.transaksi-row').remove();
  tambahBahan();
});
// $(document).on('click','#btnPrint',function(){
//     printElement(document.getElementById("print"));
//     // printElement(document.getElementById("printThisToo"), true, "<hr />");
//     window.print();
// });
$(document).on('click','.view',function(){
    $('#myForm').trigger("reset");
    $('.save').hide();
    $('input').attr('readonly','readonly');
    
    var idx = $(this).closest('tr').attr('idx');
    var id = $(this).closest('tr').attr('id');
    var tr = $(this).closest('tr');
    var menu = localStorage.getItem('data_menu');
    $('.transaksi-row').remove();
    $.post("pembayaran.php?a=detail", {idx: id}).done(function( data1 ) {
      var json = $.parseJSON(data1);
      $('[name="kembalian"]').val(json.kembalian);
      $('[name="diskon"]').val(json.diskon);
      $('[name="bayar"]').val(json.bayar);
      $('[name="jml_bayar"]').val(json.total_bayar);
    });
    $.post("pembayaran.php?a=edit", {idx: idx}).done(function( data1 ) {
      var json = $.parseJSON(data1);
      console.log(json)
      $('[name="id_pemesanan"]').val(json.id_pemesanan);
      $('[name="no_meja"]').val(json.no_meja);
      $('[name="id_pegawai"]').val(json.id_pegawai);
      $.post("pembayaran.php?a=edit_detail", {idx: json.id_pemesanan}).done(function( data ) {
    // var json = $.parseJSON(data1.detail);
        var json = $.parseJSON(data);
        for (var i = 0; i < json.length; i++) {
             $('#tableBahan').append(
            '<tr class="transaksi-row"><td><select class="select2 form-control" style="width:100%" name="menu[]" disabled><option value="">select menu</option>'+menu+'</select></td>'+
            '<td><input type="text" class="form-control" readonly name="jumlah[]" value="" required><input type="hidden" class="form-control" value="'+json[i].id_detail_pemesanan+'" name="id_detail_pemesanan[]"></td>'+
            '<td><input type="text" class="form-control" name="harga[]" readonly value="" required></td>'+
            '<td><input type="text" class="form-control" name="subtotal[]" readonly value="" required></td></tr>'
          );
          $('[name^="menu"]').eq(i).val(json[i].id_menu).trigger('change');
          $('[name="jumlah[]"]').eq(i).val(json[i].jumlah).trigger('change');
        
        }
      });
        // $('[name="requester_institution"]').val(json.requester_institution);
       
    });
});
$(document).on('click','.update',function(){
    $('#myForm').trigger("reset");
    $('.save').show();

    $('[name="diskon"]').removeAttr('readonly');
    $('[name="bayar"]').removeAttr('readonly')
    var idx = $(this).closest('tr').attr('idx');
    var tr = $(this).closest('tr');
    var menu = localStorage.getItem('data_menu');
    $('.transaksi-row').remove();
    $.post("pembayaran.php?a=edit", {idx: idx}).done(function( data1 ) {
      var json = $.parseJSON(data1);
      console.log(json)
      $('[name="id_pemesanan"]').val(json.id_pemesanan);
      $('[name="no_meja"]').val(json.no_meja);
      $('[name="id_pegawai"]').val(json.id_pegawai);
      $.post("pembayaran.php?a=edit_detail", {idx: json.id_pemesanan}).done(function( data ) {
    // var json = $.parseJSON(data1.detail);
        var json = $.parseJSON(data);
        for (var i = 0; i < json.length; i++) {
             $('#tableBahan').append(
            '<tr class="transaksi-row"><td><select class="select2 form-control" style="width:100%" name="menu[]" disabled><option value="">select menu</option>'+menu+'</select></td>'+
            '<td><input type="text" class="form-control" readonly name="jumlah[]" value="" required><input type="hidden" class="form-control" value="'+json[i].id_detail_pemesanan+'" name="id_detail_pemesanan[]"></td>'+
            '<td><input type="text" class="form-control" name="harga[]" readonly value="" required></td>'+
            '<td><input type="text" class="form-control" name="subtotal[]" readonly value="" required></td></tr>'
          );
          $('[name^="menu"]').eq(i).val(json[i].id_menu).trigger('change');
          $('[name="jumlah[]"]').eq(i).val(json[i].jumlah).trigger('change');
          setTimeout(function() {

          console.log($('[name^="harga"]').eq(i).val());
          console.log($('[name^="jumlah"]').eq(i).val());
          }, 1000);
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
            $.post("pembayaran.php?a=delete", {idx : idx}).done(function( data ) {
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
function get_menu(){
  var list="";
  $.ajax({ type:'POST',url:"pembayaran.php?a=get_menu"}).done(function( data ) {
    var json = $.parseJSON(data);
      // json = response.student_list;
    // var ipkRange = "IPK Range "+response.total_sow['min_ipk']+" - "+response.total_sow['max_ipk'];
    // $('label[for=working_hour_in]').text(ipkRange);
    // var list="";
    // console.log(json);
    console.log(data)
    for (var i = 0; i < json.length; i++) {
      // console.log(json[i].id);
      list = list + '<option value="'+json[i].id_menu+'">'+json[i].nama+' </option>';
    }
    localStorage.setItem('data_menu', list);

    // initStudentList();
  });
}

$(document).on('change','[name="menu[]"]',function(){
  // var idx = $(this).closest('tr').attr('idx');
  var id = $(this).val();
  var n = $('[name="menu[]"]').index(this);
  if(id){
    $.post("pembayaran.php?a=get_menu_details", {id: id}).done(function( data ) {
      var json = $.parseJSON(data);
      // console.log(json)
      $('[name="harga[]"]').eq(n).val(json.harga);
      // $('[name="address"]').val(json.address);
      var harga = $('[name="harga[]"]').eq(n).val(),
  jumlah = $('[name="jumlah[]"]').eq(n).val(),
  total = Number(harga) * Number(jumlah),
  len = $('[name="jumlah[]"]').length,
    jml = 0;
   $('[name="subtotal[]"]').eq(n).val(total);
   for (var i = 0; i < len; i++) {
    jml = Number(jml) + Number($('[name="subtotal[]"]').eq(i).val());
   }
   $('[name="jml_bayar"]').val(jml);
    });
    
  }
  
  // alert();
  // $('[name="id"]').val(idx);
  // tambahTransaksi();

});
$(document).on('change','[name="jumlah[]"]',function(){
  // var idx = $(this).closest('tr').attr('idx');
  var val = $(this).val(),
      len = $('[name="jumlah[]"]').length,
    n = $('[name="jumlah[]"]').index(this),
    harga = $('[name="harga[]"]').eq(n).val(),
    total = Number(harga) * Number(val),
    jml = 0;
   $('[name="subtotal[]"]').eq(n).val(total);
   for (var i = 0; i < len; i++) {
    jml = Number(jml) + Number($('[name="subtotal[]"]').eq(i).val());
   }
   $('[name="jml_bayar"]').val(jml);
   console.log(len);
});
$(document).on('change','[name="diskon"]',function(){
  // var idx = $(this).closest('tr').attr('idx');
  $('[name^="jumlah"]').trigger('change');
  var val = $(this).val(),
   jml_bayar = $('[name="jml_bayar"]').val(),
    total = Number(jml_bayar)-(Number(jml_bayar) * Number(val)/100);
    $('[name="jml_bayar"]').val(total);
   
   // console.log(len);
});
$(document).on('change','[name="bayar"]',function(){
  // var idx = $(this).closest('tr').attr('idx');
  var val = $(this).val(),
   jml_bayar = $('[name="jml_bayar"]').val();
   if(Number(val)<Number(jml_bayar)){
    bootbox.alert('Jumlah uang yang dibayarkan kurang.');
    $(this).val('');
   }else{
    total =  Number(val) - Number(jml_bayar);
    $('[name="kembalian"]').val(total);
  }
   
   // console.log(len);
});
// function printElement(elem, append, delimiter) {
//     var domClone = elem.cloneNode(true);

//     var $printSection = document.getElementById("printSection");

//     if (!$printSection) {
//         $printSection = document.createElement("div");
//         $printSection.id = "printSection";
//         document.body.appendChild($printSection);
//     }

//     if (append !== true) {
//         $printSection.innerHTML = "";
//     }

//     else if (append === true) {
//         if (typeof (delimiter) === "string") {
//             $printSection.innerHTML += delimiter;
//         }
//         else if (typeof (delimiter) === "object") {
//             $printSection.appendChlid(delimiter);
//         }
//     }

//     $printSection.appendChild(domClone);
// }
</script>
<style type="text/css">
  


</style>
<div id="page-content-wrapper">
<h2><?=$pageTitle?></h2>
<div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                       
                         <!-- <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" style="padding: 4px" class="btn btn-sm btn-primary text-black add">Tambah Pemesanan</a> -->
                         <br><br>
                        <div class="table-responsive">
                            <table name="asd" class='table table-bordered table-hover table-striped' width="100%" id="dataTables-export2">
                                <thead>
                                    <th>#</th>
                                    <th>ID Pemesanan</th>
                                    <th>Diskon</th>
                                    <th>Total bayar</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Dibayar</th>
                                    <th>Uang Kembali</th>
                                    <th></th>
                                    
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    while($a=mysqli_fetch_array($pembayaran)){
                                ?>
                                    <tr id='<?=$a['id_pembayaran']?>' idx='<?=$a['id_pemesanan']?>'><td><?=$i?></td><td><?=$a['id_pemesanan']?><td><?=$a['diskon']?></td><td><?=$a['total_bayar']?></td><td><?=$a['tgl_pesan']?></td><td><?=$a['bayar']?></td><td><?=$a['kembalian']?></td><td>
                                        <a data-target="#modal-admin" data-backdrop="static" data-toggle="modal" class="view btn btn-sm btn-white text-black"><i class="fa fa-search fa-lg"></i></a>  
                                        <!-- <a class="delete btn btn-sm btn-white text-red" href="javascript:;"><i class="fa fa-trash-o fa-lg"></i></a> -->
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
          <div class="modal-body" id="print">
            <form name="form-<?php echo $title; ?>" id="myForm" method="POST" action="../public_html/pembayaran.php?a=save_data" class=" form-horizontal">
            <div class="row">
                <div class="form-group required" style="margin-bottom: 20px">
                  <label class="col-sm-3 control-label">No Meja</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" readonly="" maxlength="50" required name="no_meja" placeholder="No Meja">
                  <input type="hidden" class="form-control" required id="id" name="id_pemesanan" value=0>
                  <input type="hidden" class="form-control" required id="id" name="id_pegawai" value=<?=$_SESSION['petugas_id'];?>>
                  
                  </div>
                </div>
                <div class="form-group required" style="margin-bottom: 20px">
                  <label class="col-sm-3 control-label">ID Pemesanan</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" readonly="" maxlength="50" required name="id_pemesanan" placeholder="No Meja">
                  
                  </div>
                </div>
                
               
            
                
                <div class="col-lg-12">
                  <table class="table table-striped table-bordered" id="tableBahan" width="100%">
                    <tr><td width="40%">Menu</td><td width="10%">Jumlah</td><td width="20%">Harga</td><td>Sub Total</td></tr>
                    
                  </table>
                  <!-- <label class="col-sm-3 control-label pull-right">Total Bayar</label> -->
                  <div class="form-group required" style="margin-bottom: 20px">
                    <div class="col-sm-3 pull-right">
                      <input type="text" class="form-control " maxlength="50" required readonly name="jml_bayar" >
                    </div>
                    <div class="col-sm-3 pull-right">
                      <input type="number" class="form-control " max="100" required placeholder="Diskon" name="diskon" >
                    </div>
                  </div>
                  <div class="form-group required" style="margin-bottom: 20px">
                    <div class="col-sm-3 pull-right">
                      <input type="number" class="form-control " maxlength="50" required name="bayar" >
                    </div>
                    <label class="col-sm-3 control-label pull-right">Bayar</label>
                  </div>
                  <div class="form-group required" style="margin-bottom: 20px">
                    <div class="col-sm-3 pull-right">
                      <input type="number" class="form-control " readonly="" maxlength="50" required name="kembalian" >
                    </div>
                    <label class="col-sm-3 control-label pull-right">Kembalian</label>
                  </div>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-default print" id="btnPrint">Print</button> -->
            <input type="submit" class="btn btn-primary save" value="Save">
          </div>
          </form>
        </div>

      </div>
    </div>
