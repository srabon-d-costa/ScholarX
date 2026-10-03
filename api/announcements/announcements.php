<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
apiRequireMethod('GET');
apiRequireRole([1,4]);
$model = new Announcement();
$data = $model->getAllAnnouncements();
jsonResponse(["success" => true, "count" => count($data), "data" => $data]);
?>
