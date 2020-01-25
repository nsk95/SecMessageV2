$( document ).ready(function() 
{
        // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("#file_h1").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#file_h1").text("Drop");
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#file_h1").text("Drop");
    });

    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $("#file_h1").text("Upload");

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData($('#newMessageForm'));

        fd.append('file', file[0]);

        uploadData(fd);
    });

    
    $("#uploadfile").click(function()
    {
        $("#file").click();
    });


    $('form#newMessageForm').on('submit', function(e)
    {
        e.preventDefault();
        if(!validateForm(this))
        {
            return;
        }
        $('#sbtbtn').prop('disabled', true);
        
        var fd = new FormData(this);
        
        if(fd.get('pass1') != '')
        {
            fd.set('hashedPass', (CryptoJS.SHA512(fd.get('pass1')).toString()).toUpperCase()) 
        }
        fd.delete('pass1');
        fd.delete('pass2');

        var resultRP = '';
        var pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#!';
        for( var i = 0; i < 16; i++)
        {
            resultRP += pool.charAt(Math.floor(Math.random() * pool.length));
        }
        if(fd.get('hashedPass') != undefined)
        {
            var resultRC = resultRP + fd.get('hashedPass');
        }
        else
        {
            var resultRC = resultRP;
        }
        fd.set('cryptedMessage', CryptoJS.AES.encrypt(fd.get('message'), resultRC).toString());
        fd.delete('message');
        fd.set('pass', resultRC);
        
        $.ajax({
            url: "/message/create/",
            data: fd,
            type: 'POST',
            enctype: 'multipart/form-data',
            contentType: false, 
            processData: false, 
            cache: false,
            success: function(result) 
            {
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

    function validateForm(form)
    {
        if(form.message.value == '')
        {
            alert('Message cannot be empty');
            return false;
        }
        else if(form.pass1.value != '' && form.pass1.value != form.pass2.value)
        {
            alert('Passwords do not match');
            return false;
        }
        else
        {
            return true;
        }
    };
});