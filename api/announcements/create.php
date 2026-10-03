<?php
require_once __DIR__ . "/../../helpers/api.php";
require_once __DIR__ . "/../../models/Announcement.php";
require_once __DIR__ . "/../../models/Department.php";
require_once __DIR__ . "/../../models/Notification.php";
apiRequireMethod('POST');
apiRequireRole([1,4]);
$data = apiBody();
apiRequired($data, ['title','content','target_role']);
$title=trim($data['title']); $content=trim($data['content']); $targetRole=trim($data['target_role']);
if ($title==='' || $content==='') jsonResponse(["success"=>false,"message"=>"Title and content are required"],400);
if (!in_array($targetRole,['All','Student','Supervisor','Coordinator'],true)) jsonResponse(["success"=>false,"message"=>"Invalid target role"],400);
$targetDepartment=apiOptionalInt($data['target_department']??null,'target department');
$model=new Announcement();
$id=$model->createAnnouncement($title,$content,(int)$_SESSION['user_id'],$targetRole,$targetDepartment);
if(!$id) jsonResponse(["success"=>false,"message"=>"Failed to create announcement"],500);
if(in_array($targetRole,['All','Student'],true)) {
    $recipients=$model->getAnnouncementRecipients($targetRole,$targetDepartment);
    if(!empty($recipients)) {
        $notification=new Notification();
        $notification->createBulkNotifications($recipients,'announcement',$id,'New research announcement: '.$title);
    }
}
apiLog((int)$_SESSION['user_id'],"Created announcement: ".$title);
jsonResponse(["success"=>true,"message"=>"Announcement created successfully","data"=>["id"=>(int)$id]],201);
?>
