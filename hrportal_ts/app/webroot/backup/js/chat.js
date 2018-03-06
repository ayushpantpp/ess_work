jQuery(document).ready(function(){
    getUpdates =  function (){
        jQuery.post(baseUrl+'chat/prOnlineViewHtml/'+jQuery('.chat-rooms-list').val(),{},function (data){jQuery('.chat-box-txt1 ul').html(data)});
        jQuery.post(baseUrl+'chat/prUpdatesViewJson/', jQuery('.cust-chat div.chat-box-txt form').serialize(), function(data){
                    jQuery.each(data,function(key,val){
                        var roomIdElement = jQuery('input#vc_room_id[value="'+val.vc_room_id+'"]');
                        if(roomIdElement.length==0){
                                var chatbox = jQuery('.chat-box-dummy:first').clone();
                                jQuery(chatbox).find('.chat-box-txt ul').html(decodeURIComponent(val.html));
                                jQuery(chatbox).find('#chat_max_id').attr('name','data[Updates]['+(jQuery('.cust-chat > div').length-1)+'][chat_max_id]');
                                jQuery(chatbox).find('#vc_room_id').attr('name','data[Updates]['+(jQuery('.cust-chat > div').length-1)+'][vc_room_id]');
                                jQuery(chatbox).find('#chat_max_id').val(val.max_id);
                                jQuery(chatbox).find('#vc_room_id').val(val.vc_room_id);        

                                jQuery(chatbox).find('.chat-room-name').html(val.vc_room_name);
                                jQuery(chatbox).removeClass('chat-box-dummy').addClass('chat-box').show();

                                jQuery('.cust-chat > div:last').after(chatbox);
                                jQuery('.cust-chat > div:last').find('.chat-box-txt:first').attr({scrollTop: jQuery('.cust-chat > div:last').find('.chat-box-txt:first').attr("scrollHeight")});
                                jQuery('.cust-chat > div:last').css('right',(((jQuery('.cust-chat > div.chat-box').length-1)*351)+228)+'px');                            
                        }
                        if(parseInt(jQuery('input#vc_room_id[value="'+val.vc_room_id+'"]').parent().find('input#chat_max_id').val())<parseInt(val.max_id)){
                            roomIdElement.parents('.chat-box-txt:first').find('ul').append(decodeURIComponent(val.html));
                            roomIdElement.parent().find('input#chat_max_id').val(val.max_id);
                            roomIdElement.parents('.chat-box-txt:first').attr({scrollTop: roomIdElement.parents('.chat-box-txt:first').attr("scrollHeight")});
                            //jQuery('audio').remove();
                            //var audioElement = document.createElement('audio');
                            //audioElement.setAttribute('src', baseUrl+'files/DoorBell.wav');
                            //audioElement.play();
                        }                        
                    });
        }, 'json')
        .complete(function() {
            setTimeout('getUpdates()',2500);
        });
    };
    jQuery.post(baseUrl+'chat/prRoomsListHtml',{},function(data){
        jQuery('.chat-rooms-list').html(data);
    },'html');
    jQuery('.chat-rooms-list').change(function(){
        roomName = jQuery('.chat-rooms-list option[value="'+jQuery(this).val()+'"]').text();
        if(roomName.indexOf('(Owner)')==-1) 
            jQuery('.chat-member-add-container').hide();
        else
            jQuery('.chat-member-add-container').show();
        jQuery.post(baseUrl+'chat/prOnlineViewHtml/'+jQuery(this).val(),{},function (data){
            jQuery('.chat-box-txt1 ul').html(data)
        });        
    });
    jQuery("#chat-member-name").autocomplete({
            source: baseUrl+'employees/prListJson/',
            minLength: 2,
            select: function( event, ui ) {
                jQuery( "#chat-member-name" ).val(ui.item.label);
                jQuery( "#chat-member-id" ).val(ui.item.id);
            }
    });    
    var ajaxManager = $.manageAjax.create('cacheQueue', {queue: true});
    jQuery('#chat-text').live('keypress',function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) { //Enter keycode
            e.preventDefault();
            jQuery(this).attr('disabled',true);
            ajaxManager.add({ 
                success: function(data) { 
                    jQuery('#chat-text').val('');
                    chat_text = jQuery('input#vc_room_id').filter('input[value='+data.roomid+']').parents('.chat-box').find('#chat-text');
                    chat_text.val('');
                    chat_text.attr('disabled',false);
                }, 
                url: baseUrl+'chat/prMessageAddJson/',
                data: {
                'data[ChatMessages][vc_message]':jQuery(this).val(),
                'data[ChatMessages][vc_room_id]':jQuery(this).siblings('.chat-box-txt').find('input#vc_room_id').val()
                },
                type: 'post',
                dataType: 'json'
            });            
        }
    });
    jQuery('ul.chat-rooms-actions li.delete').live('click',function(e){
        e.preventDefault();
        jQuery.post(baseUrl+'chat/prRoomDeleteJson/'+jQuery('.chat-rooms-list').val(),{},function(data){
            jQuery.post(baseUrl+'chat/prRoomsListHtml',{},function(data){
                jQuery('.chat-rooms-list').html(data);
            },'html');            
        },'json');        
    });
    jQuery('ul.chat-rooms-actions li.chat').live('click',function(){
        value = jQuery(this).parent().parent().find('.chat-rooms-list').val();
        if(jQuery('input#vc_room_id[value="'+value+'"]').length==0){
            var chatbox = jQuery('.chat-box-dummy:first').clone();

            jQuery(chatbox).find('.chat-box-txt ul').html('');

            jQuery(chatbox).find('#chat_max_id').attr('name','data[Updates]['+(jQuery('.cust-chat > div.chat-box').length)+'][chat_max_id]');
            jQuery(chatbox).find('#vc_room_id').attr('name','data[Updates]['+(jQuery('.cust-chat > div.chat-box').length)+'][vc_room_id]');

            jQuery(chatbox).find('#chat_max_id').val('0');

            
            jQuery(chatbox).find('#vc_room_id').val(value);        


            jQuery(chatbox).find('.chat-room-name').html(jQuery(this).parent().parent().find('.chat-rooms-list option[value="'+value+'"]').text());
            jQuery(chatbox).removeClass('chat-box-dummy').addClass('chat-box').show();

            jQuery('.cust-chat > div:last').after(chatbox);
            if(jQuery('.cust-chat > div.chat-box').length > 2) {
                jQuery('.chat-box-nav-right').show();
                jQuery('.chat-box-nav-left').show();
                jQuery('.cust-chat > div.chat-box').hide();
                jQuery('.cust-chat > div.chat-box:last').css('right',((351)+228+35)+'px').show(); 
                jQuery('.cust-chat > div.chat-box:last').prev().css('right',(228+35)+'px').show();
            }else{
                jQuery('.chat-box-nav-right').hide();
                jQuery('.chat-box-nav-left').hide();
                jQuery('.cust-chat > div.chat-box').show();                
                jQuery('.cust-chat > div.chat-box:last').css('right',(((jQuery('.cust-chat > div.chat-box').length-1)*351)+228)+'px');        
            }
        }
    });
    jQuery('.chat-image, .chat-status, .chat-room-name').live('click',function(){
        jQuery(this).parent().siblings().toggle();
    });
    jQuery('.online-box-panel span').click(function(){
        if(jQuery(this).parent().siblings('.chat-box-txt1').is(':visible')){
            jQuery(this).parent().siblings().hide();
        }else{
            jQuery(this).parent().siblings().show();
            if(jQuery('.chat-rooms-list option:selected').text().indexOf('(Owner)')==-1){
                jQuery('.chat-member-add-container').hide();
            }else{
                jQuery('.chat-member-add-container').show();
            }            
        }
    });
    jQuery('.chat-box-txt1 ul li').live('click',function(e){
        if(jQuery('input#vc_room_id[value="'+jQuery(this).attr('id')+'"]').length==0){
            var chatbox = jQuery('.chat-box-dummy:first').clone();
            jQuery(chatbox).find('.chat-box-txt ul').html('');

            jQuery(chatbox).find('#chat_max_id').attr('name','data[Updates]['+(jQuery('.cust-chat > div').length-1)+'][chat_max_id]');
            jQuery(chatbox).find('#vc_room_id').attr('name','data[Updates]['+(jQuery('.cust-chat > div').length-1)+'][vc_room_id]');

            jQuery(chatbox).find('#chat_max_id').val('0');
            jQuery(chatbox).find('#vc_room_id').val(jQuery(this).attr('id'));        

            jQuery(chatbox).find('.chat-room-name').html(jQuery(this).html());
            jQuery(chatbox).removeClass('chat-box-dummy').addClass('chat-box').show();

            //jQuery('.cust-chat > div:last').after(chatbox); 
            //jQuery('.cust-chat > div:last').css('right',(((jQuery('.cust-chat > div').length-2)*322)+228)+'px');        
            //alert(1);
            jQuery('.cust-chat > div:last').after(chatbox);
            if(jQuery('.cust-chat > div.chat-box').length > 2) {
                jQuery('.chat-box-nav-right').show();
                jQuery('.chat-box-nav-left').show();
                jQuery('.cust-chat > div.chat-box').hide();
                jQuery('.cust-chat > div.chat-box:last').css('right',((351)+228+35)+'px').show(); 
                jQuery('.cust-chat > div.chat-box:last').prev().css('right',(228+35)+'px').show();
            }else{
                jQuery('.chat-box-nav-right').hide();
                jQuery('.chat-box-nav-left').hide();
                jQuery('.cust-chat > div.chat-box').show();                
                jQuery('.cust-chat > div.chat-box:last').css('right',(((jQuery('.cust-chat > div.chat-box').length-1)*351)+228)+'px');        
            }            
        }
    });
    jQuery('.chat-box-expand').live('click',function(e){
        e.preventDefault();
        jQuery(this).removeClass('chat-box-expand').addClass('chat-box-expand-close');
        if(jQuery('.cust-chat > div.chat-box').length > 2){
            jQuery(this).parents('.chat-box:first').css('right',(228+35)+'px');
        }else{
            jQuery(this).parents('.chat-box:first').css('right',(228)+'px');
        }
        jQuery(this).parents('.chat-box:first').removeClass('chat-box').addClass('chat-box-panel-expend');
        jQuery('.cust-chat > div.chat-box').hide();
    });
    jQuery('.chat-box-expand-close').live('click',function(e){
        e.preventDefault();
        jQuery(this).removeClass('chat-box-expand-close').addClass('chat-box-expand');
        jQuery(this).parents('.chat-box-panel-expend:first').removeClass('chat-box-panel-expend').addClass('chat-box');
        jQuery('.cust-chat > div.chat-box').hide();
        next_chat_box = jQuery(this).parents('.chat-box:first').next();
        if(jQuery('.cust-chat > div.chat-box').length<=2){
            jQuery('.chat-box-nav-right').hide();
            jQuery('.chat-box-nav-left').hide();
            jQuery('.cust-chat > div.chat-box:first').css('right',(228)+'px').show();
            jQuery('.cust-chat > div.chat-box:first').next().css('right',(351+228)+'px').show();
        } else {
            if(next_chat_box.length!=0){
                next_chat_box.css('right',((351)+228+35)+'px').show();
                next_chat_box.prev().css('right',(228+35)+'px').show();
            }else{
                jQuery('.cust-chat > div.chat-box:last').css('right',(351+228+35)+'px').show();
                jQuery('.cust-chat > div.chat-box:last').prev().css('right',(228+35)+'px').show();
            }            
        }        
    });    
    jQuery('.chat-box-close').live('click',function(){
        jQuery(this).parents('.chat-box-panel-expend:first').removeClass('chat-box-panel-expend').addClass('chat-box');
        next_chat_box = jQuery(this).parents('.chat-box:first').next();
        jQuery(this).parents('.chat-box:first').remove();
        jQuery('.cust-chat > div.chat-box').hide();
        if(jQuery('.cust-chat > div.chat-box').length<=2){
            jQuery('.chat-box-nav-right').hide();
            jQuery('.chat-box-nav-left').hide();
            jQuery('.cust-chat > div.chat-box:first').css('right',(228)+'px').show();
            jQuery('.cust-chat > div.chat-box:first').next().css('right',(351+228)+'px').show();
        } else {
            if(next_chat_box.length!=0){
                next_chat_box.css('right',((351)+228+35)+'px').show();
                next_chat_box.prev().css('right',(228+35)+'px').show();
            }else{
                jQuery('.cust-chat > div.chat-box:last').css('right',(351+228+35)+'px').show();
                jQuery('.cust-chat > div.chat-box:last').prev().css('right',(228+35)+'px').show();
            }            
        }       
    }); 
    jQuery('.chat-box-nav-right').click(function(){
        jQuery('.cust-chat > div.chat-box-panel-expend .chat-box-expand-close').removeClass('chat-box-expand-close').addClass('chat-box-expand');
        jQuery('.cust-chat > div.chat-box-panel-expend').removeClass('chat-box-panel-expend').addClass('chat-box');
        if(jQuery('.cust-chat > div.chat-box').length>2){
            if (jQuery('.cust-chat > div.chat-box').index(jQuery('.cust-chat > div.chat-box:visible:first'))!=0){
                chat_box = jQuery('.cust-chat > div.chat-box:visible:first');
                if(chat_box.prev().length!=0){
                    jQuery('.cust-chat > div.chat-box').hide();
                    chat_box.css('right',((351)+228+35)+'px').show();
                    chat_box.prev().css('right',(228+35)+'px').show();
                }
            }
        }        
    });
    jQuery('.chat-box-nav-left').click(function(){
        jQuery('.cust-chat > div.chat-box-panel-expend .chat-box-expand-close').removeClass('chat-box-expand-close').addClass('chat-box-expand');
        jQuery('.cust-chat > div.chat-box-panel-expend').removeClass('chat-box-panel-expend').addClass('chat-box');
        if(jQuery('.cust-chat > div.chat-box').length>2){
            if (jQuery('.cust-chat > div.chat-box').index(jQuery('.cust-chat > div.chat-box:visible:last'))!=jQuery('.cust-chat > div.chat-box').length-1){
                chat_box = jQuery('.cust-chat > div.chat-box:visible:last');
                if(chat_box.next().length!=0){
                    jQuery('.cust-chat > div.chat-box').hide();
                    chat_box.css('right',(228+35)+'px').show();
                    chat_box.next().css('right',((351)+228+35)+'px').show();
                }
            }
        }        
    });    
    jQuery('.chat-room-add-member').live('click',function(e){
        e.preventDefault();
        jQuery.post(baseUrl+'chat/prRoomMemberAddJson/'+jQuery('.chat-rooms-list').val()+'/'+jQuery('#chat-member-id').val(),{},function(data){
            jQuery('#chat-member-id').val('');
            jQuery('#chat-member-name').val('')
        },'json');        
    });
    jQuery('.chat-rooms-add-container a').live('click',function(e){
        e.preventDefault();
        jQuery.post(baseUrl+'chat/prRoomAddJson/'+jQuery('.chat-rooms-add-container input').val(),{},function(data){
            jQuery('.chat-rooms-add-container input').val('');
            jQuery.post(baseUrl+'chat/prRoomsListHtml',{},function(data){
                jQuery('.chat-rooms-list').html(data);
            },'html');            
        },'json');         
    });
    getUpdates();
});