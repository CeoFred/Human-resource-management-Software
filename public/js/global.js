function showurlForPassportUpload(){

    input =  document.getElementById('showUrlInputPassportUpload')
    if(input.style.display == 'none' ){
 document.getElementById('showUrlInputPassportUpload').style.display = 'block';
 document.getElementById('employeePassport').style.display = 'none';
 document.getElementById('query2').style.display = 'block';
 document.getElementById('query1').style.display = 'none';

}else{ 
    document.getElementById('showUrlInputPassportUpload').style.display = 'none';
 document.getElementById('employeePassport').style.display = 'block';
 document.getElementById('query2').style.display = 'none';
 document.getElementById('query1').style.display = 'block';


}

}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#fileToUpload").change(function(){
    readURL(this);
});
function sendWish(event) {
event.preventDefault();

    const url = $('#wishform').attr('action');
    var xhttp;
    xhttp = new XMLHttpRequest();
var email =   document.getElementById('celebrantsEmail').value;
var message = document.getElementById('birthdayWish').value;
console.log(email,message);
xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("response").style.display = 'block';
            document.getElementById("response").innerHTML = this.responseText;
            // document.getElementById('gif10').style.display = 'none';
setTimeout(close,7000);
setTimeout(stop,1000)

        }
        if (this.readyState == 2 || this.readyState == 3 || this.readState == 1) {

            document.getElementById('gif10').style.display = 'block'
        }
    };
    var parameters = "email=" + email + "&message=" + message;
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhttp.send(parameters);
function close(){

    document.getElementById("response").style.display = 'none';
}
function stop(){
    document.getElementById('gif10').style.display = 'none'

}
}


function showBirhdayWishes() {
    let wishlist = document.getElementById('wishelist')
    if(wishlist.style.display == 'none'){
    document.getElementById('wishelist').style.display = 'block';
    }else{
        document.getElementById('wishelist').style.display = 'none';

    }
// document.getElementById('wishesLog')
}

new Chartist.Bar('.ct-chart', {
    labels: ['Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
    series: [20, 60, 120, 200, 180, 20, 10]
}, {
    distributeSeries: true
});



// employee search
function showHint2(val) {
    const url = $('#employeeSearch2').attr('action');
    let value = val;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
if (this.responseText.length == 0 ){
            document.getElementById("txtHintContent2").innerHTML = 'not found';

}
            document.getElementById("txtHintContent2").innerHTML = this.responseText;
            document.getElementById("txtHint2").style.display = 'block';

            document.getElementById('gif5').style.display = 'none'
        }
        if (this.readyState == 2 || this.readyState == 3 || this.readState == 1) {

            document.getElementById('gif5').style.display = 'block'
        }
    };
    xhttp.open("GET", url + value, true);
    xhttp.send();

}
function closediv2() {
    setTimeout(closeup2, 200)

}

function closeup2() {
    document.getElementById("txtHint2").style.display = 'none';
}

function showMembers(department){


    if(department == 1){
        //  document.getElementById('Software').style.display = 'inline';
        document.getElementById('softguys').style.display = 'block';
        document.getElementById('marketingguys').style.display = 'none';
        document.getElementById('showing').innerHTML = 'Software Department';
    document.getElementById('accountguys').style.display = 'none';


    }else if(department == 2){
document.getElementById('softguys').style.display = 'none';
document.getElementById('marketingguys').style.display = 'block';
    document.getElementById('accountguys').style.display = 'block';
document.getElementById('showing').innerHTML = 'Marketing Department';
document.getElementById('accountguys').style.display = 'none';

        // document.getElementById('Marketing').style.display = 'inline';
}else {

    document.getElementById('accountguys').style.display = 'block';
    document.getElementById('softguys').style.display = 'none';
    document.getElementById('marketingguys').style.display = 'none';
    document.getElementById('showing').innerHTML = 'Accounting Department';

}
}


function show(value){

    if (value == 'departmentAndMembers')
    {
        document.getElementById('directory').style.border = ''
        document.getElementById('dept').style.border = ''

        document.getElementById('departmentAndMembers').style.display = 'block';
        document.getElementById('departmentList').style.display = 'none';
        document.getElementById('directory').style.borderBottom = '3px solid lightblue'

    } else if(value == 'departmentList'){

        document.getElementById('directory').style.border = ''
        document.getElementById('dept').style.border = ''

        document.getElementById('departmentList').style.display = 'block';
        document.getElementById('departmentAndMembers').style.display = 'none';

        document.getElementById('dept').style.borderBottom = '3px solid lightblue'
    }
}
function closediv(){
    setTimeout(closeup,1000)

}
function closeup(){
document.getElementById("txtHint").style.display = 'none';
}
// employee search
function showHint(val) {
    const url = $('#employeeSearch').attr('action');
    let value = val;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHintContent").innerHTML = this.responseText;
            document.getElementById("txtHint").style.display = 'block';

            $('txtHintContent').LoadingOverlay('show');
        }
        if (this.readyState == 2 || this.readyState == 3 || this.readState == 1) {

            // document.getElementById('gif5').style.display = 'block'
            $('txtHintContent').LoadingOverlay('show');
        }
    };
    xhttp.open("GET", url + value, true);
    xhttp.send();

}

