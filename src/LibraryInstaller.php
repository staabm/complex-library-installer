<?php

namespace Complex\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller as BaseInstaller;

class LibraryInstaller extends BaseInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $prefix = substr($package->getPrettyName(), 0, 8);
        if ('complex/' !== $prefix) {
            throw new \InvalidArgumentException(
                'Unable to install package as a complex library. A complex library '
                .'should always start their package name with '
                .'"complex/"'
            );
        }

        return 'vendor/plugins/'.$package->getPrettyName();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'complex-library' === $packageType;
    }
}