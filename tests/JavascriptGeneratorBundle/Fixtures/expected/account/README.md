# @vendor/account-client

`@vendor/account-client` package provides means to interact with Vendor AccountClient REST API.
Package source code is written in ES6 syntax ant is transpiled to ES5 using babel.
Additional Angular JS module `vendor.http.account-client` with `vendorHttpAccountClientFactory` service is also provided.

## Installing
Using npm:
```bash
$ npm install @vendor/account-client
```

Using javascript files
```html
<script src="//domain.com/path/to/@paysera/http-client-common/dist/main.js"></script>
<script src="//domain.com/path/to/@vendor/account-client/dist/lib.js"></script>
```

# Usage
```js
import {
    createClient,
    createRequest,
    JWTAuthenticationMiddleware,
    SessionStorageTokenProvider,
    Scope,
} from '@paysera/http-client-common';
import { createAccountClient } from '@vendor/account-client';

const client = createAccountClient({
    baseUrl: 'http://sandbox.domain.com/', // optional, custom base url
    middleware: [ // optional, list of middleware
        new JWTAuthenticationMiddleware(
            new Scope('scope:a'),
            new SessionStorageTokenProvider(
                (scope) => ({ scope, accessToken: 'created-token' }),
                (scope) => ({ scope, accessToken: 'refreshed-token' }),
                'account_client', // unique identifier of token
                'AccountClient', // storage namespace
            ),
        ),
    ]
});
```

## Demo
 - Run `npm install`
 - Run `npm run build`
 - Run `npm run serve` and take a look at `/dist/app.js` file
