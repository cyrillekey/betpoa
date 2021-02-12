<?php
require('../conn/conn.php');
session_start();
echo("hello world");
$json = file_get_contents('php://input');

$obj = json_decode($json, TRUE);
$status = $obj['Body']['stkCallback']['ResultCode'];
$amount = $obj['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
$transid = $obj['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
$date = $obj['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
$number="0".substr($date,3);


$sql="INSERT into transactions_table VALUES(:transaction_id,:user,:transaction_type,:transaction_time,:transaction_amount)";
$stmt=$conn->prepare($sql);
$stmt->debugDumpParams();
$stmt->execute([
    "transaction_id"=>$transid,
    "user"=>$number,
    "transaction_type"=>$status,
    "transaction_time"=>time(),
    "transaction_amount"=>(int)$amount
]);
$stmt->debugDumpParams();