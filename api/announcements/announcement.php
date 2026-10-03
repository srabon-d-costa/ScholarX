<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
apiRequireMethod('GET');
apiRequireRole([1,4]);
$id = apiInt($_GET['id'] ?? null, 'announcement ID');
$model = new Announcement();
$data = $model->getAnnouncementById($id);
if (!$data) jsonResponse(["success"=>false,"message"=>"Announcement not found"],404);
jsonResponse(["success"=>true,"data"=>$data]);
?>
