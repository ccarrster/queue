# queue
Go to the main page.
It's multi store... so store_id is a must
index.php is where you go for web.
ajax.php connects to the db, mostly.

All get params run.
TODO -> Nothing secure.

page=store -> store admin overview of many queues and ability to send notifications. Auto updates every 5 seconds.
page=scan -> show a fixed qr code for the moment. TODO make it dynamic and real for the specific queue
page=add -> entry of name,phone,email for a specific queue. TODO send real text and email notifications
page=personal -> shows the number of people ahead of you in the queue. A great place for communication in the future. Refreshes every 5 seconds.

TODO
Add page=display -> a queue specific public display for the one queue. Similar to Pizza Hut or McDonalds order screens.
Add page=terminal -> a queue specific add page that will run not on your phone, but on a physical terminal.
Add page=>reports -> review and export a series of queue reports. Time in queue, no shows etc, number of customers per day etc.
