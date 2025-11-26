<?php

namespace Concrete\Package\DarkModeEditor;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Http\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

defined('C5_EXECUTE') or die('Access Denied.');

class Plugin
{
    /**
     * @var \Concrete\Core\Config\Repository\Repository
     */
    private $config;

    /**
     * @var \Concrete\Core\Http\ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(Repository $config, ResponseFactoryInterface $responseFactory)
    {
        $this->config = $config;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view()
    {
        return $this->responseFactory->create(
            $this->generateJavascript(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/javascript',
            ]
        );
    }

    private function generateJavascript()
    {
        $styles = [];
        $color = $this->config->get('dark_mode_editor::options.backgroundColor');
        $styles['background-color'] = is_string($color) && ($color = trim($color)) !== '' ? $color : '#222222';
        $color = $this->config->get('dark_mode_editor::options.textColor');
        if (is_string($color) && ($color = trim($color)) !== '') {
            $styles['color'] = $color;
        }
        $jsStyles = json_encode($styles);
        $jsLabel = json_encode(t('Toggle Dark Mode'));

        return <<<EOT
(function() {

const STYLES = {$jsStyles};

function setDarkMode(editor, enable) {
    const editable = editor?.editable();
    if (!editable) {
        return;
    }
    if (enable) {
        if (!editor._darkModeOriginalData) {
            editor._darkModeOriginalData = {};
            Object.keys(STYLES).forEach(key => editor._darkModeOriginalData[key] = editable.getStyle(key));
        }
        for (const [key, value] of Object.entries(STYLES)) {
            editable.setStyle(key, value);
        }
    } else if (editor._darkModeOriginalData) {
        for (const [key, value] of Object.entries(editor._darkModeOriginalData)) {
            editable.setStyle(key, value);
        }
    }
}

CKEDITOR.plugins.add('darkmode', {
    init(editor) {
        editor.addCommand('toggleDarkMode', {
            exec(editor) {
                switch (this.state) {
                    case CKEDITOR.TRISTATE_OFF:
                        setDarkMode(editor, true);
                        this.setState(CKEDITOR.TRISTATE_ON);
                        break;
                    case CKEDITOR.TRISTATE_ON:
                        setDarkMode(editor, false);
                        this.setState(CKEDITOR.TRISTATE_OFF);
                        break;
                }
            },
        });
        editor.ui.addButton('darkmode', {
            label: {$jsLabel},
            command: 'toggleDarkMode',
            toolbar: 'tools',
            icon: CCM_REL + '/packages/dark_mode_editor/images/plugin.svg',
        });
        editor.on('beforeDestroy', (e) => setDarkMode(e?.editor, false));
    },
});

})();

EOT;
    }
}
