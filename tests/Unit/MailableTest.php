<?php

use Mperonnet\ReactEmail\Exceptions\NodeNotFoundException;
use Mperonnet\ReactEmail\ReactEmailFactory;
use Mperonnet\ReactEmail\Renderer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Process\ExecutableFinder;

it('renders the html and text from react-email', function () {
    $renderer = new Renderer($this->params);
    $factory = new ReactEmailFactory($renderer);
    
    $email = $factory->create('new-user', ['user' => ['name' => 'test']]);
    
    expect($email)
        ->toBeInstanceOf(Email::class)
        ->and($email->getHtmlBody())
        ->toContain('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html dir="ltr" lang="en"><head></head><!--$--><p style="font-size:14px;line-height:24px;margin:16px 0">Hello from react email, <!-- -->test</p><!--/$--></html>')
        ->and($email->getTextBody())
        ->toContain('Hello from react email, test');
});

it('throws an exception if node executable is not resolved', function () {
    $this->params->set('react_email.node_path', null);
    
    $this->expectException(NodeNotFoundException::class);
    
    // Mock ExecutableFinder class
    $mockFinder = \Mockery::mock('overload:Symfony\Component\Process\ExecutableFinder');
    $mockFinder->shouldReceive('find')->andReturn(null);
    
    $renderer = new Renderer($this->params);
    $reflectionMethod = new ReflectionMethod($renderer, 'resolveNodeExecutable');
    $reflectionMethod->invoke($renderer);
});

it('prioritises configuration value over executable finder', function () {
    $this->params->set('react_email.node_path', '/path/to/node');
    
    $renderer = new Renderer($this->params);
    $reflectionMethod = new ReflectionMethod($renderer, 'resolveNodeExecutable');
    
    expect($reflectionMethod->invoke($renderer))->toEqual('/path/to/node');
});