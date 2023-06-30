<?php
$answer = 0;
if ($_SERVER["RESQUEST_METHOD"] == "post") {

    $numOne = $_POST['num_1'];
    $numTwo = $_POST['num_2'];
    $op = $_POST['operator'];

    // $operator +, -, *, /
    if ($op == '+') {
        $answer = $numOne + $numTwo;
    } elseif ($op == '-') {
        $answer = $numOne - $numTwo;
    } elseif ($op == '*') {
        $answer = $numOne * $numTwo;
    } elseif ($op == '/') {
        $answer = $numOne / $numTwo;
    } else {
        $answer = 'Invalid operator';
    }
}