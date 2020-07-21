
/*$(document).ready(function() {
    var $loadMoreMessagesLink = $("#loadMoreMessages");
    var $commentsDiv = $("#commentsDiv > .row:last-child");


    $loadMoreMessagesLink.on("click", function(e) {
        var offset = 0;
        $.ajax({
            url: "{{ path('loadMessages', {'id': trick.id, 'limit': 10, 'offset': '__OFFSET__' }) }}" . replace('__OFFSET__', offset),
            success: function(messages) {
                alert(messages);
            }
        });
    });
})*/




/*
$(document).ready(function() {
    var loadMoreMessagesLink = $("#loadMoreMessages");
    var commentsDiv = $("#commentsDiv > .row:last-child");

    loadMoreMessagesLink.on("click", function(e) {
        console.log("ok");
        $.ajax({
            type: 'POST',
            url: "{{ path('loadMessages', {'id': }) }}",
            data: { messages: 'messages' },
            success: function(messages) {
                alert(messages);
            }
        });
    })
});
*/