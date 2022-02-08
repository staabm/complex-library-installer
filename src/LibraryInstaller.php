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
        
        if ($packageName == 'moxiemanager') {
            $parentProject = basename(dirname(__DIR__,4 ));
            if (strpos($parentProject, 'rocket') !== false) {
                return realpath($this->vendorDir .'/../builtin/public/js/tiny_mce4/plugins/moxiemanager');
            }
            return realpath($this->vendorDir .'/plugins/rocket/builtin/public/js/tiny_mce4/plugins/moxiemanager');
        }
        
        // we have some packages which casing is important in the filesystem for BC reasons.
        // since we had to adjust package-names for composer 2.0 to be lower case, we map back to the BC friendly name here
        $bcMap = array(
            'clxmobilenet' => 'clxMobileNet',
            'clxmobilenetportable' => 'clxMobileNetPortable',
            'clxbackendcms' => 'clxBackendCms',
            'clxfrontendcms' => 'clxFrontendCms',
            'ebayman' => 'eBayMan',
            'mobisapi' => 'MobisApi',
        );
        
        if (isset($bcMap[$packageName])) {
            $packageName = $bcMap[$packageName];
        }

        return realpath($this->vendorDir .'/plugins/'. $packageName);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'complex-library' === $packageType;
    }
}
