<?php
include "../../../Include/class/connect_sql.php";
include "../../../00_function/function_php.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$year_month = date("Ym");
$ymd = date("Ymd");

$dochid = $_POST['dochid'];
$docdid = $_POST['docdid'];
$empcode = $_POST['empcode'];
$shift = $_POST['shift'];
$line = $_POST['line'];
$mc = $_POST['mc'];
$revision = $_POST['revision'];
$answer = $_POST['answer'];
$lnno = $_POST['lnno'];
$result = $_POST['result'];
$remark = $_POST['remark'];
$checkpicture = $_POST['checkpicture'];

/**
 * TODO : Check ว่ามีไฟล์แนบมาด้วยไหม
 */
$picture = array();
if($checkpicture == 0) {
    array_push($picture,null);
    $insert = "INSERT INTO [dbo].[DOCTEMP_TBL]
            ([DOC_HID]
           ,[DOC_DID]
           ,[DOC_REV]
           ,[DOC_EMPID]
           ,[DOC_LINE]
           ,[DOC_MC]
           ,[DOC_SHIFT]
           ,[DOC_LNNO]
           ,[DOC_ANSWER]
           ,[DOC_RESULT]
           ,[DOC_REMARK]
           ,[DOC_DATETIME])
           VALUES
           ('".$dochid."',
            '".$docdid."',
            '".$revision."',
            '".$empcode."',
            '".$line."',
            '".$mc."',
            '".$shift."',
            '".$lnno."',
            '".$answer."',
            '".$result."',
            N'".$remark."',
            getdate())";
    $mDBConn->Query($insert);
    //$reslut = $mDBConn->FetchData();
} else {
    $insert = "INSERT INTO [dbo].[DOCTEMP_TBL]
            ([DOC_HID]
           ,[DOC_DID]
           ,[DOC_REV]
           ,[DOC_EMPID]
           ,[DOC_LINE]
           ,[DOC_MC]
           ,[DOC_SHIFT]
           ,[DOC_LNNO]
           ,[DOC_ANSWER]
           ,[DOC_RESULT]
           ,[DOC_REMARK]
           ,[DOC_DATETIME])
           VALUES
           ('".$dochid."',
            '".$docdid."',
            '".$revision."',
            '".$empcode."',
            '".$line."',
            '".$mc."',
            '".$shift."',
            '".$lnno."',
            '".$answer."',
            '".$result."',
            N'".$remark."',
            getdate())";
    $mDBConn->Query($insert);
    //$reslut = $mDBConn->FetchData();

    $picArr = ['DOC_PIC1','DOC_PIC2','DOC_PIC3','DOC_PIC4','DOC_PIC5'];
    for($j=0; $j<sizeof($_FILES['files']['name']); $j++){
        $data['files'] = $_FILES['files']['name'][$j];
        $filename_new = $ymd."_".$docdid."_".$revision."_".$lnno."_".$j."_".randomChar(5).".jpg";
        $filePath = '../../PictureAttached/'.$filename_new;
		if (move_uploaded_file($_FILES['files']['tmp_name'][$j], $filePath)) {
            $updatePIC = "UPDATE [dbo].[DOCTEMP_TBL] SET ".$picArr[$j]." = '".$filename_new."'
                        WHERE DOC_HID = '".$dochid."'
                        AND DOC_DID = '".$docdid."'
                        AND DOC_REV = '".$revision."'
                        AND DOC_EMPID = '".$empcode."'
                        AND DOC_LINE = '".$line."'
                        AND DOC_MC = '".$mc."'
                        AND DOC_SHIFT = '".$shift."'
                        AND DOC_LNNO = '".$lnno."'"; 
            $mDBConn->Query($updatePIC);
            array_push($picture,$filename_new);
        }
    }
}

$array_data = array(
'dochid' => $dochid,
'docdid' => $docdid,
'empcode' => $empcode,
'shift' => $shift,
'line' => $line,
'mc' => $mc,
'revision' => $revision,
'answer' => $answer,
'lnno' => $lnno,
'result' => $result,
'remark' => $remark,
'checkpicture' => $checkpicture,
'picture' => $picture
);
echo json_encode($array_data);

?>