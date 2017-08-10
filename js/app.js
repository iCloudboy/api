$(document).ready(function() {
    function relTime(time_value) {
        time_value = time_value.replace(/(\+[0-9]{4}\s)/ig,"");
        var parsed_date = Date.parse(time_value);
        var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
        var timeago = parseInt((relative_to.getTime() - parsed_date) / 1000);
        if (timeago < 60) return 'less than a minute ago';
        else if(timeago < 120) return 'about a minute ago';
        else if(timeago < (45*60))
            return (parseInt(timeago / 60)).toString() + 'minutes ago';
        else if(timeago < (90*60)) return 'about an hour ago';
        else if(timeago < (24*60*60))
            return 'about ' + (parseInt(timeago / 3600)).toString() + ' hours ago';
        else if(timeago < (48*60*60)) return '1 day ago';
        else return (parseInt(timeago / 86400)).toString() + ' days ago';
    }

    $.getJSON("searchtweets.php", function (tweetdata) {
        var tl = $("#tweet-list");
        $.each(tweetdata, function(i,tweet) {
            $.each(tweet, function(i, tweetdetails){
                tl.append("<div id='tweet-container'>"
                    + "<div id='tweet-left'>"
                    + "<img src='" + tweetdetails.user.profile_image_url + "'/>"
                    + "</div>"
                    + "<div id='tweet-right'>"
                    + "<div id='tweet-user-details'>"
                    + "<p class='tweet-username'>" + tweetdetails.user.screen_name + "</p>" + "   " + "<p class='tweet-time'>" + relTime(tweetdetails.created_at) + "</p><br/> "
                    + "</div>"
                    + "<br/>"
                    + tweetdetails.text
                    + "</div>"
                    + "</div><br/>");
            });
        });
    });


    //if the refresh button is pressed search for tweets again
    $("#refresh-tweets").click(function() {
        $.getJSON("searchtweets.php", function (tweetdata) {
            var tl = $("#tweet-list");
            tl.empty(); //empty the list before repopulating
            $.each(tweetdata, function(i,tweet) {
                $.each(tweet, function(i, tweetdetails){
                    tl.append("<div id='tweet-container'>"
                        + "<div id='tweet-left'>"
                        + "<img src='" + tweetdetails.user.profile_image_url + "'/>"
                        + "</div>"
                        + "<div id='tweet-right'>"
                        + "<div id='tweet-user-details'>"
                        + "<p class='tweet-username'>" + tweetdetails.user.screen_name + "</p>" + "   " + "<p class='tweet-time'>" + relTime(tweetdetails.created_at) + "</p><br/> "
                        + "</div>"
                        + "<br/>"
                        + tweetdetails.text
                        + "</div>"
                        + "</div><br/>");
                });

            });

        });
    });

    $(".giglocation").each(function(){
        $(this).mouseenter(function(){
            $(this).children().last().show();
        });
        $(this).mouseleave(function(){
            $(this).children().last().hide();
        });
    })

});
