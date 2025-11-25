<?php

namespace Concrete\Package\DarkModeEditor;

use Concrete\Core\Application\Application;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\CkeditorEditor;
use Concrete\Core\Editor\Plugin as EditorPlugin;
use Concrete\Core\Package\Package;
use Concrete\Core\Routing\RouterInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends Package
{
    protected $pkgHandle = 'dark_mode_editor';

    protected $pkgVersion = '1.1.0';

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::$appVersionRequired
     */
    protected $appVersionRequired = '8.5.7';

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::getPackageName()
     */
    public function getPackageName()
    {
        return t('CKEditor Dark Mode Toggle');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::getPackageDescription()
     */
    public function getPackageDescription()
    {
        return t('Adds a Dark Mode Toggler für Ckeditor.');
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::install()
     */
    public function install()
    {
        $package = parent::install();
        $this->setPluginEnabled(true);

        return $package;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Concrete\Core\Package\Package::uninstall()
     */
    public function uninstall()
    {
        parent::uninstall();
        $this->setPluginEnabled(false);
    }

    public function on_start()
    {
        $this->registerAssets();
        $this->registerPlugin();
    }

    private function registerAssets()
    {
        $router = $this->app->make(RouterInterface::class);
        $router->get('ccm/dark_mode_editor/ckeditor4/plugin', Plugin::class . '::view');
        $al = AssetList::getInstance();
        $al->register('javascript-localized', 'dark_mode_editor/ckeditor4/plugin', 'ccm/dark_mode_editor/ckeditor4/plugin');
        $al->registerGroup('dark_mode_editor/ckeditor4/plugin', [
            ['javascript-localized', 'dark_mode_editor/ckeditor4/plugin']
        ]);
    }

    private function registerPlugin()
    {
        $this->app->extend(
            CkeditorEditor::class,
            static function (CkeditorEditor $editor, Application $app)
            {
                $pluginManager = $editor->getPluginManager();
                $plugin = new EditorPlugin();
                $plugin->setKey('darkmode');
                $plugin->setName('Darkmode Toggle');
                $plugin->requireAsset('dark_mode_editor/ckeditor4/plugin');
                if (!$pluginManager->isAvailable($plugin)) {
                    $pluginManager->register($plugin);
                }

                return $editor;
            }
        );
    }

    /**
     * @param bool $enabled
     */
    private function setPluginEnabled($enable)
    {
        $editor = $this->app->make('editor');
        if (!$editor instanceof CkeditorEditor) {
            return;
        }
        $manager = $editor->getPluginManager();
        $selected = array_values($manager->getSelectedPlugins());
        if ($enable) {
            if (in_array('darkmode', $selected, true)) {
                return;
            }
            $selected[] = 'darkmode';
        } else {
            $index = array_search('darkmode', $selected, true);
            if ($index === false) {
                return;
            }
            do {
                array_splice($selected, $index, 1);
                $index = array_search('darkmode', $selected, true);
            } while ($index !== false);
        }
        $site = $this->app->make('site')->getSite();
        if (!$site) {
            return;
        }
        $siteConfig = $site->getConfigRepository();
        $siteConfig->save('editor.ckeditor4.plugins.selected', $selected);
    }
}
