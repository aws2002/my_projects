<?php
 include 'header.php';
$button_text        = 'Add';
$button_name        = 'add';
$button_class       = 'warning';
$button_border_calor= 'fdf401';
$border_calor_th    = 'fdf401';

 if(isset($_POST['add'])){
     $name       =htmlspecialchars($_POST['name']);
     $num_hours  =htmlspecialchars($_POST['num_hours']);
     $mark       =htmlspecialchars($_POST['mark']);
     $total_hours=htmlspecialchars($_POST['total_hours']);

     $sql = " INSERT INTO info_std(name,num_of_hours,expected_mark,	total_hours) VALUES ('$name ',$num_hours,$mark,$total_hours )";
     if(mysqli_query($conn, $sql)){
        $_SESSION['message'] = 'The addition has been completed successfully';
        $_SESSION['type']    = 'success';
        header("Location: index.php"); 
        exit;
     }

 }

 if (isset($_GET['delete'])) {
    $id  = htmlspecialchars($_GET['delete']);
    $sql ="DELETE FROM info_std WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'The deletion was completed successfully';
        $_SESSION['type']    = 'danger';
        
        header("Location: index.php"); 
        exit;
    }
}

$old_name_subject   ='';
$old_number_of_hours='';
$old_expected_mark  ='';
$old_total_hours    ='';

if(isset($_GET['edit'])){
    $id=htmlspecialchars($_GET['edit']);

    $sql=" SELECT * FROM info_std WHERE id=$id";
    $result=mysqli_query($conn,$sql);
    $old_data=mysqli_fetch_assoc($result);

    $old_name_subject   =$old_data  ['name'];
    $old_number_of_hours=$old_data  ['num_of_hours'];
    $old_expected_mark  =$old_data  ['expected_mark'];
    $old_total_hours    =$old_data  ['total_hours'];


    $button_text        ='Update Record';
    $button_name        ='update';
    $button_class       ='primary';
    $button_border_calor='007bff';
    $border_calor_th    ='007bff';
}

if(isset($_POST['update'])){
     $id          =htmlspecialchars($_POST['id']);
     $name        =htmlspecialchars($_POST['name']);
     $num_hours   =htmlspecialchars($_POST['num_hours']);
     $mark        =htmlspecialchars($_POST['mark']);
     $total_hours =htmlspecialchars($_POST['total_hours']);

     $sql="UPDATE info_std SET name='$name' , num_of_hours='$num_hours',expected_mark='$mark',total_hours='$total_hours' WHERE id =$id";
     if(mysqli_query($conn,$sql)){
        $_SESSION['message'] = 'The modification has been completed successfully';
        $_SESSION['type']    = 'warning';
        header("Location: index.php");
        
        exit;
     }
}
if(isset($_POST['cal'])){
    $sql=" SELECT * FROM info_std";
    $result=mysqli_query($conn,$sql);

    

}
     
    
?>
<main>


    <section>
        <?php if(isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['type'] ?> alert-dismissible fade show tex_h4 m-0  " role="alert">
            <?php echo '<h4>'.$_SESSION['message'].'</h4>';
        
        unset($_SESSION['message']);
        unset($_SESSION['type']);
        ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php } ?>


        <div class="container">

            <div class="row ">
                <div class="col-md-6">
                    <div class="sec1 mt-3" style="border-bottom:4px solid #<?php echo $button_border_calor?> ;">
                        <div class="container ">
                            <form action="" method="post">

                                <?php if (isset($_GET['edit'])) { ?>

                                <input type="hidden" name="id" value="<?php echo $_GET['edit'] ?>">

                                <?php } ?>

                                <div class="form-group ">
                                    <label>Name Subject </label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?php echo $old_name_subject ?>" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label>Hours subject</label>
                                    <input type="number" name="num_hours" class="form-control"
                                        value="<?php echo $old_number_of_hours ?>" placeholder="Number of hours">
                                </div>
                                <div class="form-group">
                                    <label>expected mark</label>
                                    <input type="number" name="mark" class="form-control"
                                        value="<?php echo $old_expected_mark ?>" placeholder="Degree">
                                </div>
                                <div class="form-group">
                                    <label>Total hours</label>
                                    <input type="number" name="total_hours" class="form-control"
                                        placeholder="Total hours" value="<?php echo $old_total_hours ?>">
                                </div>
                                <div class="form-group">
                                    <label>average =</label>
                                </div>
                                <button class="btn btn-<?php echo $button_class?> btn-block mt-4"
                                    name="<?php echo $button_name ?>"><?php echo $button_text?></button>
                                <button class="btn btn-success btn-block mt-3" name="cal">Calculate</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="container  mt-3">
                        <div class="sec2">
                            <table
                                class="table table-striped table-dark table-bordered table-hover table-sm text-center">
                                <tr>
                                    <th style="border-top: 5px solid #<?php echo $border_calor_th?>;">Name Subject</th>
                                    <th style="border-top: 5px solid #<?php echo $border_calor_th?>;">number of hours
                                    </th>
                                    <th style="border-top: 5px solid #<?php echo $border_calor_th?>;">expected mark</th>
                                    <th style="border-top: 5px solid #<?php echo $border_calor_th?>;">Actions</th>
                                </tr>
                                <?php 
                                $sql= " SELECT * FROM info_std ORDER BY id DESC";
                                $result= mysqli_query($conn,$sql);
                                while($subject = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td><?php echo $subject['name'] ?></td>
                                    <td><?php echo $subject['num_of_hours'] ?></td>
                                    <td><?php echo $subject['expected_mark'] ?></td>
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to delete the data ?')"
                                            href="index.php?delete=<?php echo $subject['id'] ?>"
                                            class="btn btn-sm btn-danger ml-1 "><i class="fas fa-trash"></i></a>
                                        <a href="index.php?edit=<?php echo $subject['id'] ?>"
                                            class="btn btn-sm btn-primary ml-2"><i class="fas fa-edit "></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


</main>
<?php include 'footer.php'; ?>