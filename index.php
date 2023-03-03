<html>
<head>
  <title>Queue</title>
  <script src="jquery-3.6.3.js"></script>
</head>
<body>
<?php

if(isset($_GET['store'])){
  $store = $_GET['store'];
  //echo('Store: ' . $store.'<br>');
} else {
  $store = 1;
}
if(isset($_GET['page'])){
  $page = $_GET['page'];
  //echo('Page: '.$page.'<br>');
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "queue";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name FROM store WHERE id = ".$store;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    //echo "Store: " . $row["name"]. " " . "<br>";
    $store_name = $row["name"];
  }
} else {
  echo "0 results";
}
$conn->close();


if($page == 'store'){
  echo('<div id="queues"></div>');
}
if($page == 'personal'){
  echo('<div id="personal"></div>');
}
if($page == 'add'){
  echo('Add yourself to the queue<br>');
  echo('We will notify you when it is your turn to be served<br>');
  echo('<form>Name: <input id="input_name" name="name"><br>Phone: <input id="input_phone" name="phone"><br>Email: <input id="input_email" name="email"><br><input type="button" value="Add to Queue" onclick=add_queue('.$_GET['queue_id'].')></form>');
}
if($page == 'scan'){
  echo("<img src='frame.png'>");
  echo("<br>Scan to add yourself the queue<br>or go to http://localhost:8888/?store=1&queue_id=1&page=add to add yourself to the queue");
  echo('We will notify you when it is your turn to be served<br>');
}
?>
<script>
  function notify(customer_id, queue_id){
    alert("Notify " + customer_id + " " + queue_id);
    $.get('ajax.php?action=notify&customer_id=' + customer_id + '&queue_id=' + queue_id);
  }
  function serve(customer_id, queue_id){
    alert("Serve " + customer_id + " " + queue_id);
    $.get('ajax.php?action=serve&customer_id=' + customer_id + '&queue_id=' + queue_id);
  }
  function cancel(customer_id, queue_id){
    alert("Cancel " + customer_id + " " + queue_id);
    $.get('ajax.php?action=cancel&customer_id=' + customer_id + '&queue_id=' + queue_id);
  }
  function getQueues(store_id){
    $.get('ajax.php?action=queues&store_id=' + store_id, function(data){
      var queues = JSON.parse(data);
      $("#queues").html('');
      for (let i = 0; i < queues.data.length; i++) {
        var queue = queues.data[i];
        console.log(queue);
        $("#queues").append(queue.queue_name+'<hr>');
        if(queue.customers.length == 0){
          $("#queues").append('Queue is empty.');
        }
        for(let j = 0; j < queue.customers.length; j++){
          var customer = queue.customers[j];
          $("#queues").append('Customer Name: '+customer.customer_name+'<br>');
          $("#queues").append('Phone: ' + customer.customer_phone+'<br>');
          $("#queues").append('Email: ' + customer.customer_email+'<br>');
          $("#queues").append('<form><input onclick="notify('+customer.customer_id+', '+queue.queue_id+')" type="button" value="Notify"> <input onclick="serve('+customer.customer_id+', '+queue.queue_id+')" type="button" value="Serve"> <input onclick="cancel('+customer.customer_id+', '+queue.queue_id+')" type="button" value="Cancel"></form>');
        }
      }
    });
  }
  function add_queue(queue_id){
    var customer_name = $("#input_name").val();
    var customer_phone = $("#input_phone").val();
    var customer_email = $("#input_email").val();
  
    $.get('ajax.php?action=add_to_queue&queue_id=' + queue_id+'&customer_name=' + customer_name+'&customer_phone=' + customer_phone+'&customer_email=' + customer_email);
  }

  function getPersonal(queue_id, customer_id){
    $.get('ajax.php?action=personal&queue_id=' + queue_id + '&customer_id=' + customer_id, function(data){
      var queues = JSON.parse(data);
      console.log(queues);
      if(queues.data[0].customers_ahead != undefined){
        $("#personal").html('Customers ahead of you: '+queues.data[0].customers_ahead);
      } else {
        $("#personal").html('You are at the front of the line.');
      }
    });
  }
  

  function refresh_loop(){
    getQueues(1);
    <?php
    if($page == 'personal'){
      $queue_id = $_GET['queue_id'];
      $customer_id = $_GET['customer_id'];
      echo('getPersonal('.$queue_id.', '.$customer_id.');');
    }
    ?>
    
    setTimeout(refresh_loop, 5000);
  }
  refresh_loop();
</script>
</body>
</html>