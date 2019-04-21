# Core Tools

Core Tools to build common page types.

## Migrating from 1.x to 2.x

To migrate data from `SiteConfig` to `GlobalSiteSetting` create the file `migration.yml` in the mysite/_config folder with the following:

```
SiteConfig:
  extensions:
	- Addressable
	- Geocodable
	- CompanyConfig
	- UtilityNavigationManager
	- FooterNavigationManager
  db:
	PhoneNumber: Varchar(20)
	EmailAddress: Varchar(255)
```

Run `dev/build`

Lastly, run `dev/tasks/SettingsToConfigTask` to migrate the data.