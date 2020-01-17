$( document ).ready(function() {
    $( "#sbtbtn" ).on( "click", function( event ) {
        event.preventDefault();
        var formData = { };
        $.each($( '#newMessageForm' ).serializeArray(), function() {
            formData[this.name] = this.value;
        });

        if(formData.pass1 != "")
        {
            if(formData.pass1 != formData.pass2)
            {
                alert('Passwords does not match.');
                return;
            }
            else{
                formData.hashedPass = (CryptoJS.SHA512(formData.pass1).toString()).toUpperCase();
                delete formData.pass1;
                delete formData.pass2;
            }
        }

        var resultRP = '';
        var pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#!';
        var poolLength = pool.length;
        for( var i = 0; i < 16; i++)
        {
            resultRP += pool.charAt(Math.floor(Math.random() * poolLength));
        }
        if(formData.hashedPass != undefined)
        {
            var resultRC = resultRP + formData.hashedPass;
        }
        else
        {
            var resultRC = resultRP;
        }

        formData.cryptedMessage = CryptoJS.AES.encrypt(formData.message, resultRC).toString();
        delete formData.message;
        formData.pass = resultRC;
        var data = JSON.stringify(formData);
        $.ajax({
                url: "proceed/create/",
                data: {
                    data: data,
                },
                type: 'post',
                success: function(result) {
                    result = JSON.parse(result);
                    if(result.success == true)
                    {
                        $('#mainbox').html(result.append);
                    }
                    else
                    {
                        $('#placeholder').html(result.append);
                    } 
                } 
            });
        
      });
});