$(function() {
    $("#cancel-comment-reply-link").hide();
    $(".reply_button").live('click', function(event) {
        event.preventDefault();
        var id = $(this).attr("id");
        var x = "#list-children-" + id;

        //alert(id);
        if ($("#list-children-" + id).find('media').size() > 0) {
            $("#media-" + id + x).prepend($("#comment_form_wrapper"));
            $("#comment_name").focus();
        } else {
            $("#list-children-" + id).append($("#comment_form_wrapper"));
            $("#comment_name").focus();
        }
        $("#reply_id").attr("value", id);
        $("#cancel-comment-reply-link").show();
    });

    $("#cancel-comment-reply-link").bind("click", function(event) {
        event.preventDefault();
        $("#reply_id").attr("value", "");
        $("#comment_wrapper").prepend($("#comment_form_wrapper"));
        $(this).hide();
        $("#comment_name").focus();
    });

    $("#comment_form").bind("submit", function(event) {
        event.preventDefault();
        if ($("#comment_text").val() == "") {
            alert("Please enter your comment");
            return false;
        }
        
        $.ajax({
            type: "POST",
            url: window.location.origin + '/portal/blog/add_blog_comment',
            data: $('#comment_form').serialize(),
            dataType: "html",
            beforeSend: function() {
                $('#comment_wrapper').block({
                    message: 'Please wait....',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#ccc',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px'
                    },
                    overlayCSS: {
                        backgroundColor: '#ffe'
                    }
                });
            },
            success: function(comment) {
                //alert(comment);
                var reply_id = $("#reply_id").val();
                var x = "#list-children-" + reply_id;
                if (reply_id == "") {
                    $("#comment_wrapper").prepend(comment);
                    if (comment.toLowerCase().indexOf("error") >= 0) {
                        $("#comment_resp_err").attr("value", comment);
                    }
                } else {
                    if ($("#list-children-" + reply_id).find('media').size() > 0) {

                        //$("#li_comment_" + reply_id + " ul:first").prepend(comment);
                        $("#media-" + reply_id + x).prepend($("#comment_form_wrapper"));
                    } else {
                        $(x).append(comment);
                    }
                }

                $("#comment_text").attr("value", "");
                $("#reply_id").attr("value", "");
                $("#cancel-comment-reply-link").hide();
                $("#comment_wrapper").prepend($("#comment_form_wrapper"));
                $('#comment_wrapper').unblock();
            }


        }).done(function() {
            var newest = $("#newest").val();
            var media = "#media-" + newest;
            //jQuery(media).animate({ scrollTop: 100 }, 1000);
        });

    });

});