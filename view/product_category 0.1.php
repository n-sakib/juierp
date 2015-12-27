<?php 
	$mojud ="selected"; 
	include('template/blankStart.php');?>
<script type="text/javascript" src="js/product_categoryScript.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title text-center">জুতা ধরন</h3>
            </div>
            <div class="panel-body">
                            	
            	<ul>
            		<li>
            			<input class="" type="text" data-tableIndex="" readonly>
            			<span class="edit fa fa-edit fa-2 cur"></span>
            			<span class="delete fa fa-trash-o fa-2 cur"></span>
            			<span class="addSub fa fa-cogs fa-2 cur"></span>
            		</li>
            		<li>
            			<input class="" type="text">
            			<span class="addEntry fa fa-plus-square fa-2 cur"></span>
            		</li>
            	</ul>

            </div>
        </div>
    </div>
</div>


<?php include('template/blankEnd.php');?>