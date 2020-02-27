<?php
include ('./header.php');
require_once('./dao/customerDao.php');
require_once('./websiteUser.php');

session_start();
session_regenerate_id(false);

if(isset($_SESSION['AdminID'])){
   if(!$_SESSION['websiteUser']->isAuthenticated()){
      header('Location:login.php');
    }
} else {
    header('Location:login.php');
}


$customerDao = new customerDao;
$customers=$customerDao->getCustomers();
$customerIDs=$customerDao->getID();
//echo '<pre>'. $customers[0].'/<pre>';
echo '<div>'.'SessionID: ' . session_id() .'</div>';
echo '<div>'.'Session AdminID: ' . $_SESSION['AdminID'].'</div>';
if($_SESSION['websiteUser']->getDate()!=null){
echo '<div>'.'Last login date: ' . $_SESSION['websiteUser']->getDate().'</div>';
}else{
echo '<div>'.'The first time to log in' .'</div>';
}
echo("<button onclick=\"location.href='logout.php'\">Logout!</button>");
/*
if ($customers){

    echo '<table class="table table-hover table-bordered" style="table-layout:fixed">';
                //echo '<tr><th>Customer Name</th> <th>Phone Number</th> <th>Email Address</th> <th>Referrer</th></tr>';
                echo "<tr><th style=\"width:100px;\">Customer</th><th style=\"width:150px;\">Phone</th><th style=\"width:250px;\">Email Address</th><th style=\"width:100px;\">Referral</th></tr>";

                $ID = $customerDao->getID();
                $i=0;
                foreach($customers as $customer){
                    echo '<tr>';
                   // echo '<td>' . $ID[$i] . '</td>';
                  //  echo '<td><a href=\'edit_employee.php?employeeId='. $ID . '\'>' . $ID . '</a></td>';
                    echo '<td>' . '<center>' . $customer->getName() . '</center>' . '</td>';
                    echo '<td>' . '<center>' . $customer->getPhone() . '</center>' . '</td>';
                    echo '<td word-break: break-all>' . '<center>' . $customer->getEmail() . '</center>' . '</td>';
                    echo '<td>' . '<center>' . $customer->getReferrer() . '</center>' . '</td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</table>';
                echo '<a href="logout.php" style="color:red;">Logout!</a>';
}else{
    echo '<h3>'.'No mailing exist now'.'</h3>';
    echo '<a href="logout.php" style="color:red;">Logout!</a>';
}


*/

            //$adminUser = $_SESSION["adminSession"];

			mysqli_report(MYSQLI_REPORT_STRICT);
			$connect = mysqli_connect("localhost", "wp_eatery", "password", "wp_eatery") or die('Error: ' . mysqli_error($link));
			$query = "SELECT * FROM mailinglist" ;
			$log = $connect->query($query) or die('Error: ' . mysqli_error($conect));
			

$sql="Select * from mailinglist";
$result = $connect->query($sql);

if ($result->num_rows>0) {
		echo "<br><br>Click on an Edit button to update customer information:<br><br>";
          echo '<table class ="table" style=\"text-align:center;\">';
         echo "<tr><th style=\"width:50px;\">id</th><th style=\"width:100px;\">Customer Name</th><th style=\"width:150px;\">Phone Number</th><th style=\"width:300px;\"><center>Email Address</center></th><th style=\"width:100px;\"><center>Referrer</center></th></tr>";
			 //row and values
			 echo"<tbody>";
    while ($row = $result->fetch_assoc()) {
        //CustomerName is the key in the array so it will return customerID
            //echo "<tr><td style=\"text-align:center;\">".$row['customerName']."</td><td style=\"text-align:center;\">".$row['phoneNumber']."</td><td style=\"word-break:break-all;\">".$row['emailAddress']."</td><td style=\"text-align:center;\">".$row['referrer']."</td></tr>";
            echo '<tr>';
			
			echo '<td style="text-align:center" >'.$row['id']. '</td>';
            echo '<td style="text-align:center">' .$row['customerName']  . '</td>';
            echo '<td style="text-align:center">' . $row['phoneNumber'] . '</td>';
            echo '<td style="word-break:break-all; text-align:center;">' . $row['emailAddress'] .'</td>';
            echo '<td style="text-align:center">' . $row['referrer'].'</td>';
			echo '<td><form action="" method="POST"><input type="hidden" name="id" value='.$row['id'].'><input type="submit" class="btn btn-sm btn-warning" name="edit" value="Edit"></form></td>';
            echo '</tr>';
			echo"</tbody>";
			}
}		
			
?>
<?php
mysqli_report(MYSQLI_REPORT_STRICT);
			$connect = mysqli_connect("localhost", "wp_eatery", "password", "wp_eatery") or die('Error: ' . mysqli_error($link));
			$query = "SELECT * FROM mailinglist" ;
			$log = $connect->query($query) or die('Error: ' . mysqli_error($conect));

    if(isset($_REQUEST['update'])){
	if(($_REQUEST['customerName'] == "")||($_REQUEST['phoneNumber'] == "")||($_REQUEST['emailAddress'] == "")||($_REQUEST['referrer'] == "")){
		echo "<small>Fill all fields.</small><hr>";
	   }
	    else{
	    $name = $_REQUEST['customerName'];
		$phone = $_REQUEST['phoneNumber'];
		$email = $_REQUEST['emailAddress'];
		$referrer = $_REQUEST['referrer'];
		
		$sql = "UPDATE mailinglist SET customerName = '$name', phoneNumber ='$phone', emailAddress = '$email', referrer = '$referrer' WHERE id = {$_REQUEST['id']}";
		
		if($connect->query($sql) == TRUE){
		    echo "Record Updated Successfully";
		}else{
			echo"Unable to Update Data";
		}	
	}
		}
?>

<?php  if(isset($_REQUEST['edit'])){
	$sql = "SELECT * From mailinglist where id = {$_REQUEST['id']}";
	$result = $connect->query($sql);
	$row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<body>
<form action="" method="POST">
<div class="form-group">
<label for="name">customerName</label>
<input type ="text" class="form-control" name="customerName" id ="customerName" value="<?php if(isset($row["customerName"])){echo $row["customerName"];}?>">
</div>
<div class="form-group">
<label for="phoneNumber">phoneNumber</label>
<input type ="text" class="form-control" name="phoneNumber" id ="phoneNumber" value="<?php if(isset($row["phoneNumber"])){echo $row["phoneNumber"];}?>">
</div>
<div class="form-group">
<label for="emailAddress">emailAddress</label>
<input type ="text" class="form-control" name="emailAddress" id ="emailAddress" value="<?php if(isset($row["emailAddress"])){echo $row["emailAddress"];}?>">
</div>
<div class="form-group">
<label for="referrer">referrer</label>
<input type ="text" class="form-control" name="referrer" id ="referrer" value="<?php if(isset($row["referrer"])){echo $row["referrer"];}?>">
</div>
<input type="hidden" name="id" value="<?php echo $row['id']?>">
<button type="submit" class="btn btn-success" name="update">Update</button>
</form>
</body>
</html>


<?php  mysqli_close($connect); ?>
