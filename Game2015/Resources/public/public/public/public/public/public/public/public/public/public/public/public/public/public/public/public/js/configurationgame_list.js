(function () {
    'use strict';

    var configurationgameId;
    var configurationgameElement;

    $('.configurationgame-delete-button').click(function () {
        $('#delete-configurationgame-validation-box').modal('show');
        configurationgameId = $(this).attr('btn-configurationgame-id');
        configurationgameElement = $(this).parent().parent();
    });

    $('#delete-confirm-ok').click(function () {
        $.ajax({
            url: Routing.generate('claro_configurationgame_delete', {'configurationgameId': configurationgameId}),
            type: 'DELETE',
            success: function () {
                $('#delete-configurationgame-validation-box').modal('hide');
                configurationgame.remove();
            }
        });
    });
})();