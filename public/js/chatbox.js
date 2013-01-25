        socket.on('receivefromuser', function (username, id, data) {

            if($('body').find($('#chat_' + id)).html()){
                $('#chat_' + id).find($('.chat_area')).append('<p>' + '<b>'+username + ':</b> ' + data + '<p>');

                $('#chat_' + id).find($('.chat_area')).scrollTop($('#chat_' + id).find($('.chat_area')).scrollHeight);
            } else {

                message = '<p>' + '<b>'+username + ':</b> ' +  data + '</p>';
                $('body').append('<div class="chatbox" id="chat_'+id+'" title="Demo Bot">'+
                    '<div class="header" title="Chat com '+ username +'">'+
                        '<p>'+ username +'</p>'+
                        '<a href="#" class="close_chatbox" title="close chat window">X</a>'+
                        '<a href="#" class="minimize_chatbox" title="minimize chat window">_</a>'+
                        '<a href="#" class="maximize_chatbox" title="maximize chat window">&#8254;</a>'+
                    '</div>'+
                    '<div class="chat_area">'+ message +
                    '</div>'+
                    '<div class="chat_info"><p></p></div>'+
                    '<div class="chat_message" title="Type your message here">'+
                        '<textarea class="s-user-message" id="'+ id +'"></textarea>'+
                    '</div>'+
                '</div>');
            }

        })

        // listener, whenever the server emits 'updateusers', this updates the username list
        socket.on('updateusers', function(data) {

            $('#users').empty();
            $.each(data, function(key, value) {
                if(value.name != localStorage.getItem('nickname')) {
                    $('#users').append('<div><a class="user" href="#!" rel="'+value.id+'">' + value.name + '</a></div>');
                }

            });
        });



        // on load of page
        $(function(){
            $.fn.selectRange = function(start, end) {
                return this.each(function() {
                    if (this.setSelectionRange) {
                        this.focus();
                        this.setSelectionRange(start, end);
                    } else if (this.createTextRange) {
                        var range = this.createTextRange();
                        range.collapse(true);
                        range.moveEnd('character', end);
                        range.moveStart('character', start);
                        range.select();
                    }
                });
            };


            $('.close_chatbox').live('click', function(){
                $(this).parent().parent().remove();
            })

            $('.s-user-message').live('keypress', function(e) {

                if(e.which == 13) {
                    e.preventDefault();
                    $(this).blur();
                    $(this).parent().parent().find($('.chat_area')).append('<p> <b> eu: </b>'+$(this).val()+'</p>')
                    socket.emit('sendtouser', $(this).attr('id'), $(this).val());
                    $(this).val('');
                    $(this).focus();
                }
            });

            $('.user').live('click', function() {
                $('#datasend').attr('rel', $(this).attr('rel'));

                if($('body').find($('#chat_' + $(this).attr('rel'))).html()){
                    $('#chat_' + $(this).attr('rel')).find($('.chat_message')).find($('textarea')).focus();

                    $('#chat_' + $(this).attr('rel')).find($('.chat_area')).scrollTop($('#chat_' + $(this).attr('rel')).find($('.chat_area')).scrollHeight);
                } else {
                     $('body').append('<div class="box-container"><div class="chatbox" id="chat_'+$(this).attr('rel')+'" title="Demo Bot">'+
                        '<div class="header" title="Chat com '+ $(this).html() +'">'+
                            '<p>'+ $(this).html() +'</p>'+
                            '<a href="#" class="close_chatbox" title="close chat window">X</a>'+
                            '<a href="#" class="minimize_chatbox" title="minimize chat window">_</a>'+
                            '<a href="#" class="maximize_chatbox" title="maximize chat window">&#8254;</a>'+
                        '</div>'+
                        '<div class="chat_area" title="Demo Bot">'+
                        '</div>'+
                        '<div class="chat_info"><p></p></div>'+
                        '<div class="chat_message" title="Type your message here">'+
                            '<textarea class="s-user-message" id="'+ $(this).attr('rel') +'"></textarea>'+
                        '</div>'+
                    '</div></div>');
                }


                $('#'+$(this).attr('rel'));
            })

        });