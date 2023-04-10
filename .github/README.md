# Walker

An easy-to-use package to create awesome multi step flows in your<br />
Laravel application.

# Installation

```bash
composer require qube/laravel-walker
```

# Usage

Create a step using the following command:

```bash
# Replace <name> with the full qualified name of your step.
php artisan walker:step <name>
```

After creating your steps, you can instantiate and render a Walker, for example, in a route:

```php
Route::get('/checkout', function () {
    return Qube\Walker\Walker::walk(
        // Assign a name to your Walker. This name will be used
        // to identify your data in the storage.
        name: 'checkout'
    )->through([
        // Specify the list of steps that the Walker will have.
        App\Steps\Step1::class,
        App\Steps\Step2::class,
        // ...
    ])->render();
})->name('checkout');
```

The `render` method will render the current step of your Walker.

## Navigating through your Walker

The Walker class exposes 2 methods: `next` and `previous` to navigate through it. You can define 2 routes that access these methods:

```php
Route::post('/next', function () {
    return Qube\Walker\Walker::walk(name: 'checkout')->next(function () {
        // This callback will be executed after the Walker moves to
        // the next step. So, for example, we can redirect to
        // the /checkout route that will render the current step.
        return redirect()->route('checkout');
    })
})->name('checkout.next');
```

Analogous to this, you could make a route that hits the `previous` method.

## Validating data inside steps

You'll surely encounter a scene where you want to validate data before navigating the Walker. To do this, the step classes have 2 methods defined, which you can override in your steps:

```php
/**
 * Callback executed before navigating to
 * the next step.
 *
 * @param  \Qube\Walker\Contracts\Walker  $walker
 * @return mixed
 */
public function onBeforeNextStep(Walker $walker);

/**
 * Callback executed before navigating to
 * the previous step.
 *
 * @param  \Qube\Walker\Contracts\Walker  $walker
 * @return mixed
 */
public function onBeforePreviousStep(Walker $walker);
```

As the names of the methods indicate, they are executed before navigating the Walker. You could create a `\Illuminate\Support\Facades\Validator` and validate the input in these methods.

## What happens when I reach the last step?

You could, for example, override the `onBeforeNextStep(Walker $walker)` and redirect the user to another part of your application!

# License

Walker is open-sourced software licensed under the [MIT license](LICENSE.md).
