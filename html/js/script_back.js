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