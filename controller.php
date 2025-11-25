<?php

/**
 * @project:   Update Dark Mode Extension
 * @copyright  (C) 2016-2025 www.blink.ch
 * @author     blinkbox 2025-11-20
 * @version    1.0.2
 */

namespace Concrete\Package\DarkModeEditor;

defined('C5_EXECUTE') or die('Access denied.');

/*
  Ckeditor Dark Mode Plugin, developed for ConcreteCMS v.5.7 for blink.ch 2016-04-05 by Ravish Aggarwal.
  This Extension is part of the blink_base_theme and variable_font_package.
*/

use Concrete\Core\Editor\Plugin;
use Concrete\Core\Package\Package;
use Concrete\Core\Asset\AssetList as AssetList;
use Concrete\Core\Support\Facade\Application as Application;
use Concrete\Core\Editor\EditorServiceProvider;
// use Concrete\Package\DarkModeEditor\Src\Editor\DarkModePlugin; // only if needed!

class Controller extends Package
{
    protected $pkgHandle = 'dark_mode_editor';
    protected $appVersionRequired = '9.4';
    protected $pkgVersion = '1.0.2';

    public function getPackageName()
    {
        return t('CKEditor Dark Mode Toggle');
    }

    public function getPackageDescription()
    {
        return t('Adds a Dark Mode Toggler für Ckeditor.');
    }

    public function on_start()
    {
        $this->registerPlugin();
    }
    // Extend CKEditor asset to load the plugin - Some Setting need to be verified in order to see the icon locally. 
    // Icon is only visible, whe fetched from a remote http server.
    protected function registerPlugin()
    {
        $app = Application::getFacadeApplication();
        $editor = $app->make('editor');
        $pluginManager = $editor->getPluginManager();
        $al = AssetList::getInstance();
        $al->register('javascript', 'editor/ckeditor4/darkmode', 'js/ckeditor/plugins/darkmode/plugin.js', array(), 'dark_mode_editor');
        $al->registerGroup('editor/ckeditor4/darkmode', array( array('javascript', 'editor/ckeditor4/darkmode')));
        $plugin = new Plugin();
        $plugin->setKey('darkmode');
        $plugin->setName('Darkmode Toggle');
        $plugin->requireAsset('editor/ckeditor4/darkmode');
        if (!$pluginManager->isAvailable($plugin)) {
            $pluginManager->register($plugin);
        }
        if (!$pluginManager->isSelected($plugin)) {
            $key = $plugin->getKey();
        }
    }
}









