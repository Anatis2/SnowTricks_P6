
$(document).ready(function() {
    var loadMoreMessagesLink = $("#loadMoreMessages");
    var commentsDiv = $("#commentsDiv > .row:last-child");

    loadMoreMessagesLink.on("click", function(e) {
        $.ajax({
            type: 'GET',
            url: "{{ path('loadMessages')}} ",
            data: { messages: 'messages' }
        });
    })
});


