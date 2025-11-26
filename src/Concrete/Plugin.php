<?php

namespace Concrete\Package\DarkModeEditor;

use Concrete\Core\Http\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

defined('C5_EXECUTE') or die('Access Denied.');

class Plugin
{
    /**
     * @var \Concrete\Core\Http\ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
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
        $label = json_encode(t('Toggle Dark Mode'));

        return <<<EOT
(function() {

function setDarkMode(editor, enable) {
    const editable = editor?.editable();
    if (!editable) {
        return;
    }
    if (enable) {
        if (!editor._darkModeOriginalData) {
            editor._darkModeOriginalData = {
                backgroundColor: editable.getStyle('background-color'),
                color: editable.getStyle('color')
            };
        }
        editable.setStyle('background-color', '#222222');
        editable.setStyle('color', '#eeeeee');
    } else if (editor._darkModeOriginalData) {
        editable.setStyle('background-color', editor._darkModeOriginalData.backgroundColor);
        editable.setStyle('color', editor._darkModeOriginalData.color);
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
            label: {$label},
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
