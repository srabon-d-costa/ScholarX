<?php

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/json_response.php";


/*
|--------------------------------------------------------------------------
| API Request Method
|--------------------------------------------------------------------------
*/

function apiRequireMethod($method)
{
    if ($_SERVER['REQUEST_METHOD'] !== strtoupper($method))
    {
        jsonResponse([
            "success" => false,
            "message" => "Only " . strtoupper($method) . " requests are allowed"
        ], 405);
    }
}


/*
|--------------------------------------------------------------------------
| API Authentication
|--------------------------------------------------------------------------
*/

function apiRequireAuth()
{
    if (!isset($_SESSION['user_id']))
    {
        jsonResponse([
            "success" => false,
            "message" => "Authentication required"
        ], 401);
    }
}


/*
|--------------------------------------------------------------------------
| API Role Authorization
|--------------------------------------------------------------------------
*/

function apiRequireRole($roles)
{
    apiRequireAuth();

    $roles = array_map('intval', (array)$roles);

    if (
        !isset($_SESSION['role_id']) ||
        !in_array((int)$_SESSION['role_id'], $roles, true)
    )
    {
        jsonResponse([
            "success" => false,
            "message" => "Access denied"
        ], 403);
    }
}


/*
|--------------------------------------------------------------------------
| Read JSON Request Body
|--------------------------------------------------------------------------
*/

function apiBody()
{
    $raw = file_get_contents("php://input");

    if ($raw === false || trim($raw) === '')
    {
        jsonResponse([
            "success" => false,
            "message" => "Request body is required"
        ], 400);
    }

    $data = json_decode($raw, true);

    if (!is_array($data))
    {
        jsonResponse([
            "success" => false,
            "message" => "Invalid JSON data"
        ], 400);
    }

    return $data;
}


/*
|--------------------------------------------------------------------------
| Required JSON Fields
|--------------------------------------------------------------------------
*/

function apiRequired($data, $fields)
{
    foreach ($fields as $field)
    {
        if (
            !array_key_exists($field, $data) ||
            $data[$field] === null ||
            (
                is_string($data[$field]) &&
                trim($data[$field]) === ''
            )
        )
        {
            jsonResponse([
                "success" => false,
                "message" => "Missing required field: " . $field
            ], 400);
        }
    }
}


/*
|--------------------------------------------------------------------------
| Integer Validation
|--------------------------------------------------------------------------
*/

function apiInt($value, $label, $minimum = 1)
{
    $result = filter_var(
        $value,
        FILTER_VALIDATE_INT
    );

    if (
        $result === false ||
        $result < $minimum
    )
    {
        jsonResponse([
            "success" => false,
            "message" => $label . " must be a valid integer"
        ], 400);
    }

    return (int)$result;
}


/*
|--------------------------------------------------------------------------
| Optional Integer
|--------------------------------------------------------------------------
*/

function apiOptionalInt($value, $label)
{
    if (
        $value === null ||
        $value === ''
    )
    {
        return null;
    }

    return apiInt($value, $label);
}


/*
|--------------------------------------------------------------------------
| Date Validation
|--------------------------------------------------------------------------
*/

function apiDate($value, $label)
{
    $value = trim((string)$value);

    $date = DateTime::createFromFormat(
        'Y-m-d',
        $value
    );

    if (
        !$date ||
        $date->format('Y-m-d') !== $value
    )
    {
        jsonResponse([
            "success" => false,
            "message" => $label . " must be in YYYY-MM-DD format"
        ], 400);
    }

    return $value;
}


/*
|--------------------------------------------------------------------------
| Date Range Validation
|--------------------------------------------------------------------------
*/

function apiDateRange($start, $end)
{
    if ($start > $end)
    {
        jsonResponse([
            "success" => false,
            "message" => "End date cannot be earlier than start date"
        ], 400);
    }

    return true;
}


/*
|--------------------------------------------------------------------------
| Find Record By ID
|--------------------------------------------------------------------------
*/

function apiFindById($items, $id)
{
    foreach ((array)$items as $item)
    {
        if (
            is_array($item) &&
            isset($item['id']) &&
            (int)$item['id'] === (int)$id
        )
        {
            return $item;
        }
    }

    return false;
}


/*
|--------------------------------------------------------------------------
| Activity Log
|--------------------------------------------------------------------------
*/

function apiLog($userId, $action)
{
    require_once __DIR__ . "/../controllers/ActivityLogController.php";

    $activityLog = new ActivityLogController();

    $activityLog->log(
        $userId,
        $action
    );
}

?>