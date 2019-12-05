<?php

namespace Nora\Skelton;

use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Script\Event;

class Composer
{
    public static function preInstall(Event $event) : void
    {
        (new Install)($event);
    }
}
