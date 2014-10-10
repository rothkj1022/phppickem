/*
 Navicat MySQL Data Transfer

 Source Server         : _localhost
 Source Server Type    : MySQL
 Source Server Version : 50534
 Source Host           : localhost
 Source Database       : nflpickem

 Target Server Type    : MySQL
 Target Server Version : 50534
 File Encoding         : utf-8

 Date: 10/10/2014 17:33:48 PM
*/

SET NAMES utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `nflp_email_templates`
-- ----------------------------
INSERT INTO `nflp_email_templates` VALUES ('WEEKLY_PICKS_REMINDER', 'Weekly Picks Reminder', 'NFL Pick \'Em Week {week} Reminder', 'Hello {player},<br /><br />You are receiving this email because you do not yet have all of your picks in for week {week}.&nbsp; This is your reminder.&nbsp; The first game is {first_game} (Eastern), so to receive credit for that game, you\'ll have to make your pick before then.<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />', 'NFL Pick \'Em Week {week} Reminder', 'Hello {player},<br /><br />You are receiving this email because you do not yet have all of your picks in for week {week}.&nbsp; This is your reminder.&nbsp; The first game is {first_game} (Eastern), so to receive credit for that game, you\'ll have to make your pick before then.<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />');
INSERT INTO `nflp_email_templates` VALUES ('WEEKLY_RESULTS_REMINDER', 'Last Week Results/Reminder', 'NFL Pick \'Em Week {previousWeek} Standings/Reminder', 'Congratulations this week go to {winners} for winning week {previousWeek}.  The winner(s) had {winningScore} out of {possibleScore} picks correct.<br /><br />The current leaders are:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />*Reminder* - Please make your picks for week {week} before {first_game} (Eastern).<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />', 'NFL Pick \'Em Week {previousWeek} Standings/Reminder', 'Congratulations this week go to {winners} for winning week {previousWeek}.  The winner(s) had {winningScore} out of {possibleScore} picks correct.<br /><br />The current leaders are:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />*Reminder* - Please make your picks for week {week} before {first_game} (Eastern).<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />');
INSERT INTO `nflp_email_templates` VALUES ('FINAL_RESULTS', 'Final Results', 'NFL Pick \'Em 2014 Final Results', 'Congratulations this week go to {winners} for winning week\r\n{previousWeek}. The winner(s) had {winningScore} out of {possibleScore}\r\npicks correct.<br /><br /><span style=\"font-weight: bold;\">Congratulations to {final_winner}</span> for winning NFL Pick \'Em 2014!&nbsp; {final_winner} had {final_winningScore} wins and had a pick ratio of {picks}/{possible} ({pickpercent}%).<br /><br />Top Wins:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />Thanks for playing, and I hope to see you all again for NFL Pick \'Em 2012!', 'NFL Pick \'Em 2014 Final Results', 'Congratulations this week go to {winners} for winning week\r\n{previousWeek}. The winner(s) had {winningScore} out of {possibleScore}\r\npicks correct.<br /><br /><span style=\"font-weight: bold;\">Congratulations to {final_winner}</span> for winning NFL Pick \'Em 2014!&nbsp; {final_winner} had {final_winningScore} wins and had a pick ratio of {picks}/{possible} ({pickpercent}%).<br /><br />Top Wins:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />Thanks for playing, and I hope to see you all again for NFL Pick \'Em 2012!');

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
--  Records of `nflp_picks`
-- ----------------------------

