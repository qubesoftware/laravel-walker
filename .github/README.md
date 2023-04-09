# Walker

A easy-to-use package to create awesome multi step flows in your<br />
Laravel application.

## Installation

```bash
composer require qube/laravel-walker
```

## Usage

In general, you'll start defining a route that will render the current step:

```php
/**
 * Render the current walker step.
 */
public function show()
{
    $walker = Walker::walk(
        // Define the name of the flow. This name
        // will be used as a key to store / retreive
        // the data from the storage.
        name: 'my-awesome-multistep-flow'
    );

    // Define the list of steps that the flow
    // will have.
    $walker->through([
        App\Steps\Step1::class,
        App\Steps\Step2::class,
        // ... as many as you want.
    ])

    // Last, render the current step.
    return $walker->render();
}
```

To create a step, you can use the following artisan command:

```bash
php artisan walker:step Step1
```
