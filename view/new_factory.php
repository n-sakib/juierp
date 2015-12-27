<?php include('template/blankStart.php');?>

<?php include('sections/profiles-nav.php');?>
<?php
require_once '../model/factory.php';

if($_POST)
{
    $factory = new Factory($_POST["name"]);
    $factory->createProfile();

    echo "<hr>
         <div>
            <div class=\"alert alert-dismissable alert-success\">
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
              সফল
            </div>
          </div>";
}
?>

<form action="new_factory.php" method="post">
       <div>
            <div class="row text-center">
                <!-- 
                <h2> ~ তালিকাভুক্তি</h2>
                <a href="test_page.php">test</a> 
                -->
            </div>
            <div>
                 <label for="firstname" class="col-md-2">
                    নাম :
                </label>
                <div class="col-md-9">
                    <input type="text" name="name" class="form-control" id="firstname" placeholder="">
                </div>
            </div>   
            <br>  
            <div>
                <label for="lastname" class="col-md-2">
                    ফোন :
                </label>
                <div class="col-md-9">
                    <input type="text" name="clientPhone" class="form-control" id="lastname" placeholder="">
                </div>
            </div>  
            <br> 
            <div>
                <label for="lastname" class="col-md-2">
                    ঠিকানা :
                </label>
                <div class="col-md-9">
                    <input type="text" name="clientAddress" class="form-control" id="lastname" placeholder="">
                </div>
            </div>
            <br>
            <div>
                <label for="emailaddress" class="col-md-2">
                    ইমেইল :
                </label>
                <div class="col-md-9">
                    <input type="email" name="clientEmail" class="form-control" id="emailaddress" placeholder="">
                    <p class="help-block">
                        উদাহরন: yourname@domain.com
                    </p>
                </div>
            </div>
            
            <!-- <div>
                <label for="uploadimage" class="col-md-2">
                    ছবি :
                </label>
                <div class="col-md-10">
                    <input type="file" name="uploadimage" id="uploadimage">
                    <p class="help-block">
                        যেসব ছবির ফাইল দেওয়া যাবে : jpeg, jpg, gif, png
                    </p>
                </div>          
            </div> -->
            <div>
                <div class="col-md-2">
                </div>
                          
            </div>
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-info pull-right">
                        তালিকাভুক্তি
                    </button>
                </div>
            </div> <!-- one tabspace added -->
        </div>  
    </form>

<?php include('template/blankEnd.php');?>