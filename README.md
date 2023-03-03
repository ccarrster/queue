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


More notes

Queueing System

Register
Get updates
Get notifications - soon
Back on site
Notification of you are now
Getting help
Cancel/delay
Reports

API links
Plugin to app -> end points
Text messages
Multi-site
PII?
Scenario for story -> shop example.

Users
Cell Phone customers -> QR code or url register, cancel
Cookies, check back in
Terminal Customers -> Touch screen/keyboard mouse/tablet
Everyone same… Single entry only?, check back in
Display Customers -> TV -> read only who is next, how many in line, instructions, QR code to scan?
Terminal Employees -> touch screen/keyboard see list, say you are servicing/remove. No shows. Send messages… now helping X via email/text/phone or say their name. Flash up on the screen.
