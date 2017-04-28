<?php
include "inc/header.php";

if (!isset($_SESSION['user'])) {
    header('Location:../view/index.php');
}
?>


<body>

<?php if (isset($message)) { ?>

        <div  class="<?= $class ?>" style="margin-top:60px;"><?= $message ?></div>

<?php } ?>
    <!-- Fixed navbar -->
    <?php include "inc/nav.php"; ?>
    <section id="content" role="main" class="container">

        <div id="homepage-panel">

            <div class="row">

                <div class="col-md-10">
                    <h3>My Open Tasks</h3>
                    <div class="search-input">
                        <input type="text" id="search" class="form-control" placeholder="Type to search">
                    </div>
                    <table id="userlist" class="table table-responsive table-bordered">
                        <thead style="background-color: #205081; color: #fff;">
                            <tr>
                                <th>id</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Progress</th>
                                <th>Project</th>
                            </tr>
                        </thead>
                        <tbody>
								<?php if (isset($openTasks) && $openTasks) {
								    foreach ($openTasks as $task) {
								        ?>

                                    <?php //var_dump($task); ?>
                                    <tr>
                                        <td><?= $task->prefixId ?></td>
                                        <td><?= $task->title?></td>
                                        <td><img style="width: 20px; margin-right: 5px;" src="../view/images/type_<?= $task->type?>.png"><?= $task->type?></td>
                                        <td><?= $task->priority?><img style="width: 30px; margin-left: 0px;" src="../view/images/priority_<?= $task->priority?>.png"></td>
                                         <td><?= (!strtotime($task->startDate) ? "<em style='color:red;'>Not set</em>" : $task->startDate) ?></td>
                               			 <td><?= (!strtotime($task->startDate) ? "<em style='color:red;'>Not set</em>" : $task->endDate) ?></td>
                                        <td>
                                            <div class="progress-wrap progress" style="background-color:orange;" data-progress-percent="<?= $task->progress?>">
                                                <div class="progress-bar progress"></div>	  
                                            </div>
                                            <p class="progress_perc" ><?= $task->progress ?>%</p>
                                        </td>
                                        <td><?= $task->projectName ?></td>
                                    </tr>
							    <?php }
							} else {
							    ?>
                                <tr>
                                    <td colspan="9" style="text-align: center;"><em><strong>No results found.</strong></em></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <h3>My Working On Tasks</h3>
                    <table id="userlist" class="table table-responsive table-bordered">
                        <thead style="background-color: #205081; color: #fff;">
                            <tr>
                                <th>id</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Progress</th>
                                <th>Project</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($workingOnTasks) && $workingOnTasks) {
                                foreach ($workingOnTasks as $task) {
                                    ?>

                                    <?php //var_dump($task); ?>
                                    <tr>
                                        <td><?= $task->prefixId ?></td>
                                        <td><?= $task->title ?></td>
                                        <td><img style="width: 20px; margin-right: 5px;" src="../view/images/type_<?= $task->type ?>.png"><?= $task->type ?></td>
                                        <td><?= $task->priority ?><img style="width: 30px; margin-left: 0px;" src="../view/images/priority_<?= $task->priority?>.png"></td>
                                         <td><?= (!strtotime($task->startDate) ? "<em style='color:red;'>Not set</em>" : $task->startDate) ?></td>
                               			 <td><?= (!strtotime($task->startDate) ? "<em style='color:red;'>Not set</em>" : $task->endDate) ?></td>
                                        <td>
                                            <div class="progress-wrap progress" style="background-color:orange;" data-progress-percent="<?= $task->progress ?>">
                                                <div class="progress-bar progress"></div>	  
                                            </div>
                                            <p class="progress_perc" ><?= $task->progress ?>%</p>
                                        </td>
                                        <td><?= $task->projectName ?></td>
                                    </tr>
                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" style="text-align: center;"><em><strong>No results found.</strong></em></td>
                                </tr>
						<?php } ?>
                        </tbody>
                    </table>


                </div><!-- /.blog-main -->

                <aside class="col-md-2 sidebar">
                    <div class="bg-info">
                        <h3 class="text-center">My projects</h3>
                        <ul>
                            <?php if (isset($workingOnTasks) && $workingOnTasks)
                                foreach ($workingOnTasks as $task):
                                    ?>
                                    <li onclick="location.href = '../controller/ViewProjectController.php?project=<?= $task->projectName ?> ';"><a href="#"><?= $task->projectName ?></a></li>
  							  <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="bg-info">
                        <h3 class="text-center">Users</h3>

                    </div>
                    <aside><!-- /.blog-sidebar -->

                        </div><!-- /.row -->
                        </div>


                        </section><!-- /.container -->


<?php include "inc/footer.php"; ?>
