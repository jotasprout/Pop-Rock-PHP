<?php 
    include "config.php";
?>
<!doctype html>
<html>
    <head>
        <title>Sorting the Table by clicking Header with AJAX</title>
        <link href='style.css' rel='stylesheet' type='text/css'>
        <script src='jquery-1.12.0.min.js' type='text/javascript'></script>
        <script src='script.js' type='text/javascript'></script>
        
    </head>
    <body>
        <div class='container'>
            <input type='hidden' id='sort' value='asc'>
            <table width='100%' id='empTable' border='1' cellpadding='10'>
                <tr>
                    <th><span onclick='sortTable("emp_name");'>Name</span></th>
                    <th><span onclick='sortTable("salary");'>Salary</span></th>
                    <th><span onclick='sortTable("gender");'>Gender</span></th>
                    <th><span onclick='sortTable("city");'>City</span></th>
                    <th><span onclick='sortTable("email");'>Email</a></th>
                </tr>
                <?php 
                $query = "SELECT * FROM employee order by id asc";
                $result = mysql_query($query);
                while($row = mysql_fetch_array($result)){
                    $name = $row['emp_name'];
                    $salary = $row['salary'];
                    $gender = $row['gender'];
                    $city = $row['city'];
                    $email = $row['email'];

                ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $salary; ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><?php echo $city; ?></td>
                        <td><?php echo $email; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </body>
</html>