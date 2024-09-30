<?php
$serverName = "AOTHLP0135\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array("Database" => "SYS-CHECK", "UID" => "", "PWD" => "");
$conn = sqlsrv_connect($serverName, $connectionInfo);
//echo "Connection established connection completed.<br />";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="../js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap5.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->


    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery-3.7.1.min.js"></script>
</head>

<body>

    <!-- <h2 style="color:blue">History Antivirus Sysmatec Update </h2>
    <center><a href="Link-Page/Antivirus.php" target="_blank"><button type="submit" class="mb-2 btn btn-success">Confirm record</button></center></a>
    
    
    <table id="example" class="table table-bodered table-striped" style="width:100%">
        <thead>

            <tr>
                <th>Date</th>
                <th>Virus Definition</th>
                <th>SuccFail/</th>
                <th>Check By</th>
                <th>Confirm By</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011-04-25</td>
                <td>$320,800</td>
            </tr>
            </tfoot>
    </table> -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ffd60a;">
                    <h3 style="color:blck ;font-weight:bold;" class="modal-title" id="exampleModalLabel">Check by</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <form action="insert.php" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col">
                                <label style="color: blue;" for="" class="form-label">วันที่อัพเดทครั้งล่าสุด</label>
                                <input type="date" id="date_start" name="date_start" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">Definition:</label>
                            <input type="text" required class="form-control" name="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">Record Name:</label>
                            <input type="text" required class="form-control" name="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">Comment:</label>
                            <input type="text" required class="form-control" name="position">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">Image:</label>
                            <input type="file" required class="form-control" id="imgInput" name="img">
                            <img loading="lazy" width="100%" id="previewImg" alt="">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                            <!-- <button class="px-4 py-1 text-sm text-green-500 font-semibold rounded-full border border-green-400 hover:text-white hover:bg-green-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">Register</button> -->

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- <h2 color> TEST SWEETALERT 2 REGISTER </h2> -->
                <h2 style="color:blue">History Antivirus Sysmatec Update </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">Record Check</button>

                <button type="button" class="btn btn-success btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo"> Confirm record</button>

            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Definition</th>
                    <th scope="col">Record by</th>
                    <th scope="col">Confirm by</th>
                    <th scope="col">Comment</th>
                    <!-- <th scope="col">Img</th>
                    <th scope="col">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <!-- <?php
                        $stmt = $conn->query("SELECT * FROM user");
                        $stmt->execute();
                        $users = $stmt->fetchAll();

                        if (!$users) {
                            echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                        } else {
                            foreach ($users as $user) {
                        ?> -->
                <tr>
                    <th scope="row"><?php echo $user['id']; ?></th>
                    <td><?php echo $user['firstname']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['position']; ?></td>
                    <td width="250px"><img class="rounded" width="100%" src="uploads/<?php echo $user['img']; ?>" alt=""></td>
                    <td>
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">Edit</a>
                        <a data-id="<?php echo $user['id']; ?>" href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger delete-btn">Delete</a>
                    </td>
                </tr>
        <?php }
                        } ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file)
            }
        }
        $('.delete-btn').click(function(e) {
            var userid = $(this).data('id');
            e.preventDefault();
            deleteConfirm(userid);
        })

        function deleteConfirm(userid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "It will be delete permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#25a347',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,delete it!',
                showCancelButton: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        setTimeout(function(resolve) {
                            $.ajax({
                                    url: 'index.php',
                                    type: 'GET',
                                    data: 'delete=' + userid,
                                })
                                .done(function() {
                                    Swal.fire({
                                        title: 'success',
                                        text: 'Data deleted successfully!',
                                        icon: 'success',
                                    }).then(() => {
                                        document.location.href = 'index.php';
                                    })
                                })
                                .fail(function() {
                                    Swal.fire('Oops...', 'Somthing went wrong with ajax!', 'error');
                                    window.location.reload();
                                })
                        })
                    })
                }
            })
        }
    </script>

</body>

</html>