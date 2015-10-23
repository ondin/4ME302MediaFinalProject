$(document).ready(function() {

    //*** send add record Ajax request to response.php ***/
    $("#FormSubmit").click(function (e) {
        e.preventDefault();
        if($("#contentText").val()==='')
        {
            alert("Text area cannot be empty!");
            return false;
        }

        $("#FormSubmit").hide(); //hide submit button
        $("#LoadingImage").show(); //show loading image

        var myData = 'content_txt='+ $("#contentText").val(); //build a post data structure
        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "response.php", //Where to make Ajax calls
            dataType:"text", // Data type, HTML, json , in this case text
            data:myData, //Form variables
            success:function(response){
                $("#responds").append(response);
                $("#contentText").val(''); //empty text field on successful
                $("#FormSubmit").show(); //show submit button
                $("#LoadingImage").hide(); //hide loading image

            },
            error:function (xhr, ajaxOptions, thrownError){
                $("#FormSubmit").show(); //show submit button
                $("#LoadingImage").hide(); //hide loading image
                alert(thrownError);
            }
        });
    });

    //******* Send delete Ajax request to response.php ******/
    $("body").on("click", "#responds .del_button", function(e) {
        e.preventDefault();
        var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
        var DbNumberID = clickedID[1]; //and get number from array
        var myData = 'recordToDelete='+ DbNumberID; //build a post data structure

        $('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
        $(this).hide(); //hide currently clicked delete button

        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "response.php", //Where to make Ajax calls
            dataType:"text", // Data type, HTML, json
            data:myData, //Form variables
            success:function(response){
                //on success, hide element user wants to delete.
                $('#item_'+DbNumberID).fadeOut();
            },
            error:function (xhr, ajaxOptions, thrownError){
                //On error, alert user
                alert(thrownError);
            }
        });
    });

});