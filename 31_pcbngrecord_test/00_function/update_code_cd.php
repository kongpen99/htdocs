<?php
function FN_SET_RUNNO($rev_RUNNO , $rev_year_month , $rev_MCD_POINT1 , $rev_point){
    //* ใส่เลข 0 หน้าฟิลล์ MCD_RUNNO 
    $SET_RUNNO = str_pad($rev_RUNNO,$rev_point,"0",STR_PAD_LEFT);
    //* กำหนด OPS_ID
    $OPS_ID = $rev_MCD_POINT1."-".$rev_year_month."-".$SET_RUNNO;
    return($OPS_ID);
}

function UPDATE_RUNNO($rev_RUNNO , $mDBConn  , $CODE){
    $update = "UPDATE [WEB_CODECD_TBL]
    SET [CODE_RUNNO] = '".$rev_RUNNO."',
    [CODE_LSTDT] = GETDATE()
    WHERE [CODE_CD] = '".$CODE."'";
    $mDBConn->Query($update);
}
?>