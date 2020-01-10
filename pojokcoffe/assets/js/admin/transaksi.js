$(document).on('click','.transaksi',function(){
	// var idx = $(this).closest('tr').attr('idx');
	// alert();
	// $('[name="id"]').val(idx);
	$('[name="jml_bayar"]').val(0);
	$('.transaksi-row').remove();
	$('.save').show();
	tambahTransaksi();
});
$(document).on('click','.detail',function(){
	$('.save').hide();
	var idx = $(this).closest('tr').attr('idx');

	$('[name="jml_bayar"]').val(0);
	$('.transaksi-row').remove();
	$.post( base_url+"admin/transaksi/get_transaksi", {idx: idx}).done(function( data1 ) {
		// var json = $.parseJSON(data1.detail);
		var json = $.parseJSON(data1);
		for (var i = 0; i < json.detail.length; i++) {
			$('#tabel-transaksi').append(
			'<tr class="transaksi-row"><td><input type="obat" class="form-control" disabled name="obat[]" value="'+json.detail[i].obat+'"></td>'+
			'<td><input type="number" class="form-control" disabled name="harga[]" value="'+json.detail[i].harga_obat+'"></td>'+
			'<td><input type="text" class="form-control" name="jumlah[]" required value="'+json.detail[i].total+'"><input type="hidden" class="form-control" value="0" name="id_transaksi[]"></td>'+
			'<td><input type="text" class="form-control" name="subTotal[]" value="'+json.detail[i].jumlah_bayar+'" disabled required></td><td>'+
			// '<a class="btn btn-sm btn-white text-black" onclick="tambahTransaksi();"><i class="fa fa-plus-square-o fa-lg"></i></a>'+ 
			// '<a class="btn btn-sm btn-white text-black" onclick="hapusTransaksi(this);"><i class="fa fa-minus-square-o fa-lg"></i></a>'+ 
			'</td></tr>'
			);
			
		}
		console.log(json.master);
		$('[name="tanggal"]').val(json.master.tgl_transaksi);
		$('[name="kd_transaksi"]').val(json.master.id);
		$('[name="pembeli"]').val(json.master.pembeli);

		$('[name="pegawai"]').val(json.master.id_pegawai);
		$('[name="total_item"]').val(json.master.jml_obat);
		$('[name="jml_bayar"]').val(json.master.jumlah);
		$('[name="pengirim"]').val(json.master.pengirim);
	})

});
$(document).on('change','[name="obat[]"]',function(){
	// var idx = $(this).closest('tr').attr('idx');
	var id = $(this).val();
	var n = $('[name="obat[]"]').index(this);
	if(id){
		$.post( base_url+"admin/transaksi/get_obat_details", {id: id}).done(function( data ) {
			var json = $.parseJSON(data);
			// console.log(json)
			$('[name="harga[]"]').eq(n).val(json.harga);
			// $('[name="address"]').val(json.address);
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
	 $('[name="subTotal[]"]').eq(n).val(total);
	 for (var i = 0; i < len; i++) {
	 	jml = Number(jml) + Number($('[name="subTotal[]"]').eq(i).val());
	 }
	 $('[name="jml_bayar"]').val(jml);
	 console.log(len);
});
$(document).ready(function() {
	get_obat();
});
function initTransaksi(idx){
	// $('[name="id"]').val(idx);
	$('.transaksi-row').remove();
	$.post( base_url+"admin/provider/get_transaksi", {idx: idx}).done(function( data1 ) {
		var json = $.parseJSON(data1);
		if(json.length == 0){
			$('#tabel-transaksi').append(
				'<tr class="transaksi-row"><td><input type"text" class="form-control" name="obat[]" required></td>'+
				'<td><input type"number" class="form-control" name="harga[]" required><input type="hidden" class="form-control" value="0" name="id_transaksi[]"></td>'+
				'<td><input type"text" class="form-control" name="jumlah[]" required></td>'+
				'<td><input type"text" class="form-control" name="subtotal[]" required></td><td>'+
				'<a class="btn btn-sm btn-white text-black" onclick="tambahTransaksi();"><i class="fa fa-plus-square-o fa-lg"></i></a>'+ 
				'<a class="btn btn-sm btn-white text-black" onclick="hapusTransaksi(this);"><i class="fa fa-minus-square-o fa-lg"></i></a>'+ 
				'</td></tr>'
			);
		}else{
			console.log(json);
			for (var i = 0; i < json.length; i++) {
				$('#tabel-transaksi').append('<tr class="transaksi-row"><td><input type="text" class="form-control" value="'+json[i].obat+'" name="obat[]" required></td>'+
				'<td><input type="number" value="'+json[i].harga+'" class="form-control" name="harga[]" required></td>'+
				'<td><input type="text" value="'+json[i].jumlah+'" class="form-control" name="jumlah[]" required><input type="hidden" value="'+json[i].id_transaksi+'" class="form-control" name="id_transaksi[]" required></td>'+
				'<td><select class="form-control" value="'+json[i].obat+'" name="jenis[]"><option value="0">Lantai Vinyl</option>'+
				'<option value="1">Rumput Sintetis</option>'+
				'<option value="2">Lantai polypropylene</option>'+
				'<option value="3">Lantai Beton</option></select></td><td>'+
				'<a class="btn btn-sm btn-white text-black" onclick="tambahTransaksi();"><i class="fa fa-plus-square-o fa-lg"></i></a>'+ 
				'<a class="btn btn-sm btn-white text-black" onclick="hapusTransaksi(this);"><i class="fa fa-minus-square-o fa-lg"></i></a>'+ 
				'</td></tr>');
				$('[name="jenis[]"]').eq(i).val(json[i].jenis);
			}
		}
	});
}
function tambahTransaksi(){
	// $(".select2").select2();
	var obat = localStorage.getItem('obat_data');
	$('#tabel-transaksi').append(
		'<tr class="transaksi-row"><td><select class="select2 form-control" style="width:100%" name="obat[]"><option value="">select obat</option>'+obat+'</select></td>'+
		'<td><input type="number" class="form-control" disabled name="harga[]"></td>'+
		'<td><input type="text" class="form-control" name="jumlah[]" required><input type="hidden" class="form-control" value="0" name="id_transaksi[]"></td>'+
		'<td><input type="text" class="form-control" name="subTotal[]" disabled required></td><td>'+
		'<a class="btn btn-sm btn-white text-black" onclick="tambahTransaksi();"><i class="fa fa-plus-square-o fa-lg"></i></a>'+ 
		'<a class="btn btn-sm btn-white text-black" onclick="hapusTransaksi(this);"><i class="fa fa-minus-square-o fa-lg"></i></a>'+ 
		'</td></tr>'
	);
	$(".select2").select2({
	  placeholder: "Select obat"
	});
	var len = $('[name="obat[]"]').length;
	$('[name="total_item"]').val(len);
}
function hapusTransaksi(el){
	var idx = $(el).closest('tr').find('[name="id_transaksi[]"]').val();
	var kode = $(el).closest('tr').find('[name="obat[]"]').val();
	if(idx == 0){
		$(el).parent().parent().remove();
	}else{
		bootbox.confirm("Apakan anda yakin akan menghapus transaksi "+kode+"?", function(result){
			if (result) {
				$.post( base_url+"admin/provider/delete_transaksi", {id : idx}).done(function( data ) {
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
function get_obat(){
	var list="";
 	$.ajax({ type:'POST',url:base_url+"admin/transaksi/get_obat"}).done(function( data ) {
		var json = $.parseJSON(data);
			// json = response.student_list;
		// var ipkRange = "IPK Range "+response.total_sow['min_ipk']+" - "+response.total_sow['max_ipk'];
		// $('label[for=working_hour_in]').text(ipkRange);
		// var list="";
		// console.log(json);
		for (var i = 0; i < json.length; i++) {
			// console.log(json[i].id);
			list = list + '<option value="'+json[i].id_obat+'">'+json[i].nama+' - '+json[i].stok+'</option>';
		}
		localStorage.setItem('obat_data', list);

		// initStudentList();
	});
}
function post_transaksi(){
	$('input').removeAttr('disabled');
	var data = $('#transaksiForm').serialize();
	var api = base_url+"admin/transaksi/post";
	    
    $.post(api, data).done(function( data ) {
      if (data == "1"){
        bootbox.alert("Data transaksi berhasil disimpan.", function(){
          location.reload();
        })
      }else{
        bootbox.alert("Gagal menyimpan data.");
      }   
    });
    console.log(base_url);
 }
 function post_transaksi_pembelian(){
	$('input').removeAttr('disabled');
	var data = $('#transaksiForm').serialize();
	var api = base_url+"admin/transaksi/post_beli";
	    
    $.post(api, data).done(function( data ) {
      if (data == "1"){
        bootbox.alert("Data transaksi berhasil disimpan.", function(){
          location.reload();
        })
      }else{
        bootbox.alert("Gagal menyimpan data.");
      }   
    });
    console.log(base_url);
 }