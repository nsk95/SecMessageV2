$( document ).ready(function() 
{
    var isAdvancedUpload = function() 
    {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();

    var $form = $('.box');

    if(isAdvancedUpload) 
    {
        $form.addClass('has-advanced-upload');
    }

    if (isAdvancedUpload) {

        var droppedFiles = false;
      
        $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
          e.preventDefault();
          e.stopPropagation();
        })
        .on('dragover dragenter', function() {
          $form.addClass('is-dragover');
        })
        .on('dragleave dragend drop', function() {
          $form.removeClass('is-dragover');
        })
        .on('drop', function(e) {
          droppedFiles = e.originalEvent.dataTransfer.files;
        });
      
    }

    var $input    = $form.find('input[type="file"]'),
    $label    = $form.find('#label_file'),
    showFiles = function(files) {
      $label.text(files.length > 1 ? ($input.attr('data-multiple-caption') || '').replace( '{count}', files.length ) : files[ 0 ].name);
    };

// ...

    $input.on('drop', function(e) {
    droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
    showFiles( droppedFiles );
    });

    //...

    $input.on('change', function(e) {
    showFiles(e.target.files);
    });


    $( "#sbtbtn" ).on( "click", function( event ) 
    {
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
                url: "/message/create/",
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