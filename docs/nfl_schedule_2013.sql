/*
Navicat MySQL Data Transfer

Source Server         : _localhost
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : nflpickem

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2013-07-29 22:56:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `nflp_schedule`
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
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nflp_schedule
-- ----------------------------
INSERT INTO `nflp_schedule` VALUES ('1', '1', '2013-09-05 20:30:00', 'DEN', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('2', '1', '2013-09-08 13:00:00', 'BUF', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('3', '1', '2013-09-08 13:00:00', 'CHI', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('4', '1', '2013-09-08 13:00:00', 'CLE', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('5', '1', '2013-09-08 13:00:00', 'DET', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('6', '1', '2013-09-08 13:00:00', 'IND', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('7', '1', '2013-09-08 13:00:00', 'NO', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('8', '1', '2013-09-08 13:00:00', 'NYJ', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('9', '1', '2013-09-08 13:00:00', 'PIT', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('10', '1', '2013-09-08 13:00:00', 'CAR', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('11', '1', '2013-09-08 13:00:00', 'JAX', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('12', '1', '2013-09-08 16:25:00', 'STL', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('13', '1', '2013-09-08 16:25:00', 'SF', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('14', '1', '2013-09-08 20:30:00', 'DAL', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('15', '1', '2013-09-09 19:00:00', 'WAS', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('16', '1', '2013-09-09 22:15:00', 'SD', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('17', '2', '2013-09-12 20:25:00', 'NE', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('18', '2', '2013-09-15 13:00:00', 'ATL', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('19', '2', '2013-09-15 13:00:00', 'BUF', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('20', '2', '2013-09-15 13:00:00', 'CHI', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('21', '2', '2013-09-15 13:00:00', 'GB', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('22', '2', '2013-09-15 13:00:00', 'IND', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('23', '2', '2013-09-15 13:00:00', 'KC', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('24', '2', '2013-09-15 13:00:00', 'PHI', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('25', '2', '2013-09-15 13:00:00', 'BAL', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('26', '2', '2013-09-15 13:00:00', 'HOU', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('27', '2', '2013-09-15 16:05:00', 'ARI', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('28', '2', '2013-09-15 16:05:00', 'TB', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('29', '2', '2013-09-15 16:25:00', 'OAK', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('30', '2', '2013-09-15 16:25:00', 'NYG', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('31', '2', '2013-09-15 20:30:00', 'SEA', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('32', '2', '2013-09-16 20:30:00', 'CIN', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('33', '3', '2013-09-19 20:25:00', 'PHI', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('34', '3', '2013-09-22 13:00:00', 'CIN', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('35', '3', '2013-09-22 13:00:00', 'DAL', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('36', '3', '2013-09-22 13:00:00', 'TEN', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('37', '3', '2013-09-22 13:00:00', 'MIN', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('38', '3', '2013-09-22 13:00:00', 'NE', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('39', '3', '2013-09-22 13:00:00', 'NO', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('40', '3', '2013-09-22 13:00:00', 'WAS', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('41', '3', '2013-09-22 13:00:00', 'CAR', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('42', '3', '2013-09-22 13:00:00', 'BAL', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('43', '3', '2013-09-22 16:05:00', 'MIA', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('44', '3', '2013-09-22 16:25:00', 'NYJ', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('45', '3', '2013-09-22 16:25:00', 'SF', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('46', '3', '2013-09-22 16:25:00', 'SEA', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('47', '3', '2013-09-22 20:30:00', 'PIT', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('48', '3', '2013-09-23 20:30:00', 'DEN', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('49', '4', '2013-09-26 20:25:00', 'STL', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('50', '4', '2013-09-29 13:00:00', 'BUF', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('51', '4', '2013-09-29 13:00:00', 'CLE', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('52', '4', '2013-09-29 13:00:00', 'DET', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('53', '4', '2013-09-29 13:00:00', 'KC', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('54', '4', '2013-09-29 13:00:00', 'MIN', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('55', '4', '2013-09-29 13:00:00', 'TB', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('56', '4', '2013-09-29 13:00:00', 'JAX', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('57', '4', '2013-09-29 13:00:00', 'HOU', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('58', '4', '2013-09-29 16:05:00', 'TEN', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('59', '4', '2013-09-29 16:25:00', 'DEN', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('60', '4', '2013-09-29 16:25:00', 'OAK', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('61', '4', '2013-09-29 16:25:00', 'SD', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('62', '4', '2013-09-29 20:30:00', 'ATL', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('63', '4', '2013-09-30 20:30:00', 'NO', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('64', '5', '2013-10-03 20:25:00', 'CLE', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('65', '5', '2013-10-06 13:00:00', 'CHI', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('66', '5', '2013-10-06 13:00:00', 'CIN', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('67', '5', '2013-10-06 13:00:00', 'GB', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('68', '5', '2013-10-06 13:00:00', 'TEN', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('69', '5', '2013-10-06 13:00:00', 'IND', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('70', '5', '2013-10-06 13:00:00', 'STL', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('71', '5', '2013-10-06 13:00:00', 'MIA', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('72', '5', '2013-10-06 13:00:00', 'NYG', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('73', '5', '2013-10-06 16:05:00', 'ARI', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('74', '5', '2013-10-06 16:25:00', 'DAL', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('75', '5', '2013-10-06 16:25:00', 'OAK', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('76', '5', '2013-10-06 20:30:00', 'SF', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('77', '5', '2013-10-07 20:30:00', 'ATL', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('78', '6', '2013-10-10 20:25:00', 'CHI', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('79', '6', '2013-10-13 13:00:00', 'BUF', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('80', '6', '2013-10-13 13:00:00', 'CLE', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('81', '6', '2013-10-13 13:00:00', 'KC', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('82', '6', '2013-10-13 13:00:00', 'MIN', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('83', '6', '2013-10-13 13:00:00', 'NYJ', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('84', '6', '2013-10-13 13:00:00', 'TB', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('85', '6', '2013-10-13 13:00:00', 'BAL', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('86', '6', '2013-10-13 13:00:00', 'HOU', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('87', '6', '2013-10-13 16:05:00', 'DEN', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('88', '6', '2013-10-13 16:05:00', 'SEA', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('89', '6', '2013-10-13 16:25:00', 'NE', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('90', '6', '2013-10-13 16:25:00', 'SF', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('91', '6', '2013-10-13 20:30:00', 'DAL', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('92', '6', '2013-10-14 20:30:00', 'SD', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('93', '7', '2013-10-17 20:25:00', 'ARI', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('94', '7', '2013-10-20 13:00:00', 'ATL', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('95', '7', '2013-10-20 13:00:00', 'DET', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('96', '7', '2013-10-20 13:00:00', 'KC', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('97', '7', '2013-10-20 13:00:00', 'MIA', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('98', '7', '2013-10-20 13:00:00', 'NYJ', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('99', '7', '2013-10-20 13:00:00', 'PHI', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('100', '7', '2013-10-20 13:00:00', 'WAS', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('101', '7', '2013-10-20 13:00:00', 'CAR', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('102', '7', '2013-10-20 13:00:00', 'JAX', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('103', '7', '2013-10-20 16:05:00', 'TEN', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('104', '7', '2013-10-20 16:25:00', 'GB', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('105', '7', '2013-10-20 16:25:00', 'PIT', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('106', '7', '2013-10-20 20:30:00', 'IND', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('107', '7', '2013-10-21 20:30:00', 'NYG', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('108', '8', '2013-10-24 20:25:00', 'TB', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('109', '8', '2013-10-27 13:00:00', 'DET', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('110', '8', '2013-10-27 13:00:00', 'KC', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('111', '8', '2013-10-27 13:00:00', 'NE', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('112', '8', '2013-10-27 13:00:00', 'NO', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('113', '8', '2013-10-27 13:00:00', 'PHI', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('114', '8', '2013-10-27 13:00:00', 'JAX', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('115', '8', '2013-10-27 16:05:00', 'CIN', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('116', '8', '2013-10-27 16:05:00', 'OAK', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('117', '8', '2013-10-27 16:25:00', 'DEN', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('118', '8', '2013-10-27 16:25:00', 'ARI', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('119', '8', '2013-10-27 20:30:00', 'MIN', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('120', '8', '2013-10-28 20:30:00', 'STL', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('121', '9', '2013-10-31 20:25:00', 'MIA', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('122', '9', '2013-11-03 13:00:00', 'BUF', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('123', '9', '2013-11-03 13:00:00', 'DAL', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('124', '9', '2013-11-03 13:00:00', 'STL', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('125', '9', '2013-11-03 13:00:00', 'NYJ', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('126', '9', '2013-11-03 13:00:00', 'WAS', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('127', '9', '2013-11-03 13:00:00', 'CAR', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('128', '9', '2013-11-03 16:05:00', 'OAK', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('129', '9', '2013-11-03 16:05:00', 'SEA', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('130', '9', '2013-11-03 16:25:00', 'CLE', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('131', '9', '2013-11-03 16:25:00', 'NE', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('132', '9', '2013-11-03 20:30:00', 'HOU', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('133', '9', '2013-11-04 20:30:00', 'GB', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('134', '10', '2013-11-07 20:25:00', 'MIN', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('135', '10', '2013-11-10 13:00:00', 'ATL', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('136', '10', '2013-11-10 13:00:00', 'CHI', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('137', '10', '2013-11-10 13:00:00', 'GB', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('138', '10', '2013-11-10 13:00:00', 'TEN', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('139', '10', '2013-11-10 13:00:00', 'IND', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('140', '10', '2013-11-10 13:00:00', 'NYG', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('141', '10', '2013-11-10 13:00:00', 'PIT', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('142', '10', '2013-11-10 13:00:00', 'BAL', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('143', '10', '2013-11-10 16:05:00', 'SF', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('144', '10', '2013-11-10 16:25:00', 'ARI', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('145', '10', '2013-11-10 16:25:00', 'SD', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('146', '10', '2013-11-10 20:30:00', 'NO', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('147', '10', '2013-11-11 20:30:00', 'TB', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('148', '11', '2013-11-14 20:25:00', 'TEN', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('149', '11', '2013-11-17 13:00:00', 'BUF', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('150', '11', '2013-11-17 13:00:00', 'CHI', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('151', '11', '2013-11-17 13:00:00', 'CIN', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('152', '11', '2013-11-17 13:00:00', 'MIA', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('153', '11', '2013-11-17 13:00:00', 'PHI', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('154', '11', '2013-11-17 13:00:00', 'PIT', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('155', '11', '2013-11-17 13:00:00', 'TB', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('156', '11', '2013-11-17 13:00:00', 'JAX', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('157', '11', '2013-11-17 13:00:00', 'HOU', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('158', '11', '2013-11-17 16:05:00', 'DEN', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('159', '11', '2013-11-17 16:25:00', 'NO', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('160', '11', '2013-11-17 16:25:00', 'SEA', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('161', '11', '2013-11-17 20:30:00', 'NYG', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('162', '11', '2013-11-18 20:30:00', 'CAR', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('163', '12', '2013-11-21 20:25:00', 'ATL', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('164', '12', '2013-11-24 13:00:00', 'CLE', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('165', '12', '2013-11-24 13:00:00', 'DET', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('166', '12', '2013-11-24 13:00:00', 'GB', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('167', '12', '2013-11-24 13:00:00', 'KC', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('168', '12', '2013-11-24 13:00:00', 'STL', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('169', '12', '2013-11-24 13:00:00', 'MIA', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('170', '12', '2013-11-24 13:00:00', 'BAL', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('171', '12', '2013-11-24 13:00:00', 'HOU', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('172', '12', '2013-11-24 16:05:00', 'OAK', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('173', '12', '2013-11-24 16:05:00', 'ARI', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('174', '12', '2013-11-24 16:25:00', 'NYG', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('175', '12', '2013-11-24 20:30:00', 'NE', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('176', '12', '2013-11-25 20:30:00', 'WAS', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('177', '13', '2013-11-28 12:30:00', 'DET', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('178', '13', '2013-11-28 16:30:00', 'DAL', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('179', '13', '2013-11-28 20:30:00', 'BAL', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('180', '13', '2013-12-01 13:00:00', 'CLE', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('181', '13', '2013-12-01 13:00:00', 'IND', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('182', '13', '2013-12-01 13:00:00', 'KC', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('183', '13', '2013-12-01 13:00:00', 'MIN', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('184', '13', '2013-12-01 13:00:00', 'NYJ', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('185', '13', '2013-12-01 13:00:00', 'PHI', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('186', '13', '2013-12-01 13:00:00', 'CAR', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('187', '13', '2013-12-01 16:05:00', 'BUF', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('188', '13', '2013-12-01 16:05:00', 'SF', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('189', '13', '2013-12-01 16:25:00', 'SD', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('190', '13', '2013-12-01 16:25:00', 'HOU', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('191', '13', '2013-12-01 20:30:00', 'WAS', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('192', '13', '2013-12-02 20:30:00', 'SEA', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('193', '14', '2013-12-05 20:25:00', 'JAX', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('194', '14', '2013-12-08 13:00:00', 'CIN', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('195', '14', '2013-12-08 13:00:00', 'NE', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('196', '14', '2013-12-08 13:00:00', 'NO', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('197', '14', '2013-12-08 13:00:00', 'NYJ', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('198', '14', '2013-12-08 13:00:00', 'PHI', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('199', '14', '2013-12-08 13:00:00', 'PIT', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('200', '14', '2013-12-08 13:00:00', 'TB', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('201', '14', '2013-12-08 13:00:00', 'WAS', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('202', '14', '2013-12-08 13:00:00', 'BAL', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('203', '14', '2013-12-08 16:05:00', 'DEN', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('204', '14', '2013-12-08 16:25:00', 'ARI', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('205', '14', '2013-12-08 16:25:00', 'SD', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('206', '14', '2013-12-08 16:25:00', 'SF', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('207', '14', '2013-12-08 20:30:00', 'GB', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('208', '14', '2013-12-09 20:30:00', 'CHI', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('209', '15', '2013-12-12 20:25:00', 'DEN', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('210', '15', '2013-12-15 13:00:00', 'ATL', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('211', '15', '2013-12-15 13:00:00', 'CLE', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('212', '15', '2013-12-15 13:00:00', 'TEN', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('213', '15', '2013-12-15 13:00:00', 'IND', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('214', '15', '2013-12-15 13:00:00', 'STL', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('215', '15', '2013-12-15 13:00:00', 'MIA', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('216', '15', '2013-12-15 13:00:00', 'MIN', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('217', '15', '2013-12-15 13:00:00', 'NYG', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('218', '15', '2013-12-15 13:00:00', 'TB', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('219', '15', '2013-12-15 13:00:00', 'JAX', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('220', '15', '2013-12-15 16:05:00', 'OAK', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('221', '15', '2013-12-15 16:05:00', 'CAR', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('222', '15', '2013-12-15 16:25:00', 'DAL', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('223', '15', '2013-12-15 20:30:00', 'PIT', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('224', '15', '2013-12-16 20:30:00', 'DET', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('225', '16', '2013-12-22 13:00:00', 'BUF', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('226', '16', '2013-12-22 13:00:00', 'CIN', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('227', '16', '2013-12-22 13:00:00', 'KC', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('228', '16', '2013-12-22 13:00:00', 'STL', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('229', '16', '2013-12-22 13:00:00', 'NYJ', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('230', '16', '2013-12-22 13:00:00', 'PHI', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('231', '16', '2013-12-22 13:00:00', 'WAS', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('232', '16', '2013-12-22 13:00:00', 'CAR', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('233', '16', '2013-12-22 13:00:00', 'JAX', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('234', '16', '2013-12-22 13:00:00', 'HOU', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('235', '16', '2013-12-22 16:05:00', 'DET', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('236', '16', '2013-12-22 16:05:00', 'SEA', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('237', '16', '2013-12-22 16:25:00', 'GB', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('238', '16', '2013-12-22 16:25:00', 'SD', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('239', '16', '2013-12-22 20:30:00', 'BAL', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('240', '16', '2013-12-23 20:30:00', 'SF', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('241', '17', '2013-12-29 13:00:00', 'ATL', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('242', '17', '2013-12-29 13:00:00', 'CHI', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('243', '17', '2013-12-29 13:00:00', 'CIN', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('244', '17', '2013-12-29 13:00:00', 'DAL', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('245', '17', '2013-12-29 13:00:00', 'TEN', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('246', '17', '2013-12-29 13:00:00', 'IND', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('247', '17', '2013-12-29 13:00:00', 'MIA', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('248', '17', '2013-12-29 13:00:00', 'MIN', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('249', '17', '2013-12-29 13:00:00', 'NE', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('250', '17', '2013-12-29 13:00:00', 'NO', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('251', '17', '2013-12-29 13:00:00', 'NYG', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('252', '17', '2013-12-29 13:00:00', 'PIT', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('253', '17', '2013-12-29 16:25:00', 'OAK', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('254', '17', '2013-12-29 16:25:00', 'ARI', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('255', '17', '2013-12-29 16:25:00', 'SD', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('256', '17', '2013-12-29 16:25:00', 'SEA', null, 'STL', null, '0');
