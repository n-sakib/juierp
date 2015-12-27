$(document).ready(function(){
	$(".button").click(function(){
        alert("this whole thing");
    });
    $(document).on("click",".addSub",function () {    
        $('<ul> <li> <input class="input" type="text"> <span class="addEntry fa fa-plus-square fa-2x cur"></span> </li> </ul>').insertAfter(this); 
    });

    // add new entries
    $(document).on("click",".addEntry",function () {    
       textIn = $(this).siblings(".input").val();
       // parent = $(this).parent().parent().parent(). ;//span<li<ul<li>span:first
       parent = $(this).parent().parent().siblings("span:first").text();//span<li<ul - span first

       grandParent = $(this).parent().parent().siblings("span:first").attr('data-parent');//span<li<ul - span first
       
       parentIndex = $(this).parent().parent().siblings("span:first").attr('data-tableIndex');
       if(parent == '')
       {
            parent = 'root';
            parentIndex = 0 ;
       }
       //alert(parentIndex+" is parent index");

       
       // $('<li><span data-parent="'+parent+'" data-parentIndex="'+parent+'" data-tableIndex="'+parent+'">'+textIn+'</span><span class="edit fa fa-edit fa-2-x cur"></span> <span class="delete fa fa-trash-o fa-2-x cur"></span> <span class="addSub fa fa-list-ul fa-2-x cur"></span> </li>').insertBefore($(this).parent()); 
       // $(this).siblings(".input").val('');

       //save this using ajax, where name = textIn and parent = parent //might be root if the first
       //all the entries must be unique
       //the ajax call must be done first, then the dom insertion 
       //the index of the new entry must be fetched first
       postNewEntry(parent,parentIndex,textIn,this);
    });
    
    function postNewEntry(parent,parentIndex,name,spanElement)
    {

        var clientName = $("input[name='clientName']").val();
        var url = '../model/ajaxHandlers/productCategory.php';
        var vars = "variable=variable"+"&function=postNewEntry"+"&parent="+parent+"&parentIndex="+parentIndex+"&name="+name;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(newEntryIndex){
            index = newEntryIndex ;
            $('<li><span class="lead" data-parent="'+parent+'" data-parentIndex="'+parentIndex+'" data-tableIndex="'+index+'">'+name+'</span><span class="divider-vertical"></span><span class="edit fa fa-edit fa-2-x cur"></span> <span class="delete fa fa-trash-o fa-2-x cur"></span> <span class="addSub fa fa-list-ul fa-2-x cur"></span> </li>').insertBefore($(spanElement).parent()); 
            $(spanElement).siblings(".input").val('');

            //alert(index);
            //alert("something");
        });
    }


    //color part
    $(".addColor").click(function(){
        textIn = $(this).siblings(".colorName").val();
        addNewColor(textIn,this);
        $(this).siblings(".colorName").val("");
      });

    function addNewColor(colorName,spanElement)
    {
        //alert(colorName);
        var url = '../model/ajaxHandlers/productCategory.php';
        var vars = "variable=variable"+"&function=createNewColor"+"&name="+colorName;
        
        var request = $.ajax({
            url: url,
            type: 'POST',
            data: vars,
            dataType: "text"
        });
        
        //the page returns the new entry index
        request.done(function(newEntryIndex){
            index = newEntryIndex ;
            $('<li> <span class="lead" data-colorIndex="'+index+'">'+colorName+'</span> <span class="divider-vertical"></span><span class="editColor fa fa-edit fa-2 cur"></span> <span class="deleteColor fa fa-trash-o fa-2 cur"></span> </li>').insertBefore($(spanElement).parent()); 

        });
    }
});