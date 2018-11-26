# FlashMessages
Simple Flash Messages for Your Laravel App

Features:
- Messages by levels (info, success, warning, danger);
- Multiple messages (of different types and for types);
- Stack of messages and ability to pick messages of a single type;
- Additional message data (by array or current interface);
- Message sent on a page does not replace a message sent by redirecting to the page;
- Does not need linking with JS or message front-end.

## Installation

```
composer require larapac/flash
```

## Usage

To send a message use helper `flash()`

```php
  flash('Some info message');
```

In template:

```blade
  @foreach (flash()->messages() as $message)
      {{ $message->level }}: {{ $message->text }}
  @endforeach
```

Messages have properties
 - `text`
 - `level` (success, info, warning, danger)
 

Messages have levels and service allows to send multiple messages:

```php
  flash('Info level message');
  flash()->info('Info level message two');
  flash()->success('Success level message');
  flash()->warning('Warning level message');
  flash()->warning('Warning level message two');
  flash()->danger('Danger level message');
  flash()->error('Danger level message from alias method');
```

And we can get messages of only one single level:

```blade
Errors:
    @foreach(flash()->messages('danger') as $message)
        {{ $message->text }};
    @endforeach
    @foreach($errors->all() as $message)
        {{ $message }};
    @endforeach
```

Add extra data message:

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
If you want it to be more simple, use class from gist: [FlashMessageSender](https://gist.github.com/Ellrion/7ee8085b35f0de8c6d386255f9dd16bb)

Or see these packages:
- [codecourse/notify](https://github.com/codecourse/notify)
- [laracasts/flash](https://github.com/laracasts/flash)