-- ----------------------------
--  Table structure for `nflp_picksummary`
-- ----------------------------
DROP TABLE IF EXISTS `nflp_picksummary`;
CREATE TABLE `nflp_picksummary` (
  `weekNum` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `tieBreakerPoints` int(11) NOT NULL,
  `showPicks` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`weekNum`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
--  Records of `nflp_picksummary`
-- ----------------------------

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
INSERT INTO `nflp_schedule` VALUES ('1', '1', '2014-09-04 20:30:00', 'SEA', '36', 'GB', '16', '0'), ('2', '1', '2014-09-07 13:00:00', 'ATL', '37', 'NO', '34', '1'), ('3', '1', '2014-09-07 13:00:00', 'CHI', '20', 'BUF', '23', '1'), ('4', '1', '2014-09-07 13:00:00', 'KC', '10', 'TEN', '26', '0'), ('5', '1', '2014-09-07 13:00:00', 'STL', '6', 'MIN', '34', '0'), ('6', '1', '2014-09-07 13:00:00', 'MIA', '33', 'NE', '20', '0'), ('7', '1', '2014-09-07 13:00:00', 'NYJ', '19', 'OAK', '14', '0'), ('8', '1', '2014-09-07 13:00:00', 'PHI', '34', 'JAX', '17', '0'), ('9', '1', '2014-09-07 13:00:00', 'PIT', '30', 'CLE', '27', '0'), ('10', '1', '2014-09-07 13:00:00', 'BAL', '16', 'CIN', '23', '0'), ('11', '1', '2014-09-07 13:00:00', 'HOU', '17', 'WAS', '6', '0'), ('12', '1', '2014-09-07 16:25:00', 'DAL', '17', 'SF', '28', '0'), ('13', '1', '2014-09-07 16:25:00', 'TB', '14', 'CAR', '20', '0'), ('14', '1', '2014-09-07 20:30:00', 'DEN', '31', 'IND', '24', '0'), ('15', '1', '2014-09-08 19:10:00', 'DET', '35', 'NYG', '14', '0'), ('16', '1', '2014-09-08 22:20:00', 'ARI', '18', 'SD', '17', '0'), ('17', '2', '2014-09-11 20:25:00', 'BAL', '26', 'PIT', '6', '0'), ('18', '2', '2014-09-14 13:00:00', 'BUF', '29', 'MIA', '10', '0'), ('19', '2', '2014-09-14 13:00:00', 'CIN', '24', 'ATL', '10', '0'), ('20', '2', '2014-09-14 13:00:00', 'CLE', '26', 'NO', '24', '0'), ('21', '2', '2014-09-14 13:00:00', 'TEN', '10', 'DAL', '26', '0'), ('22', '2', '2014-09-14 13:00:00', 'MIN', '7', 'NE', '30', '0'), ('23', '2', '2014-09-14 13:00:00', 'NYG', '14', 'ARI', '25', '0'), ('24', '2', '2014-09-14 13:00:00', 'WAS', '41', 'JAX', '10', '0'), ('25', '2', '2014-09-14 13:00:00', 'CAR', '24', 'DET', '7', '0'), ('26', '2', '2014-09-14 16:05:00', 'SD', '30', 'SEA', '21', '0'), ('27', '2', '2014-09-14 16:05:00', 'TB', '17', 'STL', '19', '0'), ('28', '2', '2014-09-14 16:25:00', 'DEN', '24', 'KC', '17', '0'), ('29', '2', '2014-09-14 16:25:00', 'GB', '31', 'NYJ', '24', '0'), ('30', '2', '2014-09-14 16:25:00', 'OAK', '14', 'HOU', '30', '0'), ('31', '2', '2014-09-14 20:30:00', 'SF', '20', 'CHI', '28', '0'), ('32', '2', '2014-09-15 20:30:00', 'IND', '27', 'PHI', '30', '0'), ('33', '3', '2014-09-18 20:25:00', 'ATL', null, 'TB', null, '0'), ('34', '3', '2014-09-21 13:00:00', 'BUF', null, 'SD', null, '0'), ('35', '3', '2014-09-21 13:00:00', 'CIN', null, 'TEN', null, '0'), ('36', '3', '2014-09-21 13:00:00', 'CLE', null, 'BAL', null, '0'), ('37', '3', '2014-09-21 13:00:00', 'DET', null, 'GB', null, '0'), ('38', '3', '2014-09-21 13:00:00', 'STL', null, 'DAL', null, '0'), ('39', '3', '2014-09-21 13:00:00', 'NE', null, 'OAK', null, '0'), ('40', '3', '2014-09-21 13:00:00', 'NO', null, 'MIN', null, '0'), ('41', '3', '2014-09-21 13:00:00', 'NYG', null, 'HOU', null, '0'), ('42', '3', '2014-09-21 13:00:00', 'PHI', null, 'WAS', null, '0'), ('43', '3', '2014-09-21 13:00:00', 'JAX', null, 'IND', null, '0'), ('44', '3', '2014-09-21 16:05:00', 'ARI', null, 'SF', null, '0'), ('45', '3', '2014-09-21 16:25:00', 'MIA', null, 'KC', null, '0'), ('46', '3', '2014-09-21 16:25:00', 'SEA', null, 'DEN', null, '0'), ('47', '3', '2014-09-21 20:30:00', 'CAR', null, 'PIT', null, '0'), ('48', '3', '2014-09-22 20:30:00', 'NYJ', null, 'CHI', null, '0'), ('49', '4', '2014-09-25 20:25:00', 'WAS', null, 'NYG', null, '0'), ('50', '4', '2014-09-28 13:00:00', 'CHI', null, 'GB', null, '0'), ('51', '4', '2014-09-28 13:00:00', 'IND', null, 'TEN', null, '0'), ('52', '4', '2014-09-28 13:00:00', 'OAK', null, 'MIA', null, '0'), ('53', '4', '2014-09-28 13:00:00', 'NYJ', null, 'DET', null, '0'), ('54', '4', '2014-09-28 13:00:00', 'PIT', null, 'TB', null, '0'), ('55', '4', '2014-09-28 13:00:00', 'BAL', null, 'CAR', null, '0'), ('56', '4', '2014-09-28 13:00:00', 'HOU', null, 'BUF', null, '0'), ('57', '4', '2014-09-28 16:05:00', 'SD', null, 'JAX', null, '0'), ('58', '4', '2014-09-28 16:25:00', 'MIN', null, 'ATL', null, '0'), ('59', '4', '2014-09-28 16:25:00', 'SF', null, 'PHI', null, '0'), ('60', '4', '2014-09-28 20:30:00', 'DAL', null, 'NO', null, '0'), ('61', '4', '2014-09-29 20:30:00', 'KC', null, 'NE', null, '0'), ('62', '5', '2014-10-02 20:25:00', 'GB', null, 'MIN', null, '0'), ('63', '5', '2014-10-05 13:00:00', 'DAL', null, 'HOU', null, '0'), ('64', '5', '2014-10-05 13:00:00', 'DET', null, 'BUF', null, '0'), ('65', '5', '2014-10-05 13:00:00', 'TEN', null, 'CLE', null, '0'), ('66', '5', '2014-10-05 13:00:00', 'IND', null, 'BAL', null, '0'), ('67', '5', '2014-10-05 13:00:00', 'NO', null, 'TB', null, '0'), ('68', '5', '2014-10-05 13:00:00', 'NYG', null, 'ATL', null, '0'), ('69', '5', '2014-10-05 13:00:00', 'PHI', null, 'STL', null, '0'), ('70', '5', '2014-10-05 13:00:00', 'CAR', null, 'CHI', null, '0'), ('71', '5', '2014-10-05 13:00:00', 'JAX', null, 'PIT', null, '0'), ('72', '5', '2014-10-05 16:05:00', 'DEN', null, 'ARI', null, '0'), ('73', '5', '2014-10-05 16:25:00', 'SD', null, 'NYJ', null, '0'), ('74', '5', '2014-10-05 16:25:00', 'SF', null, 'KC', null, '0'), ('75', '5', '2014-10-05 20:30:00', 'NE', null, 'CIN', null, '0'), ('76', '5', '2014-10-06 20:30:00', 'WAS', null, 'SEA', null, '0'), ('77', '6', '2014-10-09 20:25:00', 'HOU', null, 'IND', null, '0'), ('78', '6', '2014-10-12 13:00:00', 'ATL', null, 'CHI', null, '0'), ('79', '6', '2014-10-12 13:00:00', 'BUF', null, 'NE', null, '0'), ('80', '6', '2014-10-12 13:00:00', 'CIN', null, 'CAR', null, '0'), ('81', '6', '2014-10-12 13:00:00', 'CLE', null, 'PIT', null, '0'), ('82', '6', '2014-10-12 13:00:00', 'TEN', null, 'JAX', null, '0'), ('83', '6', '2014-10-12 13:00:00', 'MIA', null, 'GB', null, '0'), ('84', '6', '2014-10-12 13:00:00', 'MIN', null, 'DET', null, '0'), ('85', '6', '2014-10-12 13:00:00', 'NYJ', null, 'DEN', null, '0'), ('86', '6', '2014-10-12 13:00:00', 'TB', null, 'BAL', null, '0'), ('87', '6', '2014-10-12 16:05:00', 'OAK', null, 'SD', null, '0'), ('88', '6', '2014-10-12 16:25:00', 'ARI', null, 'WAS', null, '0'), ('89', '6', '2014-10-12 16:25:00', 'SEA', null, 'DAL', null, '0'), ('90', '6', '2014-10-12 20:30:00', 'PHI', null, 'NYG', null, '0'), ('91', '6', '2014-10-13 20:30:00', 'STL', null, 'SF', null, '0'), ('92', '7', '2014-10-16 20:25:00', 'NE', null, 'NYJ', null, '0'), ('93', '7', '2014-10-19 13:00:00', 'BUF', null, 'MIN', null, '0'), ('94', '7', '2014-10-19 13:00:00', 'CHI', null, 'MIA', null, '0'), ('95', '7', '2014-10-19 13:00:00', 'DET', null, 'NO', null, '0'), ('96', '7', '2014-10-19 13:00:00', 'GB', null, 'CAR', null, '0'), ('97', '7', '2014-10-19 13:00:00', 'IND', null, 'CIN', null, '0'), ('98', '7', '2014-10-19 13:00:00', 'STL', null, 'SEA', null, '0'), ('99', '7', '2014-10-19 13:00:00', 'WAS', null, 'TEN', null, '0'), ('100', '7', '2014-10-19 13:00:00', 'JAX', null, 'CLE', null, '0'), ('101', '7', '2014-10-19 13:00:00', 'BAL', null, 'ATL', null, '0'), ('102', '7', '2014-10-19 16:05:00', 'SD', null, 'KC', null, '0'), ('103', '7', '2014-10-19 16:25:00', 'DAL', null, 'NYG', null, '0'), ('104', '7', '2014-10-19 16:25:00', 'OAK', null, 'ARI', null, '0'), ('105', '7', '2014-10-19 20:30:00', 'DEN', null, 'SF', null, '0'), ('106', '7', '2014-10-20 20:30:00', 'PIT', null, 'HOU', null, '0'), ('107', '8', '2014-10-23 20:25:00', 'DEN', null, 'SD', null, '0'), ('108', '8', '2014-10-26 09:30:00', 'ATL', null, 'DET', null, '0'), ('109', '8', '2014-10-26 13:00:00', 'CIN', null, 'BAL', null, '0'), ('110', '8', '2014-10-26 13:00:00', 'TEN', null, 'HOU', null, '0'), ('111', '8', '2014-10-26 13:00:00', 'KC', null, 'STL', null, '0'), ('112', '8', '2014-10-26 13:00:00', 'NE', null, 'CHI', null, '0'), ('113', '8', '2014-10-26 13:00:00', 'NYJ', null, 'BUF', null, '0'), ('114', '8', '2014-10-26 13:00:00', 'TB', null, 'MIN', null, '0'), ('115', '8', '2014-10-26 13:00:00', 'CAR', null, 'SEA', null, '0'), ('116', '8', '2014-10-26 13:00:00', 'JAX', null, 'MIA', null, '0'), ('117', '8', '2014-10-26 16:05:00', 'ARI', null, 'PHI', null, '0'), ('118', '8', '2014-10-26 16:25:00', 'CLE', null, 'OAK', null, '0'), ('119', '8', '2014-10-26 16:25:00', 'PIT', null, 'IND', null, '0'), ('120', '8', '2014-10-26 20:30:00', 'NO', null, 'GB', null, '0'), ('121', '8', '2014-10-27 20:30:00', 'DAL', null, 'WAS', null, '0'), ('122', '9', '2014-10-30 20:25:00', 'CAR', null, 'NO', null, '0'), ('123', '9', '2014-11-02 13:00:00', 'CIN', null, 'JAX', null, '0'), ('124', '9', '2014-11-02 13:00:00', 'CLE', null, 'TB', null, '0'), ('125', '9', '2014-11-02 13:00:00', 'DAL', null, 'ARI', null, '0'), ('126', '9', '2014-11-02 13:00:00', 'KC', null, 'NYJ', null, '0'), ('127', '9', '2014-11-02 13:00:00', 'MIA', null, 'SD', null, '0'), ('128', '9', '2014-11-02 13:00:00', 'MIN', null, 'WAS', null, '0'), ('129', '9', '2014-11-02 13:00:00', 'HOU', null, 'PHI', null, '0'), ('130', '9', '2014-11-02 16:05:00', 'SF', null, 'STL', null, '0'), ('131', '9', '2014-11-02 16:25:00', 'NE', null, 'DEN', null, '0'), ('132', '9', '2014-11-02 16:25:00', 'SEA', null, 'OAK', null, '0'), ('133', '9', '2014-11-02 20:30:00', 'PIT', null, 'BAL', null, '0'), ('134', '9', '2014-11-03 20:30:00', 'NYG', null, 'IND', null, '0'), ('135', '10', '2014-11-06 20:25:00', 'CIN', null, 'CLE', null, '0'), ('136', '10', '2014-11-09 13:00:00', 'BUF', null, 'KC', null, '0'), ('137', '10', '2014-11-09 13:00:00', 'DET', null, 'MIA', null, '0'), ('138', '10', '2014-11-09 13:00:00', 'NO', null, 'SF', null, '0'), ('139', '10', '2014-11-09 13:00:00', 'NYJ', null, 'PIT', null, '0'), ('140', '10', '2014-11-09 13:00:00', 'TB', null, 'ATL', null, '0'), ('141', '10', '2014-11-09 13:00:00', 'JAX', null, 'DAL', null, '0'), ('142', '10', '2014-11-09 13:00:00', 'BAL', null, 'TEN', null, '0'), ('143', '10', '2014-11-09 16:05:00', 'OAK', null, 'DEN', null, '0'), ('144', '10', '2014-11-09 16:25:00', 'ARI', null, 'STL', null, '0'), ('145', '10', '2014-11-09 16:25:00', 'SEA', null, 'NYG', null, '0'), ('146', '10', '2014-11-09 20:30:00', 'GB', null, 'CHI', null, '0'), ('147', '10', '2014-11-10 20:30:00', 'PHI', null, 'CAR', null, '0'), ('148', '11', '2014-11-13 20:25:00', 'MIA', null, 'BUF', null, '0'), ('149', '11', '2014-11-16 13:00:00', 'CHI', null, 'MIN', null, '0'), ('150', '11', '2014-11-16 13:00:00', 'CLE', null, 'HOU', null, '0'), ('151', '11', '2014-11-16 13:00:00', 'GB', null, 'PHI', null, '0'), ('152', '11', '2014-11-16 13:00:00', 'KC', null, 'SEA', null, '0'), ('153', '11', '2014-11-16 13:00:00', 'STL', null, 'DEN', null, '0'), ('154', '11', '2014-11-16 13:00:00', 'NO', null, 'CIN', null, '0'), ('155', '11', '2014-11-16 13:00:00', 'NYG', null, 'SF', null, '0'), ('156', '11', '2014-11-16 13:00:00', 'WAS', null, 'TB', null, '0'), ('157', '11', '2014-11-16 13:00:00', 'CAR', null, 'ATL', null, '0'), ('158', '11', '2014-11-16 16:05:00', 'SD', null, 'OAK', null, '0'), ('159', '11', '2014-11-16 16:25:00', 'ARI', null, 'DET', null, '0'), ('160', '11', '2014-11-16 20:30:00', 'IND', null, 'NE', null, '0'), ('161', '11', '2014-11-17 20:30:00', 'TEN', null, 'PIT', null, '0'), ('162', '12', '2014-11-20 20:25:00', 'OAK', null, 'KC', null, '0'), ('163', '12', '2014-11-23 13:00:00', 'ATL', null, 'CLE', null, '0'), ('164', '12', '2014-11-23 13:00:00', 'BUF', null, 'NYJ', null, '0'), ('165', '12', '2014-11-23 13:00:00', 'CHI', null, 'TB', null, '0'), ('166', '12', '2014-11-23 13:00:00', 'IND', null, 'JAX', null, '0'), ('167', '12', '2014-11-23 13:00:00', 'MIN', null, 'GB', null, '0'), ('168', '12', '2014-11-23 13:00:00', 'NE', null, 'DET', null, '0'), ('169', '12', '2014-11-23 13:00:00', 'PHI', null, 'TEN', null, '0'), ('170', '12', '2014-11-23 13:00:00', 'HOU', null, 'CIN', null, '0'), ('171', '12', '2014-11-23 16:05:00', 'SD', null, 'STL', null, '0'), ('172', '12', '2014-11-23 16:05:00', 'SEA', null, 'ARI', null, '0'), ('173', '12', '2014-11-23 16:25:00', 'DEN', null, 'MIA', null, '0'), ('174', '12', '2014-11-23 16:25:00', 'SF', null, 'WAS', null, '0'), ('175', '12', '2014-11-23 20:30:00', 'NYG', null, 'DAL', null, '0'), ('176', '12', '2014-11-24 20:30:00', 'NO', null, 'BAL', null, '0'), ('177', '13', '2014-11-27 12:30:00', 'DET', null, 'CHI', null, '0'), ('178', '13', '2014-11-27 16:30:00', 'DAL', null, 'PHI', null, '0'), ('179', '13', '2014-11-27 20:30:00', 'SF', null, 'SEA', null, '0'), ('180', '13', '2014-11-30 13:00:00', 'BUF', null, 'CLE', null, '0'), ('181', '13', '2014-11-30 13:00:00', 'IND', null, 'WAS', null, '0'), ('182', '13', '2014-11-30 13:00:00', 'STL', null, 'OAK', null, '0'), ('183', '13', '2014-11-30 13:00:00', 'MIN', null, 'CAR', null, '0'), ('184', '13', '2014-11-30 13:00:00', 'PIT', null, 'NO', null, '0'), ('185', '13', '2014-11-30 13:00:00', 'TB', null, 'CIN', null, '0'), ('186', '13', '2014-11-30 13:00:00', 'JAX', null, 'NYG', null, '0'), ('187', '13', '2014-11-30 13:00:00', 'BAL', null, 'SD', null, '0'), ('188', '13', '2014-11-30 13:00:00', 'HOU', null, 'TEN', null, '0'), ('189', '13', '2014-11-30 16:05:00', 'ATL', null, 'ARI', null, '0'), ('190', '13', '2014-11-30 16:25:00', 'GB', null, 'NE', null, '0'), ('191', '13', '2014-11-30 20:30:00', 'KC', null, 'DEN', null, '0'), ('192', '13', '2014-12-01 20:30:00', 'NYJ', null, 'MIA', null, '0'), ('193', '14', '2014-12-04 20:25:00', 'CHI', null, 'DAL', null, '0'), ('194', '14', '2014-12-07 13:00:00', 'CIN', null, 'PIT', null, '0'), ('195', '14', '2014-12-07 13:00:00', 'CLE', null, 'IND', null, '0'), ('196', '14', '2014-12-07 13:00:00', 'DET', null, 'TB', null, '0'), ('197', '14', '2014-12-07 13:00:00', 'TEN', null, 'NYG', null, '0'), ('198', '14', '2014-12-07 13:00:00', 'MIA', null, 'BAL', null, '0'), ('199', '14', '2014-12-07 13:00:00', 'MIN', null, 'NYJ', null, '0'), ('200', '14', '2014-12-07 13:00:00', 'NO', null, 'CAR', null, '0'), ('201', '14', '2014-12-07 13:00:00', 'WAS', null, 'STL', null, '0'), ('202', '14', '2014-12-07 13:00:00', 'JAX', null, 'HOU', null, '0'), ('203', '14', '2014-12-07 16:05:00', 'DEN', null, 'BUF', null, '0'), ('204', '14', '2014-12-07 16:05:00', 'ARI', null, 'KC', null, '0'), ('205', '14', '2014-12-07 16:25:00', 'OAK', null, 'SF', null, '0'), ('206', '14', '2014-12-07 16:25:00', 'PHI', null, 'SEA', null, '0'), ('207', '14', '2014-12-07 20:30:00', 'SD', null, 'NE', null, '0'), ('208', '14', '2014-12-08 20:30:00', 'GB', null, 'ATL', null, '0'), ('209', '15', '2014-12-11 20:25:00', 'STL', null, 'ARI', null, '0'), ('210', '15', '2014-12-14 13:00:00', 'ATL', null, 'PIT', null, '0'), ('211', '15', '2014-12-14 13:00:00', 'BUF', null, 'GB', null, '0'), ('212', '15', '2014-12-14 13:00:00', 'CLE', null, 'CIN', null, '0'), ('213', '15', '2014-12-14 13:00:00', 'DET', null, 'MIN', null, '0'), ('214', '15', '2014-12-14 13:00:00', 'IND', null, 'HOU', null, '0'), ('215', '15', '2014-12-14 13:00:00', 'KC', null, 'OAK', null, '0'), ('216', '15', '2014-12-14 13:00:00', 'NE', null, 'MIA', null, '0'), ('217', '15', '2014-12-14 13:00:00', 'NYG', null, 'WAS', null, '0'), ('218', '15', '2014-12-14 13:00:00', 'CAR', null, 'TB', null, '0'), ('219', '15', '2014-12-14 13:00:00', 'BAL', null, 'JAX', null, '0'), ('220', '15', '2014-12-14 16:05:00', 'TEN', null, 'NYJ', null, '0'), ('221', '15', '2014-12-14 16:05:00', 'SD', null, 'DEN', null, '0'), ('222', '15', '2014-12-14 16:25:00', 'SEA', null, 'SF', null, '0'), ('223', '15', '2014-12-14 20:30:00', 'PHI', null, 'DAL', null, '0'), ('224', '15', '2014-12-15 20:30:00', 'CHI', null, 'NO', null, '0'), ('225', '16', '2014-12-18 20:25:00', 'JAX', null, 'TEN', null, '0'), ('226', '16', '1970-01-01 01:00:00', 'SF', null, 'SD', null, '0'), ('227', '16', '1970-01-01 01:00:00', 'WAS', null, 'PHI', null, '0'), ('228', '16', '2014-12-21 13:00:00', 'CHI', null, 'DET', null, '0'), ('229', '16', '2014-12-21 13:00:00', 'MIA', null, 'MIN', null, '0'), ('230', '16', '2014-12-21 13:00:00', 'NO', null, 'ATL', null, '0'), ('231', '16', '2014-12-21 13:00:00', 'NYJ', null, 'NE', null, '0'), ('232', '16', '2014-12-21 13:00:00', 'PIT', null, 'KC', null, '0'), ('233', '16', '2014-12-21 13:00:00', 'TB', null, 'GB', null, '0'), ('234', '16', '2014-12-21 13:00:00', 'CAR', null, 'CLE', null, '0'), ('235', '16', '2014-12-21 13:00:00', 'HOU', null, 'BAL', null, '0'), ('236', '16', '2014-12-21 16:05:00', 'STL', null, 'NYG', null, '0'), ('237', '16', '2014-12-21 16:25:00', 'DAL', null, 'IND', null, '0'), ('238', '16', '2014-12-21 16:25:00', 'OAK', null, 'BUF', null, '0'), ('239', '16', '2014-12-21 20:30:00', 'ARI', null, 'SEA', null, '0'), ('240', '16', '2014-12-22 20:30:00', 'CIN', null, 'DEN', null, '0'), ('241', '17', '2014-12-28 13:00:00', 'ATL', null, 'CAR', null, '0'), ('242', '17', '2014-12-28 13:00:00', 'GB', null, 'DET', null, '0'), ('243', '17', '2014-12-28 13:00:00', 'TEN', null, 'IND', null, '0'), ('244', '17', '2014-12-28 13:00:00', 'KC', null, 'SD', null, '0'), ('245', '17', '2014-12-28 13:00:00', 'MIA', null, 'NYJ', null, '0'), ('246', '17', '2014-12-28 13:00:00', 'MIN', null, 'CHI', null, '0'), ('247', '17', '2014-12-28 13:00:00', 'NE', null, 'BUF', null, '0'), ('248', '17', '2014-12-28 13:00:00', 'NYG', null, 'PHI', null, '0'), ('249', '17', '2014-12-28 13:00:00', 'PIT', null, 'CIN', null, '0'), ('250', '17', '2014-12-28 13:00:00', 'TB', null, 'NO', null, '0'), ('251', '17', '2014-12-28 13:00:00', 'WAS', null, 'DAL', null, '0'), ('252', '17', '2014-12-28 13:00:00', 'BAL', null, 'CLE', null, '0'), ('253', '17', '2014-12-28 13:00:00', 'HOU', null, 'JAX', null, '0'), ('254', '17', '2014-12-28 16:25:00', 'DEN', null, 'OAK', null, '0'), ('255', '17', '2014-12-28 16:25:00', 'SF', null, 'ARI', null, '0'), ('256', '17', '2014-12-28 16:25:00', 'SEA', null, 'STL', null, '0');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `nflp_teams`
-- ----------------------------
BEGIN;
INSERT INTO `nflp_teams` VALUES ('ARI', '8', 'Arizona', 'Cardinals', null), ('ATL', '6', 'Atlanta', 'Falcons', null), ('BAL', '1', 'Baltimore', 'Ravens', null), ('BUF', '3', 'Buffalo', 'Bills', null), ('CAR', '6', 'Carolina', 'Panthers', null), ('CHI', '5', 'Chicago', 'Bears', null), ('CIN', '1', 'Cincinnati', 'Bengals', null), ('CLE', '1', 'Cleveland', 'Browns', null), ('DAL', '7', 'Dallas', 'Cowboys', null), ('DEN', '4', 'Denver', 'Broncos', null), ('DET', '5', 'Detroit', 'Lions', null), ('GB', '5', 'Green Bay', 'Packers', null), ('HOU', '2', 'Houston', 'Texans', null), ('IND', '2', 'Indianapolis', 'Colts', null), ('JAX', '2', 'Jacksonville', 'Jaguars', null), ('KC', '4', 'Kansas City', 'Chiefs', null), ('MIA', '3', 'Miami', 'Dolphins', null), ('MIN', '5', 'Minnesota', 'Vikings', null), ('NE', '3', 'New England', 'Patriots', null), ('NO', '6', 'New Orleans', 'Saints', null), ('NYG', '7', 'New York', 'Giants', 'NY Giants'), ('NYJ', '3', 'New York', 'Jets', 'NY Jets'), ('OAK', '4', 'Oakland', 'Raiders', null), ('PHI', '7', 'Philadelphia', 'Eagles', null), ('PIT', '1', 'Pittsburgh', 'Steelers', null), ('SD', '4', 'San Diego', 'Chargers', null), ('SEA', '8', 'Seattle', 'Seahawks', null), ('SF', '8', 'San Francisco', '49ers', null), ('STL', '8', 'St. Louis', 'Rams', null), ('TB', '6', 'Tampa Bay', 'Buccaneers', null), ('TEN', '2', 'Tennessee', 'Titans', null), ('WAS', '7', 'Washington', 'Redskins', null);
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
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `nflp_users`
-- ----------------------------
INSERT INTO `nflp_users` VALUES ('1', 'admin', 'jl7LZ1B7ZNUq/RnVqnFmuwRXvMkO/DD5', 'Cb8Jjj0OPy', 'Admin', 'Admin', 'admin@yourdomain.com', '1');
