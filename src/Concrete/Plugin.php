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
CKEDITOR.plugins.add('darkmode', {
    init(editor) {
        editor.addCommand('toggleDark', {
            exec(editor) {
                const editable = editor.editable();
                switch (this.state) {
                    case CKEDITOR.TRISTATE_OFF:
                        editable.setStyle('background-color', '#222222');
                        editable.setStyle('color', '#eeeeee');
                        this.setState(CKEDITOR.TRISTATE_ON);
                        break;
                    case CKEDITOR.TRISTATE_ON:
                        editable.setStyle('background-color', '');
                        editable.setStyle('color', '');
                        this.setState(CKEDITOR.TRISTATE_OFF);
                        break;
                }
            },
        });
        editor.ui.addButton('darkmode', {
            label: {$label},
            command: 'toggleDark',
            toolbar: 'tools',
            icon: CCM_REL + '/packages/dark_mode_editor/images/plugin.svg',
        });
    },
});

EOT
        ;
    }
}
