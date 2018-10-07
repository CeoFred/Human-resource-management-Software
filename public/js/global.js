$(document).ready(function () {
    $("#submit").click(function () {
    console.info('form about to be submitted,ajax call next')
        var firstname = $("#fname").val();
        var lastname = $('#lname').val();
        var email = $("#email").val();
        var address = $("#address").val();
        var cal = $("#cal").val();
        var state = $('#state').val();
        var lga = $('#lga').val();
        // Returns successful data submission message when the entered information is stored in database.
console.log(email);
        var dataString = 'lastname=' + lastname +
        '&firstname=' + firstname + '&email='
         + email + '&address=' + address
         + '&cal=' + cal + '&state=' + state + '&lga=' + lga;
console.log(dataString);
            // AJAX Code To Submit Form.
            $.ajax({
                type: "POST",
                url: "ajaxsubmit.php",
                data: dataString,
                cache: false,
                success: function (result) {
                    alert(result);
                }
            });

    });
});

