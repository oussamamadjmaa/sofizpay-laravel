# Sandbox behavior

Sandbox mode is enabled by default through `SOFIZPAY_SANDBOX=true`.

In sandbox mode, the package uses the SofizPay sandbox base URL. Service-operation requests are intercepted with Laravel's HTTP fake and receive sample responses for submission, details, history, and product lookup. This is useful for local development and package tests.

CIB transaction requests are not locally faked outside the testing environment; they use the configured sandbox API URL. In the package test environment, CIB responses are faked as well.

Set `SOFIZPAY_SANDBOX=false` to use the non-sandbox base URL. Verify your SofizPay credentials and integration before making live requests.
