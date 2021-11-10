<?php 

namespace App\Extension;

use App\Extension\ElephpantWidget;
use Bolt\Extension\BaseExtension;

class ElephpantExtension extends BaseExtension
{
    public function getName(): string
    {
        return 'elephpant extension';
    }


    public function initialize($cli = false): void
    {
        $this->addWidget(new ElephpantWidget($this->getObjectManager()));

    }
}