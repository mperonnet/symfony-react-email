# React Email for Symfony

Easily render [React Email](https://react.email/) templates with Symfony using this bundle.

> This package is a Symfony adaptation of [laravel-react-email](https://github.com/maantje/laravel-react-email) by Jamie Schouten.

## Installation

First, install the bundle via Composer:

```bash
composer require mperonnet/symfony-react-email
```

Then, install the required Node dependencies:

```bash
npm install vendor/mperonnet/symfony-react-email
```

Register the bundle in your `config/bundles.php`:

```php
return [
    // ...
    Mperonnet\ReactEmail\ReactEmailBundle::class => ['all' => true],
];
```

## Configuration

Create a configuration file at `config/packages/react_email.yaml`:

```yaml
react_email:
    template_directory: '%kernel.project_dir%/emails'
    # Optional: custom path to node executable
    # node_path: '/usr/local/bin/node'
    # Optional: custom path to tsx executable
    # tsx_path: '%kernel.project_dir%/node_modules/tsx/dist/cli.mjs'
```

## Getting Started

1. Install React Email using the [automatic](https://react.email/docs/getting-started/automatic-setup) or [manual](https://react.email/docs/getting-started/manual-setup) setup.
2. Create an email component in the configured `template_directory` (e.g., `emails/new-user.tsx`). Ensure the component is the default export.

Example email component:

```tsx
import * as React from 'react';
import { Text, Html } from '@react-email/components';

export default function Email({ user }) {
    return (
        <Html>
            <Text>Hello, {user.name}</Text>
        </Html>
    );
}
```

3. Use the `ReactEmailRenderer` service to render your email templates:

```php
use Mperonnet\ReactEmail\ReactEmailRenderer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserController
{
    private ReactEmailRenderer $emailRenderer;
    private MailerInterface $mailer;
    
    public function __construct(
        ReactEmailRenderer $emailRenderer,
        MailerInterface $mailer
    ) {
        $this->emailRenderer = $emailRenderer;
        $this->mailer = $mailer;
    }
    
    public function createUser()
    {
        // Create a user...
        $user = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];
        
        // Render the email template
        $content = $this->emailRenderer->render('new-user', [
            'user' => $user
        ]);
        
        // Create a Symfony Email object
        $email = (new Email())
            ->html($content->html)
            ->text($content->text)
            ->subject('Welcome to our platform!')
            ->from('noreply@example.com')
            ->to($user['email']);
            
        // Send the email
        $this->mailer->send($email);
        
        // ...
    }
}
```

## ReactEmailContent Structure

The `ReactEmailRenderer::render()` method returns a `ReactEmailContent` object with the following properties:

```php
class ReactEmailContent
{
    public readonly string $html; // The rendered HTML version of the email
    public readonly string $text; // The rendered plain text version of the email
}
```

## Advanced Usage

### Direct Integration with Symfony Mailer

The example below shows how to use the renderer with Symfony Mailer:

```php
// Render the email template
$content = $this->emailRenderer->render('welcome-email', [
    'user' => $user,
    'resetLink' => $resetLink
]);

// Create and configure a Symfony Email object
$email = (new Email())
    ->html($content->html)
    ->text($content->text)
    ->subject('Welcome to our Application')
    ->from('noreply@example.com')
    ->to($user->getEmail());

// Send the email
$this->mailer->send($email);
```

### Use with Symfony Messenger

You can also use this with Symfony Messenger for asynchronous email sending:

```php
// In your controller/service
$this->messageBus->dispatch(new SendEmailMessage(
    'welcome-email',
    ['user' => ['name' => $user->getName(), 'email' => $user->getEmail()]],
    'Welcome to our Platform!'
));

// In your message handler
class SendEmailMessageHandler
{
    public function __invoke(SendEmailMessage $message)
    {
        $content = $this->emailRenderer->render($message->template, $message->data);
        
        $email = (new Email())
            ->html($content->html)
            ->text($content->text)
            ->subject($message->subject)
            ->from('noreply@example.com')
            ->to($message->data['user']['email']);
            
        $this->mailer->send($email);
    }
}
```

## Running Tests

Run tests using PEST:

```bash
./vendor/bin/pest
```

## Security

If you discover any security-related issues, please email the author instead of using the issue tracker.

## License

This bundle is open-source and licensed under the MIT License. See the [LICENSE](/LICENSE) file for details.