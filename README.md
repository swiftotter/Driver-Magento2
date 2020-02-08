# Driver: Magento 2 Transformations
### A database task-runner

For more information about how Driver works, see https://github.com/SwiftOtter/Driver.

### How to use these modules:

```bash
composer require swiftotter/driver-magento2
```

In your project's root directory (the one where `vendor` is), create a new
folder called `config.d`. Create a file inside `config.d` called `config.yaml`.

Your directory structure should now look something like:

* composer.json
* composer.lock
* config.d/
    * config.yaml (where you configure what happens)
    * connections.yaml (with your connection information, also specified in `.gitignore`)
* vendor/
    * swiftotter/
        * driver
        * driver-magento2