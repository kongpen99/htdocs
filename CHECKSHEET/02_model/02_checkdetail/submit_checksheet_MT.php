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
$php_empcode = $_POST['php_empcode'];
$php_shift = $_POST['php_shift'];
$php_line = $_POST['php_line'];
$php_mc = $_POST['php_mc'];
$php_docdid = $_POST['php_docdid'];
$php_dochid = $_POST['php_dochid'];
$php_dept = $_POST['php_dept'];
$php_empname = $_POST['php_empname'];
$php_docrevision = $_POST['php_docrevision'];
$lnno = $_POST['lnno'];
$type_answer = $_POST['type_answer'];
$answer_system = $_POST['answer_system'];
$answer = $_POST['answer'];
$remark = $_POST['remark'];
$count = sizeof($answer);

$result_answer = array();

$check_answer = array();
/**
 * TODO : 2023-08-08
 * * loop สำหรับตรวจสอบว่า user ใส่คำตอบมาครบทุกข้อไหม
 * * if = ใส่มาเพิ่ม 1
 * * else = ไม่ได้ใส่มา 0 
 */
for($i=0;$i<sizeof($answer);$i++) {
    if(!empty($answer[$i])) {
        array_push($check_answer,1);
    } else {
        array_push($check_answer,0);
    }
}

/**
 * TODO : 2023-08-08
 * * อันนี้จะเป็น condition ตรวจสอบว่าถ้าคำตอบครบถ้วนก็จะทำเงื่อนไข SQL ต่อไป
 * * ถ้ามี 0 อยู่ใน array ก็จะสิ้นสุดการทำงานและส่งกลับไปบอก user ว่าใส่คำตอบไม่ครบถ้วน
 * * if = return
 * * else = continue
 */
if(in_array(0,$check_answer)){
    $return_std = false;
} else {
    $return_std = true;
    $PRODOC_GETRUNNO = "EXEC [dbo].[PRODOC_GETRUNNO]";
    $PRODOC_GETRUNNO .= "'DCS-R'";
    $mDBConn->Query($PRODOC_GETRUNNO);
    $reslut = $mDBConn->FetchData();

    //* FN_SET_RUNNO from:function_php.php
    $RID = FN_SET_RUNNO($reslut[0]['RUNNO'] , $year_month , $reslut[0]['CD'] , 6);

    /**
     * * 2.procedure สำหรับบันทึกในตาราง main : [DOCRH_TBL]
     */
    $PRODOC_NEWDOCRH  = "EXEC [dbo].[PRODOC_NEWDOCRH]";
    $PRODOC_NEWDOCRH .= "'{$RID}' , '{$php_dochid}' , {$php_docrevision} , '{$php_docdid}' , '{$php_empcode}' , '{$php_empname}','{$php_dept}','{$php_shift}','{$php_line}','{$php_mc}',0,0,''";
    $mDBConn->Query($PRODOC_NEWDOCRH);

    for($i=0;$i<sizeof($answer);$i++) {
        $temp_result_answer = '';
        if($type_answer[$i] == '=') {
            if($answer_system[$i] == $answer[$i]) {
                array_push($result_answer,'Correct');
                $temp_result_answer = 'Correct';
            } else {
                array_push($result_answer,'Incorrect');
                $temp_result_answer = 'Incorrect';
            }
        }
        else if($type_answer[$i] == 'Between') {
            $explode_val = explode('&',$answer_system[$i]);
            if((floatval($answer[$i]) >= floatval($explode_val[0])) && (floatval($answer[$i]) <= floatval($explode_val[1]))) {
                array_push($result_answer,'Correct');
                $temp_result_answer = 'Correct';
            } else {
                array_push($result_answer,'Incorrect');
                $temp_result_answer = 'Incorrect';
            }
        }
        else if($type_answer[$i] == 'OK/NG') {
            if($answer_system[$i] == $answer[$i]) {
                array_push($result_answer,'Correct');
                $temp_result_answer = 'Correct';
            } else {
                array_push($result_answer,'Incorrect');
                $temp_result_answer = 'Incorrect';
            }
        }

        $PRODOC_NEWDOCRD  = "EXEC [dbo].[PRODOC_NEWDOCRD]";
        $PRODOC_NEWDOCRD .= "'{$php_docdid}','{$RID}','{$lnno[$i]}','{$answer[$i]}','{$temp_result_answer}',N'{$remark[$i]}'";
        $PRODOC_NEWDOCRD .= ",'','','','',''";
        $PRODOC_NEWDOCRD .= ",'',''";
        $mDBConn->Query($PRODOC_NEWDOCRD);
        
    }
    
    //* +1 ให้กับ ID : DCS-R
    $PRODOC_ADDRUNNO = "EXEC [dbo].[PRODOC_ADDRUNNO]";
    $PRODOC_ADDRUNNO .= "'DCS-R'";
    $mDBConn->Query($PRODOC_ADDRUNNO);
}

$result = array(
    'sizeof'=>$count , 
    'anser'=>$answer ,
    'remark'=>$remark ,
    'php_empcode'=>$php_empcode ,
    'php_shift'=>$php_shift ,
    'php_line'=>$php_line ,
    'php_mc'=>$php_mc ,
    'php_docdid'=>$php_docdid ,
    'php_dochid'=>$php_dochid ,
    'php_dept'=>$php_dept ,
    'php_empname'=>$php_empname ,
    'php_docrevision'=>$php_docrevision ,
    'lnno'=>$lnno ,
    'type_answer'=>$type_answer ,
    'answer_system'=>$answer_system ,
    'check_answer'=>$check_answer ,
    'return_std'=>$return_std ,
    'result_answer'=>$result_answer 
);
echo json_encode($result);
?>