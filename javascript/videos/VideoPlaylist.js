$(document).ready(function(){
    objecthtml = $("#video").html();

    $('body').on('click','.youtubeVideo',function(e){
        e.preventDefault();
        $('#results li').removeClass("current");
        $(this).parent().addClass("current");
        var t = $(this);
        var url = t.attr("href");
        var title = t.attr('title');
        description = t.attr('alt');
        $("html, body").animate({ scrollTop:600 },"slow");
        buildYoutubeLink(url, title);
        return false;

    });
});

function buildYoutubeLink(url, title){
    var frame = '<iframe width="561" height="342" src="//www.youtube.com/embed/'+url+'" frameborder="0" allowfullscreen></iframe>';
    $("#video").html(frame);
    $('#currentVidTitle').html(title);
    $("#currentVidDesc").html(description);//do we need this?
    return false;
}