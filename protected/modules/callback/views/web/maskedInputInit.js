$(document).ready(function () {
    /* Phone masked */
    $(document).on('focus', 'input[name="Callback[phone]"]', function () {
        $(this).inputmask(yupeCallbacPhonekMask, {clearMaskOnLostFocus: false});
    });
});