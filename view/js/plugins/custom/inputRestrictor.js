/**
 * restricts to enter any data 
 * other than those in the respective
 * data-list of a certain input element
 */
function restrictInDataList(inputElement){
    if(ifNotInList(inputElement))
    {
        $(inputElement).val("");
    }
}
function restrictInDB(inputElement){
    if(ifNotInList(inputElement))
    {
        $(inputElement).val("");
    }
}
function ifNotInList(inputElement) {
    textIn = $(inputElement).val();

    not_ListingState = true;

    //console.log("==============");
    //console.log(textIn);
    //console.log("==============");
    listName = $(inputElement).attr("list");
    $("#" + listName).children("option").each(function() {
        //console.log($(this).val());
        if ($(this).val() == textIn) {
            //console.log("no")
            not_ListingState = false; //reverse logic tho
        }
    });
    //console.log("yes")
    return not_ListingState;
}