<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Patients</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];


    //echo $userid;
    //echo $username;
    ?>
    <div class="container">
    <?php include 'doctorMenu.php'; ?>
        <?php       

            $selecttype="My";
            $current="My patients Only";
            if($_POST){

                if(isset($_POST["search"])){
                    $keyword=$_POST["search12"];
                    
                    $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                    $selecttype="my";
                }
                
                if(isset($_POST["filter"])){
                    if($_POST["showonly"]=='all'){
                        $sqlmain= "select * from patient";
                        $selecttype="All";
                        $current="All patients";
                    }else{
                        $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                        $selecttype="My";
                        $current="My patients Only";
                    }
                }
            }else{
                $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                $selecttype="My";
            } ?>

        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">

                    <a href="patient.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                        
                    </td>
                    <td>
                        
                        <form action="" method="post" class="header-search">

                            <input type="search" name="search12" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;
                            
                            <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query($sqlmain);
                               //$list12= $database->query("select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=1;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["pname"];
                                    $c=$row00["pemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';?>
                       
                            <input type="Submit" value="Search" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        
                        </form>
                        
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                        date_default_timezone_set('Asia/Kolkata');

                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype." Patients (".$list11->num_rows.")"; ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
 
                        <form action="" method="post">
                        
                        <td  style="text-align: right;">
                        Show Details About : &nbsp;
                        </td>
                        <td width="30%">
                        <select name="showonly" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                                    <option value="" disabled selected hidden><?php echo $current   ?></option><br/>
                                    <option value="my">My Patients Only</option><br/>
                                    <option value="all">All Patients</option><br/>
                        </select>
                    </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>
                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                        <thead>
                        <tr>
                                <th class="table-headin">   
                                Name                           
                                </th>
                                <th class="table-headin">
                                                                 
                                    NIC
                                    
                                </th>
                                <th class="table-headin">

                                Telephone
                                
                                </th>
                                <th class="table-headin">
                                    Email
                                </th>
                                <th class="table-headin">
                                    
                                    Date of Birth
                                    
                                </th>
                                <th class="table-headin">
                                    
                                    Events
                                    
                                </tr>
                        </thead>
                        <tbody>
                        
                            <?php

                                
                                $result= $database->query($sqlmain);
                                //echo $sqlmain;
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $pid=$row["pid"];
                                    $name=$row["pname"];
                                    $email=$row["pemail"];
                                    $nic=$row["pnic"];
                                    $dob=$row["pdob"];
                                    $tel=$row["ptel"];
                                    
                                    echo '<tr>
                                        <td> &nbsp;'.
                                        substr($name,0,35)
                                        .'</td>
                                        <td>
                                        '.substr($nic,0,12).'
                                        </td>
                                        <td>
                                            '.substr($tel,0,10).'
                                        </td>
                                        <td>
                                        '.substr($email,0,20).'
                                         </td>
                                        <td>
                                        '.substr($dob,0,10).'
                                        </td>
                                        <td >
                                        <div style="display:flex;justify-content: center;">
                                        <a href="?action=report&id='.$pid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;margin-right:5px"><font class="tn-in-text">Add report</font></button></a>
                                        <a href="?action=view&id='.$pid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                       
                                        </div>
                                        </td>
                                    </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>    
            </table>
        </div>
    </div>
    <?php 
   
    if($_GET){

        $id=$_GET["id"];
        $action=$_GET["action"];

        if ($action == "view"){
            
            $sqlmain= "select * from patient where pid='$id'";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $name=$row["pname"];
            $email=$row["pemail"];
            $nic=$row["pnic"];
            $dob=$row["pdob"];
            $tele=$row["ptel"];
            $address=$row["paddress"];
           
            echo '
    <div id="popup1" class="overlay">
        <div class="popup">
            <center>
                <a class="close" href="patient.php">&times;</a>
                <div class="content">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Patient ID: </label>
                                P-'.$id.'<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Name: </label>
                                '.$name.'<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label">Email: </label>
                                '.$email.'<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="nic" class="form-label">NIC: </label>
                                '.$nic.'<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label">Telephone: </label>
                                '.$tele.'<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label">Address: </label>
                                '.$address.'<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Date of Birth: </label>
                                '.$dob.'<br><br>
                            </td>
                        </tr>';

    $sql = "SELECT * FROM reports WHERE pid = '$id'";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        echo '<tr><td colspan="2"><p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Reports:</p><br></td></tr>';
        while ($row = $result->fetch_assoc()) {

            $date = $row['report_date'];
            $report = $row['report'];
            echo '
                <tr>
                    <td class="label-td" colspan="2">
                        <label class="form-label">Report Date: </label>
                        '.$date.'<br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label class="form-label">Report Content: </label>
                        '.$report.'<br><br>
                    </td>
                </tr>
                ';
        }
    }
    else {
        echo '<tr><td colspan="2">No reports available.</td></tr>';
    }

    echo '
                <tr>
                    <td colspan="2">
                        <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a> 
                    </td>
                </tr>
            </table>
        </center>
    </div>
    </div>
    </div>';

    }
        elseif ($action == "report" ) {
            $id = $_GET['id']; // Get patient ID from URL or form submission
            $sqlmain= "SELECT * FROM patient WHERE pid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $name = $row["pname"];

            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">
                        </div>
                        <div style="display: flex; justify-content: center;">
                        <form action="savereport.php" method="POST">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                    <td>
                                        <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">Add report</p><br><br>
                                    </td>
                                </tr>
                                <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Patient ID: </label>
                                    P-'.$id.'<br><br>
                                </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Name: </label>
                                        '.$name.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                <td class="label-td" colspan="2">
                                    <label for="report" class="form-label">Report: </label>
                                    <textarea name="report" rows="4" cols="50" required></textarea><br><br>
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="hidden" name="pid" value="'.$id.'">
                                        <input type="submit" name="addreport" value="Save Report" style="margin-bottom: 10px" class="login-btn btn-primary-soft btn">
                                        <a href="patient.php"><input type="button" value="Cancel" class="login-btn btn-primary-soft btn"></a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </center>
                <br><br>
                </div>
            </div>';
            }
        }
?>
</div>
</body>
</html>