<?php

namespace Complex\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class LibraryInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new LibraryInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}