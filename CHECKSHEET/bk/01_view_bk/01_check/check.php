    <!-- //* row-1 -->
    <div class="row p-5" id="row-login">
        <div class="col d-flex justify-content-center">
            <div class="card border-dark w-75" >
                <div class="row g-0">
                    <div class="col-4">
                        <img src="../artworks/PIC_CHECK-SHEET.svg" class="h-100  rounded-start" alt="...">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h5 class="card-title">production check sheets</h5><hr style="margin: 0 0;">
                            <div class="mt-1">
                                <!-- <form action="" method="post"> -->
                                    <label for="empid" class="form-label">กรุณาใส่รหัสพนักงาน</label>
                                    <input type="number" class="form-control" id="empid" placeholder="ใส่รหัสพนักงาน 7 หลัก">
                                    <div class="mt-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-md btn-success" name="submit" id="btn-row-login" value="next">next</button>
                                    </div>
                                <!-- </form> -->
                            </div>              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //* row-1 -->

    <!-- //* row-2 เลือกเอกสารตรวจสอบ -->
    <div class="row p-5" id="row-doc">
      <div class="col d-flex justify-content-center">
        <div class="card text-center w-100">
          <div class="card-header">
            เลือกเอกสารตรวจสอบ
          </div>
          <div class="card-body">
            <table class="table table-hover" id="tb-document">
              <thead id="thead-document" >
                <tr>
                  <th style="width:20%; text-align:center;">หมายเลขเอกสาร</th>
                  <th style="width:5%; text-align:center;">เวอร์ชั่น</th>
                  <th style="width:65%; text-align:left;">ชื่อเอกสาร</th>
                  <th style="width:10%; text-align:center;">เลือก</th>
                </tr>
              </thead>
              <tbody id="tbody-document"></tbody>
            </table>
            <a href="#" id="btn-row-login-back" class="btn btn-secondary">back</a>
          </div>
        </div>
      </div>
    </div>
    <!-- //* row-2 -->    

    <!-- //* row-3 ระบุข้อมูลการตรวจสอบเพิ่มเติม -->
    <div class="row p-5" id="row-fillcheck">
        <div class="col d-flex justify-content-center">
            <div class="card text-center w-100">
                <div class="card-header">
                ระบุข้อมูลการตรวจสอบเพิ่มเติม
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label for="sel-shift" class="col-4 col-form-label">รหัสกะทำงาน</label>
                        <div class="col-8">
                            <select class="form-select" id="sel-shift" aria-label="">
                                <option value="A" selected>SHIFT : A</option>
                                <option value="B">SHIFT : B</option>
                            </select>                    
                            <div class="valid-feedback">ยอดเยี่ยม!</div>
                            <div class="invalid-feedback">กรุณาเลือกกะทำงาน</div>
                        </div>
                    </div>

                    <!-- //TODO : ใช้กับเอกสาร PM : ประเภทเครื่องจักร -->
                    <div class="mb-3 row" id="row-mc-type">
                        <label for="sel-line" class="col-4 col-form-label">ประเภทเครื่องจักร</label>
                        <div class="col-8" id="col-sel-mc-type">
                            <select class="form-select" id="sel-mc-type" aria-label="" onchange="find_mc()">
                            </select>                    
                        </div>
                    </div>

                    <div class="mb-3 row" >
                        <label for="inp-cus" class="col-4 col-form-label">เครื่องจักร</label>
                        <div class="col-8" id="col-sel-mc">
                           
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="sel-line" class="col-4 col-form-label">ไลน์</label>
                        <div class="col-8">
                            <select class="form-select" id="sel-line" aria-label="">
                            </select>                    
                            <div class="valid-feedback">ยอดเยี่ยม!</div>
                            <div class="invalid-feedback">กรุณาเลือกกะทำงาน</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col d-flex justify-content-end">
                            <a href="#" id="btn-row-doc-back" class="btn btn-secondary">back</a>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-md btn-success" name="submit" id="btn-row-fillcheck" value="next">next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //* row-3 -->   
    
    <div class="row p-5" id="row-sum">
        <div class="col d-flex justify-content-center">
            <div class="card text-left w-100">
                <div class="card-header">
                สรุปรายละเอียดก่อนตรวจเช็ค
                </div>
                <div class="card-body" id="">
                    <!-- <caption>ตารางสรุปรายละเอียดหัวข้อที่เลือก</caption> -->
                    <table class="table table-bordered table-hover" id="table-row-sum">
                    </table>

                    <div class="mb-3 row">
                        <div class="col d-flex justify-content-end">
                            <a href="#" id="btn-row-sum-back" class="btn btn-secondary">back</a>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-md btn-success" name="submit" id="btn-row-sum" value="next">Start</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="" id="revDOCD_DID">
    <input type="hidden" name="" id="revDOCH_HID">

