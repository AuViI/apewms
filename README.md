# Weather Monitoring System
## Configuration
You have to change the settings to fit this software to your database.
```bash
git clone https://github.com/tibyte/apewms.git
cd apewms/interface/exec/
cp _auth.php auth.php
nano auth.php
```
Enter the ip to your database, your username, password, and database name. The base dir variable is not used for anything as of now.

**You have to create your database tables manually**

```sql
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- create ENTRIES-FOLDER
CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fid` int(10) unsigned zerofill NOT NULL,
  `remote` tinyint(1) NOT NULL,
  `content` text NOT NULL,
  `src` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- create FOLDER-TABLE
CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `folder` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- create ACCOUNT-TABLE
CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(18) NOT NULL,
  `desc` text NOT NULL COMMENT 'About Location e.g. "Hafenhaus"',
  `pw` text NOT NULL,
  `salt` text NOT NULL,
  `speed` int(10) unsigned zerofill NOT NULL DEFAULT '0000000010',
  `session` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;
```

## Dependencies
- php5
- mysql

## Python API
Github-Repo: [WMS-API](https://github.com/tibyte/autowkid/blob/master/wmsapi.py)
