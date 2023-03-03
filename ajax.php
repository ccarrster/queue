<?php

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

if($_GET['action'] == 'notify'){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "INSERT INTO notification (customer_id, queue_id, type, text) VALUES(".$_GET['customer_id'].", ".$_GET['queue_id'].", 1, 'You are next in line to be served. Come on back.')";
    $result = $conn->query($sql);
    $conn->close();
}
if($_GET['action'] == 'serve'){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE queue_customer SET status = 1, updated_at = NOW() WHERE customer_id = ".$_GET['customer_id']." and queue_id = ".$_GET['queue_id'];
    $result = $conn->query($sql);
    $conn->close();
}

if($_GET['action'] == 'cancel'){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE queue_customer SET status = 2, updated_at = NOW() WHERE customer_id = ".$_GET['customer_id']." and queue_id = ".$_GET['queue_id'];
    $result = $conn->query($sql);
    $conn->close();
}

if($_GET['action'] == 'add_to_queue'){
    $customer_name = $_GET['customer_name'];
    $customer_phone = $_GET['customer_phone'];
    $customer_email = $_GET['customer_email'];
    $queue_id = $_GET['queue_id'];
    //TODO set this
    $store_id = 1;

    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "INSERT INTO customer (name, phone, email, store_id) VALUES('".$customer_name."','".$customer_phone."','".$customer_email."','".$store_id."')";  
    $result = $conn->query($sql);

    $customer_id = mysqli_insert_id($conn);
    $sql = "INSERT INTO queue_customer (queue_id, customer_id) VALUES('".$queue_id."','".$customer_id."')";  
    $result = $conn->query($sql);
}

if($_GET['action'] == 'queues'){
  $queues = array();
  $conn = new mysqli($servername, $username, $password, $dbname);
  $store_id = $_GET['store_id'];
  $sql = "select id, name from queue where store_id = ".$store_id;
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $queues[] = array('queue_name' => $row["name"], 'queue_id' => $row["id"]);
    }
  }
  $conn->close();

  foreach($queues as &$queue){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "select customer.id, customer.name, customer.phone, customer.email, customer.created from queue_customer JOIN customer on queue_customer.customer_id = customer.id where queue_customer.status = 0 AND queue_id = ".$queue['queue_id'];
    $result = $conn->query($sql);
    $customers = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $customer = array();
            $customer['customer_id'] =  $row["id"];
            $customer['customer_name'] = $row["name"];
            $customer['customer_phone'] = $row["phone"];
            $customer['customer_email'] = $row["email"];
            $customers[] = $customer;
        }
    }
    $queue['customers'] = $customers;
    $conn->close();
  }
  echo(json_encode(array('data'=>$queues)));
}

if($_GET['action'] == 'personal'){
    $queues = array();
    $conn = new mysqli($servername, $username, $password, $dbname);
    $queue_id = $_GET['queue_id'];
    $customer_id = $_GET['customer_id'];
    $sql = "select count(*) as count from queue_customer where status = 0 AND queue_id = " . $queue_id . " AND id < (select id from queue_customer where queue_id = " . $queue_id . " AND customer_id = ".$customer_id.")";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $queues[] = array('customers_ahead' => $row["count"]);
      }
    }
    $conn->close();
  
    echo(json_encode(array('data'=>$queues)));
  }



