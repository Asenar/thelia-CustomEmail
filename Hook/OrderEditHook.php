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
use Thelia\Model\ConfigQuery;


/**
 * Class FrontHook
 * @package HookCurrency\Hook
 * @author Julien Chanséaume <jchanseaume@openstudio.fr>
 */
class OrderEditHook extends BaseHook {

    public function onEditOrderJs(HookRenderEvent $event)
    {
        $jscode = <<<JSCODE
alert("on y arrive");
JSCODE;
        echo $jscode;
    }

} 
