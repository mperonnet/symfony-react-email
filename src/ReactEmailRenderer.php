<?php

declare(strict_types=1);

namespace Mperonnet\ReactEmail;

final class ReactEmailRenderer
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Render a React Email template to a ReactEmailContent object
     *
     * @param string $view The React component name (without extension)
     * @param array $data The data to pass to the React component
     * @return ReactEmailContent
     */
    public function render(string $view, array $data = []): ReactEmailContent
    {
        $content = $this->renderer->render($view, $data);
        
        return new ReactEmailContent(
            html: $content['html'],
            text: $content['text']
        );
    }
}