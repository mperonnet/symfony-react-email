# React Email for Symfony

Easily send [React Email](https://react.email/) emails with Symfony using this bundle.

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

3. Use the `ReactEmailFactory` service to create and send emails:

```php
use Mperonnet\ReactEmail\ReactEmailFactory;
use Symfony\Component\Mailer\MailerInterface;

class UserController
{
    private ReactEmailFactory $emailFactory;
    private MailerInterface $mailer;
    
    public function __construct(
        ReactEmailFactory $emailFactory,
        MailerInterface $mailer
    ) {
        $this->emailFactory = $emailFactory;
        $this->mailer = $mailer;
    }
    
    public function createUser()
    {
        // Create a user...
        $user = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];
        
        // Create email with React component
        $email = $this->emailFactory->create('new-user', [
            'user' => $user
        ]);
        
        // Set additional email properties
        $email->subject('Welcome to our platform!')
            ->from('noreply@example.com')
            ->to($user['email']);
            
        // Send the email
        $this->mailer->send($email);
        
        // ...
    }
}
```

## Running Tests

Run tests using PHPUnit:

```bash
./vendor/bin/phpunit
```

## Security

If you discover any security-related issues, please email the author instead of using the issue tracker.

## License

This bundle is open-source and licensed under the MIT License. See the [LICENSE](/LICENSE) file for details.