<?php

namespace MarcW\Bundle\WurstBundle\Tests\Command;

use MarcW\Bundle\WurstBundle\MarcWWurstBundle;
use Nyholm\BundleTest\BaseBundleTestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use MarcW\Bundle\WurstBundle\Command\WurstCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class WurstCommandTestCase extends BaseBundleTestCase
{
    use SetUpTearDownTrait;

    protected $defaultWurst = 'classic';
    protected $wurstResourcesDirectory;
    protected $sideResourcesDirectory;
    protected $command;
    protected $commandTester;
    protected $wurstTypes;
    protected $sides;

    private function doSetUp()
    {
        $resourceDirectory = $this->getResourceDirectory();
        $this->wurstResourcesDirectory = $resourceDirectory.'wurst/';
        $this->sideResourcesDirectory = $resourceDirectory.'sides/';

        $this->setCommand();
        $this->commandTester = new CommandTester($this->command);

        $this->wurstTypes = $this->findFilenamesFromGivenDirectory($this->wurstResourcesDirectory);
        $this->sides = $this->findFilenamesFromGivenDirectory($this->sideResourcesDirectory);
    }

    protected function getBundleClass()
    {
        return MarcWWurstBundle::class;
    }


    protected function getResourceDirectory()
    {
        $sourceDirectory = __DIR__.'/../../';
        $resourceDirectory = $sourceDirectory.'Resources/';

        return $resourceDirectory;
    }

    protected function setCommand()
    {
        $kernel = $this->createKernel();
        $this->bootKernel();

        $application = new Application($kernel);
        $application->add(new WurstCommand());

        $this->command = $application->find('wurst:print');
    }

    protected function findFilenamesFromGivenDirectory($givenDirectory)
    {
        $foundFiles = Finder::create()
            ->in($givenDirectory)
            ->name('*.txt')
            ->depth(0)
            ->filter(function (SplFileInfo $file) {
                return $file->isReadable();
            })
        ;

        $filenames = array();
        foreach ($foundFiles as $foundFile) {
            $filenames[] = basename($foundFile->getRelativePathName(), '.txt');
        }

        return $filenames;
    }
}
