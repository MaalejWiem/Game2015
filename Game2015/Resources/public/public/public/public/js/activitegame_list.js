(function () {
    'use strict';

    var activitegameId;
    var activitegameElement;

    $('.activitegame-delete-button').click(function () {
        $('#delete-activitegame-validation-box').modal('show');
        activitegameId = $(this).attr('btn-activitegame-id');
        activitegameElement = $(this).parent().parent();
    });

    $('#delete-confirm-ok').click(function () {
        $.ajax({
            url: Routing.generate('claro_activite_delete', {'activitegameId': activitegameId}),
            type: 'DELETE',
            success: function () {
                $('#delete-activitegame-validation-box').modal('hide');
                activitegame.remove();
            }
        });
    });
})();