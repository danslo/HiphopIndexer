# Rubic_HiphopIndexer

## What is this?

When trying to run Magento on [HHVM](https://github.com/facebook/hhvm), you;

1. may experience issues due to bugs in HHVM
2. your store uses unsupported functionality (such as ioncube)

Even in these cases, you may want to use HHVM just for certain requests: one of these requests are those made against the indexer, because you know that it's almost [three times as fast](https://twitter.com/daniel_sloof/status/401414537204625408). 

## How does it work?

1. We observe an early event: ``controller_front_init_before``.
2. A check is made to see if HHVM is running by inspecting ``$_SERVER['SERVER_SOFTWARE']``.
3. A check is made to see if the current request matches a request path whitelist.
4. We then ban the usage of saving config cache for the request.
5. We reinitialize the config cache with a specific module whitelist.

## What else should I do?

You should ensure your webserver configuration reroutes these specific requests to HHVM. This is child's play if you're already using nginx to loadbalance your store.

More detailed configuration instructions will follow.

## License

Copyright 2014 Daniel Sloof

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
