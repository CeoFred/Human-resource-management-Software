$(document).ready(function () {


$('#eform').on('submit',function(e){
e.preventDefault();
// console.log('in progress');

var givenname = $('#givenname').val();
var familyname = $('#familyname').val();
var email = $('#email').val();
var department = $('#department').val();
var gender = $('#gender').val();
    const url = $('#eform').attr('action');

    $.ajax({
        method: "POST",
        data: {
            email: email,
            givenname: givenname,
            familyname: familyname,
            department: department,
            gender: gender},
        url: url,
        success: function (data, textStatus, jqXHR) {
            console.log(data)
            console.log(textStatus)
            console.log(jqXHR)
            document.getElementById('alertfore').style.display = 'block';
        },

        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
            console.log(jqXHR)
            console.log(textStatus)

            document.getElementById("alertforerror").style.display = "none";
            ;
        },

        beforeSend: function () {
            $('#gif').show();
            document.getElementById("alertfore").style.display = "none";
            document.getElementById("alertforerror").style.display = "none";
        },

        complete: function () {
            $('#gif').hide();
            setTimeout(close, 5000);

        }

    });

    function close() {
        document.getElementById("alertfore").style.display = "none";
    }

});


$('#iform').on('submit',function(e){
e.preventDefault();
console.log('first step');
  var formData = new FormData(this);
const url = $('#iform').attr('action');
$.ajax({
method:"POST",
data: formData,
url:url,
 cache:false,
contentType: false,
processData: false,
 success: function (data, textStatus, jqXHR) {
    console.log(data);
             document.getElementById('alert3').style.display = 'block';
     },
     error: function (jqXHR, textStatus, errorThrown) {
         console.log(errorThrown)
         console.log(jqXHR)
         console.log(textStatus)
     },
     beforeSend: function () {
             $('#gif3').show();
             document.getElementById('alert3').style.display = 'none';
         },
         complete: function () {
             $('#gif3').hide();
setTimeout(close,3000);

            }

});

function close(){
 document.getElementById('alert3').style.display = 'none';
}

});


//update work information
    $('#wsubmit').click(function(e){
e.preventDefault();
var employmenMode = $('#empm').val();
var dateOfEmployment = $('#dos').val();
var position = $('#position').val();
var department = $('#department').val();
var actionurl = $('#wform').attr('action');
$.ajax({
    type: "POST",
        url: actionurl,
        data: {
        department: department,
        dateOfEmployment:dateOfEmployment,
        position:position,
        employmenMode:employmenMode
        },
        beforeSend: function () {
                $('#gif2').show();
                document.getElementById('alert2').style.display = 'none';
            },
            complete: function () {
                $('#gif2').hide();
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);

                document.getElementById('alert2').style.display = 'block';

                //data - response from server
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
                console.log(jqXHR)
                console.log(textStatus)
            }

});

});

    $("#submit").click(function (event) {

        document.getElementById('alert').style.display = 'none';
        var email =   $("#email").val();
      var  actionurl = $('#pform').attr('action');
      var firstname = $('#fname').val();
      var lastname = $('#lname').val();
      var address = $('#address').val();
      var state = $('#state').val();
      var lga = $('#lga').val();
      var phonenumber = $('#phone').val();
      var maritalstatus = $('#maritalstatus').val();
    //   var dateofbirth = $('#cal');
    console.log(email,actionurl,firstname,lastname
        ,address,state,lga,phonenumber,maritalstatus)
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: actionurl,
            data: { email:email,state:state,
                lga:lga,address:address ,
            lastname:lastname,
        firstname:firstname,
    maritalstatus: maritalstatus,
    phonenumber:phonenumber
    },
            beforeSend: function() {
                $('#gif').show();
            },
            complete: function() {
                $('#gif').hide();
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data,textStatus);
                document.getElementById('alert').style.display = 'block';

                //data - response from server
            },
            error: function (jqXHR, textStatus, errorThrown) {
console.log(errorThrown)
console.log(jqXHR)
console.log(textStatus)
}
        })

    });
});
