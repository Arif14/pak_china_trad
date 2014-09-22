



$(".nav-sidebar li").click(function(e){
    e.preventDefault();
    
    if($(e.currentTarget).attr("class") === "sub"){
        
        console.log("sub sub");
        var href =  $($(this).html()).attr("href");
        loadAjax(href);
        console.log("href : " + href);
        e.stopPropagation();
        return;
    }
    
    console.log($(e.currentTarget).html());
    
     var l = $(e.currentTarget).attr("class");
    console.log(l);
    //console.log(l.indexOf("expand"));
    
    if(l.indexOf("unexpand") > -1 ){
        
        
        
        console.log("inside if");
       
        expandList($(e.currentTarget));
       
    }else if(l.indexOf("expand") > -1){
    }else{
        console.log("inside else");
    
    $(".nav-sidebar li").attr("class","inactive");
    
    $(e.currentTarget).attr("class","active");
    
    
    var href =  $($(this).html()).attr("href");
    
    loadAjax(href);
    }
    
});

function loadAjax(url){
    
  //  console.log(url);
    $(".main").load(url);

}


function expandList(list){
    
    
    $(".expand ul").attr("class","nav nav-sidebar hidden");
    $(".expand").attr("class","unexpand");
    
    
    list.attr("class","active expand");
    
    $(".expand ul").attr("class","nav nav-sidebar visible");
    
}

$.getJSON("http://localhost/pak_china_template/gmap_lat_long.json").done(function(data){
    console.log(data);
});


