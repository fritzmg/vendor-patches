<?php

declare (strict_types=1);
namespace Symplify\VendorPatches\Composer;

use VendorPatches20220610\Symplify\SmartFileSystem\FileSystemGuard;
use VendorPatches20220610\Symplify\SmartFileSystem\Json\JsonFileSystem;
use VendorPatches20220610\Symplify\SmartFileSystem\SmartFileInfo;
use VendorPatches20220610\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use Symplify\VendorPatches\FileSystem\PathResolver;
/**
 * @see \Symplify\VendorPatches\Tests\Composer\PackageNameResolverTest
 */
final class PackageNameResolver
{
    /**
     * @var \Symplify\SmartFileSystem\Json\JsonFileSystem
     */
    private $jsonFileSystem;
    /**
     * @var \Symplify\VendorPatches\FileSystem\PathResolver
     */
    private $pathResolver;
    /**
     * @var \Symplify\SmartFileSystem\FileSystemGuard
     */
    private $fileSystemGuard;
    public function __construct(JsonFileSystem $jsonFileSystem, PathResolver $pathResolver, FileSystemGuard $fileSystemGuard)
    {
        $this->jsonFileSystem = $jsonFileSystem;
        $this->pathResolver = $pathResolver;
        $this->fileSystemGuard = $fileSystemGuard;
    }
    public function resolveFromFileInfo(SmartFileInfo $vendorFile) : string
    {
        $packageComposerJsonFilePath = $this->getPackageComposerJsonFilePath($vendorFile);
        $composerJson = $this->jsonFileSystem->loadFilePathToJson($packageComposerJsonFilePath);
        if (!isset($composerJson['name'])) {
            throw new ShouldNotHappenException();
        }
        return $composerJson['name'];
    }
    private function getPackageComposerJsonFilePath(SmartFileInfo $vendorFileInfo) : string
    {
        $vendorPackageDirectory = $this->pathResolver->resolveVendorDirectory($vendorFileInfo);
        $packageComposerJsonFilePath = $vendorPackageDirectory . '/composer.json';
        $this->fileSystemGuard->ensureFileExists($packageComposerJsonFilePath, __METHOD__);
        return $packageComposerJsonFilePath;
    }
}
