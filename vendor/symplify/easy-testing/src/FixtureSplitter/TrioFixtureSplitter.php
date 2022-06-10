<?php

declare (strict_types=1);
namespace VendorPatches20220610\Symplify\EasyTesting\FixtureSplitter;

use VendorPatches20220610\Nette\Utils\Strings;
use VendorPatches20220610\Symplify\EasyTesting\ValueObject\FixtureSplit\TrioContent;
use VendorPatches20220610\Symplify\EasyTesting\ValueObject\SplitLine;
use VendorPatches20220610\Symplify\SmartFileSystem\SmartFileInfo;
use VendorPatches20220610\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @api
 */
final class TrioFixtureSplitter
{
    public function splitFileInfo(SmartFileInfo $smartFileInfo) : TrioContent
    {
        $parts = Strings::split($smartFileInfo->getContents(), SplitLine::SPLIT_LINE_REGEX);
        $this->ensureHasThreeParts($parts, $smartFileInfo);
        return new TrioContent($parts[0], $parts[1], $parts[2]);
    }
    /**
     * @param mixed[] $parts
     */
    private function ensureHasThreeParts(array $parts, SmartFileInfo $smartFileInfo) : void
    {
        if (\count($parts) === 3) {
            return;
        }
        $message = \sprintf('The fixture "%s" should have 3 parts. %d found', $smartFileInfo->getRelativeFilePathFromCwd(), \count($parts));
        throw new ShouldNotHappenException($message);
    }
}
