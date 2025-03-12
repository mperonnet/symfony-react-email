<?php

namespace Mperonnet\ReactEmail;

use Symfony\Component\Mime\Email;

class ReactEmailFactory
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Create an email with React Email content
     *
     * @param string $view The React component name (without extension)
     * @param array $data The data to pass to the React component
     * @return Email
     */
    public function create(string $view, array $data = []): Email
    {
        $content = $this->renderer->render($view, $data);
        
        return (new Email())
            ->html($content['html'])
            ->text($content['text']);
    }
}