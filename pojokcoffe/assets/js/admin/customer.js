$(document).ready(function() {
	initCloseBtn();
	initValidatorStyle();
	initValidatorFormMain();
	initValidatorFormPass();
	
});
function initValidatorFormMain(){
	var validator = $( "#myForm" ).validate({
		rules: {
			email:{
		        required: true,
		        remote: {
		          url: base_url+"/admin/customer/check_code",
		          type: "post",
		          data: {
		            id: function() {
		              return $( "input[name=user_login_id]" ).val();
		            }
		          }
		        }
			},
			image: {
	      		required: false,
	      		accept: "image/png"
	      	},
           	password: { 
             	required: true,
                minlength: 6,
                maxlength: 50

           } , 
               password_conf: { 
                equalTo: "#password",
                 minlength: 6,
                 maxlength: 50
           }
        },
        messages:{
	      email:{
	        required: "This field is required.",
	        remote: "This email already exist."
	      },
	      image:{
	        accept: "This file extension must be png."
	      }
	    }
	});
}
function initValidatorFormPass(){
	var validator = $( "#passwordForm" ).validate({
		rules: {
			password_old:{
		        required: true,
		        remote: {
		          url: base_url+"/admin/customer/check_password",
		          type: "post",
		          data: {
		            id: function() {
		              return $( "input[name=id]" ).val();
		            }
		          }
		        }
			},
           new_password: { 
             required: true,
                minlength: 6,
                maxlength: 50

           } , 
               new_password_conf: { 
                equalTo: "#new_password",
                 minlength: 6,
                 maxlength: 50
           }
        },
        messages:{
	      password_old:{
	        required: "This field is required.",
	        remote: "Password salah"
	      }
	    }
	});
}
function initCloseBtn(){
  var $form = $('form'),
    origForm = $form.serialize();

  $('form :input').on('change input', function() {
      if($form.serialize() !== origForm){
        $("#myForm").data('changed', 1);
      }
  });

  $('.close-modal').on('click', function(e){
    e.preventDefault();
    if($("#myForm").data('changed') == 1) {
      bootbox.dialog({
        message: "Apakah anda yakin akan menutup form ini? form akan direset ketika ditutup.",
        buttons: {
          close: {
            label: "Cancel",
            className: "btn-default flat",
            callback: function () {
              $(this).modal('hide');
            }
          },
          danger: {
            label: "Confirm",
            className: "btn-primary flat",
            callback: function () {
              $('#modal-admin').modal('hide');
            }
          }
        }
      });
    }else{
      $('#modal-admin').modal('hide');
    }
  });
}
$('#modal-admin').on('hide.bs.modal', function () {
    $("#myForm").trigger("reset");
	$('.password').show();
    $("#myForm").validate().resetForm();
    $("#myForm").get(0).reset();
    $("#myForm").data('changed', 0);
});
function post_data(){
	var validator = $( "#myForm" ).validate();
	console.log();
	if(validator.form()){
		if($('[name="status"]').is(":checked")){
			// alert();
			$('[name="status"]').val(1);
		}else{
			$('[name="status"]').val(0);
		}
		var data = new FormData($('#myForm')[0]);
 
	     $.ajax({
               type:"POST",
               url:base_url+"admin/customer/post",
               data:data,
               mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
               success:function(data)
              {
                if (data == "1"){
				bootbox.alert("Data berhasil disimpan.", function(){
				location.reload();
					})
				}else{
					bootbox.alert("Data gagal disimpan.");
				}		
 
               }
	       });
 
	}
}
jQuery.fn.getCheckboxVal = function(){
	var vals = [];
	var i = 0;
	this.each(function(){
		vals[i++] = jQuery(this).val();
	});
	return vals;
}
$(document).on('click','.delete',function(){
	var idx = $(this).closest('tr').attr('idx');
	var tr = $(this).closest('tr');
	
	bootbox.confirm("Apakan anda yakin akan menghapus "+$(tr).find('td').eq(1).html()+"?", function(result){
		if (result) {
			$.post( base_url+"admin/customer/delete", {id : idx}).done(function( data ) {
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
$(document).on('click','.change-pass',function(){
	var id = $(this).closest('tr').attr('id');
	$('[name="id"]').val(id);
});

$('#modal-change-password').on('hide.bs.modal', function () {
    $("#passwordForm").trigger("reset");
});
$(document).on('click','.update',function(){
	$('#myForm').trigger("reset");
	var idx = $(this).closest('tr').attr('idx');
	var tr = $(this).closest('tr');
	$('#active').show();
	$('.password').hide();
	
	$.post( base_url+"admin/customer/get_by_id", {idx: idx}).done(function( data1 ) {
		var json = $.parseJSON(data1);
		console.log(json)
		$('[name="id_customer"]').val(json.id_customer);
		$('[name="user_login_id"]').val(json.user_login_id);
		$('[name="username"]').val(json.username);
		$('[name="nama"]').val(json.nama);
		$('[name="email"]').val(json.email);
		$('[name="no_telp"]').val(json.no_tlp);

		$('[name="tgl_lahir"]').val(json.tgl_lahir);
		$('[name="image_name"]').val(json.foto);
		$('[name="alamat"]').val(json.alamat);
		$('[name="password"]').val(json.password);
		$('[name="password_conf"]').val(json.password);
		// $('[name="requester_institution"]').val(json.requester_institution);
		if(json.status==1){
			$('[name="status"]').attr('checked',true);
			$('[name="status"]').val(1);
		}else{
			$('[name="status"]').attr('checked',false);
			$('[name="status"]').val(0);
		}
	});
});
function change_pass(){
	var validator = $( "#passwordForm" ).validate();
	  if(validator.form()){
	    var data = $('#passwordForm').serialize();
	    // $.post('url', data);
	    var api = base_url+"admin/customer/change_pass";
	    
	    $.post(api, data).done(function( data ) {
	      if (data == "1"){
	        bootbox.alert("Password berhasil diubah.", function(){
	          location.reload();
	        })
	      }else{
	        bootbox.alert("Gagal mengubah password.");
	      }   
	    });
	    console.log(base_url);
	  }
}