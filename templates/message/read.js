$( document ).ready(function() 
{
    $('form#passform').on('submit', function(e)
    {
        $('#sbtbtn').prop('disabled', true);
        
        if(this.pass != undefined)
        {
            this.pass.value = (CryptoJS.SHA512(this.pass.value).toString()).toUpperCase();
        }
    });
});