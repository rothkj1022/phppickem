-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2017 at 07:12 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1-log
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nflpickem`
--

-- --------------------------------------------------------

--
-- Table structure for table `nflp_comments`
--

CREATE TABLE `nflp_comments` (
  `commentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `comment` longtext NOT NULL,
  `postDateTime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `nflp_divisions`
--

CREATE TABLE `nflp_divisions` (
  `divisionID` int(11) NOT NULL,
  `conference` varchar(10) NOT NULL,
  `division` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `nflp_divisions`
--

INSERT INTO `nflp_divisions` (`divisionID`, `conference`, `division`) VALUES
(1, 'AFC', 'North'),
(2, 'AFC', 'South'),
(3, 'AFC', 'East'),
(4, 'AFC', 'West'),
(5, 'NFC', 'North'),
(6, 'NFC', 'South'),
(7, 'NFC', 'East'),
(8, 'NFC', 'West');

-- --------------------------------------------------------

--
-- Table structure for table `nflp_email_templates`
--

CREATE TABLE `nflp_email_templates` (
  `email_template_key` varchar(255) NOT NULL,
  `email_template_title` varchar(255) NOT NULL,
  `default_subject` varchar(255) DEFAULT NULL,
  `default_message` text,
  `subject` varchar(255) DEFAULT NULL,
  `message` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `nflp_email_templates`
--

INSERT INTO `nflp_email_templates` (`email_template_key`, `email_template_title`, `default_subject`, `default_message`, `subject`, `message`) VALUES
('WEEKLY_PICKS_REMINDER', 'Weekly Picks Reminder', 'NFL Pick \'Em Week {week} Reminder', 'Hello {player},<br /><br />You are receiving this email because you do not yet have all of your picks in for week {week}.&nbsp; This is your reminder.&nbsp; The first game is {first_game} (Eastern), so to receive credit for that game, you\'ll have to make your pick before then.<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />', 'NFL Pick \'Em Week {week} Reminder', 'Hello {player},<br /><br />You are receiving this email because you do not yet have all of your picks in for week {week}.&nbsp; This is your reminder.&nbsp; The first game is {first_game} (Eastern), so to receive credit for that game, you\'ll have to make your pick before then.<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />'),
('WEEKLY_RESULTS_REMINDER', 'Last Week Results/Reminder', 'NFL Pick \'Em Week {previousWeek} Standings/Reminder', 'Congratulations this week go to {winners} for winning week {previousWeek}.  The winner(s) had {winningScore} out of {possibleScore} picks correct.<br /><br />The current leaders are:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />*Reminder* - Please make your picks for week {week} before {first_game} (Eastern).<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />', 'NFL Pick \'Em Week {previousWeek} Standings/Reminder', 'Congratulations this week go to {winners} for winning week {previousWeek}.  The winner(s) had {winningScore} out of {possibleScore} picks correct.<br /><br />The current leaders are:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />*Reminder* - Please make your picks for week {week} before {first_game} (Eastern).<br /><br />Links:<br />&nbsp;- NFL Pick \'Em URL: {site_url}<br />&nbsp;- Help/Rules: {rules_url}<br /><br />Good Luck!<br />'),
('FINAL_RESULTS', 'Final Results', 'NFL Pick \'Em 2016 Final Results', 'Congratulations this week go to {winners} for winning week\r\n{previousWeek}. The winner(s) had {winningScore} out of {possibleScore}\r\npicks correct.<br /><br /><span style="font-weight: bold;">Congratulations to {final_winner}</span> for winning NFL Pick \'Em 2016!&nbsp; {final_winner} had {final_winningScore} wins and had a pick ratio of {picks}/{possible} ({pickpercent}%).<br /><br />Top Wins:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />Thanks for playing, and I hope to see you all again for NFL Pick \'Em 2017!', 'NFL Pick \'Em 2016 Final Results', 'Congratulations this week go to {winners} for winning week\r\n{previousWeek}. The winner(s) had {winningScore} out of {possibleScore}\r\npicks correct.<br /><br /><span style="font-weight: bold;">Congratulations to {final_winner}</span> for winning NFL Pick \'Em 2016!&nbsp; {final_winner} had {final_winningScore} wins and had a pick ratio of {picks}/{possible} ({pickpercent}%).<br /><br />Top Wins:<br />{currentLeaders}<br /><br />The most accurate players are:<br />{bestPickRatios}<br /><br />Thanks for playing, and I hope to see you all again for NFL Pick \'Em 2017!');

-- --------------------------------------------------------

--
-- Table structure for table `nflp_picks`
--

CREATE TABLE `nflp_picks` (
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL,
  `pickID` varchar(10) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `nflp_picksummary`
--

CREATE TABLE `nflp_picksummary` (
  `weekNum` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `tieBreakerPoints` int(11) NOT NULL DEFAULT '0',
  `showPicks` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `nflp_schedule`
--

CREATE TABLE `nflp_schedule` (
  `gameID` int(11) NOT NULL,
  `weekNum` int(11) NOT NULL,
  `gameTimeEastern` datetime DEFAULT NULL,
  `homeID` varchar(10) NOT NULL,
  `homeScore` int(11) DEFAULT NULL,
  `visitorID` varchar(10) NOT NULL,
  `visitorScore` int(11) DEFAULT NULL,
  `overtime` tinyint(1) NOT NULL DEFAULT '0',
  `final` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `nflp_schedule`
--

INSERT INTO `nflp_schedule` (`gameID`, `weekNum`, `gameTimeEastern`, `homeID`, `homeScore`, `visitorID`, `visitorScore`, `overtime`, `final`) VALUES
(57234, 1, '2017-09-07 20:30:00', 'NE', NULL, 'KC', NULL, 0, 0),
(57235, 1, '2017-09-10 13:00:00', 'BUF', NULL, 'NYJ', NULL, 0, 0),
(57236, 1, '2017-09-10 13:00:01', 'CHI', NULL, 'ATL', NULL, 0, 0),
(57237, 1, '2017-09-10 13:00:02', 'CIN', NULL, 'BAL', NULL, 0, 0),
(57238, 1, '2017-09-10 13:00:03', 'CLE', NULL, 'PIT', NULL, 0, 0),
(57239, 1, '2017-09-10 13:00:04', 'DET', NULL, 'ARI', NULL, 0, 0),
(57240, 1, '2017-09-10 13:00:05', 'HOU', NULL, 'JAX', NULL, 0, 0),
(57241, 1, '2017-09-10 13:00:06', 'MIA', NULL, 'TB', NULL, 0, 0),
(57242, 1, '2017-09-10 13:00:07', 'TEN', NULL, 'OAK', NULL, 0, 0),
(57243, 1, '2017-09-10 13:00:08', 'WAS', NULL, 'PHI', NULL, 0, 0),
(57244, 1, '2017-09-10 16:05:09', 'LA', NULL, 'IND', NULL, 0, 0),
(57245, 1, '2017-09-10 16:25:10', 'GB', NULL, 'SEA', NULL, 0, 0),
(57246, 1, '2017-09-10 16:25:11', 'SF', NULL, 'CAR', NULL, 0, 0),
(57247, 1, '2017-09-10 20:30:12', 'DAL', NULL, 'NYG', NULL, 0, 0),
(57248, 1, '2017-09-11 19:10:00', 'MIN', NULL, 'NO', NULL, 0, 0),
(57249, 1, '2017-09-11 22:20:01', 'DEN', NULL, 'LAC', NULL, 0, 0),
(57250, 2, '2017-09-14 20:25:00', 'CIN', NULL, 'HOU', NULL, 0, 0),
(57251, 2, '2017-09-17 13:00:00', 'BAL', NULL, 'CLE', NULL, 0, 0),
(57252, 2, '2017-09-17 13:00:01', 'CAR', NULL, 'BUF', NULL, 0, 0),
(57253, 2, '2017-09-17 13:00:02', 'IND', NULL, 'ARI', NULL, 0, 0),
(57254, 2, '2017-09-17 13:00:03', 'JAX', NULL, 'TEN', NULL, 0, 0),
(57255, 2, '2017-09-17 13:00:04', 'KC', NULL, 'PHI', NULL, 0, 0),
(57256, 2, '2017-09-17 13:00:05', 'NO', NULL, 'NE', NULL, 0, 0),
(57257, 2, '2017-09-17 13:00:06', 'PIT', NULL, 'MIN', NULL, 0, 0),
(57258, 2, '2017-09-17 13:00:07', 'TB', NULL, 'CHI', NULL, 0, 0),
(57259, 2, '2017-09-17 16:05:08', 'LAC', NULL, 'MIA', NULL, 0, 0),
(57260, 2, '2017-09-17 16:05:09', 'OAK', NULL, 'NYJ', NULL, 0, 0),
(57261, 2, '2017-09-17 16:25:10', 'DEN', NULL, 'DAL', NULL, 0, 0),
(57262, 2, '2017-09-17 16:25:11', 'LA', NULL, 'WAS', NULL, 0, 0),
(57263, 2, '2017-09-17 16:25:12', 'SEA', NULL, 'SF', NULL, 0, 0),
(57264, 2, '2017-09-17 20:30:13', 'ATL', NULL, 'GB', NULL, 0, 0),
(57265, 2, '2017-09-18 20:30:00', 'NYG', NULL, 'DET', NULL, 0, 0),
(57266, 3, '2017-09-21 20:25:00', 'SF', NULL, 'LA', NULL, 0, 0),
(57267, 3, '2017-09-24 09:30:00', 'JAX', NULL, 'BAL', NULL, 0, 0),
(57268, 3, '2017-09-24 13:00:01', 'BUF', NULL, 'DEN', NULL, 0, 0),
(57269, 3, '2017-09-24 13:00:02', 'CAR', NULL, 'NO', NULL, 0, 0),
(57270, 3, '2017-09-24 13:00:03', 'CHI', NULL, 'PIT', NULL, 0, 0),
(57271, 3, '2017-09-24 13:00:04', 'DET', NULL, 'ATL', NULL, 0, 0),
(57272, 3, '2017-09-24 13:00:05', 'IND', NULL, 'CLE', NULL, 0, 0),
(57273, 3, '2017-09-24 13:00:06', 'MIN', NULL, 'TB', NULL, 0, 0),
(57274, 3, '2017-09-24 13:00:07', 'NE', NULL, 'HOU', NULL, 0, 0),
(57275, 3, '2017-09-24 13:00:08', 'NYJ', NULL, 'MIA', NULL, 0, 0),
(57276, 3, '2017-09-24 13:00:09', 'PHI', NULL, 'NYG', NULL, 0, 0),
(57277, 3, '2017-09-24 16:05:10', 'TEN', NULL, 'SEA', NULL, 0, 0),
(57278, 3, '2017-09-24 16:25:11', 'GB', NULL, 'CIN', NULL, 0, 0),
(57279, 3, '2017-09-24 16:25:12', 'LAC', NULL, 'KC', NULL, 0, 0),
(57280, 3, '2017-09-24 20:30:13', 'WAS', NULL, 'OAK', NULL, 0, 0),
(57281, 3, '2017-09-25 20:30:00', 'ARI', NULL, 'DAL', NULL, 0, 0),
(57282, 4, '2017-09-28 20:25:00', 'GB', NULL, 'CHI', NULL, 0, 0),
(57283, 4, '2017-10-01 09:30:00', 'MIA', NULL, 'NO', NULL, 0, 0),
(57284, 4, '2017-10-01 13:00:01', 'ATL', NULL, 'BUF', NULL, 0, 0),
(57285, 4, '2017-10-01 13:00:02', 'BAL', NULL, 'PIT', NULL, 0, 0),
(57286, 4, '2017-10-01 13:00:03', 'CLE', NULL, 'CIN', NULL, 0, 0),
(57287, 4, '2017-10-01 13:00:04', 'DAL', NULL, 'LA', NULL, 0, 0),
(57288, 4, '2017-10-01 13:00:05', 'HOU', NULL, 'TEN', NULL, 0, 0),
(57289, 4, '2017-10-01 13:00:06', 'MIN', NULL, 'DET', NULL, 0, 0),
(57290, 4, '2017-10-01 13:00:07', 'NE', NULL, 'CAR', NULL, 0, 0),
(57291, 4, '2017-10-01 13:00:08', 'NYJ', NULL, 'JAX', NULL, 0, 0),
(57292, 4, '2017-10-01 16:05:09', 'ARI', NULL, 'SF', NULL, 0, 0),
(57293, 4, '2017-10-01 16:05:10', 'LAC', NULL, 'PHI', NULL, 0, 0),
(57294, 4, '2017-10-01 16:05:11', 'TB', NULL, 'NYG', NULL, 0, 0),
(57295, 4, '2017-10-01 16:25:12', 'DEN', NULL, 'OAK', NULL, 0, 0),
(57296, 4, '2017-10-01 20:30:13', 'SEA', NULL, 'IND', NULL, 0, 0),
(57297, 4, '2017-10-02 20:30:00', 'KC', NULL, 'WAS', NULL, 0, 0),
(57298, 5, '2017-10-05 20:25:00', 'TB', NULL, 'NE', NULL, 0, 0),
(57299, 5, '2017-10-08 13:00:00', 'CIN', NULL, 'BUF', NULL, 0, 0),
(57300, 5, '2017-10-08 13:00:01', 'CLE', NULL, 'NYJ', NULL, 0, 0),
(57301, 5, '2017-10-08 13:00:02', 'DET', NULL, 'CAR', NULL, 0, 0),
(57302, 5, '2017-10-08 13:00:03', 'IND', NULL, 'SF', NULL, 0, 0),
(57303, 5, '2017-10-08 13:00:04', 'MIA', NULL, 'TEN', NULL, 0, 0),
(57304, 5, '2017-10-08 13:00:05', 'NYG', NULL, 'LAC', NULL, 0, 0),
(57305, 5, '2017-10-08 13:00:06', 'PHI', NULL, 'ARI', NULL, 0, 0),
(57306, 5, '2017-10-08 13:00:07', 'PIT', NULL, 'JAX', NULL, 0, 0),
(57307, 5, '2017-10-08 16:05:08', 'LA', NULL, 'SEA', NULL, 0, 0),
(57308, 5, '2017-10-08 16:05:09', 'OAK', NULL, 'BAL', NULL, 0, 0),
(57309, 5, '2017-10-08 16:25:10', 'DAL', NULL, 'GB', NULL, 0, 0),
(57310, 5, '2017-10-08 20:30:11', 'HOU', NULL, 'KC', NULL, 0, 0),
(57311, 5, '2017-10-09 20:30:00', 'CHI', NULL, 'MIN', NULL, 0, 0),
(57312, 6, '2017-10-12 20:25:00', 'CAR', NULL, 'PHI', NULL, 0, 0),
(57313, 6, '2017-10-15 13:00:00', 'ATL', NULL, 'MIA', NULL, 0, 0),
(57314, 6, '2017-10-15 13:00:01', 'BAL', NULL, 'CHI', NULL, 0, 0),
(57315, 6, '2017-10-15 13:00:02', 'HOU', NULL, 'CLE', NULL, 0, 0),
(57316, 6, '2017-10-15 13:00:03', 'MIN', NULL, 'GB', NULL, 0, 0),
(57317, 6, '2017-10-15 13:00:04', 'NO', NULL, 'DET', NULL, 0, 0),
(57318, 6, '2017-10-15 13:00:05', 'NYJ', NULL, 'NE', NULL, 0, 0),
(57319, 6, '2017-10-15 13:00:06', 'WAS', NULL, 'SF', NULL, 0, 0),
(57320, 6, '2017-10-15 16:05:07', 'ARI', NULL, 'TB', NULL, 0, 0),
(57321, 6, '2017-10-15 16:05:08', 'JAX', NULL, 'LA', NULL, 0, 0),
(57322, 6, '2017-10-15 16:25:09', 'KC', NULL, 'PIT', NULL, 0, 0),
(57323, 6, '2017-10-15 16:25:10', 'OAK', NULL, 'LAC', NULL, 0, 0),
(57324, 6, '2017-10-15 20:30:11', 'DEN', NULL, 'NYG', NULL, 0, 0),
(57325, 6, '2017-10-16 20:30:00', 'TEN', NULL, 'IND', NULL, 0, 0),
(57326, 7, '2017-10-19 20:25:00', 'OAK', NULL, 'KC', NULL, 0, 0),
(57327, 7, '2017-10-22 13:00:00', 'BUF', NULL, 'TB', NULL, 0, 0),
(57328, 7, '2017-10-22 13:00:01', 'CHI', NULL, 'CAR', NULL, 0, 0),
(57329, 7, '2017-10-22 13:00:02', 'CLE', NULL, 'TEN', NULL, 0, 0),
(57330, 7, '2017-10-22 13:00:03', 'GB', NULL, 'NO', NULL, 0, 0),
(57331, 7, '2017-10-22 13:00:04', 'IND', NULL, 'JAX', NULL, 0, 0),
(57332, 7, '2017-10-22 13:00:05', 'LA', NULL, 'ARI', NULL, 0, 0),
(57333, 7, '2017-10-22 13:00:06', 'MIA', NULL, 'NYJ', NULL, 0, 0),
(57334, 7, '2017-10-22 13:00:07', 'MIN', NULL, 'BAL', NULL, 0, 0),
(57335, 7, '2017-10-22 13:00:08', 'PIT', NULL, 'CIN', NULL, 0, 0),
(57336, 7, '2017-10-22 16:05:09', 'SF', NULL, 'DAL', NULL, 0, 0),
(57337, 7, '2017-10-22 16:25:10', 'LAC', NULL, 'DEN', NULL, 0, 0),
(57338, 7, '2017-10-22 16:25:11', 'NYG', NULL, 'SEA', NULL, 0, 0),
(57339, 7, '2017-10-22 20:30:12', 'NE', NULL, 'ATL', NULL, 0, 0),
(57340, 7, '2017-10-23 20:30:00', 'PHI', NULL, 'WAS', NULL, 0, 0),
(57341, 8, '2017-10-26 20:25:00', 'BAL', NULL, 'MIA', NULL, 0, 0),
(57342, 8, '2017-10-29 09:30:00', 'CLE', NULL, 'MIN', NULL, 0, 0),
(57343, 8, '2017-10-29 13:00:01', 'BUF', NULL, 'OAK', NULL, 0, 0),
(57344, 8, '2017-10-29 13:00:02', 'CIN', NULL, 'IND', NULL, 0, 0),
(57345, 8, '2017-10-29 13:00:03', 'NE', NULL, 'LAC', NULL, 0, 0),
(57346, 8, '2017-10-29 13:00:04', 'NO', NULL, 'CHI', NULL, 0, 0),
(57347, 8, '2017-10-29 13:00:05', 'NYJ', NULL, 'ATL', NULL, 0, 0),
(57348, 8, '2017-10-29 13:00:06', 'PHI', NULL, 'SF', NULL, 0, 0),
(57349, 8, '2017-10-29 13:00:07', 'TB', NULL, 'CAR', NULL, 0, 0),
(57350, 8, '2017-10-29 16:05:08', 'SEA', NULL, 'HOU', NULL, 0, 0),
(57351, 8, '2017-10-29 16:25:09', 'WAS', NULL, 'DAL', NULL, 0, 0),
(57352, 8, '2017-10-29 20:30:10', 'DET', NULL, 'PIT', NULL, 0, 0),
(57353, 8, '2017-10-30 20:30:00', 'KC', NULL, 'DEN', NULL, 0, 0),
(57354, 9, '2017-11-02 20:25:00', 'NYJ', NULL, 'BUF', NULL, 0, 0),
(57355, 9, '2017-11-05 13:00:00', 'CAR', NULL, 'ATL', NULL, 0, 0),
(57356, 9, '2017-11-05 13:00:01', 'HOU', NULL, 'IND', NULL, 0, 0),
(57357, 9, '2017-11-05 13:00:02', 'JAX', NULL, 'CIN', NULL, 0, 0),
(57358, 9, '2017-11-05 13:00:03', 'NO', NULL, 'TB', NULL, 0, 0),
(57359, 9, '2017-11-05 13:00:04', 'NYG', NULL, 'LA', NULL, 0, 0),
(57360, 9, '2017-11-05 13:00:05', 'PHI', NULL, 'DEN', NULL, 0, 0),
(57361, 9, '2017-11-05 13:00:06', 'TEN', NULL, 'BAL', NULL, 0, 0),
(57362, 9, '2017-11-05 16:05:07', 'SF', NULL, 'ARI', NULL, 0, 0),
(57363, 9, '2017-11-05 16:05:08', 'SEA', NULL, 'WAS', NULL, 0, 0),
(57364, 9, '2017-11-05 16:25:09', 'DAL', NULL, 'KC', NULL, 0, 0),
(57365, 9, '2017-11-05 20:30:10', 'MIA', NULL, 'OAK', NULL, 0, 0),
(57366, 9, '2017-11-06 20:30:00', 'GB', NULL, 'DET', NULL, 0, 0),
(57367, 10, '2017-11-09 20:25:00', 'ARI', NULL, 'SEA', NULL, 0, 0),
(57368, 10, '2017-11-12 13:00:00', 'BUF', NULL, 'NO', NULL, 0, 0),
(57369, 10, '2017-11-12 13:00:01', 'CHI', NULL, 'GB', NULL, 0, 0),
(57370, 10, '2017-11-12 13:00:02', 'DET', NULL, 'CLE', NULL, 0, 0),
(57371, 10, '2017-11-12 13:00:03', 'IND', NULL, 'PIT', NULL, 0, 0),
(57372, 10, '2017-11-12 13:00:04', 'JAX', NULL, 'LAC', NULL, 0, 0),
(57373, 10, '2017-11-12 13:00:05', 'TB', NULL, 'NYJ', NULL, 0, 0),
(57374, 10, '2017-11-12 13:00:06', 'TEN', NULL, 'CIN', NULL, 0, 0),
(57375, 10, '2017-11-12 13:00:07', 'WAS', NULL, 'MIN', NULL, 0, 0),
(57376, 10, '2017-11-12 16:05:08', 'LA', NULL, 'HOU', NULL, 0, 0),
(57377, 10, '2017-11-12 16:25:09', 'ATL', NULL, 'DAL', NULL, 0, 0),
(57378, 10, '2017-11-12 16:25:10', 'SF', NULL, 'NYG', NULL, 0, 0),
(57379, 10, '2017-11-12 20:30:11', 'DEN', NULL, 'NE', NULL, 0, 0),
(57380, 10, '2017-11-13 20:30:00', 'CAR', NULL, 'MIA', NULL, 0, 0),
(57381, 11, '2017-11-16 20:25:00', 'PIT', NULL, 'TEN', NULL, 0, 0),
(57382, 11, '2017-11-19 13:00:00', 'CHI', NULL, 'DET', NULL, 0, 0),
(57383, 11, '2017-11-19 13:00:01', 'CLE', NULL, 'JAX', NULL, 0, 0),
(57384, 11, '2017-11-19 13:00:02', 'GB', NULL, 'BAL', NULL, 0, 0),
(57385, 11, '2017-11-19 13:00:03', 'HOU', NULL, 'ARI', NULL, 0, 0),
(57386, 11, '2017-11-19 13:00:04', 'MIN', NULL, 'LA', NULL, 0, 0),
(57387, 11, '2017-11-19 13:00:05', 'NO', NULL, 'WAS', NULL, 0, 0),
(57388, 11, '2017-11-19 13:00:06', 'NYG', NULL, 'KC', NULL, 0, 0),
(57389, 11, '2017-11-19 16:05:07', 'LAC', NULL, 'BUF', NULL, 0, 0),
(57390, 11, '2017-11-19 16:25:08', 'DEN', NULL, 'CIN', NULL, 0, 0),
(57391, 11, '2017-11-19 16:25:09', 'OAK', NULL, 'NE', NULL, 0, 0),
(57392, 11, '2017-11-19 20:30:10', 'DAL', NULL, 'PHI', NULL, 0, 0),
(57393, 11, '2017-11-20 20:30:00', 'SEA', NULL, 'ATL', NULL, 0, 0),
(57394, 12, '2017-11-23 00:30:00', 'DET', NULL, 'MIN', NULL, 0, 0),
(57395, 12, '2017-11-23 16:30:01', 'DAL', NULL, 'LAC', NULL, 0, 0),
(57396, 12, '2017-11-23 20:30:02', 'WAS', NULL, 'NYG', NULL, 0, 0),
(57397, 12, '2017-11-26 13:00:00', 'ATL', NULL, 'TB', NULL, 0, 0),
(57398, 12, '2017-11-26 13:00:01', 'CIN', NULL, 'CLE', NULL, 0, 0),
(57399, 12, '2017-11-26 13:00:02', 'IND', NULL, 'TEN', NULL, 0, 0),
(57400, 12, '2017-11-26 13:00:03', 'KC', NULL, 'BUF', NULL, 0, 0),
(57401, 12, '2017-11-26 13:00:04', 'NE', NULL, 'MIA', NULL, 0, 0),
(57402, 12, '2017-11-26 13:00:05', 'NYJ', NULL, 'CAR', NULL, 0, 0),
(57403, 12, '2017-11-26 13:00:06', 'PHI', NULL, 'CHI', NULL, 0, 0),
(57404, 12, '2017-11-26 16:05:07', 'LA', 0, 'NO', 10, 0, 0),
(57405, 12, '2017-11-26 16:05:08', 'SF', NULL, 'SEA', NULL, 0, 0),
(57406, 12, '2017-11-26 16:25:09', 'ARI', NULL, 'JAX', NULL, 0, 0),
(57407, 12, '2017-11-26 16:25:10', 'OAK', NULL, 'DEN', NULL, 0, 0),
(57408, 12, '2017-11-26 20:30:11', 'PIT', NULL, 'GB', NULL, 0, 0),
(57409, 12, '2017-11-27 20:30:00', 'BAL', NULL, 'HOU', NULL, 0, 0),
(57410, 13, '2017-11-30 20:25:00', 'DAL', NULL, 'WAS', NULL, 0, 0),
(57411, 13, '2017-12-03 13:00:00', 'ATL', NULL, 'MIN', NULL, 0, 0),
(57412, 13, '2017-12-03 13:00:01', 'BAL', NULL, 'DET', NULL, 0, 0),
(57413, 13, '2017-12-03 13:00:02', 'BUF', NULL, 'NE', NULL, 0, 0),
(57414, 13, '2017-12-03 13:00:03', 'CHI', NULL, 'SF', NULL, 0, 0),
(57415, 13, '2017-12-03 13:00:04', 'GB', NULL, 'TB', NULL, 0, 0),
(57416, 13, '2017-12-03 13:00:05', 'JAX', NULL, 'IND', NULL, 0, 0),
(57417, 13, '2017-12-03 13:00:06', 'MIA', NULL, 'DEN', NULL, 0, 0),
(57418, 13, '2017-12-03 13:00:07', 'NO', NULL, 'CAR', NULL, 0, 0),
(57419, 13, '2017-12-03 13:00:08', 'NYJ', NULL, 'KC', NULL, 0, 0),
(57420, 13, '2017-12-03 13:00:09', 'TEN', NULL, 'HOU', NULL, 0, 0),
(57421, 13, '2017-12-03 16:05:10', 'LAC', NULL, 'CLE', NULL, 0, 0),
(57422, 13, '2017-12-03 16:25:11', 'ARI', NULL, 'LA', NULL, 0, 0),
(57423, 13, '2017-12-03 16:25:12', 'OAK', NULL, 'NYG', NULL, 0, 0),
(57424, 13, '2017-12-03 20:30:13', 'SEA', NULL, 'PHI', NULL, 0, 0),
(57425, 13, '2017-12-04 20:30:00', 'CIN', NULL, 'PIT', NULL, 0, 0),
(57426, 14, '2017-12-07 20:25:00', 'ATL', NULL, 'NO', NULL, 0, 0),
(57427, 14, '2017-12-10 13:00:00', 'BUF', NULL, 'IND', NULL, 0, 0),
(57428, 14, '2017-12-10 13:00:01', 'CAR', NULL, 'MIN', NULL, 0, 0),
(57429, 14, '2017-12-10 13:00:02', 'CIN', NULL, 'CHI', NULL, 0, 0),
(57430, 14, '2017-12-10 13:00:03', 'CLE', NULL, 'GB', NULL, 0, 0),
(57431, 14, '2017-12-10 13:00:04', 'HOU', NULL, 'SF', NULL, 0, 0),
(57432, 14, '2017-12-10 13:00:05', 'JAX', NULL, 'SEA', NULL, 0, 0),
(57433, 14, '2017-12-10 13:00:06', 'KC', NULL, 'OAK', NULL, 0, 0),
(57434, 14, '2017-12-10 13:00:07', 'TB', NULL, 'DET', NULL, 0, 0),
(57435, 14, '2017-12-10 16:05:08', 'ARI', NULL, 'TEN', NULL, 0, 0),
(57436, 14, '2017-12-10 16:05:09', 'DEN', NULL, 'NYJ', NULL, 0, 0),
(57437, 14, '2017-12-10 16:05:10', 'LAC', NULL, 'WAS', NULL, 0, 0),
(57438, 14, '2017-12-10 16:25:11', 'LA', NULL, 'PHI', NULL, 0, 0),
(57439, 14, '2017-12-10 16:25:12', 'NYG', NULL, 'DAL', NULL, 0, 0),
(57440, 14, '2017-12-10 20:30:13', 'PIT', NULL, 'BAL', NULL, 0, 0),
(57441, 14, '2017-12-11 20:30:00', 'MIA', NULL, 'NE', NULL, 0, 0),
(57442, 15, '2017-12-14 20:25:00', 'IND', NULL, 'DEN', NULL, 0, 0),
(57443, 15, '2017-12-16 16:30:00', 'DET', NULL, 'CHI', NULL, 0, 0),
(57444, 15, '2017-12-16 20:25:01', 'KC', NULL, 'LAC', NULL, 0, 0),
(57445, 15, '2017-12-17 13:00:00', 'BUF', NULL, 'MIA', NULL, 0, 0),
(57446, 15, '2017-12-17 13:00:01', 'CAR', NULL, 'GB', NULL, 0, 0),
(57447, 15, '2017-12-17 13:00:02', 'CLE', NULL, 'BAL', NULL, 0, 0),
(57448, 15, '2017-12-17 13:00:03', 'JAX', NULL, 'HOU', NULL, 0, 0),
(57449, 15, '2017-12-17 13:00:04', 'MIN', NULL, 'CIN', NULL, 0, 0),
(57450, 15, '2017-12-17 13:00:05', 'NO', NULL, 'NYJ', NULL, 0, 0),
(57451, 15, '2017-12-17 13:00:06', 'NYG', NULL, 'PHI', NULL, 0, 0),
(57452, 15, '2017-12-17 13:00:07', 'WAS', NULL, 'ARI', NULL, 0, 0),
(57453, 15, '2017-12-17 16:05:08', 'SEA', NULL, 'LA', NULL, 0, 0),
(57454, 15, '2017-12-17 16:25:09', 'PIT', NULL, 'NE', NULL, 0, 0),
(57455, 15, '2017-12-17 16:25:10', 'SF', NULL, 'TEN', NULL, 0, 0),
(57456, 15, '2017-12-17 20:30:11', 'OAK', NULL, 'DAL', NULL, 0, 0),
(57457, 15, '2017-12-18 20:30:00', 'TB', NULL, 'ATL', NULL, 0, 0),
(57458, 16, '2017-12-23 16:30:00', 'BAL', NULL, 'IND', NULL, 0, 0),
(57459, 16, '2017-12-23 20:30:01', 'GB', NULL, 'MIN', NULL, 0, 0),
(57460, 16, '2017-12-24 13:00:00', 'CAR', NULL, 'TB', NULL, 0, 0),
(57461, 16, '2017-12-24 13:00:01', 'CHI', NULL, 'CLE', NULL, 0, 0),
(57462, 16, '2017-12-24 13:00:02', 'CIN', NULL, 'DET', NULL, 0, 0),
(57463, 16, '2017-12-24 13:00:03', 'KC', NULL, 'MIA', NULL, 0, 0),
(57464, 16, '2017-12-24 13:00:04', 'NE', NULL, 'BUF', NULL, 0, 0),
(57465, 16, '2017-12-24 13:00:05', 'NO', NULL, 'ATL', NULL, 0, 0),
(57466, 16, '2017-12-24 13:00:06', 'NYJ', NULL, 'LAC', NULL, 0, 0),
(57467, 16, '2017-12-24 13:00:07', 'TEN', NULL, 'LA', NULL, 0, 0),
(57468, 16, '2017-12-24 13:00:08', 'WAS', NULL, 'DEN', NULL, 0, 0),
(57469, 16, '2017-12-24 16:05:09', 'SF', NULL, 'JAX', NULL, 0, 0),
(57470, 16, '2017-12-24 16:25:10', 'ARI', NULL, 'NYG', NULL, 0, 0),
(57471, 16, '2017-12-24 16:25:11', 'DAL', NULL, 'SEA', NULL, 0, 0),
(57472, 16, '2017-12-25 16:30:00', 'HOU', NULL, 'PIT', NULL, 0, 0),
(57473, 16, '2017-12-25 20:30:01', 'PHI', NULL, 'OAK', NULL, 0, 0),
(57474, 17, '2017-12-31 13:00:00', 'ATL', NULL, 'CAR', NULL, 0, 0),
(57475, 17, '2017-12-31 13:00:01', 'BAL', NULL, 'CIN', NULL, 0, 0),
(57476, 17, '2017-12-31 13:00:02', 'DET', NULL, 'GB', NULL, 0, 0),
(57477, 17, '2017-12-31 13:00:03', 'IND', NULL, 'HOU', NULL, 0, 0),
(57478, 17, '2017-12-31 13:00:04', 'MIA', NULL, 'BUF', NULL, 0, 0),
(57479, 17, '2017-12-31 13:00:05', 'MIN', NULL, 'CHI', NULL, 0, 0),
(57480, 17, '2017-12-31 13:00:06', 'NE', NULL, 'NYJ', NULL, 0, 0),
(57481, 17, '2017-12-31 13:00:07', 'NYG', NULL, 'WAS', NULL, 0, 0),
(57482, 17, '2017-12-31 13:00:08', 'PHI', NULL, 'DAL', NULL, 0, 0),
(57483, 17, '2017-12-31 13:00:09', 'PIT', NULL, 'CLE', NULL, 0, 0),
(57484, 17, '2017-12-31 13:00:10', 'TB', NULL, 'NO', NULL, 0, 0),
(57485, 17, '2017-12-31 13:00:11', 'TEN', NULL, 'JAX', NULL, 0, 0),
(57486, 17, '2017-12-31 16:25:12', 'DEN', NULL, 'KC', NULL, 0, 0),
(57487, 17, '2017-12-31 16:25:13', 'LAC', NULL, 'OAK', NULL, 0, 0),
(57488, 17, '2017-12-31 16:25:14', 'LA', NULL, 'SF', NULL, 0, 0),
(57489, 17, '2017-12-31 16:25:15', 'SEA', NULL, 'ARI', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nflp_teams`
--

