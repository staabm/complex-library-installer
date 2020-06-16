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
    
    public function deactivate(Composer $composer, IOInterface $io) {
        // for plugin 2.0 compat
    }
    
    public function uninstall(Composer $composer, IOInterface $io) {
        // for plugin 2.0 compat
    }
}
