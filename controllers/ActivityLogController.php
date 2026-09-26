<?php

require_once __DIR__ . "/../models/ActivityLog.php";

class ActivityLogController
{
    private $activityLogModel;


    public function __construct()
    {
        $this->activityLogModel = new ActivityLog();
    }


    // Create activity log
    public function log(
        $user_id,
        $action,
        $ip_address = null
    )
    {
        if ($ip_address === null) {
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        }

        return $this->activityLogModel->createLog(
            $user_id,
            $action,
            $ip_address
        );
    }


    // Get all activity logs
    public function activities()
    {
        return $this->activityLogModel->getAllLogs();
    }


    // Get logs for a user
    public function userActivities($user_id)
    {
        return $this->activityLogModel->getUserLogs(
            $user_id
        );
    }
}

?>