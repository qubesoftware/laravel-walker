# Walker

A easy-to-use package to create awesome multi step flows in your<br />
Laravel application.

## Installation

```bash
composer require qube/laravel-walker
```

## Usage

The intention of the package is to facilitate the creation of multi step forms.
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
        App\MyFlow\Step1::class,
        // ... as many as you want.
    ])

    // Last, render the current step.
    return $walker->render();
}
```

As you can see in the example, we specified that we will have
1 step, defined at `App\MyFlow\Step1`.

To create a step, you can use the following artisan command:

```bash
php artisan walker:step App\MyFlow\Step1
```

This will create a file called `Step1` in the folder `app/MyFlow`.
