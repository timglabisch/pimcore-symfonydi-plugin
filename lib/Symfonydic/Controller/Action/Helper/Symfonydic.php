<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\MergeExtensionConfigurationPass;
use Symfony\Component\HttpKernel\DependencyInjection\AddClassesToCachePass;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as DIExtension;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\ClassLoader\ClassCollectionLoader;
use Symfony\Component\ClassLoader\DebugUniversalClassLoader;

class Symfonydic_Controller_Action_Helper_Symfonydic extends Zend_Controller_Action_Helper_Abstract {

    protected function getDependencyFolders() {
     $dirs = array();

        $directoryIterator = new DirectoryIterator(PIMCORE_PLUGINS_PATH);

        $dirs[] = PIMCORE_WEBSITE_PATH;

        foreach($directoryIterator as $directory) {
            if(!$directory->isDir() || $directory->isDot())
                continue;

            $dirs[] = $directory->getPathname();
        }

        return $dirs;
    }

    protected function getContainerLoader(ContainerInterface $container)
    {
        $locator = new FileLocator($this);
         return new YamlFileLoader($container, $locator);
    }

    public function init() {
        $container = new ContainerBuilder(new ParameterBag(array()));

        foreach($this->getDependencyFolders() as $folder) {
            $diFile = $folder.'/dependencies.yml';

            if(!file_exists($diFile))
                continue;

            $this->getContainerLoader($container)->load(__DIR__.'/../../../../../dependencies.yml');
        }

        // this is ugly but works for now, later using an interface.
        $this->getActionController()->di = $container;
    }
}