/* global toastr */
$(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "rtl": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": 3000,
        "hideDuration": 1000,
        "timeOut": 10000,
        "extendedTimeOut": 10000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $('#subscribeForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "subscribe.php",
            method: "POST",
            data: $('#subscribeForm').serialize(),
            success: function (response) {
                toastr.info(response);
                $('#subscribeForm')[0].reset();
            },
            error: function (error) {
                toastr.error(error);
            }                 
        });
    });
    $('#feedbackFormId').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "addFeedback.php",
            data: $('#feedbackFormId').serialize(),
            method: "POST",
            success: function(response){
                toastr.info(response);
				$('#feedbackFormId')[0].reset();
            },
            error: function(errorStr){
                toastr.error(errorStr);
				$('feedbackFormId')[0].reset();
            }
        });
    });
     $('#searchKeyword').on('keyup', function () {
                var searchKeyword = $(this).val().toLowerCase();
                $('#mainMenu *').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchKeyword) > -1);
                });

            });




});