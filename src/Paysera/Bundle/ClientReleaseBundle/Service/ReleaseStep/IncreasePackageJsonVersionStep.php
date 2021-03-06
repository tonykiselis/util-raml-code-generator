<?php
declare(strict_types=1);

namespace Paysera\Bundle\ClientReleaseBundle\Service\ReleaseStep;

use Paysera\Bundle\ClientReleaseBundle\Entity\ReleaseStepData;
use Paysera\Bundle\ClientReleaseBundle\Service\PackageJsonHelper;
use Paysera\Bundle\ClientReleaseBundle\Service\SemanticVersionManipulator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IncreasePackageJsonVersionStep implements ReleaseStepInterface
{
    private $versionManipulator;
    private $packageJsonHelper;

    public function __construct(
        SemanticVersionManipulator $versionManipulator,
        PackageJsonHelper $packageJsonHelper
    ) {
        $this->versionManipulator = $versionManipulator;
        $this->packageJsonHelper = $packageJsonHelper;
    }

    public function processStep(ReleaseStepData $releaseStepData, InputInterface $input, OutputInterface $output)
    {
        $packageJson = $this->packageJsonHelper->getSourceContents($releaseStepData);
        if ($packageJson === null) {
            $packageJson = $this->packageJsonHelper->getGeneratedContents($releaseStepData);
        }

        $packageJson['version'] = $this->versionManipulator->increase(
            $this->versionManipulator->resolveCurrentVersion($releaseStepData),
            $releaseStepData->getReleaseData()->getVersion()
        );

        file_put_contents(
            $releaseStepData->getGeneratedDir() . '/package.json',
            json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        $output->writeln(sprintf(
            '<info>*</info> Increased <comment>package.json</comment> version to <comment>%s</comment>',
            $packageJson['version']
        ));
    }
}
