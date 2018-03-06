   
/*==================== FLASH Message =====================*/    
var baseUrl ='http://203.122.58.160:90/portal/';
var requests;
(function($) {
  
    String.prototype.toCamel = function(){
            return this.replace(/(\_[a-z])/g, function($1){return $1.toUpperCase().replace('_','');}).replace(/(^[a-z])/g, function($1){return $1.toUpperCase().replace('_','');});
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
/*==================== FLASH Message =====================*/    