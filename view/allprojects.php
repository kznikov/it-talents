<?php 
  $pageTitle="All projects";
  include "inc/header.php"; 
  
  
  session_start();
  if(!isset($_SESSION['user'])){
  	header('Location:../view/index.php');
  }
?>

<body>
   
   <?php include "inc/nav.php";  ?>

   <section id="content" role="main" class="container">
    <div id="homepage-panel">
      <div class="row">          
        <div class="myproject-header">
          <div class="myproject-title col-xs-12 col-md-10">
            <h2>All projects</h2>

          </div>
          <div class="myproject-button col-xs-12 col-md-2">
             <button onclick="location.href = 'newproject.php';" class="btn btn-primary">Create  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
          </div>
        </div>

        <table class=" myproject-table table table-responsive table-bordered">
          <thead style="background-color: #205081; color: #fff;">
            <tr>
              <th>Name</th>
              <th>Admin</th>
              <th>Open tasks</th>
              <th>All tasks</th>
              <th>Client</th>
              <th>Status</th>
              <th>Progress</th>
              <th>Action</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td>Брой задачи</td>
              <td>Брой задачи</td>
              <td></td>
              <td></td>
			  <td></td>
              <td class="text-center">
                <a href="#"><span class="glyphicon glyphicon-eye-open" title="View"></span></a>
                <a href="#"><span class="glyphicon glyphicon-cog" title="Edit"></span></a>
                <a href="#"><span class="glyphicon glyphicon-trash" title="Delete"></span></a>
              </td>
              <td lass="text-center">
                <a href="mailto:joe@example.com"><span class="glyphicon glyphicon-envelope"></span></a>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="bg-success">
          <p>Export as word, exel, pdf</p>
        </div>

       

      </div> <!-- class="row" -->
    </div>
   </section><!-- /.container -->
<?php include "inc/footer.php"; ?>

   