
function fn1() {
    setTimeout(function() {
        printMsg();
    } , 0);
    function printMsg(){
            console.log("warning 1");
    }
}
function fn2() {
    dfr = $.Deferred();
    setTimeout(function() {
        printBar();
    } , 1500);
    setTimeout(function() {
        printMsg();
    } , 2000);
    setTimeout(function() {
        printBar();
    } , 2500);
    function printMsg(){
        console.log("warning 2");        
        dfr.resolve();
    }
    function printBar(){
        console.log("========");
    }
    return dfr;
}
fn = fn2();
// $.when(dfObject) takes dfObject
// hence the function must return a 
// dfr object
// still have this limitation
$.when(fn).then(function(){
    fn1()
});