<?php

namespace Mperonnet\ReactEmail;

use Mperonnet\ReactEmail\Exceptions\NodeNotFoundException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Renderer
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * Calls the react-email render
     *
     * @param string $view name of the file the component is in
     * @param array $data data that will be passed as props to the component
     * @return array
     * @throws NodeNotFoundException
     */
    public function render(string $view, array $data = []): array
    {
        $process = new Process([
            $this->resolveNodeExecutable(),
            $this->params->get('react_email.tsx_path'),
            dirname(__DIR__) . '/render.tsx',
            $this->params->get('react_email.template_directory') . '/' . $view,
            json_encode($data)
        ], dirname(__DIR__, 2)); // Move up to the project root

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return json_decode($process->getOutput(), true);
    }

    /**
     * Resolve the node path from the configuration or executable finder.
     *
     * @return string
     * @throws NodeNotFoundException
     */
    public function resolveNodeExecutable(): string
    {
        if ($executable = $this->params->get('react_email.node_path') ?? (new ExecutableFinder())->find('node'))
        {
            return $executable;
        }

        throw new NodeNotFoundException(
            'Unable to resolve node path automatically, please provide a configuration value in react_email.yaml'
        );
    }
}