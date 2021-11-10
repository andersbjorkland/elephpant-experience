<?php 

namespace App\Extension;

use Bolt\Widget\BaseWidget;
use Bolt\Widget\Injector\RequestZone;
use Bolt\Widget\Injector\AdditionalTarget;
use Bolt\Widget\TwigAwareInterface;

class ElephpantWidget extends BaseWidget implements TwigAwareInterface
{

    protected $name = 'Elephpant Experience';
    protected $target  = ADDITIONALTARGET::WIDGET_BACK_DASHBOARD_ASIDE_TOP;
    protected $priority = 300;
    protected $zone    = REQUESTZONE::BACKEND;
    protected $template = '@elephpant-experience/elephpant-widget.html.twig';

}