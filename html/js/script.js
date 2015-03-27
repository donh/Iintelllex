function getQueryVariable(variable){
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
       var pair = vars[i].split("=");
       if(pair[0] == variable){return decodeURIComponent(pair[1].replace(/\+/g," "));}
    }
   return(false);
}
function getQueryVariables(variable){
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    var result = [];
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){
            result.push(decodeURIComponent(pair[1]));
        }
    }
    if (result.length){
        return result;
    }
    return(false);
}

$(function() {
    $(".dropdown-menu li a").click(function() {
        $(".btn:first-child").text($(this).text());
        $(".btn:first-child").val($(this).text());
    });

    $("#jurisdiction-btn-all").click(function(){
        if($("#jurisdiction-btn-all").is(':checked')){
            $(".jurisdiction-btn").prop('checked', true);
        }else{
            $(".jurisdiction-btn").prop('checked', false);
        }   
    });
    $(".jurisdiction-btn").click(function(){
        if($("#jurisdiction-btn-all").is(':checked')){
            $("#jurisdiction-btn-all").prop('checked', false);
        }
    });

    function updateTopSearchBar(){
        var query = getQueryVariable("q");
        if(query) $("#searchQuery").val(query);

        var JXs = getQueryVariables("jurisdiction%5B%5D");
        jQuery("input[name='jurisdiction[]']").prop("checked",false);
        if(JXs.length){
            for(var i=0;i<JXs.length;i++){
                jQuery("input[name='jurisdiction[]'][value='"+JXs[i]+"']").prop("checked",true);
            }
        }
    }
    updateTopSearchBar();

    var start = getQueryVariable("start");
    if(start){
        start = parseInt(start);
        $("#page-right").prop("disabled",false);
        if(start>0){
            $("#page-left").prop("disabled",false);
        }
        start = start - (start % 30);
        $("#page-left").click(function(){
            var startMinus = start-30;
            if(startMinus<0) startMinus=0;
            updateTopSearchBar();
            $("#top-search-start").val(startMinus);
            $("form#top-search").submit();
        });
        $("#page-right").click(function(){
            $("#top-search-start").val(start+30);
            updateTopSearchBar();
            $("form#top-search").submit();
        });
    }
});

jQuery(function() {
    var yearDropdownHtml = "<li role='resentation'><a role='menuitem' tabindex='-1' value='-'>-</a></li>";
    for(var i=1900;i<=2020;i++){
        yearDropdownHtml+="<li role='resentation'><a role='menuitem' tabindex='-1' value='"+i+"'>"+i+"</a></li>"
    }
    jQuery(".year-dropdown-menu").html(yearDropdownHtml);
    var monthDropdownHtml = "<li role='resentation'><a role='menuitem' tabindex='-1' value='-'>-</a></li>";
    var months =["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    for(var i=1;i<=12;i++){
        monthDropdownHtml+="<li role='resentation'><a role='menuitem' tabindex='-1' value='"+i+"'>"+months[i-1]+"</a></li>"
    }
    jQuery(".month-dropdown-menu").html(monthDropdownHtml);
    
    jQuery(".dropdown>.dropdown-menu>li>a").click(function(e) {
        window.ee = e;
        window.je = jQuery(e.target).parent().parent().parent().children().first();

        jQuery(e.target).parent().parent().parent().children().first().val(
            jQuery(this).text()).html(jQuery(this).text()+" <span class='caret'></span>"
            );
    });

    jQuery("#form-choice-practictioner").click(function(){
        jQuery("#practictioner-form").show();
        jQuery("#student-form").hide();
    });
    jQuery("#form-choice-student").click(function(){
        jQuery("#student-form").show();
        jQuery("#practictioner-form").hide();
    });

    jQuery("#jurisdiction-btn-all").click(function() {
        jQuery('.jurisdiction-btn').prop('checked', true);
        var checked = 1;
        jQuery('input:checkbox.jurisdiction-btn').each(function() {
            if (jQuery(this).prop('checked') === false) {
                jQuery('#jurisdiction-btn-all').prop('checked', false);
            }
        });
        if (checked === 1)
            jQuery('#jurisdiction-btn-all').prop('checked', true);
    });

    jQuery("#logo").parent().prepend('<div id="signin-icon" style="float:right;"><a href="/sign-in/" class="fa fa-sign-in"></a></div>');

    jQuery(document).ready(function() {
        jQuery(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
    jQuery(".chosen-select").chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    }).change(function(){
        updateSubmitButton();
    });
    jQuery("#signup-form input").keyup(function() {
        updateSubmitButton();
    });
    function isFormValid_fn(){
        return jQuery("#signup-form-fn").val() != "";
    }
    function isFormValid_ln(){
        return jQuery("#signup-form-ln").val() != "";
    }
    function isFormValid_email(){
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(jQuery("#signup-form-email").val());
    }
    function isFormValid_jx(){
        return jQuery("form#signup-form .chosen-select").val() != null;
    }
    function isFormValid(){
        var bool = isFormValid_fn() && isFormValid_ln() && isFormValid_email() && isFormValid_jx();
        return bool;
    }
    function updateSubmitButton(){
        jQuery("#signup-form-submit").removeClass("disable");
        if(!isFormValid()){
            // jQuery("#signup-form-submit").attr('disabled','disabled');
            jQuery("#signup-form-submit").addClass("disable");
        } else{
            // jQuery("#signup-form-submit").removeAttr('disabled');
        }
    }
    function highlightInvalidForm(){
        var invalid = "invalid-input";
        jQuery("#signup-form .chosen-choices").removeClass(invalid);
        jQuery("#signup-form input").removeClass(invalid);

        if(!isFormValid_fn()) jQuery("#signup-form-fn").addClass(invalid);
        if(!isFormValid_ln()) jQuery("#signup-form-ln").addClass(invalid);
        if(!isFormValid_email()) jQuery("#signup-form-email").addClass(invalid);
        if(!isFormValid_jx()) jQuery("#signup-form .chosen-choices").addClass(invalid);
    }
    jQuery( "#signup-form-submit" ).click(function( event ) {
        if(!isFormValid()){
            highlightInvalidForm();
        }
    });
    jQuery( "#signup-form" ).submit(function( event ) {
        if(!isFormValid()){
            highlightInvalidForm();
            event.preventDefault();
        }
    });
});

function checkboxes() {
    var checkedboxed = false;
    jQuery('input#jurisdiction-btn').each(function() {
        console.log(jQuery(this).contents().toString());
        if (jQuery(this).prop('checked') === true) {
            checkedboxed = true;
            return;
        }
    });
    console.log(checkedboxed);
    if (!checkedboxed) {
        jQuery("#dropdownMenu1").css("border-color", "red");
    }
    return checkedboxed;
}

