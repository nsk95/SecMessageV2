$( document ).ready(function() 
{
        // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("#file_h1").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

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

    // Open file selector on div click
    $("#uploadfile").click(function(){
        $("#file").click();
    });

    // file selected
    $("#file").change(function(){
        var fd = new FormData();

        var file = $('#file')[0].files[0];

        $('#uploadfile').files = file;

        // fd.append('file',files);

        // uploadData(fd);
    });

    $( "#sbtbtn" ).on( "click", function( event ) 
    {
        var form = $('form');
        var fd = new FormData(form[0]);
        
        event.preventDefault();

        if(fd.get('pass1') != "")
        {
            if(fd.get('pass1') != fd.get('pass2'))
            {
                alert('Passwords does not match.');
                return;
            }
            else
            {
                fd.set('hashedPass', (CryptoJS.SHA512(fd.get('pass1')).toString()).toUpperCase()) 
                fd.delete('pass1');
                fd.delete('pass2');
            }
        }

        var resultRP = '';
        var pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#!';
        var poolLength = pool.length;
        for( var i = 0; i < 16; i++)
        {
            resultRP += pool.charAt(Math.floor(Math.random() * poolLength));
        }
        if(fd.get('hashedPass') != undefined)
        {
            var resultRC = resultRP + fd.get('hashedPass');
        }
        else
        {
            var resultRC = resultRP;
        }

        if(fd.get('file'))
        {
            

        }
        

        fd.set('cryptedMessage', CryptoJS.AES.encrypt(fd.get('message'), resultRC).toString());
        fd.delete('message');
        fd.set('pass', resultRC);

        var data = JSON.stringify(Object.fromEntries(fd))
        console.log(fd);
        fd.delete('file');
        $.ajax({
                url: "/message/create/",
                data: {
                    data: data,
                },
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                // processData: false, // NEEDED, DON'T OMIT THIS
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