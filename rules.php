<?php
require_once('includes/application_top.php');
require_once('includes/header.php');
?>
<h1>Rules / Help</h1>

<h2>Basics</h2>
<p>The concept of NFL Pick 'Em is simple: pick the winners of each game each week.</p>
<p>To enter, fill in the entry form by selecting the outcome of each game.</p>
<p>The player who accurately predicts the most correct winners each week gets a win.  If two players share the winning score for a week, the win is awarded to both players.</p>
<p>At the end of the football season the person who has the most weekly wins, is the winner.  The final tie breaker is determined by who has the better overall pick ratio (correct picks / total picks).</p>

<h2>Making and Changing Entries</h2>
<p>When filling in an entry form, you do not have to make a pick for each game.  This is helpful if there are early games scheduled for a given week (games played on a Thursday, Friday or Saturday). You may make your picks for these games beforehand and complete the rest later.</p>
<p>Games are automatically locked out on the entry form according to their scheduled date and time. Early games are locked at the start of the individual game. All remaining games (including the Monday Night Football game) are locked at the scheduled start time of the first Sunday game.</p>
<p>Note: all times displayed on the schedule are Eastern.</p>
<p>You may change your pick for any game up until the time that game is locked.</p>
<p>Entries must be completed on time. Once a game is locked, you may not change your pick for it. If you did not make a pick for a particular game, it is counted as a loss. If you submit a partial entry and either forget or are unable to complete it, the games you did not pick will count as losses.</p>
<p>If you have trouble accessing the site, logging in or completing your entry, please contact the Administrator for help.  If you are unable to make your picks before they are locked out, the Administrator may enter your picks after the fact if the picks are communicated to the Administrator ahead of time.</p>

<p>If you have any questions, please contact the <a href="mailto:<?php echo $adminUser->email; ?>">Administrator</a></p>

<h2>2008 Rule Changes:</h2>
<p>- No more weekly tiebreaker scores.  To make things even easier, all you need to do week to week is make picks.</p>
<p>- No more "shared wins".  If 2 players are tied for the highest score, both players get a win.</p>

<!--
Navigating the Site
Use the menu displayed at the top of every page to get around the site. Below is a description of each page.

Note: you must login in order to access most pages.

Home
This is the first page displayed after you log in. Check here for news, announcements and updates regarding the pool.

Entry Form
You may enter for the current week or make selections in advance for upcoming weeks using the links provided. To enter, select a winner (or call a tie) for each game and enter a point total for the tie breaker.

You may change your entry by returning to this page for the given week. Your current picks and points will be shown. Make your changes and hit the Submit button.

Note that you cannot make or change picks for games that have been locked. If you did not make a pick for a game that has been locked, it is counted as a loss. Also, you may not change your tie breaker point total once all games for the current week have been locked.

Results
This page shows each player's picks and score for a given week. Game scores will be updated as they arrive. All game results should be in by late Monday night or early Tuesday morning.

Results for each week's pool are generated automatically so once all scores are in, the winner will be declared.

Summary
Here you will find a list of the winners for each week's pool. Click on a week number to view the results page for an individual week.

This page also displays individual summaries for each player, showing his or her overall performance for the current season.

Weekly Schedule
This page let's you view the schedule week-by-week. By default the current week will be displayed but you can jump to any week using the links at the bottom of the page. The display includes scores when available.

Team Schedules
You can view any team's schedule here by selecting its name from the drop-down list. Again, scores are displayed when available.

Standings
This page displays the current standings for all NFL teams based on available scores. From here you can click on a team name to view its schedule.

Change Password
You can change your password here. You must enter you current password and then the new password twice in the spaces provided (this helps prevent typos since you can't see what you type in the fields). Be sure to use your new password the next time you log in.

For your protection, passwords are stored in encrypted format. If you forget your password, contact the Administrator and you will be issued a new one.

Login/Logout
Login here with your username and password. You must login first to access most pages on the site. If you're having trouble logging in, contact the Administrator.

If you are inactive for several minutes, your session may timeout. When this happens, the next time you try to access a page you will automatically be sent back to the login page. Just sign in again and you may then continue with whatever you were doing.

You may also use this link to logout and end your session. This can be used to allow another player to login with his or her own username and password.

Help
You can always come to this page for help with finding your way around or entering and updating your picks. If you need further assistance, email the Administrator.
//-->
<?php
require('includes/footer.php');
?>