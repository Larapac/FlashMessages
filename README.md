# FlashMessages
Easy Flash Messages for Your Laravel App

## Installation

```
composer require larapac/flash
```

## Usage

For send messages use helper `flash()`

```php
  flash('Some info message');
```

In template:

```blade
  @foreach (flash()->messages() as $message)
      {{ $message->level }}: {{ $message->text }}
  @endforeach
```

Messages has a properties
 - `text`
 - `level` (success, info, warning, danger)
 

Messages has levels and service possible send multiple messages:

```php
  flash('Info level message');
  flash()->info('Info level message two');
  flash()->success('Success level message');
  flash()->warning('Warming level message');
  flash()->warning('Warming level message two');
  flash()->danger('Danget level message');
  flash()->error('Danget level message from alias method');
```

And we can get messages only one concrete level:

```blade
Errors:
    @foreach(flash()->messages('danger') as $message)
        {{ $message->text }};
    @endforeach
    @foreach($errors->all() as $message)
        {{ $message }};
    @endforeach
```

Add to message extra data:

```php
  //use array
  flash()->info('Message', ['important' => true, 'timeout' => 3]);

  //fluent style
  flash()->info('Message')->important()->timeout(3);
```

```blade
  @foreach (flash()->messages() as $message)
      {{ $message->level }}: {{ $message->text }} {{ $message->important ? '!' : '.' }}
  @endforeach
```

## Other
If you want more simplest use class from gist: [FlashMessageSender](https://gist.github.com/Ellrion/7ee8085b35f0de8c6d386255f9dd16bb)

Or see this packages:
- [codecourse/notify](https://github.com/codecourse/notify)
- [laracasts/flash](https://github.com/laracasts/flash)

