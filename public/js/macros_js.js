/**
 * MACROS JS
 */

/**
 * MACRO ALERT TOASTS SUCCESS
 *
 * @param {*} _message
 */
function mc_alert_toast_success(_message) {
    $(document).Toasts('create', {
        title: 'SUCESSO...',
        body: _message,
        class: 'bg-success toasts-width margin-bottom-5 margin-right-5',
        autohide: true,
        delay: 2000,
        fade: true,
        icon: 'fa fa-thumbs-up ',
        position: 'bottomRight'
    });
}

/**
 * MACRO ALERT TOASTS WARNING
 *
 * @param {*} _message
 */
function mc_alert_toast_warning(_message) {
    $(document).Toasts('create', {
        title: 'ATENÇÃO...',
        body: _message,
        class: 'bg-warning toasts-width margin-bottom-5 margin-right-5',
        autohide: true,
        delay: 3000,
        fade: true,
        icon: 'fas fa-exclamation-triangle ',
        position: 'bottomRight'
    });
}
