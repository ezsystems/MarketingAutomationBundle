# eZ Platform Marketing Automation Bundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/531e83d6-ced2-45a3-8abb-8574da4a4e44/big.png)](https://insight.sensiolabs.com/projects/531e83d6-ced2-45a3-8abb-8574da4a4e44)

[![Build Status](https://travis-ci.org/ezsystems/MarketingAutomationBundle.svg?branch=master)](https://travis-ci.org/ezsystems/MarketingAutomationBundle)

This bundle integrates [Net-Result’s marketing automation](http://www.net-results.com/) suite into the eZ Publish
Platform.

## License
See the LICENSE file that ships at the root of this bundle.

## Installation

1. add the following to your composer.json:
    ```json
    {
        "require": {
            "ezsystems/marketing-automation-bundle": "^1.0.0@alpha",
        },
        "repositories": [
            {
                "type": "vcs",
                "url":  "git@github.com:ezsystems/MarketingAutomationBundle.git"
            }
        ]
    }
    ```

2. run `composer update ezsystems/marketing-automation-bundle`.

3. Add `new EzSystems\MarketingAutomationBundle\EzSystemsMarketingAutomationBundle()` to your kernel (`ezpublish/EzPublishKernel.php`).

4. Add the following in an override of your `content.ini.append.php` (it will activate `ezmaform` custom tag in a rich text / XmlText field in the Administration Interface):
    ```ini
    [CustomTagSettings]
    AvailableCustomTags[]=ezmaform
    
    [ezmaform]
    CustomAttributes[]
    CustomAttributes[]=form_id
    ```

5. Add the following to your `parameters.yml`:
    ```yaml
    parameters:
        ezma.default.TrackingSettings.AutomaticTracking: ~
        ezma.default.TrackingSettings.InstallationId: ~
    
        ezma.default.FormSettings.Hostname: forms.cdnma.com
    ```

6. Update your `parameters.yml` to activate automatic tracking:
    ```yaml
        ezma.default.TrackingSettings.AutomaticTracking: enabled
        ezma.default.TrackingSettings.InstallationId: _your_installation_id_
    ```

## Features

### Automatic tracker code integration
The Marketing Automation tracking code will automatically be added before the closing body tag.

### XmlText custom tag
Marketing Automation forms in XmlText fields will be rendered through the new stack.