$(document).ready(function () {



$('#showUrlInputPassportUpload').on('submit', function(event){
event.preventDefault();
const imageUrl = $('#urlValue').val();
const actionUrl = $('#showUrlInputPassportUpload').attr('action');
console.log(imageUrl);

$.ajax({

    method: "POST",
    url: actionUrl,
    data : { imageUrl: imageUrl },
    beforeSend: function(){
$('#showUrlInputPassportUpload').LoadingOverlay('show');
    } ,
    complete: function(){
        $('#showUrlInputPassportUpload').LoadingOverlay('hide');
    },success: function(data, textStatus, jqXHR){
document.getElementById('alert3').innerHTML = data;
document.getElementById('alert3').style.display = 'block';
console.log(data);
setInterval(close,5000);

    },error: function(jqXHR, textStatus, errorThrown){
        document.getElementById('alert3').innerHTML = textStatus;
document.getElementById('alert3').style.display = 'block';
setInterval(close,5000);


    }

});

function close(){
    document.getElementById('alert3').style.display = 'none';
        }
        
});

    $("#addNewDept").on('submit', function (event) {
        event.preventDefault();
        document.getElementById('alert4').style.display = 'none';
        const dept = $('#newDept').val();
        const actionurl = $('#addNewDept').attr('action');

        console.log(dept)

        $.ajax({
            method : "POST",
            url: actionurl,
            data: {
dept:dept
            },
            beforeSend: function () {
                // $('#gif8').show();
                $('#addDept').LoadingOverlay('show');
            },
            complete: function () {
                // $('#gif8').hide();
                $('#addDept').LoadingOverlay('hide');

            },
            success: function (data, textStatus, jqXHR) {
if(data == 'successfully added a new department'){
    document.getElementById('alert4').innerHTML = data;
    console.log(textStatus, data);
    document.getElementById('alert4').style.display = 'block';
    setTimeout(close, 5000);
    
}else if(data == 'Failed to created a new department'){
    document.getElementById('alert4').innerHTML = data;

    console.log(textStatus, data);
    document.getElementById('alert4').style.display = 'block';
    setTimeout(close, 5000);


}else{
let parsedJson = JSON.parse(data);
let newdata = Object.values(parsedJson);

document.getElementById('alert4').innerHTML = newdata;
    console.log(textStatus, newdata);
                document.getElementById('alert4').style.display = 'block';
                setTimeout(close, 5000);
}
                //    window.load(true)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
                console.log(jqXHR)
                console.log(textStatus)
                                document.getElementById('alert4').innerHTML = data;

            }
        })

        function close() {
            document.getElementById("alert4").style.display = "none";
        }
    });




// change employee passport
    $('#employeePassport').on('submit', function(e) {
        e.preventDefault();
        // console.log('first step');
        var formData = new FormData(this);
        const url = $('#employeePassport').attr('action');
        $.ajax({
            method: "POST",
            data: formData,
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {

              console.log(data)
                document.getElementById('alert3').innerHTML = data;
                document.getElementById('alert3').style.display = 'block';
                
            //    }
            
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
                console.log(jqXHR)
                console.log(textStatus)
            },
            beforeSend: function() {
                
$("#myBtn").LoadingOverlay("show");


                document.getElementById('alert3').style.display = 'none';
                // button = document.getElementById("myBtn")
                // if(button.disabled)
                // {
                //     document.getElementById("myBtn").disabled = false;
                // }else{
                //     document.getElementById("myBtn").disabled = true;
                // } 
                
            },
            complete: function() {
                
$("#myBtn").LoadingOverlay("hide");
                button = document.getElementById("myBtn")
                if(button.disabled)
                {
                    document.getElementById("myBtn").disabled = false;
                }else{
                    document.getElementById("myBtn").disabled = true;
                } 
                // location.reload(true);
                // setTimeout(close, 7000);

            }

        });
    });




// update employee refree information
    $("#employeeRefreeInformation").on('submit', function (event) {
        event.preventDefault();
        document.getElementById('alertforRefreeInfo').style.display = 'none';


        const fullname = $('#employeeRefreeFullname').val();
        const address = $('#empoyeeRefreeAddress').val();
        const phone = $('#employeeRefreePhone').val();
        const relationship = $('#employeeRefreeRelationship').val();
        const actionurl = $('#employeeRefreeInformation').attr('action');

        console.log(fullname, address,
            phone, relationship)

        $.ajax({
            type: "POST",
            url: actionurl,
            data: {

                fullname: fullname,
                address: address,
                phone: phone,
                relationship: relationship
            },
            beforeSend: function() {
                                
$("#refreeinformation").LoadingOverlay("show");


            },
            complete: function() {
                     
$("#refreeinformation").LoadingOverlay("hide");


            },
            success: function(data, textStatus, jqXHR) {
            
                console.log(textStatus);
                console.log(data);
                // setTimeout(close, 5000);
                
                    
                document.getElementById('alertforRefreeInfo').style.display = 'block';
                
                document.getElementById('alertforRefreeInfo').innerHTML = data;
                

                // document.getElementById('alert').innerHTML = data;
                //data - response from server

                //    window.load(true)
            }, error: function(jqXHR, textStatus, errorThrown) {
                document.getElementById('alertforerror2').style.display = 'block';
                console.log(errorThrown)
                console.log(jqXHR)
                console.log(textStatus)
            }
        })
        function close() {
            document.getElementById("alertforRefreeInfo").style.display = "none";
        }
    });


// update employee emergency information
    $("#emergencyInfo").on('submit', function (event) {
        event.preventDefault();
        document.getElementById('alertforemmergency').style.display = 'none';


        const fullname = $('#emergencyFullnameEmployee').val();
        const address = $('#emergencyAddressEmployee').val();
        const phone = $('#emergencyTelelphoneEmployee').val();
        const relationship = $('#emergencyRelationshipEmployee').val();
        const actionurl = $('#emergencyInfo').attr('action');

        console.log(fullname, address,
            phone, relationship)

        $.ajax({
            type: "POST",
            url: actionurl,
            data: {

                fullname: fullname,
                address: address,
                phone: phone,
                relationship: relationship
            },
            beforeSend: function() {
                $('#emergencyinformation').LoadingOverlay('show');
            },
            complete: function() {
            
                $('#emergencyinformation').LoadingOverlay('hide');
            },
            success: function(data, textStatus, jqXHR) {
                       if(data == 'success'){
                        document.getElementById('alertforemmergency').innerHTML = data;
                        
                    document.getElementById('alertforemmergency').style.display = 'block';
                    
                       }else{
                  let parsedData = JSON.parse(data)
                newData = Object.values(parsedData);   
                
                document.getElementById('alertforemmergency').innerHTML = newData;
                
                document.getElementById('alertforemmergency').style.display = 'block';

                setInterval(close,6000);

                }    function close(){
                    
                document.getElementById('alertforemmergency').style.display = 'none';

                }          
                    console.log(textStatus,data);
                        
        //    window.load(true)
                   }  ,error: function(jqXHR, textStatus, errorThrown) {
                document.getElementById('alertforerror2').style.display = 'block';
                console.log(errorThrown)
                console.log(jqXHR)
                console.log(textStatus)
            }
        })
function close() {
    document.getElementById("alertforemmergency").style.display = "none";
}
    });



    // update employee company information
 $("#companyFormUpdate").on('submit', function (event) {
     event.preventDefault();
     document.getElementById('alertforcompany').style.display = 'none';
     var department = $("#department").val();
     var actionurl = $('#companyFormUpdate').attr('action');
     var position = $('#position').val();
     var dateOfEmployment = $('#dos').val();
     var currenStatus = $('#currenStatus').val();
     var employmentMode = $('#employmentMode').val();
     console.log(employmentMode, currenStatus,
         dateOfEmployment, position, actionurl, department)

     $.ajax({
         type: "POST",
         url: actionurl,
         data: {
             position: position,
             department: department,
             dateOfEmployment: dateOfEmployment,
             currenStatus: currenStatus,
             employmentMode: employmentMode,
         },
         beforeSend: function () {
           $('#companyinformation').LoadingOverlay('show')
         },
         complete: function () {
             
           $('#companyinformation').LoadingOverlay('hide')
         },
         success: function (data, textStatus, jqXHR) {
            if(data == 'success'){
                document.getElementById('alertforcompany').innerHTML = data;
                
            document.getElementById('alertforcompany').style.display = 'block';
            
               }else{
          let parsedData = JSON.parse(data)
        newData = Object.values(parsedData);   
        
        document.getElementById('alertforcompany').innerHTML = newData;
        
        document.getElementById('alertforcompany').style.display = 'block';

        setInterval(close,6000);

        }    function close(){
            
        document.getElementById('alertforcompany').style.display = 'none';

        }          
            console.log(textStatus,data);
         
             
         },
         error: function (jqXHR, textStatus, errorThrown) {
             document.getElementById('alertforerror').style.display = 'block';
            console.log(errorThrown)
             console.log(jqXHR)
             console.log(textStatus)
         }
     })

function close(){
    getElementById('alertforcompany').style.display = 'none'
}

function close2(){
    getElementById('alertforerror').style.display = 'none'
}
 });

    // add an employee
    $('#eform').on('submit', function (e) {
        e.preventDefault();
        // console.log('in progress');

        var givenname = $('#givenname').val();
        var familyname = $('#familyname').val();
        var email = $('#email').val();
        var department = $('#department').val();
        var gender = $('#gender').val();
        var dateOfBirth = $('#dateOfBirth').val();
        const url = $('#eform').attr('action');

        $.ajax({
            method: "POST",
            data: {
                dateOfBirth:dateOfBirth,
                email: email,
                givenname: givenname,
                familyname: familyname,
                department: department,
                gender: gender
            },
            url: url,
            success: function (data, textStatus, jqXHR) {
                
                if(data == 'success'){
                    
                    document.getElementById('alertfore').innerHTML = newdata
                    document.getElementById('alertfore').style.display = 'block';
                    console.log(newdata);
                    console.log(textStatus);
                    setInterval(close,6000)
                
                }else if(data == 'failed'){
               
                    document.getElementById('alertfore').innerHTML = data
                    document.getElementById('alertfore').style.display = 'block';
                    console.log(data);
                    console.log(jqXHR);
                    setInterval(close,6000)
    
                
                }else{
                    let parsedJSON =   JSON.parse(data)
                    let cleanData =  Object.values(parsedJSON); 
                                        document.getElementById('alertfore').innerHTML = cleanData;
                        document.getElementById('alertfore').style.display = 'block';
                        setInterval(close,6000)
        
                }

            
            },

            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
                console.log(jqXHR)
                console.log(textStatus)
                
                document.getElementById("alertforerror").innerHTML = textStatus;
                document.getElementById("alertforerror").style.display = "none";
                setInterval(close,6000)
            },

            beforeSend: function () {
                $('#eform').LoadingOverlay('show');
            },

            complete: function () {
                
                $('#eform').LoadingOverlay('hide');

            }

        });

        function close() {
            document.getElementById("alertfore").style.display = "none";
        }

    });


    $('#iform').on('submit', function (e) {
        e.preventDefault();
        console.log('first step');
        var formData = new FormData(this);
        const url = $('#iform').attr('action');
        $.ajax({
            method: "POST",
            data: formData,
            url: url,
            cache: false,
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
                setTimeout(close, 3000);

            }

        });

        function close() {
            document.getElementsByClassName('alert-success').style.display = 'none';
        }

    });

