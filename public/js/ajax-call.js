function Login(){
    var Ruta ="/login_api";
    // pass auth vars to Security (Login) Controller

    //get form values

    
    var email = $('#inputEmail').val();
    var passwd = $('#inputPassword').val();
    var token = $('#_csrf_token').val()
    
    //({email: email,passwd: passwd}

    $.ajax({
         type: 'POST',
         url: Ruta,
         data: {email: email,password: passwd,_csrf_token:token},
         async: true,
         dataType:"json",
         success: function(data) { 
            if(data.status == "success"){
               //hide form fields
               //$("#form-container").hide();
               //show logged user
               $('#login_info').html("<div class='success'>Usuario correcto</div>");  // data.username , data.passwd               
            }else{
               $('#login_info').html("<div class='error'>Usuario incorrecto</div>");
            }
            
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert(errorThrown);
         }  
     });
     

     
}