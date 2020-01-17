$( document ).ready(function() {
   var cryptedMessage = $("#message");
   var pass = $("#pass");
   if(cryptedMessage != '')
    {
       $("#message").text(CryptoJS.AES.decrypt(cryptedMessage, pass).toString(CryptoJS.enc.Utf8));
    }
});