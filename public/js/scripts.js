/**
 * File Name: scripts.js
 */
$(function () {

    // GET CSRF s
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // TOOLTIP
    $('[data-toggle="tooltip"]').tooltip();
    // END TOOLTIP


    // AJAX DELETE DATA
    $('.btn_delete_data').click(function (e) {
        e.preventDefault();

        var _data_action = $(this).attr('data-action');
        var _redirect = $(this).attr('data-redirect');
        var _this = $(this);

        _this.parent().parent().parent().css('background-color', 'red');
        _this.parent().parent().parent().css('color', 'white');

        Swal.fire({
            title: 'Deseja deletar este registro ?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Deletar',
            cancelButtonText: 'Cancelar'

        }).then((result) => {

            if (result.value) {

                $.ajax({
                    url: _data_action ,
                    method: 'delete',
                    success: function (response) {

                        if (response.success) {
                            window.location.replace(_redirect);
                        } else if (response.warning) {
                            window.location.replace(_redirect);
                        }

                    }
                });
            } else {
                _this.parent().parent().parent().css('background-color', '');
                _this.parent().parent().parent().css('color', '');
            }

        })
    });
    // END AJAX DELETE DATA


});
