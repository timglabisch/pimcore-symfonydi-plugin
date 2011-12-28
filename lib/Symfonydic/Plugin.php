<?php

Zend_Controller_Action_HelperBroker::addHelper(new Symfonydic_Controller_Action_Helper_Symfonydic());
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

class Symfonydic_Plugin extends Pimcore_API_Plugin_Abstract implements Pimcore_API_Plugin_Interface {

    public static function install() {

        if (self::isInstalled()) {
            $statusMessage = "Symfonydic Plugin successfully installed.";
        } else {
            $statusMessage = "Symfonydic Plugin could not be installed";
        }
        return $statusMessage;
    }

    public static function uninstall() {

        if (!self::isInstalled()) {
            $statusMessage = "Symfonydic Plugin successfully uninstalled.";
        } else {
            $statusMessage = "AnySymfonydicDic Plugin could not be uninstalled";
        }
        return $statusMessage;
    }

    public static function isInstalled() {
       return true;
    }

    public static function getTranslationFile($language) {
            return "/Symfonydic/texts/en.csv";
    }

}