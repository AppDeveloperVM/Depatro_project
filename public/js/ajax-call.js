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
               $("#form-container").hide();
               //show logged user
               $('#login_info').html("Loggeado como <b>" + data.user + "</b>");  // data.username , data.passwd               
            }else{
               $('#login_info').html("<div class='error'>Datos incorrectos</div>");
            }
            
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert(errorThrown);
         }  
     });
     

     
}