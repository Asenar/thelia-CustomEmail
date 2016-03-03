# Custom Email

This module allow administrator to add a custom message to an automatic email is sent after a status change.

## Installation


### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is CustomEmail.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require your-vendor/custom-email-module:~1.0
```

## Configuration

Edit each email template which can have a custom message, to add
`{$custom_message}` where you want the message to be displayed.

If the code is missing, the email will be sent with the defaulith the default message unchanged.


## Hook

`order.edit-js` : This hooks is used to add a modal in order-edit admin page.


## Services

This module subscribe to event TheliaEvents::ORDER_UPDATE_STATUS with a high
priority in order to be called BEFORE any others

## Roadmap / todolist

* translate
* configuration
** display or not the radio "send custom message"
** force custom message everytime
* save each custom message in the database
* Add a bcc field (or a checkbox) to send a bcc to the admin
* Add a default empty email template containing only {$custom_message}
* tests
* replace the js code by some smarty templating


