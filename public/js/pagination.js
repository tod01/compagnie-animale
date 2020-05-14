var page = 1;
$(window).scroll(function() {

    event.preventDefault();
    
    var path = window.location.pathname;
    var page_name = path.split("/").pop();

    if(page_name == "offers" && $(window).scrollTop() + $(window).height() >= $(document).height()) {
        console.log("page: ", page);
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page) {
    console.log('coucou')
    $.ajax(
        {
            url: '?page=' + (page),
            type: "get",
            beforeSend: function() {
                $('.ajax-load').show();
            }
        }
    ).done(function(data) {
        console.log(data)
        console.log('currentPage:', data.currentPage);
        console.log("lastPage:", data.lastPage);
        if(data.html == " " || data.currentPage > data.lastPage) {
            $('.ajax-load').html("No more ads found!");
            return;
        }
        
        $('.ajax-load').hide();
        $('#post-data').append(data.html);
        
    })
    .fail(function(jqXHR, ajaxOptions, thrownError) {
        alert('Server not responding...');
    })
}