CREATE TABLE `nflp_teams` (
  `teamID` varchar(10) NOT NULL,
  `divisionID` int(11) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `team` varchar(50) DEFAULT NULL,
  `displayName` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `nflp_teams`
--

INSERT INTO `nflp_teams` (`teamID`, `divisionID`, `city`, `team`, `displayName`) VALUES
('ARI', 8, 'Arizona', 'Cardinals', NULL),
('ATL', 6, 'Atlanta', 'Falcons', NULL),
('BAL', 1, 'Baltimore', 'Ravens', NULL),
('BUF', 3, 'Buffalo', 'Bills', NULL),
('CAR', 6, 'Carolina', 'Panthers', NULL),
('CHI', 5, 'Chicago', 'Bears', NULL),
('CIN', 1, 'Cincinnati', 'Bengals', NULL),
('CLE', 1, 'Cleveland', 'Browns', NULL),
('DAL', 7, 'Dallas', 'Cowboys', NULL),
('DEN', 4, 'Denver', 'Broncos', NULL),
('DET', 5, 'Detroit', 'Lions', NULL),
('GB', 5, 'Green Bay', 'Packers', NULL),
('HOU', 2, 'Houston', 'Texans', NULL),
('IND', 2, 'Indianapolis', 'Colts', NULL),
('JAX', 2, 'Jacksonville', 'Jaguars', NULL),
('KC', 4, 'Kansas City', 'Chiefs', NULL),
('MIA', 3, 'Miami', 'Dolphins', NULL),
('MIN', 5, 'Minnesota', 'Vikings', NULL),
('NE', 3, 'New England', 'Patriots', NULL),
('NO', 6, 'New Orleans', 'Saints', NULL),
('NYG', 7, 'New York', 'Giants', 'NY Giants'),
('NYJ', 3, 'New York', 'Jets', 'NY Jets'),
('OAK', 4, 'Oakland', 'Raiders', NULL),
('PHI', 7, 'Philadelphia', 'Eagles', NULL),
('PIT', 1, 'Pittsburgh', 'Steelers', NULL),
('LAC', 4, 'Los Angeles', 'Chargers', NULL),
('SEA', 8, 'Seattle', 'Seahawks', NULL),
('SF', 8, 'San Francisco', '49ers', NULL),
('LA', 8, 'Los Angeles', 'Rams', NULL),
('TB', 6, 'Tampa Bay', 'Buccaneers', NULL),
('TEN', 2, 'Tennessee', 'Titans', NULL),
('WAS', 7, 'Washington', 'Redskins', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nflp_users`
--

CREATE TABLE `nflp_users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `nflp_users`
--

INSERT INTO `nflp_users` (`userID`, `userName`, `password`, `salt`, `firstname`, `lastname`, `email`, `status`, `is_admin`) VALUES
(1, 'admin', 'jl7LZ1B7ZNUq/RnVqnFmuwRXvMkO/DD5', 'Cb8Jjj0OPy', 'Admin', 'Admin', 'admin@yourdomain.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nflp_comments`
--
ALTER TABLE `nflp_comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `nflp_divisions`
--
ALTER TABLE `nflp_divisions`
  ADD PRIMARY KEY (`divisionID`);

--
-- Indexes for table `nflp_email_templates`
--
ALTER TABLE `nflp_email_templates`
  ADD PRIMARY KEY (`email_template_key`);

--
-- Indexes for table `nflp_picks`
--
ALTER TABLE `nflp_picks`
  ADD PRIMARY KEY (`userID`,`gameID`);

--
-- Indexes for table `nflp_picksummary`
--
ALTER TABLE `nflp_picksummary`
  ADD PRIMARY KEY (`weekNum`,`userID`);

--
-- Indexes for table `nflp_schedule`
--
ALTER TABLE `nflp_schedule`
  ADD PRIMARY KEY (`gameID`),
  ADD KEY `GameID` (`gameID`),
  ADD KEY `HomeID` (`homeID`),
  ADD KEY `VisitorID` (`visitorID`);

--
-- Indexes for table `nflp_teams`
--
ALTER TABLE `nflp_teams`
  ADD PRIMARY KEY (`teamID`),
  ADD KEY `ID` (`teamID`);

--
-- Indexes for table `nflp_users`
--
ALTER TABLE `nflp_users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nflp_comments`
--
ALTER TABLE `nflp_comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nflp_divisions`
--
ALTER TABLE `nflp_divisions`
  MODIFY `divisionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `nflp_users`
--
ALTER TABLE `nflp_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
