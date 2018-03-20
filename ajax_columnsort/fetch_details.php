<?php

include "config.php";

$columnName = $_POST['columnName'];
$sort = $_POST['sort'];

$select_query = "SELECT * FROM employee order by ".$columnName." ".$sort." ";

$result = mysql_query($select_query);

$html = '';
while($row = mysql_fetch_array($result)){
    $name = $row['emp_name'];
    $salary = $row['salary'];
    $gender = $row['gender'];
    $city = $row['city'];
    $email = $row['email'];

    $html .= "<tr>
    <td>".$name."</td>
    <td>".$salary."</td>
    <td>".$gender."</td>
    <td>".$city."</td>
    <td>".$email."</td>
    </tr>";
}

echo $html;