// update personal info
    $("#pform").on('submit', function (event) {
        event.preventDefault();
        document.getElementById('alert').style.display = 'none';
        var email = $("#email").val();
        var actionurl = $('#pform').attr('action');
        var firstname = $('#fname').val();
        var lastname = $('#lname').val();
        var address = $('#address').val();
        var state = $('#state').val();
        var dateOfBirth =  $('#dateOfBirth').val();
        var lga = $('#lga').val();
        var phonenumber = $('#phone').val();
        var maritalstatus = $('#maritalstatus').val();
        //   var dateofbirth = $('#cal');
        console.log(email, actionurl, firstname, lastname, address, state, lga, phonenumber, maritalstatus,dateOfBirth)

        $.ajax({
            type: "POST",
            url: actionurl,
            data: {
                email: email,
                state: state,
                lga: lga,
                dateOfBirth:dateOfBirth,
                address: address,
                familyname: lastname,
                givenname: firstname,
                maritalstatus: maritalstatus,
                phonenumber: phonenumber
            },
            beforeSend: function () {
               
$("#pinfo").LoadingOverlay("show");
                $('#gif').show();
            },
            complete: function () {
                $('#gif').hide();
                      
$("#pinfo").LoadingOverlay("hide");
         
            },
            success: function (data, textStatus, jqXHR) {
            
// var data = JSON.parse(data)
// var fineData =Object.values(data)
// document.getElementById('alert').innerHTML = fineData
// document.getElementById('alert').style.display = 'block'


                console.log(textStatus);
                document.getElementById('alert').style.display = 'block';
                document.getElementById('alert').innerHTML = data;
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
