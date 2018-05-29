$(".showLogInForm").click(function() {
    $("#logInForm").toggle();
    $("#signUpForm").toggle();

})


$("#myDiary").keyup(function() {


    $.ajax({
            method: "POST",
            url: "updateData.php",
            data: { content: $("#myDiary").val() }
        })
        .done(function(msg) {
            console.log("Data Saved: " + msg);
        });


});