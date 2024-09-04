<?php
include "../database.php";

// Initialize variables to avoid undefined warnings
$stdid = '';
$sname = '';
$fname = '';
$course = '';
$aamt = 0;
$iamt = 0;
$iden = '';
$idenamt = 0;

// Check if 'value' is set in the POST request
if (isset($_POST['value'])) {
    $sesid = $_POST['value'];
    $areg = "YSMDS" . $sesid;

    // Using prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT stdid, sname, sfname, course FROM admissiontb WHERE areg = ?");
    if ($stmt) {
        $stmt->bind_param("s", $areg);
        // Execute the query
        if ($stmt->execute()) {
            // Fetch results
            $result = $stmt->get_result();

            // Check if any rows returned
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $stdid = $row['stdid'];
                $sname = $row['sname'];
                $fname = $row['sfname'];
                $course = $row['course'];
            }
        } else {
            echo json_encode(array('error' => 'Query execution failed: ' . $stmt->error));
            exit;
        }
        $stmt->close();
    } else {
        echo json_encode(array('error' => 'Statement preparation failed: ' . $con->error));
        exit;
    }

    // Second prepared statement to fetch amounts
    $stmt1 = $con->prepare("SELECT admamount, insamount,fees FROM coursetb WHERE course = ?");
    if ($stmt1) {
        $stmt1->bind_param("s", $course);
        // Execute the query
        if ($stmt1->execute()) {
            // Fetch results
            $result1 = $stmt1->get_result();

            // Check if any rows returned
            if ($result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                $aamt = $row1['admamount'];
                $iamt = $row1['insamount'];
                $fees = $row1['fees'];
            }
        } else {
            echo json_encode(array('error' => 'Query execution failed: ' . $stmt1->error));
            exit;
        }
        $stmt1->close();
    } else {
        echo json_encode(array('error' => 'Statement preparation failed: ' . $con->error));
        exit;
    }

    // Third prepared statement to check payments
    $stmt2 = $con->prepare("SELECT amount FROM paymenttb WHERE stdid = ?");
    if ($stmt2) {
        $stmt2->bind_param("i", $stdid);
        // Execute the query
        if ($stmt2->execute()) {
            // Fetch results
            $result2 = $stmt2->get_result();
            $nrows = $result2->num_rows;

            $totalamt = 0;

            // Iterate through each row to calculate the total amount
            while ($row = $result2->fetch_assoc()) {
                $totalamt += $row['amount'];  // Summing up the amounts
            }

            $damt = $fees - $totalamt;
            if ($nrows < 1) {
                $iden = "Admission";
                $idenamt = $aamt;
            } else {
                $iden = $nrows."-Installment";
                $idenamt = $iamt;
            }
        } else {
            echo json_encode(array('error' => 'Query execution failed: ' . $stmt2->error));
            exit;
        }
        $stmt2->close();
    } else {
        echo json_encode(array('error' => 'Statement preparation failed: ' . $con->error));
        exit;
    }
    
    echo json_encode(array('success' => true, 'sid' => $stdid, 'sn' => $sname, 'sfn' => $fname, 'cs' => $course, 'amtt' => $iden, 'amt' => $idenamt, 'damt' => $damt));
} else {
    echo json_encode(array('error' => 'No value provided.'));
}

// Close the database connection
$con->close();
?>

