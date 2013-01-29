        var socket = io.connect('http://54.232.122.95:6789');

        // on connection to server, ask for user's name with an anonymous callback
        socket.on('connect', function(){
            // call the server-side function 'adduser' and send one parameter (value of prompt)
            var user = { user_id: USR_ID, username: USR_NAME }
            localStorage.setItem('user', JSON.stringify(user));
            socket.emit('adduser', JSON.stringify(user));
        });

        socket.on('receivefromuser', function (userid, username, id, data) {

            if($('body').find($('#chat_' + id)).html()){
                $('#chat_' + id).find($('.chat_area')).append('<p>' + '<b>'+username + ':</b> ' + data + '<p>');

                $('#chat_' + id).find($('.chat_area')).scrollTop($('#chat_' + id).find($('.chat_area')).get(0).scrollHeight);
            } else {

                message = '<p>' + '<b>'+username + ':</b> ' +  data + '</p>';

                $('body').append('<div class="box-container"><div class="chatbox" id="chat_'+id+'" title="Chat com '+ $(this).html() +'">'+
                    '<div class="header" title="Chat com '+ username +'">'+
                        '<p>'+ username +'</p>'+
                        '<a href="#" class="close_chatbox" title="Fechar">X</a>'+
                        '<a href="#" class="minimize_chatbox opt-button-box" title="Minimizar">_</a>'+
                        '<a href="#" class="maximize_chatbox opt-button-box" title="Maximizar">&#8254;</a>'+
                    '</div>'+
                    '<div class="chat_area">'+ message +
                    '</div>'+
                    '<div class="chat_info"><p></p></div>'+
                    '<div class="chat_message" title="Digite sua mensagem">'+
                        '<textarea class="s-user-message" id="'+ id +'"></textarea>'+
                    '</div>'+
                '</div></div>');
            }

        })

        // listener, whenever the server emits 'updateusers', this updates the username list
        socket.on('updateusers', function(data) {
            // $('#users').empty();
            $.each(data, function(key, value) {
                // if(value.name != localStorage.getItem('nickname'))
                    // $('#users').append('<div><a class="user" href="#!" rel="'+value.id+'">' + value.name + '</a></div>');
                    $('.chatwith-'+value.name).addClass('user').attr('rel', value.id);
                    $('.chatwith-'+value.name).html('<img src="'+ABSPATH+'images/chat.gif" border="0" height="12"/>').after('&nbsp;');
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


            if ($('.close_chatbox').doesExist())
                $('.close_chatbox').live('click', function(){
                    $(this).parent().parent().remove();
                    $(this).find('.chatbox').remove();
                })

            if ($('.s-user-message').doesExist())
                $('.s-user-message').live('keypress', function(e) {
                    if(e.which == 13) {
                        e.preventDefault();
                        var el = $(this).parent().parent().find($('.chat_area'));
                        $(this).blur();
                        el.append('<p> <b> eu: </b>'+$(this).val()+'</p>')
                        el.scrollTop(el.get(0).scrollHeight);
                        socket.emit('sendtouser', $(this).attr('id'), $(this).val());
                        $(this).val('');
                        $(this).focus();
                    }
                });


            if ($('.user').doesExist())
                $('.user').live('click', function() {
                    $('#datasend').attr('rel', $(this).attr('rel'));
                    var name = $(this).attr('name').substr(2, 22);
                    var user_id = $(this).attr('id');
                    console.log(user_id);

                    if($('body').find($('#chat_' + $(this).attr('rel'))).html()){
                        $('#chat_' + $(this).attr('rel')).find($('.chat_message')).find($('textarea')).focus();

                        $('#chat_' + $(this).attr('rel')).find($('.chat_area')).scrollTop($('#chat_' + $(this).attr('rel')).find($('.chat_area')).scrollHeight);
                    } else {
                         $('body').append('<div class="box-container"><div class="chatbox" id="chat_'+$(this).attr('rel')+'" title="Demo Bot">'+
                            '<div class="header" title="Chat com '+ name +'">'+
                                '<p>'+ name +'</p>'+
                                '<a href="#" class="close_chatbox" title="close chat window">X</a>'+
                                '<a href="#" class="minimize_chatbox" title="minimize chat window">_</a>'+
                                '<a href="#" class="maximize_chatbox" title="maximize chat window">&#8254;</a>'+
                            '</div>'+
                            '<div class="chat_area" title="Demo Bot">'+
                            '</div>'+
                            '<div class="chat_info"><p></p></div>'+
                            '<div class="chat_message" title="Escreva sua mensagem">'+
                                '<textarea class="s-user-message" id="'+ $(this).attr('rel') +'"></textarea>'+
                            '</div>'+
                        '</div></div>');
                    }


                    $('#'+$(this).attr('rel'));
                })


            //minimizar / maximizar
            if ($('.opt-button-box').doesExist())
                $('.opt-button-box').live('click', function(){

                        var box1 = $(this).parent().next();
                        var box2 = $(this).parent().next().next();
                        var box3 = $(this).parent().next().next().next();
                        var container = $(this).parent().parent();

                        if ($(this).hasClass('maximize_chatbox')) {
                            box1.show();
                            box2.show();
                            box3.show();
                            container.css('height', '302px');
                            $(this).hide();
                            $(this).parent().find($('.minimize_chatbox')).show();
                        } else {
                             box1.hide();
                             box2.hide();
                             box3.hide();
                             container.css('height', '25px');
                             $(this).hide();
                             $(this).parent().find($('.maximize_chatbox')).show();
                        }
                });


        });



//////////
// auto-scroll ao digitar




//auto scroll ao receber msg


