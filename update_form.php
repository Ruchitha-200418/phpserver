<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "company");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Step 1: Handle update/insert requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>DEBUG POST DATA:\n"; print_r($_POST); echo "</pre>"; // Debug incoming data

    if ($_POST['action'] == "update_employee") {
        $id    = intval($_POST['id']);
        $name  = $_POST['name'];
        $email = $_POST['email'];
        $stmt = $conn->prepare("UPDATE employees SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p style='color:green;'>✔ Employee updated successfully!</p>";
        } else {
            echo "<p style='color:orange;'>⚠ No employee updated (maybe same values or invalid ID).</p>";
        }
    }

    if ($_POST['action'] == "update_salary") {
        $id     = intval($_POST['id']);   // salary record ID
        $salary = floatval($_POST['salary']);
        $stmt = $conn->prepare("UPDATE salaries SET salary=? WHERE id=?");
        $stmt->bind_param("di", $salary, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p style='color:blue;'>✔ Salary updated successfully!</p>";
        } else {
            echo "<p style='color:orange;'>⚠ No salary updated (maybe same value or invalid salary ID).</p>";
        }
    }

    if ($_POST['action'] == "add_employee") {
        $name  = $_POST['name'];
        $email = $_POST['email'];
        $stmt = $conn->prepare("INSERT INTO employees (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        echo "<p style='color:green;'>➕ New employee added!</p>";
    }

    if ($_POST['action'] == "add_salary") {
        $emp_id = intval($_POST['emp_id']);
        $salary = floatval($_POST['salary']);
        $stmt = $conn->prepare("INSERT INTO salaries (emp_id, salary) VALUES (?, ?)");
        $stmt->bind_param("id", $emp_id, $salary);
        $stmt->execute();
        echo "<p style='color:blue;'>➕ New salary record added!</p>";
    }
}
?>
