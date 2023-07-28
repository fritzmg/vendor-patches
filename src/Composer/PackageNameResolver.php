<?php

declare(strict_types=1);

namespace Symplify\VendorPatches\Composer;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symplify\VendorPatches\Exception\ShouldNotHappenException;
use Symplify\VendorPatches\FileSystem\PathResolver;
use Webmozart\Assert\Assert;

/**
 * @see \Symplify\VendorPatches\Tests\Composer\PackageNameResolverTest
 */
final class PackageNameResolver
{
    public function resolveFromFilePath(string $vendorFile): string
    {
        $packageComposerJsonFilePath = $this->getPackageComposerJsonFilePath($vendorFile);

        $composerJson = Json::decode(FileSystem::read($packageComposerJsonFilePath), Json::FORCE_ARRAY);
        if (! isset($composerJson['name'])) {
            throw new ShouldNotHappenException();
        }

        return $composerJson['name'];
    }

    private function getPackageComposerJsonFilePath(string $vendorFilePath): string
    {
        $vendorPackageDirectory = PathResolver::resolveVendorDirectory($vendorFilePath);

        $packageComposerJsonFilePath = $vendorPackageDirectory . '/composer.json';
        Assert::fileExists($packageComposerJsonFilePath);

        return $packageComposerJsonFilePath;
    }
}
