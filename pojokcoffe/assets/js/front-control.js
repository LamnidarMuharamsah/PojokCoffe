
function openCalendar(el){
	// $('#myModalCalendar').show();

	$('.btn-prev').hide();
	var idx = $(el).attr('data-id');
	var jam_buka = $(el).attr('data-jam-buka');
	var jam_tutup = $(el).attr('data-jam-tutup');
	$('#myModalCalendar').find('.modal-body').empty();
	$('.btn-booking').attr('data-id',idx);
	$('.btn-next').attr('data-id',idx);
	$('.btn-prev').attr('data-id',idx);
	$('#myModalCalendar').find('.modal-body').append("<span class='col-md-2'></span><h4 class='col-md-8'></h4>");
	$('#myModalCalendar').find('.modal-body').append("<table class='table table-hover table-responsive table-striped table-bordered jadwal' id='table-jadwal'>"+
		"<tr><td>Jam</td><td>Senin</td><td>Selasa</td><td>Rabu</td><td>Kamis</td><td>Jumat</td><td>Sabtu</td><td>Minggu</td></tr>"+
	"</table>");
	
	for (var i = parseInt(jam_buka); i <= parseInt(jam_tutup); i++) {
		// console.log(i);
		$('#table-jadwal').append("<tr data-jam = '"+i+"'><td>"+i+".00</td class='nama'><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
	}
	$.post( base_url+"welcome/get_jadwal_lapangan", {idx: idx,tgl_sewa:0}).done(function( data1 ) {
		var json = $.parseJSON(data1);
		if(json.length != 0 ){
			for (var i = 0; i < json.length; i++) {
				console.log(json[i]);
				for (var k = parseInt(json[i].jam_mulai); k <= parseInt(json[i].jam_selsai)-1; k++) {
					console.log(k);
					var a =$("tr[data-jam='" + k +"']");
					// $(a).append('<td>asd</td>');
					var date = json[i].tgl_main.split('-');
				    var y = date[0];
				    var m = parseInt(date[1]) - 1;
				    var d = date[2];
					var d = new Date(y,m,d);
    				var n = d.getDay()
    				if(n==0)n=7;
					$(a).find('td:nth-child('+(n+1)+')').addClass('warning');
					$(a).find('td:nth-child('+(n+1)+')').append(json[i].nama);
					// $(a).find('td:nth-child(3)').empty();
					// console.log(date);
					console.log(n);
				}
			}
		}
	});
}
function nextCalendar(el){
	var idx = $(el).attr('data-id');
	var jam_buka = $(el).attr('data-jam-buka');
	var jam_tutup = $(el).attr('data-jam-tutup');
	$(el).hide();
	$('.btn-prev').show();
	$('#myModalCalendar').find('.modal-body').empty();
	$('.btn-booking').attr('data-id',idx);
	$('#myModalCalendar').find('.modal-body').append("<span class='col-md-2'></span><h4 class='col-md-8'></h4>");
	$('#myModalCalendar').find('.modal-body').append("<table class='table table-hover table-responsive table-striped table-bordered jadwal' id='table-jadwal'>"+
		"<tr><td>Jam</td><td>Senin</td><td>Selasa</td><td>Rabu</td><td>Kamis</td><td>Jumat</td><td>Sabtu</td><td>Minggu</td></tr>"+
	"</table>");
	
	for (var i = parseInt(jam_buka); i <= parseInt(jam_tutup); i++) {
		// console.log(i);
		$('#table-jadwal').append("<tr data-jam = '"+i+"'><td>"+i+".00</td class='nama'><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
	}
	$.post( base_url+"welcome/get_next_lapangan", {idx: idx,tgl_sewa:0}).done(function( data1 ) {
		var json = $.parseJSON(data1);
		if(json.length != 0 ){
			for (var i = 0; i < json.length; i++) {
				console.log(json[i]);
				for (var k = parseInt(json[i].jam_mulai); k <= parseInt(json[i].jam_selsai)-1; k++) {
					console.log(k);
					var a =$("tr[data-jam='" + k +"']");
					// $(a).append('<td>asd</td>');
					var date = json[i].tgl_main.split('-');
				    var y = date[0];
				    var m = parseInt(date[1]) - 1;
				    var d = date[2];
					var d = new Date(y,m,d);
    				var n = d.getDay()
    				if(n==0)n=7;
					$(a).find('td:nth-child('+(n+1)+')').addClass('warning');
					$(a).find('td:nth-child('+(n+1)+')').append(json[i].nama);
					// $(a).find('td:nth-child(3)').empty();
					// console.log(date);
					console.log(n);
				}
			}
		}
	});
}
function prevCalendar(el){
	var idx = $(el).attr('data-id');
	var jam_buka = $(el).attr('data-jam-buka');
	var jam_tutup = $(el).attr('data-jam-tutup');
	$(el).hide();
	$('.btn-next').show();
	$('#myModalCalendar').find('.modal-body').empty();
	$('.btn-booking').attr('data-id',idx);
	$('#myModalCalendar').find('.modal-body').append("<span class='col-md-2'></span><h4 class='col-md-8'></h4>");
	$('#myModalCalendar').find('.modal-body').append("<table class='table table-hover table-responsive table-striped table-bordered jadwal' id='table-jadwal'>"+
		"<tr><td>Jam</td><td>Senin</td><td>Selasa</td><td>Rabu</td><td>Kamis</td><td>Jumat</td><td>Sabtu</td><td>Minggu</td></tr>"+
	"</table>");
	
	for (var i = parseInt(jam_buka); i <= parseInt(jam_tutup); i++) {
		// console.log(i);
		$('#table-jadwal').append("<tr data-jam = '"+i+"'><td>"+i+".00</td class='nama'><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
	}
	$.post( base_url+"welcome/get_prev_lapangan", {idx: idx,tgl_sewa:0}).done(function( data1 ) {
		var json = $.parseJSON(data1);
		if(json.length != 0 ){
			for (var i = 0; i < json.length; i++) {
				console.log(json[i]);
				for (var k = parseInt(json[i].jam_mulai); k <= parseInt(json[i].jam_selsai)-1; k++) {
					console.log(k);
					var a =$("tr[data-jam='" + k +"']");
					// $(a).append('<td>asd</td>');
					var date = json[i].tgl_main.split('-');
				    var y = date[0];
				    var m = parseInt(date[1]) - 1;
				    var d = date[2];
					var d = new Date(y,m,d);
    				var n = d.getDay()
    				if(n==0)n=7;
					$(a).find('td:nth-child('+(n+1)+')').addClass('warning');
					$(a).find('td:nth-child('+(n+1)+')').append(json[i].nama);
					// $(a).find('td:nth-child(3)').empty();
					// console.log(date);
					console.log(n);
				}
			}
		}
	});
}

function openBukti(el){
	var id = $(el).attr('data-id');
	$('[name="kode_transaksi"]').val(id);
}
$('.save-btn').on('click', function(){
	alert();
});

function openModalTransaksi(el){
var id = $(el).attr('data-id');
	$('[name="id_lapang"]').val(id).trigger('change');
}

$('.save-btn').on('click', function(){
	alert();
});

function saveTransaksi(){
		// alert();
	    var data = $('#myForm').serialize();
	    // $.post('url', data);
	    var api = base_url+"welcome/save_transaksi";
	    
		var jam_mulai = $('[name="jam_mulai"]').val();
		var jam_selesai = $('[name="jam_selesai"]').val();
		var jumlah_jam = jam_selesai - jam_mulai;
	    $.post(api, data).done(function( data ) {
	      if (data != "0"){
	      	var json = $.parseJSON(data);
	        bootbox.alert("Booking lapang berhasil. Silahkan lakukan pembayaran ke no rekening "+json.provider.no_rek+" sebesar "+json.lapang.harga+". Waktu pembayaran selama 24 jam. Silahkan cek email", function(){
	          location.reload();
	        })

	      }else{
	        bootbox.alert("Gagal booking lapang.");
	      }   
	    });
	    // console.log(base_url);
}
function uploadBukti(){
		// alert();
	    // var data = $('#myForm-bukti').serialize();
	    var data = new FormData($('#myForm-bukti')[0]);
	    // $.post('url', data);
	    console.log(data);
	    var api = "welcome/uploadBuktiTrans";
	    
	    // $.post(api, data).done(function( data ) {
	    //   if (data != "0"){
	    //     bootbox.alert("Bukti Pembayaran Berhasil di Upload", function(){
	    //       location.reload();
	    //     })

	    //   }else{
	    //     bootbox.alert("Gagal Mengupload");
	    //   }   
	    // });
	    $.ajax({
               type:"POST",
               url:base_url+api,
               data:data,
               mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
               success:function(data)
              {
                if (data == "1"){
				bootbox.alert("Bukti Pembayaran Berhasil di Upload.", function(){
				location.reload();
					})
				}else{
					bootbox.alert("Bukti Pembayaran gagal di Upload.");
				}		
 
               }
	       });
	    // console.log(base_url);
}


function checkJadwal(){
	var tanggal = $('[name="tanggal"]').val();
	var jam_mulai = $('[name="jam_mulai"]').val();
	var jam_selesai = $('[name="jam_selesai"]').val();
	var id_lapang = $('[name="id_lapang"]').val();
	if(tanggal && jam_mulai && jam_selesai){
		if(jam_selesai <= jam_mulai){
			bootbox.alert("Jam mulai harus lebih kecil dari jam selesai");
			$('[name="jam_mulai"]').val('');
			$('[name="jam_selesai"]').val('');
		}else{
			$.post(base_url+"welcome/checkJadwal", {'tanggal':tanggal,'jam_mulai':jam_mulai,'jam_selesai':jam_selesai,'id_lapang':id_lapang}).done(function( data ) {
				if(data != '0'){
					$('[name="total_bayar"]').val(data);
				}else{
					bootbox.alert("Mohon maaf booking pada tanggal "+tanggal+" tidak dapat di lakukan karena lapangan sudah di sewa pihak lain. Silahkan periksa jadwal atau lapangan lainnya. Terimakasih");
					$('[name="jam_mulai"]').val('');
					$('[name="jam_selesai"]').val('');
				}
			});
		}
	}
}