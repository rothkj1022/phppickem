/*
 Navicat MySQL Data Transfer

 Source Server         : _localhost
 Source Server Type    : MySQL
 Source Server Version : 50542
 Source Host           : localhost
 Source Database       : nflpickem

 Target Server Type    : MySQL
 Target Server Version : 50542
 File Encoding         : utf-8

 Date: 07/07/2016 19:37:35 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `nflp_comments`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_comments`;
CREATE TABLE `nflp_comments` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `comment` longtext NOT NULL,
  `postDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `nflp_divisions`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_divisions`;
CREATE TABLE `nflp_divisions` (
  `divisionID` int(11) NOT NULL AUTO_INCREMENT,
  `conference` varchar(10) NOT NULL,
  `division` varchar(32) NOT NULL,
  PRIMARY KEY (`divisionID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `nflp_divisions`
-- ----------------------------
BEGIN;
INSERT INTO `nflp_divisions` VALUES ('1', 'AFC', 'North'), ('2', 'AFC', 'South'), ('3', 'AFC', 'East'), ('4', 'AFC', 'West'), ('5', 'NFC', 'North'), ('6', 'NFC', 'South'), ('7', 'NFC', 'East'), ('8', 'NFC', 'West');
COMMIT;

-- ----------------------------
--  Table structure for `nflp_email_templates`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_email_templates`;
CREATE TABLE `nflp_email_templates` (
  `email_template_key` varchar(255) NOT NULL,
  `email_template_title` varchar(255) NOT NULL,
  `default_subject` varchar(255) DEFAULT NULL,
  `default_message` text,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`email_template_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `nflp_email_templates`
-- ----------------------------
BEGIN;
INSERT INTO `nflp_email_templates` VALUES ('WEEKLY_PICKS_REMINDER', 'Weekly Picks Reminder', 'NFL Pick \'Em Week {week} Reminder', 'Hello {player},<br /><br />You are receiving this email because you do not yet have all of your picks in for week {week}.&nbsp; This is your reminder.&nbsp; The first game is {first_game} (Eastern), so to receive credit for that game, you\'ll have to make your pick before then.<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />', 'NFL Pick \'Em Week {week} Reminder', 'Hello {player},<br /><br />You are receiving this email because you do not yet have all of your picks in for week {week}.&nbsp; This is your reminder.&nbsp; The first game is {first_game} (Eastern), so to receive credit for that game, you\'ll have to make your pick before then.<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />'), ('WEEKLY_RESULTS_REMINDER', 'Last Week Results/Reminder', 'NFL Pick \'Em Week {previousWeek} Standings/Reminder', 'Congratulations this week go to {winners} for winning week {previousWeek}.  The winner(s) had {winningScore} out of {possibleScore} picks correct.<br /><br />The current leaders are:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />*Reminder* - Please make your picks for week {week} before {first_game} (Eastern).<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />', 'NFL Pick \'Em Week {previousWeek} Standings/Reminder', 'Congratulations this week go to {winners} for winning week {previousWeek}.  The winner(s) had {winningScore} out of {possibleScore} picks correct.<br /><br />The current leaders are:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />*Reminder* - Please make your picks for week {week} before {first_game} (Eastern).<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />'), ('FINAL_RESULTS', 'Final Results', 'NFL Pick \'Em 2016 Final Results', 'Congratulations this week go to {winners} for winning week\r\n{previousWeek}. The winner(s) had {winningScore} out of {possibleScore}\r\npicks correct.<br /><br /><span style=\"font-weight: bold;\">Congratulations to {final_winner}</span> for winning NFL Pick \'Em 2016!&nbsp; {final_winner} had {final_winningScore} wins and had a pick ratio of {picks}/{possible} ({pickpercent}%).<br /><br />Top Wins:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />Thanks for playing, and I hope to see you all again for NFL Pick \'Em 2017!', 'NFL Pick \'Em 2016 Final Results', 'Congratulations this week go to {winners} for winning week\r\n{previousWeek}. The winner(s) had {winningScore} out of {possibleScore}\r\npicks correct.<br /><br /><span style=\"font-weight: bold;\">Congratulations to {final_winner}</span> for winning NFL Pick \'Em 2016!&nbsp; {final_winner} had {final_winningScore} wins and had a pick ratio of {picks}/{possible} ({pickpercent}%).<br /><br />Top Wins:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />Thanks for playing, and I hope to see you all again for NFL Pick \'Em 2017!');
COMMIT;

-- ----------------------------
--  Table structure for `nflp_picks`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_picks`;
CREATE TABLE `nflp_picks` (
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL,
  `pickID` varchar(10) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userID`,`gameID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Table structure for `nflp_picksummary`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_picksummary`;
CREATE TABLE `nflp_picksummary` (
  `weekNum` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `tieBreakerPoints` int(11) NOT NULL DEFAULT '0',
  `showPicks` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`weekNum`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `nflp_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_schedule`;
CREATE TABLE `nflp_schedule` (
  `gameID` int(11) NOT NULL AUTO_INCREMENT,
  `weekNum` int(11) NOT NULL,
  `gameTimeEastern` datetime DEFAULT NULL,
  `homeID` varchar(10) NOT NULL,
  `homeScore` int(11) DEFAULT NULL,
  `visitorID` varchar(10) NOT NULL,
  `visitorScore` int(11) DEFAULT NULL,
  `overtime` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gameID`),
  KEY `GameID` (`gameID`),
  KEY `HomeID` (`homeID`),
  KEY `VisitorID` (`visitorID`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `nflp_schedule`
-- ----------------------------
BEGIN;
INSERT INTO `nflp_schedule` VALUES ('1', '1', '2016-09-08 20:30:00', 'DEN', '0', 'CAR', '0', '0'), ('2', '1', '2016-09-11 13:00:00', 'ATL', '0', 'TB', '0', '0'), ('3', '1', '2016-09-11 13:00:00', 'BAL', '0', 'BUF', '0', '0'), ('4', '1', '2016-09-11 13:00:00', 'HOU', '0', 'CHI', '0', '0'), ('5', '1', '2016-09-11 13:00:00', 'JAX', '0', 'GB', '0', '0'), ('6', '1', '2016-09-11 13:00:00', 'KC', '0', 'SD', '0', '0'), ('7', '1', '2016-09-11 13:00:00', 'NO', '0', 'OAK', '0', '0'), ('8', '1', '2016-09-11 13:00:00', 'NYJ', '0', 'CIN', '0', '0'), ('9', '1', '2016-09-11 13:00:00', 'PHI', '0', 'CLE', '0', '0'), ('10', '1', '2016-09-11 13:00:00', 'TEN', '0', 'MIN', '0', '0'), ('11', '1', '2016-09-11 16:05:00', 'SEA', '0', 'MIA', '0', '0'), ('12', '1', '2016-09-11 16:25:00', 'DAL', '0', 'NYG', '0', '0'), ('13', '1', '2016-09-11 16:25:00', 'IND', '0', 'DET', '0', '0'), ('14', '1', '2016-09-11 20:30:00', 'ARI', '0', 'NE', '0', '0'), ('15', '1', '2016-09-12 19:10:00', 'WAS', '0', 'PIT', '0', '0'), ('16', '1', '2016-09-12 22:20:00', 'SF', '0', 'LA', '0', '0'), ('17', '2', '2016-09-15 20:25:00', 'BUF', '0', 'NYJ', '0', '0'), ('18', '2', '2016-09-18 13:00:00', 'CAR', '0', 'SF', '0', '0'), ('19', '2', '2016-09-18 13:00:00', 'CLE', '0', 'BAL', '0', '0'), ('20', '2', '2016-09-18 13:00:00', 'DET', '0', 'TEN', '0', '0'), ('21', '2', '2016-09-18 13:00:00', 'HOU', '0', 'KC', '0', '0'), ('22', '2', '2016-09-18 13:00:00', 'NE', '0', 'MIA', '0', '0'), ('23', '2', '2016-09-18 13:00:00', 'NYG', '0', 'NO', '0', '0'), ('24', '2', '2016-09-18 13:00:00', 'PIT', '0', 'CIN', '0', '0'), ('25', '2', '2016-09-18 13:00:00', 'WAS', '0', 'DAL', '0', '0'), ('26', '2', '2016-09-18 16:05:00', 'ARI', '0', 'TB', '0', '0'), ('27', '2', '2016-09-18 16:05:00', 'LA', '0', 'SEA', '0', '0'), ('28', '2', '2016-09-18 16:25:00', 'DEN', '0', 'IND', '0', '0'), ('29', '2', '2016-09-18 16:25:00', 'OAK', '0', 'ATL', '0', '0'), ('30', '2', '2016-09-18 16:25:00', 'SD', '0', 'JAX', '0', '0'), ('31', '2', '2016-09-18 20:30:00', 'MIN', '0', 'GB', '0', '0'), ('32', '2', '2016-09-19 20:30:00', 'CHI', '0', 'PHI', '0', '0'), ('33', '3', '2016-09-22 20:25:00', 'NE', '0', 'HOU', '0', '0'), ('34', '3', '2016-09-25 13:00:00', 'BUF', '0', 'ARI', '0', '0'), ('35', '3', '2016-09-25 13:00:00', 'CAR', '0', 'MIN', '0', '0'), ('36', '3', '2016-09-25 13:00:00', 'CIN', '0', 'DEN', '0', '0'), ('37', '3', '2016-09-25 13:00:00', 'GB', '0', 'DET', '0', '0'), ('38', '3', '2016-09-25 13:00:00', 'JAX', '0', 'BAL', '0', '0'), ('39', '3', '2016-09-25 13:00:00', 'MIA', '0', 'CLE', '0', '0'), ('40', '3', '2016-09-25 13:00:00', 'NYG', '0', 'WAS', '0', '0'), ('41', '3', '2016-09-25 13:00:00', 'TEN', '0', 'OAK', '0', '0'), ('42', '3', '2016-09-25 16:05:00', 'SEA', '0', 'SF', '0', '0'), ('43', '3', '2016-09-25 16:05:00', 'TB', '0', 'LA', '0', '0'), ('44', '3', '2016-09-25 16:25:00', 'PHI', '0', 'PIT', '0', '0'), ('45', '3', '2016-09-25 16:25:00', 'IND', '0', 'SD', '0', '0'), ('46', '3', '2016-09-25 16:25:00', 'KC', '0', 'NYJ', '0', '0'), ('47', '3', '2016-09-25 20:30:00', 'DAL', '0', 'CHI', '0', '0'), ('48', '3', '2016-09-26 20:30:00', 'NO', '0', 'ATL', '0', '0'), ('49', '4', '2016-09-29 20:25:00', 'CIN', '0', 'MIA', '0', '0'), ('50', '4', '2016-10-02 21:30:00', 'JAX', '0', 'IND', '0', '0'), ('51', '4', '2016-10-02 13:00:00', 'ATL', '0', 'CAR', '0', '0'), ('52', '4', '2016-10-02 13:00:00', 'BAL', '0', 'OAK', '0', '0'), ('53', '4', '2016-10-02 13:00:00', 'CHI', '0', 'DET', '0', '0'), ('54', '4', '2016-10-02 13:00:00', 'HOU', '0', 'TEN', '0', '0'), ('55', '4', '2016-10-02 13:00:00', 'NE', '0', 'BUF', '0', '0'), ('56', '4', '2016-10-02 13:00:00', 'NYJ', '0', 'SEA', '0', '0'), ('57', '4', '2016-10-02 13:00:00', 'WAS', '0', 'CLE', '0', '0'), ('58', '4', '2016-10-02 16:05:00', 'TB', '0', 'DEN', '0', '0'), ('59', '4', '2016-10-02 16:25:00', 'ARI', '0', 'LA', '0', '0'), ('60', '4', '2016-10-02 16:25:00', 'SD', '0', 'NO', '0', '0'), ('61', '4', '2016-10-02 16:25:00', 'SF', '0', 'DAL', '0', '0'), ('62', '4', '2016-10-02 20:30:00', 'PIT', '0', 'KC', '0', '0'), ('63', '4', '2016-10-03 20:30:00', 'MIN', '0', 'NYG', '0', '0'), ('64', '5', '2016-10-06 20:25:00', 'SF', '0', 'ARI', '0', '0'), ('65', '5', '2016-10-09 13:00:00', 'CLE', '0', 'NE', '0', '0'), ('66', '5', '2016-10-09 13:00:00', 'DET', '0', 'PHI', '0', '0'), ('67', '5', '2016-10-09 13:00:00', 'IND', '0', 'CHI', '0', '0'), ('68', '5', '2016-10-09 13:00:00', 'MIA', '0', 'TEN', '0', '0'), ('69', '5', '2016-10-09 13:00:00', 'BAL', '0', 'WAS', '0', '0'), ('70', '5', '2016-10-09 13:00:00', 'MIN', '0', 'HOU', '0', '0'), ('71', '5', '2016-10-09 13:00:00', 'PIT', '0', 'NYJ', '0', '0'), ('72', '5', '2016-10-09 16:05:00', 'DEN', '0', 'ATL', '0', '0'), ('73', '5', '2016-10-09 16:25:00', 'DAL', '0', 'CIN', '0', '0'), ('74', '5', '2016-10-09 16:25:00', 'LA', '0', 'BUF', '0', '0'), ('75', '5', '2016-10-09 16:25:00', 'OAK', '0', 'SD', '0', '0'), ('76', '5', '2016-10-09 20:30:00', 'GB', '0', 'NYG', '0', '0'), ('77', '5', '2016-10-10 20:30:00', 'CAR', '0', 'TB', '0', '0'), ('78', '6', '2016-10-13 20:25:00', 'SD', '0', 'DEN', '0', '0'), ('79', '6', '2016-10-16 13:00:00', 'BUF', '0', 'SF', '0', '0'), ('80', '6', '2016-10-16 13:00:00', 'CHI', '0', 'JAX', '0', '0'), ('81', '6', '2016-10-16 13:00:00', 'DET', '0', 'LA', '0', '0'), ('82', '6', '2016-10-16 13:00:00', 'MIA', '0', 'PIT', '0', '0'), ('83', '6', '2016-10-16 13:00:00', 'NE', '0', 'CIN', '0', '0'), ('84', '6', '2016-10-16 13:00:00', 'NO', '0', 'CAR', '0', '0'), ('85', '6', '2016-10-16 13:00:00', 'NYG', '0', 'BAL', '0', '0'), ('86', '6', '2016-10-16 13:00:00', 'TEN', '0', 'CLE', '0', '0'), ('87', '6', '2016-10-16 13:00:00', 'WAS', '0', 'PHI', '0', '0'), ('88', '6', '2016-10-16 16:05:00', 'OAK', '0', 'KC', '0', '0'), ('89', '6', '2016-10-16 16:25:00', 'GB', '0', 'DAL', '0', '0'), ('90', '6', '2016-10-16 16:25:00', 'SEA', '0', 'ATL', '0', '0'), ('91', '6', '2016-10-16 20:30:00', 'HOU', '0', 'IND', '0', '0'), ('92', '6', '2016-10-17 20:30:00', 'ARI', '0', 'NYJ', '0', '0'), ('93', '7', '2016-10-20 20:25:00', 'GB', '0', 'CHI', '0', '0'), ('94', '7', '2016-10-23 21:30:00', 'LA', '0', 'NYG', '0', '0'), ('95', '7', '2016-10-23 13:00:00', 'CIN', '0', 'CLE', '0', '0'), ('96', '7', '2016-10-23 13:00:00', 'DET', '0', 'WAS', '0', '0'), ('97', '7', '2016-10-23 13:00:00', 'JAX', '0', 'OAK', '0', '0'), ('98', '7', '2016-10-23 13:00:00', 'KC', '0', 'NO', '0', '0'), ('99', '7', '2016-10-23 13:00:00', 'MIA', '0', 'BUF', '0', '0'), ('100', '7', '2016-10-23 13:00:00', 'NYJ', '0', 'BAL', '0', '0'), ('101', '7', '2016-10-23 13:00:00', 'PHI', '0', 'MIN', '0', '0'), ('102', '7', '2016-10-23 13:00:00', 'TEN', '0', 'IND', '0', '0'), ('103', '7', '2016-10-23 16:05:00', 'ATL', '0', 'SD', '0', '0'), ('104', '7', '2016-10-23 16:05:00', 'SF', '0', 'TB', '0', '0'), ('105', '7', '2016-10-23 16:25:00', 'PIT', '0', 'NE', '0', '0'), ('106', '7', '2016-10-23 20:30:00', 'ARI', '0', 'SEA', '0', '0'), ('107', '7', '2016-10-24 20:30:00', 'DEN', '0', 'HOU', '0', '0'), ('108', '8', '2016-10-27 20:25:00', 'TEN', '0', 'JAX', '0', '0'), ('109', '8', '2016-10-30 21:30:00', 'CIN', '0', 'WAS', '0', '0'), ('110', '8', '2016-10-30 13:00:00', 'ATL', '0', 'GB', '0', '0'), ('111', '8', '2016-10-30 13:00:00', 'BUF', '0', 'NE', '0', '0'), ('112', '8', '2016-10-30 13:00:00', 'CLE', '0', 'NYJ', '0', '0'), ('113', '8', '2016-10-30 13:00:00', 'HOU', '0', 'DET', '0', '0'), ('114', '8', '2016-10-30 13:00:00', 'IND', '0', 'KC', '0', '0'), ('115', '8', '2016-10-30 13:00:00', 'NO', '0', 'SEA', '0', '0'), ('116', '8', '2016-10-30 13:00:00', 'TB', '0', 'OAK', '0', '0'), ('117', '8', '2016-10-30 16:05:00', 'DEN', '0', 'SD', '0', '0'), ('118', '8', '2016-10-30 16:25:00', 'CAR', '0', 'ARI', '0', '0'), ('119', '8', '2016-10-30 20:30:00', 'DAL', '0', 'PHI', '0', '0'), ('120', '8', '2016-10-31 20:30:00', 'CHI', '0', 'MIN', '0', '0'), ('121', '9', '2016-11-03 20:25:00', 'TB', '0', 'ATL', '0', '0'), ('122', '9', '2016-11-06 13:00:00', 'BAL', '0', 'PIT', '0', '0'), ('123', '9', '2016-11-06 13:00:00', 'CLE', '0', 'DAL', '0', '0'), ('124', '9', '2016-11-06 13:00:00', 'KC', '0', 'JAX', '0', '0'), ('125', '9', '2016-11-06 13:00:00', 'MIA', '0', 'NYJ', '0', '0'), ('126', '9', '2016-11-06 13:00:00', 'MIN', '0', 'DET', '0', '0'), ('127', '9', '2016-11-06 13:00:00', 'NYG', '0', 'PHI', '0', '0'), ('128', '9', '2016-11-06 16:05:00', 'LA', '0', 'CAR', '0', '0'), ('129', '9', '2016-11-06 16:05:00', 'SF', '0', 'NO', '0', '0'), ('130', '9', '2016-11-06 16:25:00', 'GB', '0', 'IND', '0', '0'), ('131', '9', '2016-11-06 16:25:00', 'SD', '0', 'TEN', '0', '0'), ('132', '9', '2016-11-06 20:30:00', 'OAK', '0', 'DEN', '0', '0'), ('133', '9', '2016-11-07 20:30:00', 'SEA', '0', 'BUF', '0', '0'), ('134', '10', '2016-11-10 20:25:00', 'BAL', '0', 'CLE', '0', '0'), ('135', '10', '2016-11-13 13:00:00', 'JAX', '0', 'HOU', '0', '0'), ('136', '10', '2016-11-13 13:00:00', 'NO', '0', 'DEN', '0', '0'), ('137', '10', '2016-11-13 13:00:00', 'NYJ', '0', 'LA', '0', '0'), ('138', '10', '2016-11-13 13:00:00', 'PHI', '0', 'ATL', '0', '0'), ('139', '10', '2016-11-13 13:00:00', 'CAR', '0', 'KC', '0', '0'), ('140', '10', '2016-11-13 13:00:00', 'TB', '0', 'CHI', '0', '0'), ('141', '10', '2016-11-13 13:00:00', 'TEN', '0', 'GB', '0', '0'), ('142', '10', '2016-11-13 13:00:00', 'WAS', '0', 'MIN', '0', '0'), ('143', '10', '2016-11-13 16:05:00', 'SD', '0', 'MIA', '0', '0'), ('144', '10', '2016-11-13 16:25:00', 'ARI', '0', 'SF', '0', '0'), ('145', '10', '2016-11-13 16:25:00', 'PIT', '0', 'DAL', '0', '0'), ('146', '10', '2016-11-13 20:30:00', 'NE', '0', 'SEA', '0', '0'), ('147', '10', '2016-11-14 20:30:00', 'NYG', '0', 'CIN', '0', '0'), ('148', '11', '2016-11-17 20:25:00', 'CAR', '0', 'NO', '0', '0'), ('149', '11', '2016-11-20 13:00:00', 'CLE', '0', 'PIT', '0', '0'), ('150', '11', '2016-11-20 13:00:00', 'DAL', '0', 'BAL', '0', '0'), ('151', '11', '2016-11-20 13:00:00', 'DET', '0', 'JAX', '0', '0'), ('152', '11', '2016-11-20 13:00:00', 'IND', '0', 'TEN', '0', '0'), ('153', '11', '2016-11-20 13:00:00', 'CIN', '0', 'BUF', '0', '0'), ('154', '11', '2016-11-20 13:00:00', 'KC', '0', 'TB', '0', '0'), ('155', '11', '2016-11-20 13:00:00', 'MIN', '0', 'ARI', '0', '0'), ('156', '11', '2016-11-20 13:00:00', 'NYG', '0', 'CHI', '0', '0'), ('157', '11', '2016-11-20 16:05:00', 'LA', '0', 'MIA', '0', '0'), ('158', '11', '2016-11-20 16:25:00', 'SF', '0', 'NE', '0', '0'), ('159', '11', '2016-11-20 16:25:00', 'SEA', '0', 'PHI', '0', '0'), ('160', '11', '2016-11-20 20:30:00', 'WAS', '0', 'GB', '0', '0'), ('161', '11', '2016-11-21 20:30:00', 'OAK', '0', 'HOU', '0', '0'), ('162', '12', '2016-11-24 12:30:00', 'DET', '0', 'MIN', '0', '0'), ('163', '12', '2016-11-24 16:30:00', 'DAL', '0', 'WAS', '0', '0'), ('164', '12', '2016-11-24 20:30:00', 'IND', '0', 'PIT', '0', '0'), ('165', '12', '2016-11-27 13:00:00', 'CHI', '0', 'TEN', '0', '0'), ('166', '12', '2016-11-27 13:00:00', 'BUF', '0', 'JAX', '0', '0'), ('167', '12', '2016-11-27 13:00:00', 'BAL', '0', 'CIN', '0', '0'), ('168', '12', '2016-11-27 13:00:00', 'ATL', '0', 'ARI', '0', '0'), ('169', '12', '2016-11-27 13:00:00', 'CLE', '0', 'NYG', '0', '0'), ('170', '12', '2016-11-27 13:00:00', 'HOU', '0', 'SD', '0', '0'), ('171', '12', '2016-11-27 13:00:00', 'MIA', '0', 'SF', '0', '0'), ('172', '12', '2016-11-27 13:00:00', 'NO', '0', 'LA', '0', '0'), ('173', '12', '2016-11-27 16:05:00', 'TB', '0', 'SEA', '0', '0'), ('174', '12', '2016-11-27 16:25:00', 'DEN', '0', 'KC', '0', '0'), ('175', '12', '2016-11-27 16:25:00', 'OAK', '0', 'CAR', '0', '0'), ('176', '12', '2016-11-27 20:30:00', 'NYJ', '0', 'NE', '0', '0'), ('177', '12', '2016-11-28 20:30:00', 'PHI', '0', 'GB', '0', '0'), ('178', '13', '2016-12-01 20:25:00', 'MIN', '0', 'DAL', '0', '0'), ('179', '13', '2016-12-04 13:00:00', 'ATL', '0', 'KC', '0', '0'), ('180', '13', '2016-12-04 13:00:00', 'BAL', '0', 'MIA', '0', '0'), ('181', '13', '2016-12-04 13:00:00', 'CHI', '0', 'SF', '0', '0'), ('182', '13', '2016-12-04 13:00:00', 'CIN', '0', 'PHI', '0', '0'), ('183', '13', '2016-12-04 13:00:00', 'GB', '0', 'HOU', '0', '0'), ('184', '13', '2016-12-04 13:00:00', 'JAX', '0', 'DEN', '0', '0'), ('185', '13', '2016-12-04 13:00:00', 'NE', '0', 'LA', '0', '0'), ('186', '13', '2016-12-04 13:00:00', 'NO', '0', 'DET', '0', '0'), ('187', '13', '2016-12-04 16:05:00', 'OAK', '0', 'BUF', '0', '0'), ('188', '13', '2016-12-04 16:25:00', 'ARI', '0', 'WAS', '0', '0'), ('189', '13', '2016-12-04 16:25:00', 'PIT', '0', 'NYG', '0', '0'), ('190', '13', '2016-12-04 16:25:00', 'SD', '0', 'TB', '0', '0'), ('191', '13', '2016-12-04 20:30:00', 'SEA', '0', 'CAR', '0', '0'), ('192', '13', '2016-12-05 20:30:00', 'NYJ', '0', 'IND', '0', '0'), ('193', '14', '2016-12-08 20:25:00', 'KC', '0', 'OAK', '0', '0'), ('194', '14', '2016-12-11 13:00:00', 'BUF', '0', 'PIT', '0', '0'), ('195', '14', '2016-12-11 13:00:00', 'CAR', '0', 'SD', '0', '0'), ('196', '14', '2016-12-11 13:00:00', 'CLE', '0', 'CIN', '0', '0'), ('197', '14', '2016-12-11 13:00:00', 'DET', '0', 'CHI', '0', '0'), ('198', '14', '2016-12-11 13:00:00', 'IND', '0', 'HOU', '0', '0'), ('199', '14', '2016-12-11 13:00:00', 'JAX', '0', 'MIN', '0', '0'), ('200', '14', '2016-12-11 13:00:00', 'MIA', '0', 'ARI', '0', '0'), ('201', '14', '2016-12-11 13:00:00', 'PHI', '0', 'WAS', '0', '0'), ('202', '14', '2016-12-11 13:00:00', 'TB', '0', 'NO', '0', '0'), ('203', '14', '2016-12-11 13:00:00', 'TEN', '0', 'DEN', '0', '0'), ('204', '14', '2016-12-11 16:05:00', 'SF', '0', 'NYJ', '0', '0'), ('205', '14', '2016-12-11 16:25:00', 'GB', '0', 'SEA', '0', '0'), ('206', '14', '2016-12-11 16:25:00', 'LA', '0', 'ATL', '0', '0'), ('207', '14', '2016-12-11 20:30:00', 'NYG', '0', 'DAL', '0', '0'), ('208', '14', '2016-12-12 20:30:00', 'NE', '0', 'BAL', '0', '0'), ('209', '15', '2016-12-15 20:25:00', 'SEA', '0', 'LA', '0', '0'), ('210', '15', '2016-12-17 20:25:00', 'NYJ', '0', 'MIA', '0', '0'), ('211', '15', '2016-12-18 13:00:00', 'CHI', '0', 'GB', '0', '0'), ('212', '15', '2016-12-18 13:00:00', 'DAL', '0', 'TB', '0', '0'), ('213', '15', '2016-12-18 13:00:00', 'HOU', '0', 'JAX', '0', '0'), ('214', '15', '2016-12-18 13:00:00', 'BUF', '0', 'CLE', '0', '0'), ('215', '15', '2016-12-18 13:00:00', 'BAL', '0', 'PHI', '0', '0'), ('216', '15', '2016-12-18 13:00:00', 'KC', '0', 'TEN', '0', '0'), ('217', '15', '2016-12-18 13:00:00', 'MIN', '0', 'IND', '0', '0'), ('218', '15', '2016-12-18 13:00:00', 'NYG', '0', 'DET', '0', '0'), ('219', '15', '2016-12-18 16:05:00', 'ARI', '0', 'NO', '0', '0'), ('220', '15', '2016-12-18 16:05:00', 'ATL', '0', 'SF', '0', '0'), ('221', '15', '2016-12-18 16:25:00', 'DEN', '0', 'NE', '0', '0'), ('222', '15', '2016-12-18 16:25:00', 'SD', '0', 'OAK', '0', '0'), ('223', '15', '2016-12-18 20:30:00', 'CIN', '0', 'PIT', '0', '0'), ('224', '15', '2016-12-19 20:30:00', 'WAS', '0', 'CAR', '0', '0'), ('225', '16', '2016-12-22 20:25:00', 'PHI', '0', 'NYG', '0', '0'), ('226', '16', '2016-12-24 13:00:00', 'BUF', '0', 'MIA', '0', '0'), ('227', '16', '2016-12-24 13:00:00', 'CAR', '0', 'ATL', '0', '0'), ('228', '16', '2016-12-24 13:00:00', 'CHI', '0', 'WAS', '0', '0'), ('229', '16', '2016-12-24 13:00:00', 'CLE', '0', 'SD', '0', '0'), ('230', '16', '2016-12-24 13:00:00', 'GB', '0', 'MIN', '0', '0'), ('231', '16', '2016-12-24 13:00:00', 'JAX', '0', 'TEN', '0', '0'), ('232', '16', '2016-12-24 13:00:00', 'NE', '0', 'NYJ', '0', '0'), ('233', '16', '2016-12-24 13:00:00', 'NO', '0', 'TB', '0', '0'), ('234', '16', '2016-12-24 16:05:00', 'OAK', '0', 'IND', '0', '0'), ('235', '16', '2016-12-24 16:25:00', 'SEA', '0', 'ARI', '0', '0'), ('236', '16', '2016-12-24 16:25:00', 'LA', '0', 'SF', '0', '0'), ('237', '16', '2016-12-24 20:25:00', 'HOU', '0', 'CIN', '0', '0'), ('238', '16', '2016-12-25 16:30:00', 'PIT', '0', 'BAL', '0', '0'), ('239', '16', '2016-12-25 20:30:00', 'KC', '0', 'DEN', '0', '0'), ('240', '16', '2016-12-26 20:30:00', 'DAL', '0', 'DET', '0', '0'), ('241', '17', '2017-01-01 13:00:00', 'ATL', '0', 'NO', '0', '0'), ('242', '17', '2017-01-01 13:00:00', 'DET', '0', 'GB', '0', '0'), ('243', '17', '2017-01-01 13:00:00', 'IND', '0', 'JAX', '0', '0'), ('244', '17', '2017-01-01 13:00:00', 'MIA', '0', 'NE', '0', '0'), ('245', '17', '2017-01-01 13:00:00', 'MIN', '0', 'CHI', '0', '0'), ('246', '17', '2017-01-01 13:00:00', 'NYJ', '0', 'BUF', '0', '0'), ('247', '17', '2017-01-01 13:00:00', 'PHI', '0', 'DAL', '0', '0'), ('248', '17', '2017-01-01 13:00:00', 'PIT', '0', 'CLE', '0', '0'), ('249', '17', '2017-01-01 13:00:00', 'TB', '0', 'CAR', '0', '0'), ('250', '17', '2017-01-01 13:00:00', 'TEN', '0', 'HOU', '0', '0'), ('251', '17', '2017-01-01 13:00:00', 'WAS', '0', 'NYG', '0', '0'), ('252', '17', '2017-01-01 13:00:00', 'CIN', '0', 'BAL', '0', '0'), ('253', '17', '2017-01-01 16:25:00', 'SF', '0', 'SEA', '0', '0'), ('254', '17', '2017-01-01 16:25:00', 'DEN', '0', 'OAK', '0', '0'), ('255', '17', '2017-01-01 16:25:00', 'LA', '0', 'ARI', '0', '0'), ('256', '17', '2017-01-01 16:25:00', 'SD', '0', 'KC', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `nflp_teams`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_teams`;
CREATE TABLE `nflp_teams` (
  `teamID` varchar(10) NOT NULL,
  `divisionID` int(11) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `team` varchar(50) DEFAULT NULL,
  `displayName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`teamID`),
  KEY `ID` (`teamID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `nflp_teams`
-- ----------------------------
BEGIN;
INSERT INTO `nflp_teams` VALUES ('ARI', '8', 'Arizona', 'Cardinals', null), ('ATL', '6', 'Atlanta', 'Falcons', null), ('BAL', '1', 'Baltimore', 'Ravens', null), ('BUF', '3', 'Buffalo', 'Bills', null), ('CAR', '6', 'Carolina', 'Panthers', null), ('CHI', '5', 'Chicago', 'Bears', null), ('CIN', '1', 'Cincinnati', 'Bengals', null), ('CLE', '1', 'Cleveland', 'Browns', null), ('DAL', '7', 'Dallas', 'Cowboys', null), ('DEN', '4', 'Denver', 'Broncos', null), ('DET', '5', 'Detroit', 'Lions', null), ('GB', '5', 'Green Bay', 'Packers', null), ('HOU', '2', 'Houston', 'Texans', null), ('IND', '2', 'Indianapolis', 'Colts', null), ('JAX', '2', 'Jacksonville', 'Jaguars', null), ('KC', '4', 'Kansas City', 'Chiefs', null), ('MIA', '3', 'Miami', 'Dolphins', null), ('MIN', '5', 'Minnesota', 'Vikings', null), ('NE', '3', 'New England', 'Patriots', null), ('NO', '6', 'New Orleans', 'Saints', null), ('NYG', '7', 'New York', 'Giants', 'NY Giants'), ('NYJ', '3', 'New York', 'Jets', 'NY Jets'), ('OAK', '4', 'Oakland', 'Raiders', null), ('PHI', '7', 'Philadelphia', 'Eagles', null), ('PIT', '1', 'Pittsburgh', 'Steelers', null), ('SD', '4', 'San Diego', 'Chargers', null), ('SEA', '8', 'Seattle', 'Seahawks', null), ('SF', '8', 'San Francisco', '49ers', null), ('LA', '8', 'Los Angeles', 'Rams', null), ('TB', '6', 'Tampa Bay', 'Buccaneers', null), ('TEN', '2', 'Tennessee', 'Titans', null), ('WAS', '7', 'Washington', 'Redskins', null);
COMMIT;

-- ----------------------------
--  Table structure for `nflp_users`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_users`;
CREATE TABLE `nflp_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `nflp_users`
-- ----------------------------
BEGIN;
INSERT INTO `nflp_users` VALUES ('1', 'admin', 'jl7LZ1B7ZNUq/RnVqnFmuwRXvMkO/DD5', 'Cb8Jjj0OPy', 'Admin', 'Admin', 'admin@yourdomain.com', '1', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
