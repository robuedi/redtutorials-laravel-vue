function update_enable_checkbox(checkbox) {
    var target = $(checkbox).closest('[data-input-enable-switcher]').find('[data-switch-enable-target]');
    if($(checkbox).is(':checked'))
    {
        target.removeAttr('disabled');
    }
    else{
        target.val(target.attr('data-value'));
        target.attr('disabled', 'disabled');
    }
}

$(function () {
    //enable/disable checkbox
    var checkbox_enable_disable = $('[data-switch-enable]');
    if(checkbox_enable_disable.length > 0){
        update_enable_checkbox(checkbox_enable_disable);
        checkbox_enable_disable.on('change', function () {
            update_enable_checkbox(this);
        });
    }
});