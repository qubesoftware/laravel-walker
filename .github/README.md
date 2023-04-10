# Walker

Walker is a package that allows you to create multi-step wizards in your Laravel applications.

# Installation

You can install this package via composer by running the following command:

```bash
composer require qube/laravel-walker
```

You can publish the package assets by running:

```bash
php artisan vendor:publish --provider="Qube\Walker\WalkerServiceProvider"
```

# Usage

## Creating steps

To create steps for your wizards, you can use the following command:

```bash
# Replace "<name>" with the full qualified name of your step.
php artisan walker:step <name>
```

This creates a Step that includes a `render()` method, which you should update to return your step view.

## Defining a Walker

To define a Walker, you should include `Qube\Walker\Walker` and call the `walk()` method. Also, you should include the list of steps that the walker will have Here's an example:

```php
use Qube\Walker\Walker;

// Instantiate a Walker by passing a name. This method will create a new Walker
// or load it from the storage.
$walker = Walker::walk(name: 'my-walker');

// Define the steps that the Walker will have.
$walker->through([
    App\Steps\Step1::class,
    ...
]);

// Finally, you can render the current step.
$walker->render();
```

## Navigating through your Walker

To navigate through a Walker, you can use the `next()` and `previous()` methods exposed by the `Qube\Walker\Walker` class. For example:

```php
// Load the walker created earlier.
$walker = Walker::walk(name: 'my-walker');

// Move to the next step. Pass a callback that holds the behavior of the
// Walker when it moves forward.
$walker->next(next: fn () => redirect('/walker-render'));

// Or, you can move to the previous step. Pass a callback that holds the behavior of the
// Walker when it moves backwards.
$walker->previous(next: fn () => redirect('/walker-render'));
```

The Walker is automatically saved to the storage using the defined Driver when:

- It's created
- You move to the next step
- You move to the previous step

Aditionally, you can create callbacks that will be executed before the Walker moves. This callbacks can be defined in each of the steps. To do this, open a step and define the following methods:

```php
/**
 * Callback executed before navigating to
 * the next step.
 *
 * @param  \Qube\Walker\Contracts\Walker  $walker
 * @return mixed
 */
public function onBeforeNextStep(Walker $walker)
{
    //
}

/**
 * Callback executed before navigating to
 * the previous step.
 *
 * @param  \Qube\Walker\Contracts\Walker  $walker
 * @return mixed
 */
public function onBeforePreviousStep(Walker $walker)
{
    //
}
```

As the names indicate, these methods are executed before moving to the next or previous step. There is no need to define both of them, you can define whichever you need.

These methods are helpful when, for example, you need to validate data sent by the step. Here's an example:

```php
public function onBeforeNextStep(Walker $walker)
{
    // We need to validate the request data before moving
    // to the next step.
    $validated = \Illuminate\Support\Validator::make(
        request()->all(), [
            // Define the rules.
        ]
    )->validated();

    // If the validator passes, you could save the data to
    // the Walker, so you can retreive it later:
    $walker->append(data: ['step-1' => $validated]);
}
```

## Accessing the Walker's data

To access data you previously appended to a Walker, you may use the following method:

```php
// This method returns an array containing the appended data.
$walker->data();
```

# Configuration

You can configure the package options by updating the `config/walker.php` file. This file allows you to define the default driver, timeout, etc.

# Methods

| Method                                       | Description                                                                                                                                                 |
| -------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Walker::walk(name: string): Walker`         | Load the walker with the given name, or create a new Walker and save it on the storage if it doesn't exist.                                                 |
| `Walker->through(steps: array): Walker`      | Set the list of steps that the Walker will have.                                                                                                            |
| `Walker->render(): mixed`                    | Render the current step.                                                                                                                                    |
| `Walker->next(next: Closure): mixed`         | Advance 1 step in the Walker and execute the given closure afterwards.                                                                                      |
| `Walker->previous(next: Closure): mixed`     | Move back 1 step in the Walker and execute the given closure afterwards.                                                                                    |
| `Walker->append(data: array): Walker`        | Append data to the Walker. Useful for saving steps data and retreiving it later.                                                                            |
| `Walker->data(): array`                      | Return the appended data.                                                                                                                                   |
| `Step->render(walker: Walker): mixed`        | Render the step.                                                                                                                                            |
| `Step->onBeforeNextStep(walker: Walker)`     | Executed before moving to the next step. Useful for validating and appending data to the Walker, and redirecting the user to another page on the last step. |
| `Step->onBeforePreviousStep(walker: Walker)` | Executed before moving to the previous step.                                                                                                                |

# Example

You can see a full example under `examples/`.

# License

Walker is open-sourced licensed under the [MIT License](LICENSE.md).
