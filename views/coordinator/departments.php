<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/DepartmentController.php";

checkLogin();
checkRole(4);

$department = new DepartmentController();

$departments = $department->departments();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Departments - ScholarX</title>

</head>

<body>

<h1>Manage Departments</h1>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

<br><br>

<a href="create_department.php">
    <button type="button">
        Add New Department
    </button>
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>

        <th>ID</th>

        <th>Department Name</th>

        <th>Code</th>

        <th>Description</th>

        <th>Created At</th>

        <th>Action</th>

    </tr>

    <?php if(count($departments) > 0): ?>

        <?php foreach($departments as $item): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($item['id']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($item['name']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($item['code']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($item['description']); ?>
                </td>

                <td>
                    <?= htmlspecialchars($item['created_at']); ?>
                </td>

                <td>

                    <a href="edit_department.php?id=<?= $item['id']; ?>">
                        Edit
                    </a>

                    |

                    <a
                        href="delete_department.php?id=<?= $item['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this department?');"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>

            <td colspan="6">
                No departments found.
            </td>

        </tr>

    <?php endif; ?>

</table>

</body>

</html>