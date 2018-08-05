$(document).ready(function(){
    $(document).on('click', '.btn-reply', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#form_reply' + id).toggle();
    })

    $(document).on('submit', '.form_reply', function(e){
        e.preventDefault();
        var feed_id = $(this).data('feed');
        var reply_id = $(this).data('parent') || null;
        if(!feed_id){
            return false;
        }

        $.ajax({
            type: 'POST',
            url: $(this).prop('action'),
            data: $(this).serialize() + '&feed_id=' + feed_id + '&reply_id=' + reply_id + '&_token=' + _token,
            dataType: 'json',
            success:function(data){
                console.log('FORM REPLY FEED');
                console.log(data);
                getShipFeeds();
            },
            error:function(e){
                console.log(e);
            }
        });
    })

    $('.feed_refresh').click(function(e){
        e.preventDefault();
        var reload = $(this).data('time');
        if(!reload){
            return false;
        }
        setTimeFeed(reload);
    });
})

function getShipFeeds(){
    $.ajax({
        type: 'GET',
        url: _feed_route,
        dataType: 'json',
        success:function(data){
            console.log('FEED');
            feed_template = _.template($('#feed_template').html());
            $('#feed_content').html('');
            $.each(data, function(index, object){
                $('#feed_content').append(feed_template(object));
            })
            if(window.location.hash){
                var to = $(window.location.hash);
                $(document).scrollTop((to.offset().top - 100) );
                history.replaceState('', document.title, window.location.pathname);
                to.closest('.feed_area').css({border: '0 solid #f37736'})
                    .animate({borderWidth: 1}, 0)
                    .animate({borderWidth: 0}, 3000);
            }
        },
        error:function(e){
            console.log(e);
        }
    });
}
getShipFeeds();
var reload_time = Cookies.get('feed_reload') || 2;
setTimeFeed(reload_time);
function setTimeFeed(reload_time){
    if(reload_time === 'now'){
        getShipFeeds();
        $('#count-feed').hide();
        return false;
    }
    if(reload_time !== undefined && reload_time !== null) {
        Cookies.set('feed_reload', reload_time);
    }
    //reset badges
    $('.feed_refresh span').removeClass('badge-primary');
    $('.feed_refresh span').addClass('badge-secondary');

    $(".feed_refresh[data-time='" + reload_time + "'] span").addClass('badge-primary');
    $(".feed_refresh[data-time='" + reload_time + "'] span").removeClass('badge-secondary');
    window.setTimeout(function(){
        checkIfNewsFeeds();
        setTimeFeed(reload_time);
    }, (reload_time * 1000) * 60)
}

function checkIfNewsFeeds(){
    var last_feed = $("a[id*='feed-box']").prop('id');
    if(!last_feed){
        return false;
    }
    last_feed = last_feed.replace('feed-box', '');
    $.ajax({
        type: 'GET',
        url: '/count/news/feed/',
        data: {'last_feed': last_feed},
        dataType: 'json',
        success:function(data){
            if(data.count > 0){
                console.log(data.count);
                $('#count-feed .badge-light').html(data.count);
                $('#count-feed').show();
            }
        },
        error:function(e){
            console.log(e);
        }
    });
}