# Change Log
All notable changes to this project will be documented in this file.

## 2.2.3 - 9/5/2016
### Changed
- Updated README.md with new minimum requirements

### Fixed
- LA Rams Logo was not displaying
- Results showed week 1 winners before any games have been played
- Team record and team streak are no longer displayed for week 1 until scores have been entered

### Removed
- Removed old helmet logos

## 2.2.2 - 7/12/2016
### Changed/Fixed
- Time zone offset is now set automatically, based on new SERVER_TIMEZONE constant.  This should fix [issue #2](https://github.com/rothkj1022/phppickem/issues/2) and [issue #16](https://github.com/rothkj1022/phppickem/issues/16)
- Fixed [issue #17](https://github.com/rothkj1022/phppickem/issues/17)
- Fix to escape characters in comment subjects.

## 2.2.1 - 7/7/2016
### Changed
- Fixed for LA Rams

## 2.2.0 - 4/21/2016
### Changed
- Updated installer with 2016 schedule
- Transitioned changelog.txt to CHANGELOG.md based on [recommendations by olivierlacan](https://github.com/olivierlacan/keep-a-changelog/blob/master/CHANGELOG.md)
- Attempting to adhere more strictly to [Semantic Versioning](http://semver.org/) from here on out.

### Removed
- Removed all old NFL schedule spreadsheets from docs folder

## 2.1.3 - 9/10/2015
### Changed
- Removed all page references to phpFreaksCrypto class and added global reference.

## 2.1.2 - 8/28/2015
### Fixed
- Fixed team code for Washington Redskins as reported by aharonhannan. Also updated Cleveland Browns and Pittsburgh Steelers logos.
- Fixed bug when adding new user as admin and rewrote buildSchedule.php for fetching schedule from nfl.com instead of espn.com.
- Fixed password reset issue reported by hollywood-canuck.

## 2.1.1 - 8/12/2015
### Fixed
- Fixed error caused by missing mcrypt

## 2.1.0 - 8/6/2015
### Changed
 - Updated installer with 2015 schedule

## 2.0.4 - 3/31/2015
### Fixed
- Fixed installer bugs reported by BrentNewland

## 2.0.3 - 11/24/2014
### Changed
- Rewrote Load Scores script to pull data from nfl.com instead of espn.
- Minor updates to entry form page.

## 2.0.2 - 10/10/2014
### Added
- Pages are now printer friendly

### Fixed
- Fixed IE9+ support (SVG & fonts)
- Fixed several visual and functional bugs

## 2.0.1 - 9/29/2014
### Fixed
- Fixed display of correct or incorrect pick choices on entry form

## 2.0.0 - 9/27/2014
### Changed
- Updated code to use mysqli instead of mysql
- Implemented new responsive design

## 1.0.11 - 9/1/2014
### Changed
 - Updated installer with 2014 schedule

## 1.0.10 - 8/26/2013
### Changed
 - Updated installer with 2013 schedule

## 1.0.9 - 9/2/2012
## Changed
- Updated installer with 2012 schedule

## 1.0.8 - 8/8/2011
- Updated phpmailer to 5.2
- Updated htmlpurifier to lite v 1.3.0
- Updated installer with 2011 schedule

## 1.0.7.1 - 9/19/2010
### Fixed
 - Fixed conflict with HTMLPurifier on scores page

## 1.0.7 - 9/15/2010
### Added
- Added config option for display of users' names/usernames (real names, usernames, or both)
- Added HTMLPurifier to prevent cross-site scripting attacks

## 1.0.6 - 9/3/2010
### Changed
- Changed results & standings pages to display usernames instead of full names

### Fixed
- Fixed clickable helmets for Internet Explorer (all versions)

## 1.0.5 - 8/13/2010
### Fixed
- Fixed signup page (did not work when register_globals is off)

## 1.0.4 - 8/4/2010
### Changed
- Updated CBRTE to latest version (3.12a)
- Updated jquery timepicker to latest version (0.2), fixes am/pm bug

### Fixed
- Fixed schedule update mysql error

## 1.0.3 - 4/21/2010
### Changed
- Updated auto score retrieval script for 2010
- Updated install script with 2010 NFL schedule

## 1.0.2 - 9/14/2009
### Fixed
- Fixed picks entry when after current week is closed but not all games are complete for the week.

## 1.0.1 - 9/11/2009
### Added
- Added username to body of password reset email

### Fixed
- Fixed load scores function
- Fixed bug with display of results

## 1.0.0 - 8/27/2009
- Initial Release

## 0.9.0 - 8/28/2008
- Beta Release
