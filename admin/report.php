<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Report</title>
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
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    //import database
    include("../connection.php");

    
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@ehr.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text">Doctors</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient ">
                        <a href="patient.php" class="non-style-link-menu "><div><p class="menu-text">Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-report menu-active menu-icon-report-active">
                        <a href="report.php" class="non-style-link-menu-active"><div><p class="menu-text">Report</p></a></div>
                    </td>
                </tr>

            </table>
        </div>

        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">

                    <a href="report.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                        
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
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Generate Reports</p>
                    </td>
                </tr>                   
                    <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <a class="non-style-link" href="report.php?action=mostappt"><button class="btn-primary-soft btn button-icon btn-view" style="display: flex; justify-content: center; align-items: center; margin: 20px;">&nbsp; Doctor with Most Appointments &nbsp;</button></a>
                        <a class="non-style-link" href="report.php?action=totaltoday"><button class="btn-primary-soft btn button-icon btn-view" style="display: flex; justify-content: center; align-items: center; margin: 20px;">&nbsp; Total Appointments Today &nbsp;</button></a>

                    </td>
                </tr>
                        
            </table>
        </div>
    </div>
<?php
if ($_GET && isset($_GET["action"])){
   
    $action = $_GET["action"];
    
    // Handle different actions
    switch ($action) {
        
        case "mostappt":
            // Query to find the doctor with the most appointments
            $sql_most_appt = "SELECT d.docid, d.docname, d.docemail, d.doctel, d.specialties, COUNT(a.appoid) AS appointment_count
                              FROM doctor d
                              LEFT JOIN schedule s ON d.docid = s.docid
                              LEFT JOIN appointment a ON s.scheduleid = a.scheduleid
                              GROUP BY d.docid
                              ORDER BY appointment_count DESC
                              LIMIT 1";
            
            $result_most_appt = $database->query($sql_most_appt);
        
            if ($result_most_appt && $result_most_appt->num_rows > 0) {
                $row = $result_most_appt->fetch_assoc();
                $id = $row["docid"];
                $name = $row["docname"];
                $email = $row["docemail"];
                $doctel = $row["doctel"];
                $spec = $row["specialties"];
                $appocount = $row["appointment_count"];

                if ($appocount > 0){
        
                // Display the doctor with the most appointments
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="report.php">&times;</a>
                            <div class="content">
                                <h2>Doctor with Most Appointments</h2>
                                <p>Doctor ID: D-' . $id . '</p>
                                <p>Name: ' . $name . '</p>
                                <p>Email: ' . $email . '</p>
                                <p>Telephone: ' . $doctel . '</p>
                                <p>Specialties: ' . $spec . '</p>
                                <p>Appointment Count: ' . $appocount . '</p>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>';
                }
                else {
                    echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                        <a class="close" href="report.php">&times;</a>
                            <div class="content">
                                <p>No appointments today</p>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>';

                }
            } else {
                echo '<p>No data found.</p>';
            }
            break;
            
        case "totaltoday":
            // Query to count total appointments for today
            $today_date = date('Y-m-d');

            $sql_total_today = "SELECT COUNT(*) AS total_appointments
                                FROM appointment
                                WHERE DATE(appodate) = '$today_date'";

            $result_total_today = $database->query($sql_total_today);

            if ($result_total_today) {
                $row = $result_total_today->fetch_assoc();
                $total_appointments_today = $row["total_appointments"];

                // Display total appointments for today
                echo '
                <div id="popup2" class="overlay">
                    <div class="popup">
                        <center>
                            <a class="close" href="report.php">&times;</a>
                            <div class="content">
                                <h2>Total Appointments Today</h2>
                                <p>Date: ' . $today_date . '</p>
                                <p>Total Appointments: ' . $total_appointments_today . '</p>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>';
            } else {
                echo '<p>No data found.</p>';
            }
            break;

        default:
            echo '<p>Invalid action.</p>';
            break;
    }
}
    
?>

</div>

</body>
</html>