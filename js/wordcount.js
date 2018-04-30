$(document).ready(function() {
    var text_max = 2000;
    $('#countleft').html('You have ' + text_max + ' characters remaining.');

    $('#description').keyup(function() {
        var text_length = $('#description').val().length;
        var text_remaining = text_max - text_length;

        $('#countleft').html('You have ' + text_remaining + ' characters remaining.');
    });
});
