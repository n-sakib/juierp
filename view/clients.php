<?php include('template/blankStart.php');?>
<?php 
include_once '../model/profiles/client.php';
$clients = client::getAll();
 ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> </h3>
            </div>
            <div class="panel-body">
                <?php 
                    $index = 1;
                    foreach($clients as $client)
                    {
                        echo "<a href=\"client_info.php?client=$client[name]\"> $index.$client[name]</a><br>";
                        $index++;
                    }
                 ?>
            </div>
        </div>
    </div>
</div>


<?php include('template/blankEnd.php');?>