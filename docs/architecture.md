# Architecture

`SofizPay` is the container-bound entry point. It creates endpoint objects for CIB transactions and service operations.

```text
SofizPay facade / container binding
              |
              +-- CIBTransaction -- MakeCIBTransactionDTO -- typed CIB responses
              |
              +-- ServiceOperation -- operation DTOs -- typed operation responses
                                      |
                                      +-- HttpClient -- Laravel HTTP client
```

DTOs convert their public values into API request arrays through `toArray()`. Response objects convert API arrays through `fromArray()` and expose typed public properties. `HttpClient` centralizes HTTP error conversion into `SofizPayRequestException`.
