// support html5 form validation
var checkValid = function(element) {
    if (typeof element === 'object' && element.originalEvent) {
        element = this;
    }

    // check if the html5 validation passed
    if (element.checkValidity()) {
        return true;
    }

    // get the current element, add error class
    var $element = $(element);
    if($element.attr('type') == 'radio') {
        $element = $element.
            closest('form, body').
            find('input[type=radio][name=' + $element.attr('name') + ']');
    }

    // we now need to find the last element (if this is a group)
    // if not a group, it will just grab the 1 element
    var $lastElement = $element.last();

    // if there is a label to our right, inject the error after that
    var $errorSibling = $lastElement.next('label[for=' + $lastElement.attr('id') + ']');
    if (!$errorSibling.length) $errorSibling = $lastElement;

    // look for an error element and create one if not found
    var $error = $errorSibling.next('aside.error');
    if(!$error.length) {
        $error = $('<aside/>').
            addClass('error').
            insertAfter($errorSibling);
    }

    // set the error message and display
    var message = $element.attr('error') || element.validationMessage;
    var error = $error.
        html(message).
        show();

    // if there is already an error class on this element (or group), we don't need to do the rest
    if ($element.hasClass('error')) {
        return;
    }

    // make the error disappear when valid
    var recheck = function(event) {
        console.log('change', event.target, this.checkValidity());

        // if it now passes the html5 validation, hide the error and remove the event
        if (this.checkValidity()) {
            $element.removeClass('error');
            $error.hide();
            $(this).off('keypress change', recheck);
        }
    };

    // bind the recheck callback
    $element.on('keypress change', recheck);

    // add an error class to all elements in this group (usually only one)
    // that have failed the validity
    $element.addClass('error');
    return false;
}

$.fn.liveValidation = function () {
    $(this).
    find('input, select, textarea, datalist').
    not('input[type=button], input[type=submit], input[type=reset]').
    on('blur', checkValid);
}