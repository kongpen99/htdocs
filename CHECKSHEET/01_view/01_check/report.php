<!-- //* row แสดงผลเรียกรายงาน -->
<div class="row p-5" id="row-report">
    <div class="col d-flex justify-content-center">
        <div class="card w-100">
            <!-- <div class="card-header d-flex justify-content-center">หน้าเรียกรายงาน</div> -->
            <div class="card-body">
                <form action="" id="form-report" method="post">
                    <div class="row">
                        <div class="col">
                            <label for="">รายงานการตรวจเช็ค (กรุณาเลือกวันที่เริ่มต้นและวันที่สิ้นสุด)</label>
                        </div>
                    </div>
                    <hr>
                    <!-- <div class="row ">
                        <div class="col">
                            <label for="" class="form-label">กรุณาเลือกรายงานที่ท่านต้องการ</label>
                            <select class="form-select" id="select_report" name="select_report" aria-label="multiple select example" onchange="select_report()">
                                <option value="1" selected>รายงานตรวจสอบประวัติการซ่อม PCB</option>
                            </select>        
                        </div>
                    </div>     -->
                    <div class="row">
                        <div class="col">
                            <label for="" class="form-label">วันที่เริ่มต้น</label>
                            <input type="date" id="date_start" name="date_start" class="form-control">
                        </div>
                    </div>  
                    <div class="row pt-4">
                        <div class="col">
                            <label for="" class="form-label">วันที่สิ้นสุด</label>
                            <input type="date" id="date_end" name="date_end" class="form-control">
                        </div>
                    </div>  
                    <div class="row pt-4">
                        <div class="col">
                            <button type="submit" id="btn-submit-report" class="btn btn-lg btn-success"><i class="bi bi-send-check-fill"></i> ค้นหา</button>
                        </div>
                    </div>  
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <a href="#" id="btn-row-login-back" class="btn btn-secondary">back</a>
                </div>
            </div>
        </div>
    </div>
</div>