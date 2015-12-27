<?php include('template/blankStart.php');?>
<?php 
include_once '../model/profiles/client.php';
 ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"> </h3>
            </div>
            <div class="panel-body">
                <?php 
                        $client = client::get($_GET['client']);
                        echo "<h1>নাম :$_GET[client]</h1><br>";
                        echo "<h1>ফোন :$client[address]</h1><br>";                        
                        echo "<h1>ফোন :$client[phone]</h1><br>";
                        echo "<h1>ফোন :$client[email]</h1><br>";
                 ?>
            </div>
        </div>
    </div>
</div>


<?php include('template/blankEnd.php');?>