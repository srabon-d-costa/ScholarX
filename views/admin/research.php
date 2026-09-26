<?php

session_start();

require_once "../../helpers/auth_check.php";
require_once "../../controllers/ResearchController.php";

checkLogin();
checkRole(1);


$researchController = new ResearchController();

$message = "";


/*
|--------------------------------------------------------------------------
| Delete Research Opportunity
|--------------------------------------------------------------------------
*/

if(isset($_POST['delete']))
{
    $id = $_POST['id'];

    $result = $researchController->deleteOpportunity($id);

    if($result)
    {
        $message = "Research opportunity deleted successfully.";
    }
    else
    {
        $message = "Failed to delete research opportunity.";
    }
}


/*
|--------------------------------------------------------------------------
| Get Opportunities
|--------------------------------------------------------------------------
*/

$opportunities = $researchController->opportunities();

?>


<!DOCTYPE html>
<html>

<head>

    <title>
        Manage Research Opportunities - ScholarX
    </title>

</head>


<body>


<h1>
    Manage Research Opportunities
</h1>


<a href="dashboard.php">
    ← Back to Dashboard
</a>


<br><br>


<?php if($message != ""): ?>

<p>
    <strong>
        <?= htmlspecialchars($message); ?>
    </strong>
</p>

<?php endif; ?>


<h2>
    Research Opportunities
</h2>


<?php if(count($opportunities) > 0): ?>


<table border="1" cellpadding="10">

<tr>

    <th>
        ID
    </th>

    <th>
        Title
    </th>

    <th>
        Supervisor
    </th>

    <th>
        Department
    </th>

    <th>
        Required Skills
    </th>

    <th>
        Max Members
    </th>

    <th>
        Deadline
    </th>

    <th>
        Status
    </th>

    <th>
        Action
    </th>

</tr>


<?php foreach($opportunities as $item): ?>

<tr>

    <td>
        <?= htmlspecialchars($item['id']); ?>
    </td>


    <td>
        <?= htmlspecialchars($item['title']); ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $item['supervisor_name'] ?? 'N/A'
        ); ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $item['department_name'] ?? 'N/A'
        ); ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $item['required_skills'] ?? 'N/A'
        ); ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $item['max_members'] ?? 'N/A'
        ); ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $item['deadline'] ?? 'N/A'
        ); ?>
    </td>


    <td>
        <?= htmlspecialchars(
            $item['status'] ?? 'N/A'
        ); ?>
    </td>


    <td>

        <a href="edit_research.php?id=<?= $item['id']; ?>">
            Edit
        </a>

        |

        <form
            method="POST"
            style="display:inline;"
            onsubmit="return confirm('Are you sure you want to delete this research opportunity?');"
        >

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($item['id']); ?>"
            >

            <button
                type="submit"
                name="delete"
            >
                Delete
            </button>

        </form>

    </td>

</tr>

<?php endforeach; ?>


</table>


<?php else: ?>

<p>
    No research opportunities found.
</p>

<?php endif; ?>


</body>

</html>