# FlashMessages

Простая реализация для "флеш" сообщений в приложениях на базе Laravel фреймворка.

Отличительные особенности:
- Сообщения по уровням (info, success, warning, danger);
- Множественные сообщения (и различных, типов и для типа);
- Стек сообщений и возможность взять сообщения только определенного уровня;
- Дополнительные данные сообщений (через массив или текучий интерфейс);
- Сообщение, отправленное на странице, не перекрывает сообщения, отправленные при редиректе на эту страницу;
- Отсутсвие привязки к js или верстке сообщения.

## Установка

Для установки используйте composer

```
composer require larapac/flash
```

## Использование

Для "отправки" сообщения можно воспользоваться хэлпером `flash()`

```php
  flash('Some info message');
```

Для того, чтобы взять все сообщения в отображении:

```blade
  @foreach (flash()->messages() as $message)
      {{ $message->level }}: {{ $message->text }}
  @endforeach
```

Сообщения всегда будут иметь поля
 - `text`
 - `level` (success, info, warning, danger)
 
Разметка для вывода самих сообщений не регламентируется сервисом и может быть любой.

Сообщения можно отправлять сколько угодно и с разным уровнем:

```php
  flash('Info level message');
  flash()->info('Info level message two');
  flash()->success('Success level message');
  flash()->warning('Warning level message');
  flash()->warning('Warning level message two');
  flash()->danger('Danger level message');
  flash()->error('Danger level message from alias method');
```

Возможно взять сообщения только определенного уровня:

```blade
Errors:
    @foreach(flash()->messages('danger') as $message)
        {{ $message->text }};
    @endforeach
    @foreach($errors->all() as $message)
        {{ $message }};
    @endforeach
```

К сообщению можно добавлять дополнительные данные:

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

## Дополнительно

Для тех, кто не любит микропакеты, можно воспользоваться следующим кодом: [FlashMessageSender](https://gist.github.com/Ellrion/7ee8085b35f0de8c6d386255f9dd16bb)

Так же, возможно, вам больше подойдет один из следующих пакетов:
- [codecourse/notify](https://github.com/codecourse/notify)
- [laracasts/flash](https://github.com/laracasts/flash)
