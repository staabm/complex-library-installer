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
        
        $packageName = substr($package->getPrettyName(), 8);
        
        // we have some packages which casing is important in the filesystem for BC reasons.
        // since we had to adjust package-names for composer 2.0 to be lower case, we map back to the BC friendly name here
        $bcMap = array(
            'clxmobilenet' => 'clxMobileNet',
            'clxmobilenetportable' => 'clxMobileNetPortable',
            'ebayman' => 'eBayMan',
            'mobisapi' => 'MobisApi',
        );
        
        if (isset($bcMap[$packageName])) {
            $packageName = $bcMap[$packageName];
        }

        return 'vendor/plugins/'. $packageName;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'complex-library' === $packageType;
    }
}
