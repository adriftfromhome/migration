$(function(){

    // check form data
    // routing needs to be done with jquery after each ajax call, response parameters have to be checked for a given string/response value
    // the then action has to follow a strict routing pattern

    $('#test').on('click', function(e) {
        e.preventDefault();
        let form = $('form').get(0);
        let data = new FormData(form);
        if (!$('#inputName').val().length < 4 && !$('#inputLogo').val() == '') {
            $.ajax({
                url: url,
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (result) {
                $('#message').html('Organisation' + ' "' +result['name'] + '" created');
                $('form')[0].reset();
                // maybe reroute
                }
            });
        }
        else {
            // flash animation of the error message
        }
    });

    $('#inputName').keyup(function(e){
        if ($('#inputName').val().length < 4) {
            $('#errors').html('<p id="nameError">Name has to be longer than 4 characters</p>');
        } else {
            $('#nameError').remove()
        }
    });
});