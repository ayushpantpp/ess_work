var baseUrl ='http://203.122.58.160:90/portal/';
var requests;
(function($) {
    jQuery("#breadCrumb0").jBreadCrumb();
    jQuery("#breadCrumb1").jBreadCrumb();
    jQuery("#breadCrumb2").jBreadCrumb();
    jQuery("#breadCrumb3").jBreadCrumb();
    String.prototype.toCamel = function(){
            return this.replace(/(\_[a-z])/g, function($1){return $1.toUpperCase().replace('_','');}).replace(/(^[a-z])/g, function($1){return $1.toUpperCase().replace('_','');});
    };    
    vTipQTip = function(scope){
        $(scope).find('.vtip').qtip({
            content: {
                text:false
            }, // Set the tooltip content to the current corner
            position: {
                corner: {
                    target: 'topMiddle',
                    tooltip: 'bottomMiddle'
                },
                adjust: {
                    y : -7
                }
            },
            show: {
                solo: true,
                delay: 0,
                effect: {effect: 'fade', length: 0}
            },
            hide: {
                delay: 0
            },        
            style: { 
                padding: 6,
                background: '#282828',
                color: '#fff',
                textAlign: 'center',
                fontSize: '11px',
                border: {
                    width: 0,
                    radius: 2,
                    color: '#282828'
                },
                tip:  { // Now an object instead of a string
                    corner: 'bottomMiddle', // We declare our corner within the object using the corner sub-option
                    color: '#282828',
                    size: {
                        x: 7, // Be careful that the x and y values refer to coordinates on screen, not height or width.
                        y : 3 // Depending on which corner your tooltip is at, x and y could mean either height or width!
                    }
                }
            }
        });
    };
	$('.htip').qtip({
	    content: {
		text:false
	    }, // Set the tooltip content to the current corner
	    position: {
		corner: {
		    target: 'topRight',
		    tooltip: 'bottomLeft'
		},
		adjust: {
		    y : -2,
		    x : -10
		}
	    },
	    show: {
		solo: true,
		delay: 0,
		effect: {effect: 'fade', length: 0}
	    },
	    hide: {
		delay: 0
	    },        
	    style: { 
		padding: 6,
		background: '#282828',
		color: '#fff',
		textAlign: 'center',
		fontSize: '11px',
		border: {
		    width: 0,
		    radius: 0,
		    color: '#282828'
		},
		tip:  { // Now an object instead of a string
		    corner: 'bottomLeft', // We declare our corner within the object using the corner sub-option
		    color: '#282828',
		    size: {
			x: 6, // Be careful that the x and y values refer to coordinates on screen, not height or width.
			y : 10 // Depending on which corner your tooltip is at, x and y could mean either height or width!
		    }
		}
	    }
	});
    vTipQTip('*');
    showIDErrorInline = function(jsonObj) {
        var key = '';
        for (form in jsonObj) {
            key = '';
            for (index in jsonObj[form]) {
                for (element in jsonObj[form][index]) {
                    key = form.toCamel()+index.toCamel()+element.toCamel();
                    $('#'+ key).addClass('error');
                    $('#'+ key).after($('<div class="error-message">'+jsonObj[form][index][element]+'</div>'));
                }
            }
        }
    }
    clearIDErrorInline = function(obj) {
        $(obj).removeClass('error');
        $(obj).siblings('.error-message').remove();
    } 
    clearAllIDErrorInline = function() {
        $('.error').removeClass('error');
        $('.error-message').remove();        
    }
    showIDErrorQTip = function(jsonObj) {
        $.each(jsonObj, function(key,val){
            $('#'+ key).addClass('eTip');
            $('#'+ key).attr('title',val);
        });
        $('.eTip').qtip({
            content: {
                text:false
            }, // Set the tooltip content to the current corner
            position: {
                corner: {
                    target: 'topMiddle',
                    tooltip: 'bottomMiddle'
                }
            },
            show: {
              when: false, // Don't specify a show event
              ready: true // Show the tooltip when ready
            },
            hide: {
                when: {event: 'focus'}
            }, // Don't specify a hide event             
            style: { 
                padding: 6,
                background: '#F79992',
                color: '#fff',
                textAlign: 'center',
                border: {
                    width: 1,
                    radius: 0,
                    color: '#CE6F6F'
                },
                tip:  { // Now an object instead of a string
                    corner: 'bottomMiddle', // We declare our corner within the object using the corner sub-option
                    color: '#CE6F6F',
                    size: {
                        x : 7, // Be careful that the x and y values refer to coordinates on screen, not height or width.
                        y : 5 // Depending on which corner your tooltip is at, x and y could mean either height or width!
                    }
                }
            }
        });
        //$('.eTip').qtip("show");
    };    
    showErrorQTip = function(jsonObj,formName) {
        $.each(jsonObj, function(key,val){
            $('*[name="data['+formName+']['+ key +']"]').addClass('eTip');
            $('*[name="data['+formName+']['+ key +']"]').attr('title',val);
        });
        $('.eTip').qtip({
            content: {
                text:false
            }, // Set the tooltip content to the current corner
            position: {
                corner: {
                    target: 'topMiddle',
                    tooltip: 'bottomMiddle'
                }
            },
            show: {
              when: false, // Don't specify a show event
              ready: true // Show the tooltip when ready
            },
            hide: {
                when: {event: 'change'}
            }, // Don't specify a hide event             
            style: { 
                padding: 6,
                background: '#F79992',
                color: '#fff',
                textAlign: 'center',
                border: {
                    width: 3,
                    radius: 0,
                    color: '#CE6F6F'
                },
                tip:  { // Now an object instead of a string
                    corner: 'bottomMiddle', // We declare our corner within the object using the corner sub-option
                    color: '#CE6F6F',
                    size: {
                        x : 7, // Be careful that the x and y values refer to coordinates on screen, not height or width.
                        y : 5 // Depending on which corner your tooltip is at, x and y could mean either height or width!
                    }
                }
            }
        });
        //$('.eTip').qtip("show");
    };
    $.fn.errorStyle = function() {
       this.replaceWith(function(i,html){
            var StyledError = "<div class=\"ui-state-error ui-corner-all\" style=\"padding: 0 .7em;display:none;width:500px;margin:0 auto;\" id=\"response-message\">";
            StyledError += "<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\">";
            StyledError += "</span><strong><img src='"+baseUrl+"/img/attention.png' />Attention : </strong>";
            StyledError += html;
            StyledError += "<a style=\"margin-left:20px\" href=\"javascript:void()\" onclick=\"jQuery(this).parents('#response-message').hide();\">[x]</a></p></div>";
            return StyledError;
        });
    };
    $.fn.highlightStyle = function() {
        this.replaceWith(function(i,html){
            var StyledError = "<div class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0 .7em;display:none;width:500px;margin:0 auto;\" id=\"response-message\">";
            StyledError += "<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\">";
            StyledError += "</span><strong><img src='"+baseUrl+"/img/notification.png' />Attention : </strong>";
            StyledError += html;
            StyledError += "<a style=\"margin-left:20px\" href=\"javascript:void()\" onclick=\"jQuery(this).parents('#response-message').hide();\">[x]</a></p></div>";
            return StyledError;
        });
    };
    jQuery('button').button();
     $('#new-messsages').delay(10000).fadeOut(500);
})(jQuery);
