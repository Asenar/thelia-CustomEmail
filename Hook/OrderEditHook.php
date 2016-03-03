<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace CustomEmail\Hook;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Translation\Translator;
use Thelia\Model\ConfigQuery;


/**
 * Class FrontHook
 * @package HookCurrency\Hook
 * @author Julien Chanséaume <jchanseaume@openstudio.fr>
 */
class OrderEditHook extends BaseHook {

    public function onEditOrderJs(HookRenderEvent $event)
    {
        static $done;
        if ($done)
            return

        $done = true;

        $do_send = Translator::getInstance()->trans('send mail');
        $do_not_send = Translator::getInstance()->trans('Do not send mail');
        $send_custom = Translator::getInstance()->trans('Send custom message');

        $modal = <<<MODAL
<div id="customMessageModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Custom message</h4>
      </div>
      <div class="modal-body">
        <textarea class="form-control" name="customMessageText" id="customMessageText"></textarea>
      </div>
      <div class="modal-footer">
        <button id="customMessage-cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="customMessage-submit" type="button" class="btn btn-primary">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
MODAL;

        $modal = json_encode($modal);
        $jscode = <<<JSCODE
<script type="text/javascript">
$(document).on("ready", function(){

    // {{{ html things
    var customMessage = $($modal);
    $("body").append(customMessage);

    var container = $('<div class="well pull-right text-left bg-info"><h4 style="padding:0;margin:0">Change status and</h4>');
    var label0 = $('<label class="radio">');
    var radio0 = $('<input type="radio" name="send_mail" value="default">');
    label0.html(radio0);
    label0.append("$do_send");
    container.append(label0);

    var label1 = $('<label class="radio">');
    var radio1 = $('<input type="radio" name="send_mail" value="no">');
    label1.html(radio1);
    label1.append("$do_not_send");
    container.append(label1);

    var label2 = $('<label class="radio">');
    var radio2 = $('<input type="radio" name="send_mail" value="custom">');
    label2.html(radio2);
    label2.append("$send_custom");
    container.append(label2);

    var customMessageInput = $("<input>");
    customMessageInput.prop({
        "name": "customMessage",
        "id"  : "customMessage",
        "type": "hidden"
    })
    $(container).append(customMessageInput);
    $("#order-update-status-form").append(container);
    // }}}

    $("#order-update-status-form").on("submit", function(e) {
        var send_mail = $("input[name=send_mail]:checked").val();
        if (send_mail == "default") {
            return;
        }
        console && console.log("preventing default");
        e.preventDefault();
        if (send_mail == "no") {
            return;
        }
        if (send_mail == "custom") {
            console && console.log("modal show");
            $("#customMessageModal").modal("show");

            return false;
        }

        alert("Choose first the email behaviour");
    });

    $("#customMessage-cancel").on("click", function(e) {
        console && console.log("btn cancel clicked");
        $("#customMessageModal").modal("hide");
    });

    $("#customMessage-submit").on("click", function(e) {
        console && console.log("btn submit clicked");
        $("#customMessage").val($("#customMessageText").val());

        $("#order-update-status-form").off();
        console && console.log("unbind onsubmit");

        $("#order-update-status-form").submit();
        $("#customMessageModal").modal("hide");
    });


});
</script>
JSCODE;
        echo $jscode;
    }

} 
