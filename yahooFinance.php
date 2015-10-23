<?php
session_start();
echo file_get_contents('http://ichart.finance.yahoo.com/table.csv?s='.$_SESSION['stockName'].'&ignore=.csv');
