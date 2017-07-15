# core-tools
[![Build Status](https://travis-ci.com/dynamic/core-tools.svg?token=hFT1sXd4nNmguE972zHN&branch=master)](https://travis-ci.com/dynamic/core-tools)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/core-tools/badges/quality-score.png?b=master&s=76a902849ba73f7f6d9259cb9608c56ff1231dd0)](https://scrutinizer-ci.com/g/dynamic/core-tools/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dynamic/core-tools/badges/coverage.png?b=master&s=48f25344a2e1880098454f3f16b5f5e33c0d0314)](https://scrutinizer-ci.com/g/dynamic/core-tools/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/core-tools/badges/build.png?b=master&s=9bb324f03c01ebe635f436adf2143649b913eb68)](https://scrutinizer-ci.com/g/dynamic/core-tools/build-status/master)
[![codecov](https://codecov.io/gh/dynamic/core-tools/branch/master/graph/badge.svg?token=aTTN08qp6y)](https://codecov.io/gh/dynamic/core-tools)

[![Dependency Status](https://www.versioneye.com/user/projects/5761fd660a82b200276f729f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5761fd660a82b200276f729f)

core tools to build common page types

## Requirements

- SilverStripe ^4.0

## Installation

`composer require dynamic/core-tools 3.0.x-dev`

## Example usage

In your project's `Page.php`:

	private static $has_many = array(
		'Sections' => PageSection::class,
	);
	
	private static $many_many = array(
		'Promos' => Promo::class,
		'Videos' => YouTubeVideo::class,
	);
	
	private static $many_many_extraFields = array(
		'Promos' => array(
			'SortOrder' => 'Int',
		),
		'Videos' => array(
			'SortOrder' => 'Int',
		),
	);

To use `Tags`, add the `Tags` relation to the dataobjects and pages desired:

	private static $many_many = array(
		'Tags' => CoreTag::class,
	);

## Upgrading

Upgrading form 2.0.0-alpha2 or before be sure to run the `SettingsToConfigTask` to migrate data from SiteConfig to the new `GlobalSiteSetting` DataObject.

## Documentation

See the [docs/en](docs/en/index.md) folder.
