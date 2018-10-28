@php
  header("Content-type: text/javascript; charset: UTF-8");
@endphp
<script type="text/javascript">
  var notificationsCountElem = $('.notification_count');
  var notificationsCount     = parseInt(notificationsCountElem.data('count'));
  var notifications          = $('#div_notifications');

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
    encrypted: true,
    cluster: 'ap1',
  });

  // Subscribe to the channel we specified in our Laravel Event
  var channel = pusher.subscribe('Notify');
  var user_id_channel = '{{ Auth::id() }}';
  // Bind a function to a Event (the full Laravel class)
  channel.bind('notify-messages-action-' + user_id_channel , function(data) {
    var existingNotifications = notifications.html();
    var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
    var newNotificationHtml = `
      <li class="notification active mc-border-notification">
        <div class="media">
          <img src="https://api.adorable.io/avatars/71/100.png" class="mr-2 img-circle" alt="${data.sender}">
          <div class="media-body">
            <strong class="notification-title">
              <a href="${data.link}">${data.sender}</a> ${data.action} 
              <a href="${data.link}">${data.title}</a>
            </strong>
            <p class="notification-desc">${data.content}</p>
            <div class="notification-meta">
              <small class="timestamp">${data.created_at}</small>
            </div>
          </div>
        </div>
      </li>
    `;
    notifications.html(newNotificationHtml + existingNotifications);
    notificationsCount += 1;
    notificationsCountElem.attr('data-count', notificationsCount);
    notificationsCountElem.text(notificationsCount);
  });
</script>