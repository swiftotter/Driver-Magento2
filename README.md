# Driver: Magento 2 Transformations
### A database task-runner

For more information about how Driver works, see https://github.com/SwiftOtter/Driver.

### How to use these modules:

```bash
composer require swiftotter/driver-magento1
```

In your project's root directory (the one where `vendor` is), create a new
folder called `config.d`. Create a file inside `config.d` called `config.yaml`.

Your directory structure should now look something like:

* composer.json
* composer.lock
* config.d/
    * config.yaml
* vendor/
    * swiftotter/
        * driver
        * driver-magento2

In `config.yaml`, add the following lines:

```yaml

pipelines:
  default:
    - name: global-commands
      actions:
        - name: m2-clear-customers
          sort: 50
        - name: m2-clear-orders
          sort: 60
        - name: m2-clear-quotes
          sort: 70
        - name: m2-clear-reports
          sort: 80
        - name: m2-clear-common
          sort: 90
        - name: m2-clear-swiftotter
          sort: 100

```

Each of the actions above has a name. `m2-clear-customers` is an example of such
a name. This could have been automatic, but Driver is designed with
customization over convention. You need to decide where you want these commands
to execute. That said, the above template is a great starting place.