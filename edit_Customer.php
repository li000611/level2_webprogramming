<?php require_once('dao/customerDao.php');
include 'header.php';

if(!isset($_GET ['customerId']) || !is_numeric($_GET['customerId'])){
//Send the user back to the main page
header("Location:mailing_list.php");
exit;
} else{
$customerDAO = new customerDAO;
$customer = $customerDAO->getCustomer($_GET['customerID']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Edit Customer - <?php echo $customer->getcustomerName() . ' ' . $customer->getphoneName();?></title>
    </head>
    <body>

        <?php
        if(isset($_GET['recordsUpdated'])){
                if(is_numeric($_GET['recordsUpdated'])){
                    echo '<h3> '. $_GET['recordsUpdated']. ' Customer Record Updated.</h3>';
                }
        }
        if(isset($_GET['missingFields'])){
                if($_GET['missingFields']){
                    echo '<h3 style="color:red;"> Please enter both customerName,phoneNumber,emailAddress,referrer.</h3>';
                }
        }?>
        <h3>Edit Customer</h3>
        <form name="editCustomer" method="post" action="process_customer.php?action=edit">
            <table>
                <tr>
                    <td>ID:</td>
                    <td><input type="hidden" name="id" id="id"
                               value="<?php echo $customer->getId();?>"><?php echo $customer->getId();?></td>
                </tr>
                <tr>
                    <td>CustomerName:</td>
                    <td><input type="text" name="customerName" id="customerName"
                               value="<?php echo $customer->getName();?>"></td>
                </tr>
                <tr>
                    <td>phoneNumber:</td>
                    <td><input type="text" name="phoneNumber" id="phoneNumber"
                               value="<?php echo $customer->getPhone();?>"></td>
                </tr>
				<tr>
                    <td>emailAddress:</td>
                    <td><input type="text" name="emailAddress" id="emailAddress"
                               value="<?php echo $customer->getEmail();?>"></td>
                </tr>
				<tr>
                    <td>referrer:</td>
                    <td><input type="text" name="referrer" id="referrer"
                               value="<?php echo $customer->getReferrer();?>"></td>
                </tr>

                <tr>
                    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Update Customer"></td>
                    <td><input type="reset" name="btnReset" id="btnReset" value="Reset"></td>
                </tr>
            </table>
        </form>
        <h4><a href="mailing_list.php">Back to Mailing List</a></h4>
    </body>
</html>


<?php include 'footer.php';}?>
