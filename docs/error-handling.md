# Error handling

Unsuccessful HTTP responses throw `OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException`.

```php
use OussamaMadjmaa\SofizPay\Exceptions\SofizPayRequestException;

try {
    $serviceOperation->details('operation-id');
} catch (SofizPayRequestException $exception) {
    $status = $exception->response?->status();
    $payload = $exception->context();
    $body = $exception->body();

    report($exception);
}
```

`context()` returns the decoded JSON response as an array, `body()` returns the raw body when available, and `getResponse()` returns the Laravel HTTP response object.

`details()` also throws this exception when the response does not contain a `data` value. Creating a CIB transaction without an account in the DTO or configuration throws `InvalidArgumentException` before a request is sent.
