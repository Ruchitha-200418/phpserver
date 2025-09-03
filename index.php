<?php
// --- Sample Data (instead of database tables) ---
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['employees'])) {
    $_SESSION['employees'] = [
        ["id" => 1, "name" => "", "department" => ""],
       
    ];

    $_SESSION['salaries'] = [
        ["emp_id" => 1, "salary" => 50000],
        ["emp_id" => 2, "salary" => 45000],
        ["emp_id" => 3, "salary" => 60000]
    ];
}

$employees = $_SESSION['employees'];
$salaries  = $_SESSION['salaries'];

// --- Handle Update ---
if (isset($_POST['update'])) {
    foreach ($_POST['id'] as $index => $id) {
        $employees[$index]['name'] = $_POST['name'][$index];
        $employees[$index]['department'] = $_POST['department'][$index];
        $salaries[$index]['salary'] = $_POST['salary'][$index];
    }
    $_SESSION['employees'] = $employees;
    $_SESSION['salaries'] = $salaries;
    echo "<h3 style='color:green;'>✅ Records updated successfully!</h3>";
}

// --- Handle Add Row ---
if (isset($_POST['add_row'])) {
    $new_id = count($employees) + 1;
    $employees[] = ["id" => $new_id, "name" => "", "department" => ""];
    $salaries[]  = ["emp_id" => $new_id, "salary" => 0];

    $_SESSION['employees'] = $employees;
    $_SESSION['salaries']  = $salaries;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee & Salary Update</title>
</head>
<body>
    <h2>Update Employees (Master) & Salaries (Transaction)</h2>
    <form method="post">
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Salary</th>
            </tr>
            <?php foreach ($employees as $index => $emp): ?>
                <tr>
                    <td>
                        <input type="text" name="id[]" value="<?= $emp['id'] ?>" readonly>
                    </td>
                    <td>
                        <input type="text" name="name[]" value="<?= $emp['name'] ?>">
                    </td>
                    <td>
                        <input type="text" name="department[]" value="<?= $emp['department'] ?>">
                    </td>
                    <td>
                        <input type="text" name="salary[]" value="<?= $salaries[$index]['salary'] ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit" name="update">Update Records</button>
        <button type="submit" name="add_row">➕ Add Next Row</button>
    </form>

    <h2>📋 Current Records</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Salary</th>
        </tr>
        <?php foreach ($employees as $index => $emp): ?>
            <tr>
                <td><?= $emp['id'] ?></td>
                <td><?= $emp['name'] ?></td>
                <td><?= $emp['department'] ?></td>
                <td><?= $salaries[$index]['salary'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
