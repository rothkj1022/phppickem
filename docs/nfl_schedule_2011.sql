/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50137
Source Host           : localhost:3306
Source Database       : nflpickem

Target Server Type    : MYSQL
Target Server Version : 50137
File Encoding         : 65001

Date: 2011-05-11 11:29:09
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
INSERT INTO `nflp_schedule` VALUES ('1', '1', '2011-09-08 20:30:00', 'GB', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('2', '1', '2011-09-11 13:00:00', 'CHI', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('3', '1', '2011-09-11 13:00:00', 'CLE', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('4', '1', '2011-09-11 13:00:00', 'KC', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('5', '1', '2011-09-11 13:00:00', 'STL', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('6', '1', '2011-09-11 13:00:00', 'TB', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('7', '1', '2011-09-11 13:00:00', 'JAX', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('8', '1', '2011-09-11 13:00:00', 'BAL', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('9', '1', '2011-09-11 13:00:00', 'HOU', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('10', '1', '2011-09-11 16:15:00', 'ARI', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('11', '1', '2011-09-11 16:15:00', 'SD', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('12', '1', '2011-09-11 16:15:00', 'SF', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('13', '1', '2011-09-11 16:15:00', 'WAS', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('14', '1', '2011-09-11 20:20:00', 'NYJ', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('15', '1', '2011-09-12 19:00:00', 'MIA', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('16', '1', '2011-09-12 22:15:00', 'DEN', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('17', '2', '2011-09-18 13:00:00', 'BUF', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('18', '2', '2011-09-18 13:00:00', 'DET', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('19', '2', '2011-09-18 13:00:00', 'TEN', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('20', '2', '2011-09-18 13:00:00', 'IND', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('21', '2', '2011-09-18 13:00:00', 'MIN', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('22', '2', '2011-09-18 13:00:00', 'NO', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('23', '2', '2011-09-18 13:00:00', 'NYJ', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('24', '2', '2011-09-18 13:00:00', 'PIT', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('25', '2', '2011-09-18 13:00:00', 'WAS', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('26', '2', '2011-09-18 13:00:00', 'CAR', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('27', '2', '2011-09-18 16:05:00', 'SF', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('28', '2', '2011-09-18 16:15:00', 'DEN', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('29', '2', '2011-09-18 16:15:00', 'MIA', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('30', '2', '2011-09-18 16:15:00', 'NE', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('31', '2', '2011-09-18 20:20:00', 'ATL', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('32', '2', '2011-09-19 20:30:00', 'NYG', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('33', '3', '2011-09-25 13:00:00', 'BUF', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('34', '3', '2011-09-25 13:00:00', 'CIN', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('35', '3', '2011-09-25 13:00:00', 'CLE', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('36', '3', '2011-09-25 13:00:00', 'TEN', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('37', '3', '2011-09-25 13:00:00', 'MIN', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('38', '3', '2011-09-25 13:00:00', 'NO', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('39', '3', '2011-09-25 13:00:00', 'PHI', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('40', '3', '2011-09-25 13:00:00', 'CAR', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('41', '3', '2011-09-25 16:05:00', 'OAK', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('42', '3', '2011-09-25 16:05:00', 'STL', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('43', '3', '2011-09-25 16:05:00', 'SD', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('44', '3', '2011-09-25 16:15:00', 'CHI', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('45', '3', '2011-09-25 16:15:00', 'SEA', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('46', '3', '2011-09-25 16:15:00', 'TB', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('47', '3', '2011-09-25 20:20:00', 'IND', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('48', '3', '2011-09-26 20:30:00', 'DAL', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('49', '4', '2011-10-02 13:00:00', 'CHI', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('50', '4', '2011-10-02 13:00:00', 'CIN', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('51', '4', '2011-10-02 13:00:00', 'CLE', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('52', '4', '2011-10-02 13:00:00', 'DAL', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('53', '4', '2011-10-02 13:00:00', 'KC', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('54', '4', '2011-10-02 13:00:00', 'STL', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('55', '4', '2011-10-02 13:00:00', 'PHI', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('56', '4', '2011-10-02 13:00:00', 'JAX', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('57', '4', '2011-10-02 13:00:00', 'HOU', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('58', '4', '2011-10-02 16:05:00', 'ARI', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('59', '4', '2011-10-02 16:05:00', 'SEA', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('60', '4', '2011-10-02 16:15:00', 'GB', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('61', '4', '2011-10-02 16:15:00', 'OAK', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('62', '4', '2011-10-02 16:15:00', 'SD', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('63', '4', '2011-10-02 20:20:00', 'BAL', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('64', '4', '2011-10-03 20:30:00', 'TB', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('65', '5', '2011-10-09 13:00:00', 'BUF', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('66', '5', '2011-10-09 13:00:00', 'IND', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('67', '5', '2011-10-09 13:00:00', 'MIN', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('68', '5', '2011-10-09 13:00:00', 'NYG', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('69', '5', '2011-10-09 13:00:00', 'PIT', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('70', '5', '2011-10-09 13:00:00', 'CAR', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('71', '5', '2011-10-09 13:00:00', 'JAX', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('72', '5', '2011-10-09 13:00:00', 'HOU', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('73', '5', '2011-10-09 16:05:00', 'SF', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('74', '5', '2011-10-09 16:15:00', 'DEN', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('75', '5', '2011-10-09 16:15:00', 'NE', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('76', '5', '2011-10-09 20:20:00', 'ATL', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('77', '5', '2011-10-10 20:30:00', 'DET', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('78', '6', '2011-10-16 13:00:00', 'ATL', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('79', '6', '2011-10-16 13:00:00', 'CIN', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('80', '6', '2011-10-16 13:00:00', 'DET', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('81', '6', '2011-10-16 13:00:00', 'GB', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('82', '6', '2011-10-16 13:00:00', 'NYG', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('83', '6', '2011-10-16 13:00:00', 'PIT', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('84', '6', '2011-10-16 13:00:00', 'WAS', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('85', '6', '2011-10-16 16:05:00', 'OAK', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('86', '6', '2011-10-16 16:05:00', 'BAL', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('87', '6', '2011-10-16 16:15:00', 'NE', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('88', '6', '2011-10-16 16:15:00', 'TB', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('89', '6', '2011-10-16 20:20:00', 'CHI', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('90', '6', '2011-10-17 20:30:00', 'NYJ', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('91', '7', '2011-10-23 13:00:00', 'CLE', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('92', '7', '2011-10-23 13:00:00', 'DET', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('93', '7', '2011-10-23 13:00:00', 'TEN', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('94', '7', '2011-10-23 13:00:00', 'MIA', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('95', '7', '2011-10-23 13:00:00', 'NYJ', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('96', '7', '2011-10-23 13:00:00', 'TB', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('97', '7', '2011-10-23 13:00:00', 'CAR', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('98', '7', '2011-10-23 16:05:00', 'OAK', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('99', '7', '2011-10-23 16:05:00', 'ARI', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('100', '7', '2011-10-23 16:15:00', 'DAL', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('101', '7', '2011-10-23 16:15:00', 'MIN', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('102', '7', '2011-10-23 20:20:00', 'NO', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('103', '7', '2011-10-24 20:30:00', 'JAX', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('104', '8', '2011-10-30 13:00:00', 'TEN', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('105', '8', '2011-10-30 13:00:00', 'STL', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('106', '8', '2011-10-30 13:00:00', 'NYG', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('107', '8', '2011-10-30 13:00:00', 'CAR', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('108', '8', '2011-10-30 13:00:00', 'BAL', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('109', '8', '2011-10-30 13:00:00', 'HOU', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('110', '8', '2011-10-30 16:05:00', 'BUF', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('111', '8', '2011-10-30 16:05:00', 'DEN', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('112', '8', '2011-10-30 16:15:00', 'PIT', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('113', '8', '2011-10-30 16:15:00', 'SF', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('114', '8', '2011-10-30 16:15:00', 'SEA', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('115', '8', '2011-10-30 20:20:00', 'PHI', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('116', '8', '2011-10-31 20:30:00', 'KC', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('117', '9', '2011-11-06 13:00:00', 'BUF', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('118', '9', '2011-11-06 13:00:00', 'DAL', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('119', '9', '2011-11-06 13:00:00', 'IND', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('120', '9', '2011-11-06 13:00:00', 'KC', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('121', '9', '2011-11-06 13:00:00', 'NO', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('122', '9', '2011-11-06 13:00:00', 'WAS', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('123', '9', '2011-11-06 13:00:00', 'HOU', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('124', '9', '2011-11-06 16:05:00', 'TEN', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('125', '9', '2011-11-06 16:05:00', 'OAK', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('126', '9', '2011-11-06 16:15:00', 'NE', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('127', '9', '2011-11-06 16:15:00', 'ARI', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('128', '9', '2011-11-06 16:15:00', 'SD', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('129', '9', '2011-11-06 20:20:00', 'PIT', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('130', '9', '2011-11-07 20:30:00', 'PHI', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('131', '10', '2011-11-10 20:20:00', 'SD', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('132', '10', '2011-11-13 13:00:00', 'ATL', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('133', '10', '2011-11-13 13:00:00', 'CHI', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('134', '10', '2011-11-13 13:00:00', 'CIN', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('135', '10', '2011-11-13 13:00:00', 'CLE', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('136', '10', '2011-11-13 13:00:00', 'DAL', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('137', '10', '2011-11-13 13:00:00', 'IND', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('138', '10', '2011-11-13 13:00:00', 'KC', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('139', '10', '2011-11-13 13:00:00', 'MIA', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('140', '10', '2011-11-13 13:00:00', 'PHI', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('141', '10', '2011-11-13 13:00:00', 'TB', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('142', '10', '2011-11-13 13:00:00', 'CAR', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('143', '10', '2011-11-13 16:05:00', 'SEA', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('144', '10', '2011-11-13 16:15:00', 'SF', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('145', '10', '2011-11-13 20:20:00', 'NYJ', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('146', '10', '2011-11-14 20:30:00', 'GB', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('147', '11', '2011-11-17 20:20:00', 'DEN', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('148', '11', '2011-11-20 13:00:00', 'ATL', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('149', '11', '2011-11-20 13:00:00', 'CLE', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('150', '11', '2011-11-20 13:00:00', 'DET', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('151', '11', '2011-11-20 13:00:00', 'GB', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('152', '11', '2011-11-20 13:00:00', 'MIA', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('153', '11', '2011-11-20 13:00:00', 'MIN', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('154', '11', '2011-11-20 13:00:00', 'WAS', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('155', '11', '2011-11-20 13:00:00', 'BAL', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('156', '11', '2011-11-20 16:05:00', 'STL', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('157', '11', '2011-11-20 16:05:00', 'SF', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('158', '11', '2011-11-20 16:15:00', 'CHI', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('159', '11', '2011-11-20 20:20:00', 'NYG', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('160', '11', '2011-11-21 20:30:00', 'NE', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('161', '12', '2011-11-24 12:30:00', 'DET', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('162', '12', '2011-11-24 16:15:00', 'DAL', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('163', '12', '2011-11-24 20:20:00', 'BAL', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('164', '12', '2011-11-27 13:00:00', 'ATL', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('165', '12', '2011-11-27 13:00:00', 'CIN', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('166', '12', '2011-11-27 13:00:00', 'TEN', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('167', '12', '2011-11-27 13:00:00', 'IND', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('168', '12', '2011-11-27 13:00:00', 'STL', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('169', '12', '2011-11-27 13:00:00', 'NYJ', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('170', '12', '2011-11-27 13:00:00', 'JAX', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('171', '12', '2011-11-27 16:05:00', 'OAK', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('172', '12', '2011-11-27 16:05:00', 'SEA', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('173', '12', '2011-11-27 16:15:00', 'PHI', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('174', '12', '2011-11-27 16:15:00', 'SD', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('175', '12', '2011-11-27 20:20:00', 'KC', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('176', '12', '2011-11-28 20:30:00', 'NO', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('177', '13', '2011-12-01 20:20:00', 'SEA', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('178', '13', '2011-12-04 13:00:00', 'BUF', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('179', '13', '2011-12-04 13:00:00', 'CHI', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('180', '13', '2011-12-04 13:00:00', 'CLE', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('181', '13', '2011-12-04 13:00:00', 'MIA', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('182', '13', '2011-12-04 13:00:00', 'NO', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('183', '13', '2011-12-04 13:00:00', 'PIT', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('184', '13', '2011-12-04 13:00:00', 'TB', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('185', '13', '2011-12-04 13:00:00', 'WAS', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('186', '13', '2011-12-04 13:00:00', 'HOU', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('187', '13', '2011-12-04 16:05:00', 'MIN', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('188', '13', '2011-12-04 16:15:00', 'NYG', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('189', '13', '2011-12-04 16:15:00', 'ARI', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('190', '13', '2011-12-04 16:15:00', 'SF', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('191', '13', '2011-12-04 20:20:00', 'NE', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('192', '13', '2011-12-05 20:30:00', 'JAX', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('193', '14', '2011-12-08 20:20:00', 'PIT', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('194', '14', '2011-12-11 13:00:00', 'CIN', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('195', '14', '2011-12-11 13:00:00', 'DET', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('196', '14', '2011-12-11 13:00:00', 'GB', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('197', '14', '2011-12-11 13:00:00', 'TEN', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('198', '14', '2011-12-11 13:00:00', 'MIA', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('199', '14', '2011-12-11 13:00:00', 'NYJ', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('200', '14', '2011-12-11 13:00:00', 'WAS', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('201', '14', '2011-12-11 13:00:00', 'CAR', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('202', '14', '2011-12-11 13:00:00', 'JAX', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('203', '14', '2011-12-11 13:00:00', 'BAL', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('204', '14', '2011-12-11 16:05:00', 'DEN', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('205', '14', '2011-12-11 16:05:00', 'ARI', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('206', '14', '2011-12-11 16:15:00', 'SD', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('207', '14', '2011-12-11 20:20:00', 'DAL', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('208', '14', '2011-12-12 20:30:00', 'SEA', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('209', '15', '2011-12-15 20:20:00', 'ATL', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('210', '15', '2011-12-17 20:20:00', 'TB', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('211', '15', '2011-12-18 13:00:00', 'BUF', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('212', '15', '2011-12-18 13:00:00', 'CHI', null, 'SEA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('213', '15', '2011-12-18 13:00:00', 'IND', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('214', '15', '2011-12-18 13:00:00', 'KC', null, 'GB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('215', '15', '2011-12-18 13:00:00', 'STL', null, 'CIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('216', '15', '2011-12-18 13:00:00', 'MIN', null, 'NO', null, '0');
INSERT INTO `nflp_schedule` VALUES ('217', '15', '2011-12-18 13:00:00', 'NYG', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('218', '15', '2011-12-18 13:00:00', 'HOU', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('219', '15', '2011-12-18 16:05:00', 'OAK', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('220', '15', '2011-12-18 16:15:00', 'DEN', null, 'NE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('221', '15', '2011-12-18 16:15:00', 'PHI', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('222', '15', '2011-12-18 16:15:00', 'ARI', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('223', '15', '2011-12-18 20:20:00', 'SD', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('224', '15', '2011-12-19 20:30:00', 'SF', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('225', '16', '2011-12-22 20:20:00', 'IND', null, 'HOU', null, '0');
INSERT INTO `nflp_schedule` VALUES ('226', '16', '2011-12-24 13:00:00', 'BUF', null, 'DEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('227', '16', '2011-12-24 13:00:00', 'CIN', null, 'ARI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('228', '16', '2011-12-24 13:00:00', 'TEN', null, 'JAX', null, '0');
INSERT INTO `nflp_schedule` VALUES ('229', '16', '2011-12-24 13:00:00', 'KC', null, 'OAK', null, '0');
INSERT INTO `nflp_schedule` VALUES ('230', '16', '2011-12-24 13:00:00', 'NE', null, 'MIA', null, '0');
INSERT INTO `nflp_schedule` VALUES ('231', '16', '2011-12-24 13:00:00', 'NYJ', null, 'NYG', null, '0');
INSERT INTO `nflp_schedule` VALUES ('232', '16', '2011-12-24 13:00:00', 'PIT', null, 'STL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('233', '16', '2011-12-24 13:00:00', 'WAS', null, 'MIN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('234', '16', '2011-12-24 13:00:00', 'CAR', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('235', '16', '2011-12-24 13:00:00', 'BAL', null, 'CLE', null, '0');
INSERT INTO `nflp_schedule` VALUES ('236', '16', '2011-12-24 16:05:00', 'DET', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('237', '16', '2011-12-24 16:15:00', 'DAL', null, 'PHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('238', '16', '2011-12-24 16:15:00', 'SEA', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('239', '16', '2011-12-25 20:20:00', 'GB', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('240', '16', '2011-12-26 20:30:00', 'NO', null, 'ATL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('241', '17', '2012-01-01 13:00:00', 'ATL', null, 'TB', null, '0');
INSERT INTO `nflp_schedule` VALUES ('242', '17', '2012-01-01 13:00:00', 'CIN', null, 'BAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('243', '17', '2012-01-01 13:00:00', 'CLE', null, 'PIT', null, '0');
INSERT INTO `nflp_schedule` VALUES ('244', '17', '2012-01-01 13:00:00', 'GB', null, 'DET', null, '0');
INSERT INTO `nflp_schedule` VALUES ('245', '17', '2012-01-01 13:00:00', 'STL', null, 'SF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('246', '17', '2012-01-01 13:00:00', 'MIA', null, 'NYJ', null, '0');
INSERT INTO `nflp_schedule` VALUES ('247', '17', '2012-01-01 13:00:00', 'MIN', null, 'CHI', null, '0');
INSERT INTO `nflp_schedule` VALUES ('248', '17', '2012-01-01 13:00:00', 'NE', null, 'BUF', null, '0');
INSERT INTO `nflp_schedule` VALUES ('249', '17', '2012-01-01 13:00:00', 'NO', null, 'CAR', null, '0');
INSERT INTO `nflp_schedule` VALUES ('250', '17', '2012-01-01 13:00:00', 'NYG', null, 'DAL', null, '0');
INSERT INTO `nflp_schedule` VALUES ('251', '17', '2012-01-01 13:00:00', 'PHI', null, 'WAS', null, '0');
INSERT INTO `nflp_schedule` VALUES ('252', '17', '2012-01-01 13:00:00', 'JAX', null, 'IND', null, '0');
INSERT INTO `nflp_schedule` VALUES ('253', '17', '2012-01-01 13:00:00', 'HOU', null, 'TEN', null, '0');
INSERT INTO `nflp_schedule` VALUES ('254', '17', '2012-01-01 16:15:00', 'DEN', null, 'KC', null, '0');
INSERT INTO `nflp_schedule` VALUES ('255', '17', '2012-01-01 16:15:00', 'OAK', null, 'SD', null, '0');
INSERT INTO `nflp_schedule` VALUES ('256', '17', '2012-01-01 16:15:00', 'ARI', null, 'SEA', null, '0');
