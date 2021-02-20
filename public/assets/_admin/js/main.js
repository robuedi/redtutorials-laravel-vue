/**
 * Created by eduard on 25/02/18.
 */
$(function(){
    // format dates with moment.js
    $(".format-momentjs").each(function(){
        $(this).html( moment($(this).text()).format('llll') );
    });

    $(".listing-pager-rpp").click(function(){
        $(this).closest("form").submit();
    });

    $('#save-and-add').on('click', function(){
        $('#save-and-add-input').val('save');
        $('.form-edit').submit();
    });

    $('a.btn-delete').click(function(){

        var action  = $(this).attr('href');
        var message = $(this).data('warning');
        var confirm_button_text = $(this).data('confirm-button-text');

        if (confirm_button_text == '' || confirm_button_text == undefined)
            confirm_button_text = 'Yes';

        confirm_modal(action, message, confirm_button_text);

        return false;
    });

    // phone numbers mask
    $('.phone-number-mask').mask("(+?99) 999 999 999 999");

    // init tooltips
    $('.apply-tooltip').tooltip({container: 'body'});
});

function confirm_modal(action, message, yes_button_text)
{
    // set the message to display within the modal
    $('#confirm_modal .modal-body').html(message);

    // if the action is a function
    // execute the function when 'yes' button is clicked
    if(!!(action && action.constructor && action.call && action.apply))
    {
        $("#confirm_modal .modal-yes").unbind('click');

        $("#confirm_modal .modal-yes").one("click", action).one("click", function(){
            $('#confirm_modal').modal('hide');
        });
    }

    // if the action is a string (url),
    // set the url as href for 'yes' button
    else if(typeof action === 'string')
    {
        $("#confirm_modal .modal-yes").attr('href', action);
    }

    // if a custom text is defined for 'yes' button, set it instead of the default one
    if(typeof yes_button_text === 'string')
        $('#confirm_modal .modal-yes').html(yes_button_text);

    // launch the modal window
    $('#confirm_modal').modal('show');
}

function deleteRouteObject(delete_url) {
    $('#delete_form').attr('action', delete_url).submit();
}

function promptAction(action_url) {
    $('#delete_form').attr('action', action_url).submit();
}