function timeSince(date) {
    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = seconds / 31536000;

    if (interval > 1) {
        return Math.floor(interval) + " year" + (Math.floor(interval) !== 1 ? "s" : "") + " ago";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
        return Math.floor(interval) + " month" + (Math.floor(interval) !== 1 ? "s" : "") + " ago";
    }
    interval = seconds / 86400;
    if (interval > 1) {
        return Math.floor(interval) + " day" + (Math.floor(interval) !== 1 ? "s" : "") + " ago";
    }
    interval = seconds / 3600;
    if (interval > 1) {
        return Math.floor(interval) + " hour" + (Math.floor(interval) !== 1 ? "s" : "") + " ago";
    }
    interval = seconds / 60;
    if (interval > 1) {
        return Math.floor(interval) + " minute" + (Math.floor(interval) !== 1 ? "s" : "") + " ago";
    }
    return Math.floor(seconds) + " second" + (Math.floor(seconds) !== 1 ? "s" : "") + " ago";
}

$(document).ready(function() {
    $.ajax({
        url: '/Stuco/council/notification/api/fetchnotif.php', // Update with the correct path
        type: 'GET',
        dataType: 'json',
        success: function(notifications) {
            $('#notification-container').empty(); // Clear the container before appending new notifications
            if (notifications.length > 0) {
                $.each(notifications, function(index, notification) {
                    var timeString = timeSince(new Date(notification.created_at));
        
                    // Create a new row for each notification
                    var notificationRow = $('<div>').addClass('row notification-item');
                    notificationRow.append(
                        $('<div>').addClass('col-lg-11').append(
                            $('<h3>').text(notification.title),
                            $('<p>').text(notification.message),
                        ),
                        $('<div>').addClass('col-lg-7').append(
                            $('<p>').text(timeString)

                        ),

                    );
        
                    // Append the new row to the notification container
                    $('#notification-container').append(notificationRow, $('<hr>'));
                });
            } else {
                $('#notification-container').text('No new notifications.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            $('#notification-container').text('Failed to fetch notifications.');
        }
    });
});