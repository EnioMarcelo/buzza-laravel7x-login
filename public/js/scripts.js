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
                    url: _data_action,
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


/**
 * SWEET ALERT CONFIRM DELETE REGISTER FOR LIVEWIRE
 */
window.addEventListener('swa_confirm_delete', event => {

    var _message = 'Deseja deletar este registro ?';
    var _text = '';
    var _trid = '';

    /*_this.parent().parent().parent().css('background-color', 'red');
    _this.parent().parent().parent().css('color', 'white');*/

    if (event.detail.trid) {
        _trid = event.detail.trid;
        document.getElementById(_trid).className = 'bg-red';
    }

    if (event.detail.message) {
        _message = event.detail.message;
    }

    if (event.detail.text) {
        _text = event.detail.text;
    }


    Swal.fire({
        title: _message,
        text: _text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Deletar',
        cancelButtonText: 'Cancelar'

    }).then((result) => {

        if (result.value) {
            Livewire.emit('delete_confirmed')
        } else {
            if (event.detail.trid) {
                _trid = event.detail.trid;
                document.getElementById(_trid).className = 'bg-write';
            }
        }

    })
})


/**
 * TOASTR MESSAGE FOR LIVEWARE
 */

window.addEventListener('alert', ({detail: {type, message}}) => {
    if (type == 'error') {
        $(document).Toasts('create', {
            title: 'ATENÇÃO...',
            body: message,
            class: 'bg-danger toasts-width margin-bottom-5 margin-right-5',
            autohide: true,
            delay: 5000,
            fade: true,
            icon: 'fa fa-exclamation-triangle',
            position: 'bottomRight'
        });
    } else if (type == 'info') {
        $(document).Toasts('create', {
            title: 'INFORMAÇÃO...',
            body: message,
            class: 'bg-info toasts-width margin-bottom-5 margin-right-5',
            autohide: true,
            delay: 5000,
            fade: true,
            icon: 'fa fa-thumbs-up ',
            position: 'bottomRight'
        });
    } else if (type == 'success') {
        $(document).Toasts('create', {
            title: 'SUCESSO...',
            body: message,
            class: 'bg-success toasts-width margin-bottom-5 margin-right-5',
            autohide: true,
            delay: 5000,
            fade: true,
            icon: 'fa fa-thumbs-up ',
            position: 'bottomRight'
        });
    } else if (type == 'warning') {
        $(document).Toasts('create', {
            title: 'ATENÇÃO...',
            body: message,
            class: 'bg-warning toasts-width margin-bottom-5 margin-right-5',
            autohide: true,
            delay: 5000,
            fade: true,
            icon: 'fas fa-exclamation-triangle ',
            position: 'bottomRight'
        });
    }
})



