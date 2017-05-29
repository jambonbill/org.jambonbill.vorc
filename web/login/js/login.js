$(function(){

    /*
    if (window.location.host!="127.0.0.1"&&window.location.protocol != "https:") {
        window.location.protocol = "https:";//force https
    }
    */


    $("#boxlogin .overlay").hide();


    getProfile();//load

    console.log("ready");

});



function getProfile()
{
    console.log('getProfile()');

    var conf=$('#configs').val();
    if (!conf) {
        $("#email, #password").prop('disabled', true);
        console.error('!conf');
        return false;
    }

    $("#email, #password").prop('disabled', false);

    $.post("ctrl.php",{'do':'testProfile','conf':$('#configs').val()},function(json){

        if(json.user&&json.user.is_active&&json.user.is_staff){
            console.info("Hello "+json.user.first_name);
            document.location.href='../home';
        }else{
            console.log(json);
        }

    }).fail(function(e){
        console.error(e.responseText);
    });
}


