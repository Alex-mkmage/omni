<?php

/* Function requested by Giannis to test if tool was uploaded correctly */
if ( isset( $_GET['test'] ) ) exit;

@set_time_limit(0);
@ini_set("max_execution_time", 0);
@set_time_limit(0);
@ignore_user_abort(true);
if (extension_loaded('xdebug') && !isset($_GET['robot'])) {
    echo 'Xdebug detected - exitting...';
    die();
}

// Version to be updated on every build
$myversion='20180720_1317';

function isTerminal()
{
    return !isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['SHELL']);
}

/* If running via terminal. */
if (isTerminal())  parse_str(implode('&', array_slice($argv, 1)), $_GET);

if (!isset($_GET['srun'])) {
    @unlink("sucuri-cleanup.php");
    @unlink("sucuri-version-check.php");
    @unlink("sucuri-wpdb-clean.php");
    @unlink("sucuri-db-cleanup.php");
    @unlink("sucuri-db-clean.php");
    @unlink("sucuri_db_clean.php");
    @unlink("sucuri_listcleaned.php");
    @unlink("sucuri-filemanager.php");
    @unlink('sucuri-toolbox.php');
    @unlink('sucuri-toolbox-client.php');
    @unlink(__FILE__);
    exit(0);
}

$VULN_SOFTWARE = array("wordpress" => array('1.2'=>array(0,1,2,3,4,5,6,),'1.2.1'=>array(0,2,3,4,5,6,),'1.5'=>array(7,8,9,10,2,3,4,5,6,11,),'1.5.1'=>array(12,13,14,2,3,4,5,6,11,),'1.5.1.1'=>array(12,15,16,13,14,10,2,3,4,5,6,11,),'1.5.1.2'=>array(12,17,13,14,2,3,4,5,6,11,),'1.5.1.3'=>array(12,18,13,14,2,3,11,),'1.5.2'=>array(12,13,14,2,3,11,),'2.0'=>array(12,19,13,14,20,21,22,23,24,2,3,11,),'2.0.1'=>array(12,19,13,14,20,21,22,23,24,2,3,11,),'2.0.2'=>array(19,25,13,14,26,20,21,22,23,24,2,3,11,),'2.0.3'=>array(19,13,14,26,20,21,22,23,24,27,2,3,11,),'2.0.4'=>array(19,13,14,26,20,21,22,23,24,27,2,3,11,),'2.0.5'=>array(19,28,13,14,20,21,22,23,24,27,2,3,11,),'2.0.6'=>array(19,29,13,14,20,21,22,23,24,27,2,3,11,),'2.0.7'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.0.8'=>array(13,14,20,21,22,23,24,2,3,11,),'2.0.9'=>array(13,14,20,21,22,23,24,27,2,3,11,),'2.0.10'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.0.11'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.1'=>array(13,14,20,21,22,23,24,27,2,3,11,),'2.1.1'=>array(19,30,13,14,20,21,22,23,24,27,2,3,31,11,),'2.1.2'=>array(19,32,33,13,14,20,21,22,23,24,27,2,3,11,),'2.1.3'=>array(19,34,13,14,20,21,22,23,24,27,2,3,11,),'2.2'=>array(19,35,36,13,14,20,21,22,23,24,27,2,3,11,),'2.2.1'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.2.2'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.2.3'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.3'=>array(13,14,20,21,22,23,24,27,2,3,11,),'2.3.1'=>array(19,37,13,14,20,21,22,23,24,27,2,3,11,),'2.3.2'=>array(19,13,14,20,21,22,23,24,27,2,3,11,),'2.3.3'=>array(19,13,14,20,21,22,23,24,2,3,11,),'2.5'=>array(38,39,13,14,20,21,22,23,24,27,2,3,40,11,),'2.5.1'=>array(19,39,13,14,20,21,22,23,24,27,2,3,40,11,),'2.6'=>array(39,13,14,20,21,22,23,24,27,2,3,41,40,11,),'2.6.1'=>array(19,42,39,13,14,20,21,22,23,24,27,2,3,41,40,11,),'2.6.2'=>array(19,39,13,14,20,21,22,23,24,27,2,3,41,40,11,),'2.6.3'=>array(39,13,14,20,21,22,23,24,27,2,3,41,40,11,),'2.6.5'=>array(19,39,13,14,20,21,22,23,24,2,3,41,40,11,),'2.7'=>array(19,39,13,14,20,21,22,23,24,27,2,3,43,41,40,11,),'2.7.1'=>array(19,39,13,14,20,21,22,23,24,27,2,3,43,41,40,11,),'2.8'=>array(39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.8.1'=>array(46,39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.8.2'=>array(39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.8.3'=>array(47,39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.8.4'=>array(39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.8.5'=>array(48,39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.8.6'=>array(39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,11,45,),'2.9'=>array(49,50,39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,51,11,45,),'2.9.1'=>array(39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,51,11,45,),'2.9.2'=>array(39,13,14,20,21,22,23,24,27,2,3,43,41,40,44,51,11,45,),'3.0'=>array(39,13,14,52,53,54,55,20,21,22,23,24,56,27,57,58,2,3,59,43,60,61,41,40,44,51,11,45,62,),'3.8.5'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.6'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.7'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.8'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.9'=>array(63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.10'=>array(68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.11'=>array(71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.12'=>array(72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.13'=>array(43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.8.14'=>array(75,41,40,44,51,76,11,45,62,77,),'3.8.15'=>array(40,44,51,76,11,45,62,77,),'3.8.16'=>array(51,76,11,45,62,77,),'3.8.17'=>array(77,),'3.9'=>array(78,27,57,79,80,58,2,3,81,82,83,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.1'=>array(78,27,57,79,80,58,2,3,81,82,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.2'=>array(80,58,2,3,81,82,84,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.3'=>array(85,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.4'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.5'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.6'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.7'=>array(63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.8'=>array(68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.9'=>array(71,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.10'=>array(72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.11'=>array(43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'3.9.12'=>array(75,41,40,44,51,76,11,45,62,77,),'3.9.13'=>array(40,44,51,76,11,45,62,77,),'3.9.14'=>array(51,76,11,45,62,77,),'3.9.15'=>array(77,),'4.0'=>array(2,3,81,82,83,84,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.1'=>array(83,82,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.2'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.3'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.4'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.5'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.6'=>array(63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.7'=>array(68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.8'=>array(71,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.9'=>array(72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.10'=>array(43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.0.11'=>array(75,41,40,44,51,76,11,45,62,77,),'4.0.12'=>array(40,44,51,76,11,45,62,77,),'4.0.13'=>array(51,76,11,45,62,77,),'4.0.14'=>array(77,),'4.1'=>array(82,83,86,87,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.1'=>array(82,83,85,86,87,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.2'=>array(85,86,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.3'=>array(86,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.4'=>array(86,59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.5'=>array(59,63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.6'=>array(63,64,65,66,67,68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.7'=>array(68,69,70,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.8'=>array(71,71,72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.9'=>array(72,73,43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.10'=>array(43,60,61,74,75,41,40,44,51,76,11,45,62,77,),'4.1.11'=>array(75,41,40,44,51,76,11,45,62,77,),'4.1.12'=>array(40,44,51,76,11,45,62,77,),'4.5.1'=>array(88,74,89,75,41,40,44,90,51,76,11,45,62,91,77,92,),'4.5.2'=>array(89,75,41,93,94,95,40,44,90,51,76,11,45,62,91,77,92,),'4.5.3'=>array(96,40,44,90,51,76,11,45,62,91,77,92,),'4.5.4'=>array(90,51,76,11,45,62,91,77,92,),'4.5.5'=>array(90,91,77,92,),'4.6'=>array(40,44,90,51,76,11,45,62,91,77,92,),'4.6.1'=>array(90,51,76,11,45,62,91,77,92,),'4.6.2'=>array(91,77,92,),'4.7'=>array(90,97,51,98,76,11,45,62,91,77,92,99,),'4.7.1'=>array(91,77,92,99,),));


$VULNERABILITIES = array('WordPress 1.2-1.2.1 - Multiple Cross-Site Scripting (XSS)','WordPress 1.2 - HTTP Response Splitting','WordPress <= 4.0 - Long Password Denial of Service (DoS)','WordPress <= 4.0 - Server Side Request Forgery (SSRF)','WordPress <= 1.5.1.2 - XMLRPC Eval Injection ','WordPress <= 1.5.1.2 - Multiple Cross-Site Scripting (XSS)','WordPress <= 1.5.1.2 - Email Spoofing','WordPress 1.5 wp-trackback.php tb_id Parameter SQL Injection','WordPress <= 1.5 Multiple Vulnerabilities (XSS, SQLi)','WordPress 1.5 template-functions-post.php Multiple Field XSS','WordPress 1.5 & 1.5.1.1 - SQL Injection','WordPress <= 4.7 - Post via Email Checks mail.example.com by Default','Wordpress 1.5.1 - 2.0.2 wp-register.php Multiple Parameter XSS','WordPress 1.5.1 - 3.5 XMLRPC Pingback API Internal/External Port Scanning','WordPress 1.5.1 - 3.5 XMLRPC pingback additional issues','WordPress <= 1.5.1.1 "add new admin" SQL Injection Exploit','WordPress <= 1.5.1.1 SQL Injection Exploit','WordPress <= 1.5.1.2 - XMLRPC SQL Injection','Wordpress <= 1.5.1.3 Remote Code Execution eXploit (metasploit)','WordPress 2.0 - 2.7.1 admin.php Module Configuration Security Bypass ','WordPress 2.0 - 3.0.1 wp-includes/comment.php Bypass Spam Restrictions','WordPress 2.0 - 3.0.1 Multiple Cross-Site Scripting (XSS) in request_filesystem_credentials()','WordPress 2.0 - 3.0.1 Cross-Site Scripting (XSS) in wp-admin/plugins.php','WordPress 2.0 - 3.0.1 wp-includes/capabilities.php Remote Authenticated Administrator Delete Action Bypass','WordPress 2.0 - 3.0 Remote Authenticated Administrator Add Action Bypass','WordPress <= 2.0.2 (cache) Remote Shell Injection Exploit','WordPress 2.0.2 - 2.0.4 Paged Parameter SQL Injection ','WordPress 2.0.3 - 3.9.1 (except 3.7.4 / 3.8.4) CSRF Token Brute Forcing','Wordpress 2.0.5 Trackback UTF-7 Remote SQL Injection Exploit','Wordpress <= 2.0.6 wp-trackback.php Remote SQL Injection Exploit','WordPress 2.1.1 - Comm& Execution Backdoor','WordPress 2.1.1 - RCE Backdoor','WordPress \'year\' Cross-Site Scripting (XSS)','WordPress 2.1.2 Authenticated XMLRPC SQL Injection','Wordpress 2.1.3 admin-ajax.php SQL Injection Blind Fishing Exploit','WordPress 2.2 (wp-app.php) Arbitrary File Upload Exploit','Wordpress 2.2 (xmlrpc.php) Remote SQL Injection Exploit','Wordpress <= 2.3.1 Charset Remote SQL Injection ','Wordpress 2.5 Cookie Integrity Protection ','WordPress 2.5 - 3.3.1 XSS in swfupload','WordPress 2.5-4.6 - Authenticated Stored Cross-Site Scripting via Image Filename','WordPress 2.6.0-4.5.2 - Unauthorized Category Removal from Post','Wordpress 2.6.1 (SQL Column Truncation) Admin Takeover Exploit','WordPress <= 4.4.2 - SSRF Bypass using Octal & Hexedecimal IP addresses','WordPress 2.8-4.6 - Path Traversal in Upgrade Package Uploader','WordPress 2.8-4.7 - Accessibility Mode Cross-Site Request Forgery (CSRF)','Wordpress 2.8.1 (url) Remote Cross Site Scripting Exploit','Wordpress <= 2.8.3 Remote Admin Reset Password ','WordPress <= 2.8.5 Unrestricted File Upload Arbitrary PHP Code Execution','WordPress 2.9 Failure to Restrict URL Access','WordPress 2.9 - Failure to Restrict URL Access','WordPress 2.9-4.7 - Authenticated Cross-Site scripting (XSS) in update-core.php','WordPress <= 3.0.5 wp-admin/press-this.php Privilege Escalation','WordPress <= 3.3.2 Cross-Site Scripting (XSS) in wp-includes/default-filters.php','WordPress <= 3.3.2 wp-admin/media-upload.php sensitive information disclosure or bypass','WordPress <= 3.3.2 wp-admin/includes/class-wp-posts-list-table.php sensitive information disclosure by visiting a draft','WordPress 3.0 - 3.6 Crafted String URL Redirect Restriction Bypass','WordPress 3.0 - 3.9.1 Authenticated Cross-Site Scripting (XSS) in Multisite','WordPress 3.0-3.9.2 - Unauthenticated Stored Cross-Site Scripting (XSS)','WordPress <= 4.2.2 - Authenticated Stored Cross-Site Scripting (XSS)','WordPress <= 4.4.2 - Reflected XSS in Network Settings','WordPress <= 4.4.2 - Script Compression Option CSRF','WordPress 3.0-4.7 - Cryptographically Weak Pseudo-Random Number Generator (PRNG)','WordPress <= 4.2.3 - wp_untrash_post_comments SQL Injection ','WordPress <= 4.2.3 - Timing Side Channel Attack','WordPress <= 4.2.3 - Widgets Title Cross-Site Scripting (XSS)','WordPress <= 4.2.3 - Nav Menu Title Cross-Site Scripting (XSS)','WordPress <= 4.2.3 - Legacy Theme Preview Cross-Site Scripting (XSS)','WordPress <= 4.3 - Authenticated Shortcode Tags Cross-Site Scripting (XSS)','WordPress <= 4.3 - User List Table Cross-Site Scripting (XSS)','WordPress <= 4.3 - Publish Post & Mark as Sticky Permission Issue','WordPress  3.7-4.4 - Authenticated Cross-Site Scripting (XSS)','WordPress 3.7-4.4.1 - Local URIs Server Side Request Forgery (SSRF)','WordPress 3.7-4.4.1 - Open Redirect','WordPress <= 4.5.1 - Pupload Same Origin Method Execution (SOME)','WordPress 3.6-4.5.2 - Authenticated Revision History Information Disclosure','WordPress 3.4-4.7 - Stored Cross-Site Scripting (XSS) via Theme Name fallback','WordPress 3.5-4.7.1 - WP_Query SQL Injection',' WordPress 3.9 & 3.9.1 Unlikely Code Execution','WordPress 3.6 - 3.9.1 XXE in GetID3 Library','WordPress 3.4.2 - 3.9.2 Does Not Invalidate Sessions Upon Logout','WordPress 3.9, 3.9.1, 3.9.2, 4.0 - XSS in Media Playlists','WordPress <= 4.1.1 - Unauthenticated Stored Cross-Site Scripting (XSS)','WordPress 3.9-4.1.1 - Same-Origin Method Execution','WordPress <= 4.0 - CSRF in wp-login.php Password Reset','WordPress <= 4.2 - Unauthenticated Stored Cross-Site Scripting (XSS)','WordPress 4.1-4.2.1 - Genericons Cross-Site Scripting (XSS)','WordPress 4.1 - 4.1.1 - Arbitrary File Upload','WordPress 4.2-4.5.1 - MediaElement.js Reflected Cross-Site Scripting (XSS)','WordPress 4.2-4.5.2 - Authenticated Attachment Name Stored XSS','WordPress 4.3-4.7 - Potential Remote Command Execution (RCE) in PHPMailer','WordPress 4.2.0-4.7.1 - Press This UI Available to Unauthorised Users','WordPress 4.3.0-4.7.1 - Cross-Site Scripting (XSS) in posts list table','WordPress 4.5.2 - Redirect Bypass','WordPress 4.5.2 - oEmbed Denial of Service (DoS)','WordPress 4.5.2 - Password Change via Stolen Cookie','WordPress 4.5.3 - Authenticated Denial of Service (DoS)','WordPress 4.7 - User Information Disclosure via REST API','WordPress 4.7 - Cross-Site Request Forgery (CSRF) via Flash Upload','WordPress 4.7.0-4.7.1 - Unauthenticated Page/Post Content Modification via REST API',);

if ($VULN_SOFTWARE == null) {
    echo "ERROR: Unable to get current versions. Please contact support@sucuri.net for guidance.\n";
    exit(1);
}

// Get file content and find the line with content
function findLineInFile($file, $content)
{
    $fh = @fopen($file, "r");
    if (!$fh) {
        echo "DEBUG: UNABLE TO CHECK " . escapeHtml($file) . "\n";
        return null;
    }
    while (($buffer = fgets($fh, 4096)) !== false) {
        if (strpos($buffer, $content) !== false) {
            fclose($fh);
            return $buffer;
        }
    }
    fclose($fh);
    return null;
}

if (!function_exists('file_get_contents')) { // below PHP 4.3
    function file_get_contents($fileName) {
        $fh = @fopen($fileName);
        if ($fh === false) {
            return false;
        }
        $res = fread($fh, 1048576);
        fclose($fh);
        return $res;
    }
}

define('OPT_TYPE_CONST',      1);
define('OPT_TYPE_VAR',        2);
define('OPT_TYPE_ASSOC',      4);
define('OPT_TYPE_ENV',        8);
define('OPT_TYPE_XML',       16);
define('OPT_TYPE_FIRST',     32);
define('OPT_TYPE_CONST_NUM', 64);

function getOptMatch($m, $type)
{
    return ($type & OPT_TYPE_FIRST) ? $m[0] : $m[count($m) - 1];
}

function getOption($option, $config, $type)
{
    $option = preg_quote($option);

    // String constants (WordPress)
    if (($type & OPT_TYPE_CONST) &&
        preg_match_all('@^\s*define\(\s*([\'"])' . $option . '\1\s*,\s*([\'"])(.*)\2\s*\)\s*;@m', $config, $m)) {
            return stripslashes(getOptMatch($m[3], $type));
    }

    // Numeric constants
    if (($type & OPT_TYPE_CONST_NUM) &&
        preg_match_all('@^\s*define\(\s*([\'"])' . $option . '\1\s*,\s*(\d*)\s*\)\s*;@m', $config, $m)) {
            return stripslashes(getOptMatch($m[2], $type));
    }

    // wp-config.php trick, see
    // http://www.wpbeginner.com/wp-tutorials/useful-wordpress-configuration-tricks-that-you-may-not-know/
    if (($type & OPT_TYPE_ENV) && preg_match('@^\s*define\(\s*([\'"])' . $option . '\1\s*,\s*\$_ENV\s*[[{]\s*' .
        '([\'"]?)DATABASE_SERVER\2\s*[}\]]\s*\)\s*;@m', $config, $m)) {
            return $_ENV['DATABASE_SERVER'];
    }

    // Variables (Joomla, WordPress prefix)
    if (($type & OPT_TYPE_VAR) &&
        preg_match_all('@^\s*(?:public|var)?\s*' . $option . '\s*=\s*(?:([\'"])(.*)\1|([0-9]+))\s*;@m', $config, $m)) {
            $str = getOptMatch($m[2], $type); // Return the string m[2] or the number m[3] if the string was not found
            return $str ? stripslashes($str) : getOptMatch($m[3], $type);
    }

    // Associative arrays (Drupal)
    if (($type & OPT_TYPE_ASSOC) &&
        preg_match_all('@(?:^|,|\()\s*([\'"])' . $option . '\1\s*=>\s*([\'"])(.*?)\2\s*[,)]@m', $config, $m)) {
            return stripslashes(getOptMatch($m[3], $type));
    }

    // Magento XML config
    if (($type & OPT_TYPE_XML) && preg_match_all('@^\s*<' . $option . '>(?:<!\[CDATA\[|\{\{)(.*)(?:}}|\]\]>)</' .
        $option . '>\s*$@m', $config, $m)) {
            return getOptMatch($m[1], $type);
    }

    return '';
}


// Properly escape HTML content
function escapeHTML($string)
{
    global $isPlainText;

    if ($isPlainText) {
        return $string;
    }

    if (!defined('ENT_SUBSTITUTE')) {
        define('ENT_SUBSTITUTE', 0);
    }

    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$VULNERABLE_PLUGINS = array(
    'fancybox.php' => array( '3.0.2', 'https://blog.sucuri.net/2015/02/zero-day-in-the-fancybox-for-wordpress-plugin.html', 'Fancybox' ),
    'gravityforms.php' => array( '1.8.20', 'https://blog.sucuri.net/2015/02/malware-cleanup-to-arbitrary-file-upload-in-gravity-forms.html', 'Gravity Forms' ),
    'hdflvvideoshare.php' => array( '2.8', '', 'HDFLV Videoshare' ),
    'grpdocsassembly.php' => array( '2.0.5', '', 'Group Docs Assembly'),
    'wp-seo.php' => array( '3.4.2', '', 'Yoast SEO'),
    'blogvault.php' => array( '1.45', 'https://blogvault.net/security-notification/', 'BlogVault'),
);

// This line is updated with the most recent versions in refresh-versions.php on every build
$VERSIONS = array('signature'=>'sucuri-current-versions','joomla'=>array('3.8.10',),'wordpress'=>array('4.9.7',),'drupal'=>array('7.59','8.5.4',),'magento'=>array('1.14.3.9','2.2.5',),'jce'=>array('2.6.31',),'phpbb'=>array('3.2.2',),'vbulletin'=>array('4.2.5','5.4.2',),'jetpack'=>array('6.2.1',),'zenphoto'=>array('1.5',),'prestashop'=>array('1.7.3.4',),'opencart'=>array('3.0.2.0',),'oscommerce'=>array('2.3.4.1',),'timthumb'=>array('2.8.13',),'modX'=>array('evolution'=>'1.2.1','revolution'=>'2.6.4',),'typo3'=>array('8.7.16','7.6.29',),'Newsmag'=>array('3',),'Newspaper'=>array('6.7.2',),);

$isNoise = false;
if (isset($_GET['noise'])) {
    $isNoise = true;
}

// =======================
// checkIsUpdated

function checkIsUpdated($version, $latestVersions)
{
    $version = standardizeVersion($version);
    
    if (is_array($latestVersions)) {
         $lv = $latestVersions[0];
    } else {
         $lv = $latestVersions;
    }

    $latest = 1 < count($latestVersions)
        ? findMostSimilar($version, $latestVersions)
        : standardizeVersion($lv);

    return version_compare($version, $latest) >= 0;
}

// finds the most similar version using XOR bitwise operation
// (same chars at the beginning of the string result in lower values of the result,
// lowest result gives the most similar from the beginning)
function findMostSimilar($version, $versions)
{
    $mostSimilar = false;
    $mostSimilarValue = 0;

    foreach ($versions as $currentVersion) {
        $endResult = standardizeVersion($currentVersion);
        $endResult = str_pad($endResult, strlen($version), '0');
        $endResult = unpack('H*', $version ^ $endResult);
        $endResult = base_convert($endResult[1], 16, 10);

        if (!$mostSimilar || $endResult < $mostSimilarValue) {
            $mostSimilar = $currentVersion;
            $mostSimilarValue = $endResult;
        }
    }

    return $mostSimilar;
}

function standardizeVersion($version)
{
    $version = preg_replace('/ Patch Level (\d+)/i', 'pl$1', $version);

    return $version;
}


// ============================================
// checkPlugin

function checkWpPlugin($path, $fileName)
{
    global $VULNERABLE_PLUGINS;

    list($safeVersion, $url, $pluginName) = $VULNERABLE_PLUGINS[$fileName];

    $pluginVersion = getWpPluginVersion("$path/$fileName");

    if ($pluginVersion && !checkIsUpdated($pluginVersion, $safeVersion)) {
        $info = array('name' => $pluginName, 'version' => $pluginVersion, 'dir' => $path."/".$fileName,
            'oldplugin' => true);
        
        if ($url) {
            $info['url'] = $url;
        }
        
        return $info;
    }
    
    return false;
}

function getWpPluginVersion($file)
{
   $version = findLineInFile($file, "Version:");

   $version = explode(':', $version);

   if (isset($version[1])) {
      return trim($version[1]);
   }
   return false;
}

// ============================================
// checkVersionInFile and friends

function checkWordPressAndZenPhotoVersion($fileName, $path)
{
    global $VERSIONS;
    
    if (strpos($path, 'administrator/components/com_jevents') !== false ||
        strpos($path, 'tiny-compress-images/test/wp-includes') !== false) {
        return false;
    }

    $version = findLineInFile($path . '/' . $fileName, 'wp_version = ');
    if ($version !== null) {
        // WordPress
        $realdir = dirname($path);

        $explosion = explode("'", $version);

        if (isset($explosion[1])) {
            $version = $explosion[1];
        }
    
        return array('name' => 'WordPress', 'version' => $version, 'dir' => $realdir,
            'updated' => checkIsUpdated($version, $VERSIONS['wordpress']),
            'config' => $realdir . '/wp-config.php' );
    }

    // Zen Photo
    $version = findLineInFile($path . '/' . $fileName, 'ZENPHOTO_VERSION');
    if ($version == null) {
        return false;
    }

    $version = trim($version);
    $version = explode("'", $version);
    $version = $version[3];

    return array('name' => 'Zenphoto', 'version' => $version, 'dir' => $path . '/' . $fileName,
        'updated' => checkIsUpdated($version, $VERSIONS['zenphoto']) );
}

function checkJoomlaVersion($fileName, $path)
{
    global $VERSIONS;
    
    $versionFile = '';
    if (file_exists("$path/includes/version.php")) {
        $versionFile = "$path/includes/version.php";
    } elseif (file_exists("$path/libraries/joomla/version.php")) {
        $versionFile = "$path/libraries/joomla/version.php";
    } elseif (file_exists("$path/libraries/cms/version.php")) {
        $versionFile = "$path/libraries/cms/version.php";
    } elseif (file_exists("$path/libraries/cms/version/version.php") && false === strpos($path, 'breezing-forms')) {
        $versionFile = "$path/libraries/cms/version/version.php";
    } else {
        return false;
    }

    $version1 = findLineInFile($versionFile, 'RELEASE');
    if (!$version1) {
        return false;
    }

    $version1 = explode("'", $version1);
    $version2 = findLineInFile($versionFile, 'DEV_LEVEL');
    $version2 = explode("'", $version2);
    $version = $version1[1] . '.' .$version2[1];

    return array('name' => 'Joomla', 'version' => $version, 'dir' => $path, 'source' => $versionFile,
        'updated' => checkIsUpdated($version, $VERSIONS['joomla']),
        'config' => $path . '/' . $fileName );
}

function checkJceVersion($fileName, $path)
{
    global $VERSIONS;
    
    $firstLine = findLineInFile($path . '/' .$fileName, 'install');

    if (false === strpos($firstLine, 'component')) {
        return false;
    }

    $version = findLineInFile($path . '/' . $fileName, '<version>');
    $version = str_replace('<version>', '', $version);
    $version = str_replace('</version>', '', $version);
    $version = trim($version);
    $realdir = dirname($path);

    return array('name' => 'JCE component', 'version' => $version, 'dir' => $realdir,
        'updated' => checkIsUpdated($version, $VERSIONS['jce']) );
}

function checkDrupalVersion($fileName, $path)
{
    global $VERSIONS;
    
    $version = findLineInFile($path . '/' . $fileName, "define('VERSION'");

    if (!$version) {
        return false;
    }

    $version = trim($version);
    $version = preg_replace("@^define\(\s*['\"]VERSION['\"]\s*,\s*['\"]([\d\.]+)['\"]\s*\);$@", '$1', $version);
    if ($fileName == 'bootstrap.inc') {
        $realdir = dirname($path);
    } else {
        $realdir = dirname(dirname($path));
    }

    return array('name' => 'Drupal', 'version' => $version, 'dir' => $realdir, 'source' => $path . '/' . $fileName,
        'updated' => checkIsUpdated($version, $VERSIONS['drupal']) );
}

function checkMagentoVersion($fileName, $path)
{
    global $VERSIONS;
    
    $config = @file_get_contents("$path/$fileName");

    if ((false === $config) || (false === strpos($config, 'public static function getVersionInfo()')))
    {
        return false;
    }

    $version = sprintf(
        '%s.%s.%s.%s',
        getOption('major', $config, OPT_TYPE_ASSOC),
        getOption('minor', $config, OPT_TYPE_ASSOC),
        getOption('revision', $config, OPT_TYPE_ASSOC),
        getOption('patch', $config, OPT_TYPE_ASSOC)
    );
    
    return array('name' => 'Magento', 'version' => $version, 'dir' => $path . '/' . $fileName,
        'updated' => checkIsUpdated($version, $VERSIONS['magento']) );
}

function checkModXVersion($fileName, $path)
{
    global $VERSIONS;
    
    $config = @ file_get_contents("$path/$fileName");
    if ($config === false) {
         return false;
    }

    $version = getOption('$modx_version', $config, OPT_TYPE_VAR);
    if ($version) {
        return array('name' => 'ModX Evolution', 'version' => $version, 'dir' => $path . '/' . $fileName,
            'updated' => checkIsUpdated($version, $VERSIONS['modX']['evolution']) );
    }

    if (!preg_match_all('@\$v\[\'([\S]+)\'\]\s*=\s*[\'](.*)[\'];@', $config, $m)) {
        return false;
    }
    if (! isset($m[2][0], $m[2][1], $m[2][2], $m[2][3])) {
        return false;
    }

    $version = sprintf('%s.%s.%s-%s', $m[2][0], $m[2][1], $m[2][2], $m[2][3]);

    return array('name' => 'ModX Revolution', 'version' => $version, 'dir' => $path . '/' . $fileName,
        'updated' => checkIsUpdated($version, $VERSIONS['modX']['revolution']) );
}

function checkPhpBbVersion($fileName, $path)
{
    global $VERSIONS;
    
    if (!preg_match('~@?define\(.PHPBB_VERSION., +.(\S+).\);~', findLineInFile($path . '/' . $fileName, "'PHPBB_VERSION'"), $matches)) {
        return false;
    }
    $version = $matches[1];
    $realdir = dirname($path);

    return array('name' => 'PHPBB', 'version' => $version, 'dir' => $realdir,
        'updated' => checkIsUpdated($version, $VERSIONS['phpbb']) );
}

function checkVbulletinVersion($fileName, $path)
{
    global $VERSIONS;
    
    $version = findLineInFile($path . '/' . $fileName, "'vbulletin'");

    if (!$version) {
        return false;
    }

    $version = str_replace("\t\t\$md5_sum_versions = array('vbulletin' => '", '', $version);
    $version = str_replace("');", '', $version);

    return array('name' => 'vBulletin', 'version' => $version, 'dir' => $path . '/' . $fileName,
        'updated' => checkIsUpdated($version, $VERSIONS['vbulletin']) );
}

function checkOsCommerceVersion($fileName, $path)
{
    global $VERSIONS;
    $verRegex = '[0-9.]+[ -]?[0-9a-zA-Z]{0,5}'; // Examples: "2.3.1"   "2.3.3.2"   "2.2-MS2"  "2.2 RC2a"  "2.2RC2a"
    
    $realdir = dirname($path);

    // See https://github.com/osCommerce/oscommerce2/commits/23/catalog/includes/version.php
    $versionFileNames = array("$path/includes/version.php", "$path/includes/version.txt",
        "$path/includes/OSC/version.txt");
    
    $version = false;
    
    foreach ($versionFileNames as $fileName) {
        $config = @file_get_contents($fileName);
        if ($config && preg_match('/^' . $verRegex . '$/', $config)) {
            $version = $config;
            $versionFile = $fileName;
            break;
        }
    }

    if (!$version) {
        $versionFile = "$path/includes/application_top.php";
        $config = @file_get_contents($versionFile);
        $option = getOption('PROJECT_VERSION', $config, OPT_TYPE_CONST);
        // PROJECT_VERSION can be something like "osCommerce 2.2-MS2" or "osCommerce Online Merchant v2.2 RC1"
        if (preg_match('/(' . $verRegex . ')$/', $option, $m)) {
            $version = $m[1];
        }
    }

    if (!$version) {
        return false;
    }
    
    return array('name' => 'osCommerce', 'version' => $version, 'dir' => $realdir, 'source' => $versionFile,
        'updated' => checkIsUpdated($version, $VERSIONS['oscommerce']) );
}

function checkPrestaShopVersion($fileName, $path)
{
    global $VERSIONS;
    
    $realdir = dirname($path);

    $version = null;
    
    if (file_exists("$realdir/config/autoload.php")) {
        $versionFile = "$realdir/config/autoload.php";
        $config = @file_get_contents($versionFile);
        $version = getOption('_PS_VERSION_', $config, OPT_TYPE_CONST);
    }
    
    if (!$version && file_exists("$realdir/docs/readme_en.txt")) {
        $versionFile = "$realdir/docs/readme_en.txt";
        $line = findLineInFile($versionFile, 'NAME: Prestashop ');
        $version = str_replace(array("\r", "\n", 'NAME: Prestashop '), '', $line);
    }

    if (!$version) {
        return false;
    }

    return array('name' => 'PrestaShop', 'version' => $version, 'dir' => $realdir, 'source' => $versionFile,
        'updated' => checkIsUpdated($version, $VERSIONS['prestashop']) );
}

function checkOpenCartVersion($fileName, $path)
{
    global $VERSIONS;

    if (false === strpos($path, 'admin/controller/catalog')) {
        return false;
    }

    $realdir = dirname(dirname(dirname($path)));

    if (!file_exists("$realdir/admin/index.php")) {
        return false;
    }
    
    $config = @file_get_contents("$realdir/admin/index.php");
    $version = getOption('VERSION', $config, OPT_TYPE_CONST);

    if (!$version) {
        return false;
    }
    
    return array('name' => 'OpenCart', 'version' => $version, 'dir' => $realdir,
        'updated' => checkIsUpdated($version, $VERSIONS['opencart']) );
}

function checkTypo3Version($fileName, $path)
{
    global $VERSIONS;
    
    $realdir = $fileName === 'config_default.php' ? dirname($path) : dirname(dirname(dirname(dirname($path))));
    
    $config = @file_get_contents($path . '/' . $fileName);
    
    $version = getOption('TYPO3_version', $config, OPT_TYPE_CONST);
    if (!$version && $fileName === 'config_default.php') {
        // Before 4.8
        $version = getOption('$TYPO_VERSION', $config, OPT_TYPE_VAR);
    }
    
    if (!$version) {
        return false;
    }
    
    return array('name' => 'Typo3', 'version' => $version, 'dir' => $realdir, 'source' => $fileName,
        'updated' => checkIsUpdated($version, $VERSIONS['typo3']));
}
function checkTDThemesVersion($fileName, $path)
{
    global $VERSIONS;

    $version = findLineInFile($path . '/' . $fileName, 'define("TD_THEME_VERSION", ');

    if (!$version) {
        return false;
    }

    $version = trim($version);
    $version = preg_replace("@define\(\"TD_THEME_VERSION\", \"(\S+)\"\);@", '$1', $version);
    $themename = findLineInFile($path . '/' . $fileName, 'define("TD_THEME_NAME", ');
    $themename = trim(preg_replace("@define\(\"TD_THEME_NAME\", \"(\S+)\"\);@", '$1', $themename));
    if (!$themename) {
       return false;
    }
    return array('name' => 'tagDiv Theme ' . $themename, 'version' => $version, 'dir' => $path . '/' . $fileName, 'updated' => checkIsUpdated($version, $VERSIONS[$themename]) );
}

function checkTimThumbVersion($fileName, $path)
{
    global $VERSIONS;

    /* Check for timthumb version */
    if (!findLineInFile($path . '/' . $fileName, 'TimThumb')) {
        return false;
    }

    $version = findLineInFile($path . '/' . $fileName, "'VERSION'");
    $rversion = explode("'", $version);

    if (!isset($rversion[3])) {
        return false;
    }
    
    return array('name' => 'TimThumb', 'version' => $rversion[3], 'dir' => $path . '/' . $fileName,
        'updated' => checkIsUpdated($rversion[3], $VERSIONS['timthumb']) );
}

function checkRevSliderVersion($fileName, $path)
{
    $config = @file_get_contents("$path/$fileName");
    if (false === $config) {
        return false;
    }

    $version = getOption('$revSliderVersion', $config, OPT_TYPE_VAR);
    if (!$version) {
        return false;
    }

    if (version_compare($version, '4.1.5') < 0) {
        return array('name' => 'Slider Revolution', 'version' => $version, 'dir' => $path . '/' . $fileName,
            'oldplugin' => true, 'url' => 'https://www.themepunch.com/faq/how-to-update-the-slider/');
    }
    
    return false;
}

function checkShowBizVersion($fileName, $path)
{
    $config = @file_get_contents("$path/$fileName");
    if (false === $config) {
        return false;
    }
    
    $version = getOption('$showbizVersion', $config, OPT_TYPE_VAR);
    if (!$version) {
        return false;
    }

    if (version_compare($version, '1.7.2') < 0) {
        return array('name' => 'ShowBiz Plugin', 'version' => $version, 'dir' => $path . '/' . $fileName,
            'oldplugin' => true);
    }
    
    return false;
}


function checkDzsVideoGalleryVersion($fileName, $path)
{
    if (false === strpos($path, '/wp-content/plugins/dzs-videogallery/')) {
        return false;
    }

    $version = findLineInFile($path . '/' . $fileName, 'DZS Upload');

    if (strpos($version, 'version: 0.') !== false || strpos($version, 'version: 1.0') !== false) {
        return array('name' => 'dzs-videogallery', 'version' => $version, 'dir' => $path . '/' . $fileName,
            'oldplugin' => true);
    }
    
    return false;
}

function checkUploadifyVersion($fileName, $path)
{
    return array('name' => 'uploadify');
}

function checkHtaccess($fileName, $path)
{
    return array('name' => 'htaccess');
}


// ==================================
// The main version check loop

$VERSION_CHECKS = array(
    'system.module' => 'checkDrupalVersion',
    'bootstrap.inc' => 'checkDrupalVersion',
    'Mage.php' => 'checkMagentoVersion',
    'version.inc.php' => 'checkModXVersion',
    'configuration.php' => 'checkJoomlaVersion',
    'jce.xml' => 'checkJceVersion',
    'constants.php' => 'checkPhpBbVersion',
    'diagnostic.php' => 'checkVBulletinVersion',
    'version.php' => 'checkWordPressAndZenPhotoVersion',
    'checkout_shipping_address.php' => 'checkOsCommerceVersion',
    'revslider.php' => 'checkRevSliderVersion',
    'showbiz.php' => 'checkShowBizVersion',
    'TranslatedConfiguration.php' => 'checkPrestaShopVersion',
    'manufacturer.php' => 'checkOpenCartVersion',
    'upload.php' => 'checkDzsVideoGalleryVersion',
    'uploadify.php' => 'checkUploadifyVersion',
    '.htaccess' => 'checkHtaccess',
    'config_default.php' => 'checkTypo3Version',
    'SystemEnvironmentBuilder.php' => 'checkTypo3Version',
    'td_config.php' => 'checkTDThemesVersion',
);

function runVersionCheck($path, $checkFound)
{
    global $VULNERABLE_PLUGINS, $VERSION_CHECKS, $isNoise;
    
    $dh = @opendir($path);
    if (!$dh) {
        if ($isNoise) {
            echo "Open directory failed: " . escapeHtml($path) . "\n";
        }
        return;
    }

    while (($fileName = @readdir($dh)) !== false) {
        if ($fileName === '.' || $fileName == '..' || strpos($fileName, 'sucuribackup.') !== false) {
            continue;
        }

        $fullName = $path . '/' . $fileName;
        if (@is_link($fullName)) {
            if ($isNoise) {
                echo 'Skipping symlink directory: ' . escapeHtml($fullName) . "\n";
            }
            continue;
        }
        
        $res = false;
        if (isset($VERSION_CHECKS[$fileName])) {
            $res = call_user_func($VERSION_CHECKS[$fileName], $fileName, $path);
        } elseif (strpos($fileName, '.php') !== false &&
            (strpos($fileName, 'thumb') !== false ||
            strpos($fileName, 'Thumb') !== false ||
            strpos($fileName, 'crop') !== false)) {
            $res = checkTimThumbVersion($fileName, $path);
        } elseif (false !== strpos($path, '/wp-content/plugins/') && isset($VULNERABLE_PLUGINS[$fileName])) {
            $res = checkWpPlugin($path, $fileName);
        }
        if ($res) {
            call_user_func($checkFound, $fullName, $res);
        }
        
        if (@is_dir($fullName)) {
            if ($isNoise) {
                echo '    Reading Dir: ' . escapeHtml($fullName) . "\n";
            }
            runVersionCheck($fullName, $checkFound);
            @flush();
        }
    }
    closedir($dh);
}

// jsonDcode implementation that works with small jsons

class JSONError
{
}

$JSON_ESCAPE_CHARS = array('"' => '"', '\\' => '\\', '/' => '/', 'b' => "\10",
    'f' => "\f", 'n' => "\n", 'r' => "\r", 't' => "\t");

function jsonParseStr($json, &$pos)
{
    global $JSON_ESCAPE_CHARS;
    
    if ($pos >= strlen($json)) {
        return new JSONError;
    }
    
    $str = '';

    $start = $pos;
    
    while ($json[$pos] !== '"') {
        if ($json[$pos] !== '\\') {
            $pos++;
            if ($pos >= strlen($json)) {
                return new JSONError; // unterminated string
            }
            continue;
        }
        $str .= substr($json, $start, $pos - $start);

        $pos++;
        if ($pos >= strlen($json)) {
            return new JSONError; // unterminated escape sequence
        }
        
        if (isset($JSON_ESCAPE_CHARS[$json[$pos]])) {
            $str .= $JSON_ESCAPE_CHARS[$json[$pos]];
            $pos++;
            if ($pos >= strlen($json)) {
                return new JSONError; // unterminated string
            }
        } elseif ($json[$pos] === 'u' && $pos + 5 < strlen($json) &&
            ctype_xdigit(substr($json, $pos + 1, 4))) {
            $charCode = hexdec(substr($json, $pos + 1, 4));
            $pos += 5;
            // Encode UTF-8 (characters outside BMP are not supported in this version)
            if ($charCode < 0x80) {
                $str .= chr($charCode);
            } elseif ($charCode < 0x800) {
                $str .= chr(($charCode >> 6) | 0xC0) . chr(($charCode & 0x3F) | 0x80);
            } else {
                $str .= chr(($charCode >> 12) | 0xE0) . chr((($charCode >> 6) & 0x3F) | 0x80) .
                    chr(($charCode & 0x3F) | 0x80);
            }
        } else {
            return new JSONError; // invalid escape sequence
        }
        $start = $pos;
    }
    $str .= substr($json, $start, $pos - $start);
    
    $pos++;
    return $str;
}

function jsonSkipSpaces($json, &$pos)
{
    if ($pos >= strlen($json)) {
        return false;
    }
    
    while ($json[$pos] === ' ' || $json[$pos] === '\t' || $json[$pos] === '\n' || $json[$pos] === '\r') {
        $pos++;

        if ($pos >= strlen($json)) {
            return false;
        }
    }
    
    return true;
}

function jsonParseArray($json, &$pos, $isAssoc)
{
    $array = array();
    
    // Check for an empty array
    if (!jsonSkipSpaces($json, $pos)) {
        return new JSONError;
    }
    if ($json[$pos] === ']') {
        $pos++;
        return $array;
    }
    
    for (;;) {
        // Value
        $value = jsonParseAtom($json, $pos, $isAssoc);
        if (is_object($value) && get_class($value) === 'JSONError') {
            return $value;
        }
        $array[] = $value;

        // A comma or a closing bracket
        if (!jsonSkipSpaces($json, $pos)) {
            return new JSONError;
        }
    
        if ($json[$pos] === ']') {
            $pos++;
            return $array;
        } elseif ($json[$pos] !== ',') {
            return new JSONError; // expected bracket or comma
        }
        
        $pos++;
    }
}

function jsonParseObject($json, &$pos, $isAssoc)
{
    $object = $isAssoc ? array() : new stdClass;
    
    // Check for an empty object
    if (!jsonSkipSpaces($json, $pos)) {
        return new JSONError;
    }
    if ($json[$pos] === '}') {
        $pos++;
        return $object;
    }
    
    for (;;) {
        // Name
        if (!jsonSkipSpaces($json, $pos) || $json[$pos] !== '"') {
            return new JSONError;
        }
        $pos++;
        
        $name = jsonParseStr($json, $pos);
        if (is_object($name) && get_class($name) === 'JSONError') {
            return $name;
        }
    
        if (!jsonSkipSpaces($json, $pos) || $json[$pos] !== ':') {
            return new JSONError;
        }
        $pos++;
        
        // Value
        $value = jsonParseAtom($json, $pos, $isAssoc);
        if (is_object($value) && get_class($value) === 'JSONError') {
            return $value;
        }
        if ($isAssoc) {
            $object[$name] = $value;
        } else {
            // Add numeric names as strings
            // (if we convert array to an object instead, then the numeric keys will be inaccessible)
            $object->{$name} = $value;
        }

        // A comma or a closing brace
        if (!jsonSkipSpaces($json, $pos)) {
            return new JSONError;
        }
    
        if ($json[$pos] === '}') {
            $pos++;
            return $object;
        } elseif ($json[$pos] !== ',') {
            return new JSONError; // expected bracket or comma
        }
        $pos++;
    }
}

function jsonParseAtom($json, &$pos, $isAssoc)
{
    if (!jsonSkipSpaces($json, $pos)) {
        return new JSONError;
    }
    $ch = $json[$pos];
    
    if ($ch === '"') {
        $pos++;
        return jsonParseStr($json, $pos);
    } elseif ($ch === '-' || '0' <= $ch && $ch <= '9') {
        $atom = substr($json, $pos);
        if (preg_match('/^-?(?:0|[1-9][0-9]{0,8}+)(?![.eE])/', $atom, $match)) {
            $pos += strlen($match[0]);
            return intval($atom);
        } elseif (preg_match('/^-?(?:0|[1-9][0-9]*+)(?:\.[0-9]++)?(?:[eE][+-]?[0-9]++)?/', $atom, $match)) {
            $pos += strlen($match[0]);
            return floatval($atom);
        } else {
            return new JSONError; // Invalid number
        }
    } elseif ($ch === '[') {
        $pos++;
        return jsonParseArray($json, $pos, $isAssoc);
    } elseif ($ch === '{') {
        $pos++;
        return jsonParseObject($json, $pos, $isAssoc);
    } elseif ($ch === 'f' && substr($json, $pos, 5) === 'false') {
        $pos += 5;
        return false;
    } elseif ($ch === 't' && substr($json, $pos, 4) === 'true') {
        $pos += 4;
        return true;
    } elseif ($ch === 'n' && substr($json, $pos, 4) === 'null') {
        $pos += 4;
        return null;
    } else {
        return new JSONError;
    }
}

function jsonDcode($json, $isAssoc = false, $allowInternal = true)
{
    if (function_exists('json_decode') && $allowInternal) {
        return json_decode($json, $isAssoc);
    }
    
    $pos = 0;
    $ret = jsonParseAtom($json, $pos, $isAssoc);
    
    if (jsonSkipSpaces($json, $pos) || is_object($ret) && get_class($ret) === 'JSONError') {
        return null;
    }
    
    return $ret;
}

// ======================================================
// DB abstraction layer

class MySQLCommon
{
    function escapeName($name)
    {
        // See https://dev.mysql.com/doc/refman/5.7/en/identifiers.html
        return '"' . str_replace('"', '""', $name) . '"';
    }

    function begin()
    {
        $this->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
        $this->query('BEGIN;');
    }

    function commit()
    {
        $this->query('COMMIT;');
    }

    function rollback()
    {
        $this->query('ROLLBACK;');
    }

    function getTablesColumns($config, $withCompositeKeys = false)
    {
        $scannedTypes = array(
            'varchar' => 1, 'char' => 1,
            'tinytext' => 1, 'mediumtext' => 1, 'text' => 1, 'longtext' => 1,
            'binary' => 1, 'varbinary' => 1,
            'tinyblob' => 1, 'blob' => 1, 'mediumblob' => 1, 'longblob' => 1);

        // Get all tables
        $tablesResult = $this->query('SHOW TABLES;');

        $allTables = array();
        while ($tablesRow = $this->fetchRow($tablesResult)) {
            // Report tables that does not begin with the Wordpress prefix
            $table = $tablesRow[0];
            if (!empty($config['prefix']) && 0 !== strncmp($table, $config['prefix'], strlen($config['prefix'])) &&
                !isset($_GET['dump'])) {
                printMsg("\nWARN: Table " . $table . ' does not start with prefix ' .
                    $config['prefix'] . ';', ' whitelists and CMS-specific rules will not work for this table');
            }

            $allTables[$table] = array();

            // Get all columns
            $columnsResult = $this->query('SHOW COLUMNS FROM ' . $this->escapeName($table) . ';');
            $uniqueString = null;
            $compositePrimary = false;
            $compositeKeys = array();
            while ($columnsRow = $this->fetchAssoc($columnsResult)) {
                $type = $columnsRow['Type'];
                $pos = strpos($type, "(");
                if ($pos !== false) {
                    $type = substr($type, 0, $pos);
                }

                if (strtoupper($columnsRow['Key']) === 'PRI') {
                    if (isset($allTables[$table]['idname'])) {
                        $compositePrimary = true;
                    }

                    if ($withCompositeKeys) {
                        $compositeKeys[] = $columnsRow['Field'];
                    }

                    $allTables[$table]['idname'] = $columnsRow['Field'];
                }

                $type = strtolower(trim($type));
                if (!isset($scannedTypes[$type])) {
                    continue;
                }

                // Prefer unique string keys to display wp_options.option_name instead of the numeric ID
                if (strtoupper($columnsRow['Key']) === 'UNI') {
                    $uniqueString = $columnsRow['Field'];
                }

                $allTables[$table][] = $columnsRow['Field'];
            }

            if ($uniqueString !== null) {
                $allTables[$table]['idname'] = $uniqueString;
            } elseif ($withCompositeKeys && count($compositeKeys) > 1) {
                /* return idname as an array of primary keys */
                $allTables[$table]['idname'] = $compositeKeys[0];
            } elseif ($compositePrimary) { // Disable the cleanup for composite primary keys and no primary key
                unset($allTables[$table]['idname']);
            }
        }
        return $allTables;
    }

    function getColumnNamesTypes($table)
    {
        $columnsResult = $this->query('SHOW COLUMNS FROM ' . $this->escapeName($table) . ';');

        $binaryTypes = array('binary' => 1, 'varbinary' => 1,
            'tinyblob' => 1, 'blob' => 1, 'mediumblob' => 1, 'longblob' => 1);

        $numericTypes = array('tinyint' => 1, 'smallint' => 1, 'mediumint' => 1,
            'int' => 1, 'integer' => 1, 'bigint' => 1,
            'decimal' => 1, 'dec' => 1, 'numeric' => 1, 'fixed' => 1,
            'float' => 1, 'real' => 1, 'double' => 1, 'double precision' => 1);

        $names = array();
        $types = array();

        while ($columnsRow = $this->fetchAssoc($columnsResult)) {
            $names[] = $columnsRow['Field'];

            $type = $columnsRow['Type'];
            $pos = strpos($type, "(");
            if ($pos !== false) {
                $type = substr($type, 0, $pos);
            }
            $type = strtolower(trim($type));

            if (isset($numericTypes[$type])) {
                $types[] = 'num';
            } elseif (isset($binaryTypes[$type])) {
                $types[] = 'bin';
            } elseif ($type === 'bit') {
                $types[] = 'bit';
            } else {
                $types[] = 'other';
            }
        }

        return array($names, $types);
    }

    function exportRow($row, $types)
    {
        for ($i = 0; $i < count($row); $i++) {
            if ($row[$i] === null) {
                $row[$i] = 'NULL';
            } elseif ($types[$i] === 'bin') {
                // Story binary data as hex to avoid encoding problems
                $row[$i] = 'UNHEX(' . $this->escapeStr(bin2hex($row[$i])) . ')';
            } elseif ($types[$i] === 'bit') {
                // TODO: tests under PHP 4
                // See https://stackoverflow.com/questions/15106985/
                $row[$i] = "b'" . decbin($row[$i]) . "'";
            } elseif ($types[$i] === 'num') {
                $row[$i] = (string)$row[$i];
            } else {
                $row[$i] = $this->escapeStr($row[$i]);
            }
        }
        return implode(', ', $row);
    }

    function getCreateTableSql($table)
    {
        $res = $this->query('SHOW CREATE TABLE ' . $this->escapeName($table) . ';');
        $row = $this->fetchRow($res);

        if (!$row) {
            exit('Unexpected empty result from SHOW CREATE TABLE');
        }

        return $row[1] . ";\n\n";
    }

    function getCreateDBSql($db)
    {
        $res = $this->query('SHOW CREATE DATABASE ' . $this->escapeName($db) . ';');
        $row = $this->fetchRow($res);

        if (!$row) {
            exit('Unexpected empty result from SHOW CREATE DATABASE');
        }

        return $row[1] . ";\nUSE " . $this->escapeName($db) . ";\n\n";
    }

    function getDumpHeader()
    {
        return
            "SET NAMES 'utf8';\n" .
            "SET sql_mode='NO_AUTO_VALUE_ON_ZERO,ANSI_QUOTES,STRICT_TRANS_TABLES';\n" .
            "SET foreign_key_checks=0;\n";
    }

    function setModes()
    {
        $this->query("SET NAMES 'utf8';");
        $this->query("SET sql_mode='PIPES_AS_CONCAT,IGNORE_SPACE," .
            "NO_AUTO_VALUE_ON_ZERO,ANSI_QUOTES,STRICT_TRANS_TABLES';");
    }
}

class MySQLDriver extends MySQLCommon
{
    var $link;

    function connect($config)
    {
        // Connect to DB
        $host = $config['host'];
        if (isset($config['port'])) {
            $host .= ':' . $config['port'];
        }
        $this->link = @mysql_connect($host, $config['user'], $config['pass']);
        if ($this->link === false) {
            return 'Could not connect to MySQL database: ' . mysql_error();
        }

        mysql_select_db($config['db'], $this->link);

        $this->setModes();
        return true;
    }

    function disconnect()
    {
        mysql_close($this->link);
    }

    function escapeStr($str)
    {
        return "'" . mysql_real_escape_string($str, $this->link) . "'";
    }

    function query($sql, $forceResReturn = false)
    {
        global $isPlainText;
        $res = mysql_query($sql, $this->link);
        if (!$res) {
            if ($forceResReturn === true) {
                return $res;
            }

            $error = mysql_error($this->link);
            if (!$isPlainText) {
                $error = '<b>' . escapeHtml($error) . '</b>';
            }
            echo "\n" . escapeHtml(substr($sql, 0, 100)) . ' -- ' . $error . "\n";
            exit(1);
        }
        return $res;
    }

    function fetchAssoc($res)
    {
        $row = mysql_fetch_assoc($res);
        if (false === $row) {
            mysql_free_result($res);
        }
        return $row;
    }

    function fetchRow($res)
    {
        $row = mysql_fetch_row($res);
        if (false === $row) {
            mysql_free_result($res);
        }
        return $row;
    }

    function getAffectedRows()
    {
        return mysql_affected_rows($this->link);
    }

    function getName()
    {
        return 'MySQL database';
    }
}

class MySQLIDriver extends MySQLCommon
{
    var $link;

    function connect($config)
    {
        // Connect to DB
        $port = isset($config['port']) ? $config['port'] : null;
        $this->link = @mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db'], $port);
        if ($this->link === false) {
            return 'Could not connect to MySQLi database: ' . mysqli_connect_error();
        }

        $this->setModes();
        return true;
    }

    function disconnect()
    {
        mysqli_close($this->link);
    }

    function escapeStr($str)
    {
        return "'" . mysqli_real_escape_string($this->link, $str) . "'";
    }

    function query($sql, $forceResReturn = false)
    {
        global $isPlainText;
        $res = mysqli_query($this->link, $sql);
        if (!$res) {
            if ($forceResReturn === true) {
                return $res;
            }

            $error = mysqli_error($this->link);
            if (!$isPlainText) {
                $error = '<b>' . escapeHtml($error) . '</b>';
            }

            echo "\n" . escapeHtml(substr($sql, 0, 100)) . ' -- ' . $error . "\n";
            exit(1);
        }
        return $res;
    }

    function fetchAssoc($res)
    {
        $row = mysqli_fetch_assoc($res);
        if (false === $row) {
            mysqli_free_result($res);
        }
        return $row;
    }

    function fetchRow($res)
    {
        $row = mysqli_fetch_row($res);
        if (false === $row) {
            mysqli_free_result($res);
        }
        return $row;
    }

    function getAffectedRows()
    {
        return mysqli_affected_rows($this->link);
    }

    function getName()
    {
        return 'MySQLi database';
    }
}


function printFoundVersion($fullName, $res)
{
    global $VULN_SOFTWARE, $VULNERABILITIES;
    
    if ($res['name'] === 'htaccess') {
        if (isset($_GET['ht'])) {
            echo 'Checking htaccess: ' . escapeHtml($fullName) . "\n";
        }
        return;
    } elseif ($res['name'] === 'uploadify') {
        echo 'Warning: uploadify.php found at ' . escapeHtml($fullName) .
            ' . Please be sure that you have secured this plugin properly. You can find more info on: ' .
            "https://blog.sucuri.net/2012/06/uploadify-uploadify-and-uploadify-the-new-timthumb.html\n";
        return;
    }

    if ($res['dir'] === '.') {
        $res['dir'] = '/ (main folder)';
    }
    
    $info = ' inside: ' . escapeHtml($res['dir']) . ' - Version: ' . escapeHtml($res['version']);
    
    if (isset($res['source'])) {
        $info .= ' (from ' . escapeHtml($res['source']) . ')';
    }

    if (isset($res['oldplugin'])) {
        $info = ' at ' . escapeHtml($res['dir']) . ' - Version: ' . escapeHtml($res['version']) .
            ' - Please update this plugin immediately' .
            (isset($res['url']) ? ': ' . $res['url'] : '.');
        echo 'Warning: vulnerable ' . $res['name'] . ' plugin found' . $info . "\n";
    } elseif ($res['updated']) {
        echo 'OK: ' . $res['name'] . ' found (updated)' . $info . ".\n";
    } else {
        echo 'Warning: Found outdated ' . $res['name'] . $info . " - Please update asap.\n";
    }
    
    if ($res['name'] === 'WordPress') {
        if (isset($_GET['wpvulndb']) && isset($VULN_SOFTWARE['wordpress'][$res['version']])) {
            print( "\nAssociated vulnerabilities:\n" );
            foreach ($VULN_SOFTWARE['wordpress'][$res['version']] as $warningNo) {
                printf("%s - %s\n", str_repeat("\x20", 10), escapeHtml($VULNERABILITIES[$warningNo]));
            }
            print( "\n" );
        }
        if (isset($_GET['list-plugins'])) {
            listWordPressPlugins($res['config']);
        }
    } elseif ($res['name'] === 'TimThumb') {
        if (isset($_GET['ttupdate'])) {
            replaceTimThumb($fullName);
        }
    } elseif ($res['name'] === 'Joomla') {
        if (isset($_GET['list-plugins'])) {
            listJoomlaPlugins($res['config']);
        }
    }
}


// =========================
// TimThumb update functions

function backupFile($file)
{
    $backupCopy = $file . '_sucuribackup.' . time();
    if (!copy($file, $backupCopy)) {
        return false;
    }

    if (filesize($file) !== filesize($backupCopy)) {
        return false;
    }
    
    chmod($backupCopy, 000);

    $newfile = file($file);
    if ($newfile === false || empty($newfile)) {
        return false;
    }
    
    return true;
}

function replaceTimThumb($fileName)
{
    // Download the new version if not already downloaded
    global $NewTimThumb;
   
    if (!$NewTimThumb) {
        $NewTimThumb = file_get_contents('https://raw.githubusercontent.com/GabrielGil/TimThumb/564c00058271147af32da8ac665c00f6a1c4ac29/timthumb.php');
    }

    if (!strpos($NewTimThumb, 'define (\'VERSION')) {
        echo 'FAILED: TimThumb update at ' . escapeHtml($fileName) . " - Error on downloading new version\n";
        return;
    }

    // Backup the old file
    if (!backupFile($fileName)) {
        echo 'FAILED: TimThumb backup at ' . escapeHtml($fileName) . "\n";
        return;
    }

    // Replace the file with the downloaded version
    $fp = fopen($fileName, 'w');
    if (!$fp) {
        echo "Couldn't open ". escapeHtml($fileName) ."\n";
        return;
    }

    if (fwrite($fp, $NewTimThumb) === strlen($NewTimThumb)) {
        echo 'timthumb.php updated at ' . escapeHtml($fileName) . "\n";
    } else {
        echo 'FAILED: Unable to update TimThumb at ' . escapeHtml($fileName) . "\n";
    }

    fclose($fp);
}

// =====================
// List plugins

function printMsg($msg, $details = '')
{
    echo escapeHTML($msg . $details);
}


function getWordPressPlugins($configFileName)
{
    $configContent = file_get_contents($configFileName);
    if (false === $configContent) {
        echo 'Unable to read ' . escapeHtml($configFileName) . "\n\n";
        return array(array(), array());
    }
    
    $config = array(
        'host' => getOption('DB_HOST', $configContent, OPT_TYPE_CONST | OPT_TYPE_ENV),
        'user' => getOption('DB_USER', $configContent, OPT_TYPE_CONST),
        'pass' => getOption('DB_PASSWORD', $configContent, OPT_TYPE_CONST),
        'db' => getOption('DB_NAME', $configContent, OPT_TYPE_CONST),
        'prefix' => getOption('$table_prefix', $configContent, OPT_TYPE_VAR),
    );
    
    if (!$config['host'] || !$config['db'] || !$config['user']) {
        echo "WARN: No DB config\n\n";
        return array(array(), array());
    }
    
    $driver = function_exists('mysqli_connect') ? new MySQLIDriver() : new MySQLDriver();
    $errMsg = $driver->connect($config);
    if ($errMsg !== true) {
        echo escapeHtml($errMsg) . "\n";
        return array(array(), array());
    }
    
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $config['prefix'])) {
        echo 'Invalid prefix: ' . escapeHtml($config['prefix']) . "\n\n";
        return array(array(), array());
    }
    
    // Plugins
    $res = $driver->query('SELECT "option_value" FROM ' . $driver->escapeName($config['prefix'] . 'options') .
        ' WHERE "option_name" = \'_transient_plugin_slugs\';');

    $plugins = array();
    if ($row = $driver->fetchRow($res)) {
        $plugins = unserialize($row[0]);
        if (!is_array($plugins)) {
            echo 'Plugins error: ' . escapeHtml($configFileName) . "\n\n";
            return array(array(), array());
        }
    }
    
    // Themes
    $res = $driver->query('SELECT "option_value" FROM ' . $driver->escapeName($config['prefix'] . 'options') .
        ' WHERE "option_name" = \'_site_transient_theme_roots\';');
    
    $themes = array();
    if ($row = $driver->fetchRow($res)) {
        $themes = unserialize($row[0]);
        if (!is_array($themes)) {
            echo 'Themes error: ' . escapeHtml($configFileName) . "\n\n";
            return array(array(), array());
        }
    }
    
    $driver->disconnect();
    
    return array($plugins, $themes);
}

function sortWordPressPlugins($dir, $plugins)
{
    $outPlugins = array(array(), array(), array(), array());
    $dir .= '/wp-content/plugins/';
    
    foreach ($plugins as $plugin) {
        if (preg_match('@^([^/]+)/.+$@ ', $plugin, $m)) {
            $name = $m[1];
        } else {
            $name = basename($plugin, '.php'); // TODO ???
        }
        
        if (!preg_match('/^[0-9a-zA-Z._-]+$/', $name)) {
            $outPlugins[3][] = 'Invalid name: ' . $name;
            continue;
        }
        
        $fileName = realpath($dir . $plugin);
        if (substr($fileName, 0, strlen(realpath($dir))) !== realpath($dir) || !is_file($fileName)) {
            $outPlugins[3][] = 'Broken plugin: ' . $plugin . '=' . $fileName;
            continue;
        }

        $version = getWpPluginVersion($fileName);
        if (false === $version) {
            $outPlugins[3][] = 'Invalid version for ' . $name;
            continue;
        }
                
        if (!$data = @ file_get_contents('https://api.wordpress.org/plugins/info/1.0/' . $name)) {
            $outPlugins[3][] = 'Could not contact WordPress to check for update: ' . $name .
                ' version ' . $version;
            continue;
        }
        
        $data = (array) unserialize($data);
            
        if (!isset($data['version'])) {
            $outPlugins[2][] = 'Possible premium plugin ' . $name . ' version ' . $version;
            continue;
        }

        if (version_compare($data['version'], $version) > 0) {
            $outPlugins[0][] = $name . ' version ' . $version .
                ' - There is a new version available: ' . $data['version'];
        } else {
            $outPlugins[1][] = $name . ' version ' . $version .
                ' - You are up to date.';
        }
    }
    
    return $outPlugins;
}

function sortWordPressThemes($dir, $themes)
{
    $outThemes = array(array(), array(), array(), array());
    $dir .= '/wp-content';
    $themesDir = realpath($dir . '/themes/');
    
    foreach ($themes as $theme => $subdir) {
        if (!preg_match('/^[0-9a-zA-Z._-]+$/', $theme)) {
            $outThemes[3][] = 'Invalid name: ' . $theme;
            continue;
        }

        $fileName = realpath($dir . $subdir . '/' . $theme . '/style.css');
        if (substr($fileName, 0, strlen($themesDir)) !== $themesDir || !is_file($fileName)) {
            $outThemes[3][] = 'Broken theme: ' . $theme .
                ($theme !== '/themes' ? ', subdir: ' . $subdir : '');
            continue;
        }

        $version = getWpPluginVersion($fileName);
        if (false === $version) {
            $outThemes[3][] = 'Invalid version for ' . $theme;
            continue;
        }

        $url = 'https://api.wordpress.org/themes/info/1.1/?action=theme_information&request[slug]=';
        if (!$data = @ file_get_contents($url . $theme)) {
            $outThemes[3][] = 'Could not contact WordPress to check for update: ' . $theme .
                ' version ' . $version;
            continue;
        }
        
        $data = jsonDcode($data, true);
        
        if (!isset($data['version'])) {
            $outThemes[2][] = 'Possible premium theme ' . $theme . ' version ' . $version;
            continue;
        }
        
        if (version_compare($data['version'], $version) > 0) {
            $outThemes[0][] = $theme . ' version ' . $version .
                ' - There is a new version available: ' . $data['version'];
        } else {
            $outThemes[1][] = $theme . ' version ' . $version .
                ' - You are up to date.';
        }
    }
    
    return $outThemes;
}

function listWordPressPlugins($configFileName)
{
    list($plugins, $themes) = getWordPressPlugins($configFileName);
    $plugins = sortWordPressPlugins(dirname($configFileName), $plugins);
    
    echo "\n [Plugins]\n";
    
    $label = array('Outdated plugins', 'Updated plugins', 'Possible premium plugins', 'Errors');
    foreach ($plugins as $order => $arr) {
        if (count($arr) > 0) {
            echo ' ' . $label[$order] . ":\n";
        }

        foreach ($arr as $msg) {
            echo ' ' . escapeHtml($msg) . "\n";
        }

        if (count($arr) > 0) {
            echo "\n";
        }
    }
    
    echo "\n [Themes]\n";
    
    $themes = sortWordPressThemes(dirname($configFileName), $themes);
    
    $label = array('Outdated themes', 'Updated themes', 'Possible premium themes', 'Errors');
    foreach ($themes as $order => $arr) {
        if (count($arr) > 0) {
            echo ' ' . $label[$order] . ":\n";
        }

        foreach ($arr as $msg) {
            echo ' ' . escapeHtml($msg) . "\n";
        }
        
        if (count($arr) > 0) {
            echo "\n";
        }
    }
}



function listJoomlaPlugins($configFileName)
{
    $configContent = file_get_contents($configFileName);
    
    $config = array(
        'host' => getOption('$host', $configContent, OPT_TYPE_VAR),
        'user' => getOption('$user', $configContent, OPT_TYPE_VAR),
        'pass' => getOption('$password', $configContent, OPT_TYPE_VAR),
        'db' => getOption('$db', $configContent, OPT_TYPE_VAR),
        'prefix' => getOption('$dbprefix', $configContent, OPT_TYPE_VAR),
    );
    if (!$config['host'] || !$config['db'] || !$config['user']) {
        echo "WARN: No DB config\n\n";
        return;
    }
    
    $driver = function_exists('mysqli_connect') ? new MySQLIDriver() : new MySQLDriver();
    $errMsg = $driver->connect($config);
    if ($errMsg !== true) {
        echo escapeHtml($errMsg) . "\n";
        return;
    }
    
    if (!preg_match('/^[a-zA-Z0-9_-]*$/', $config['prefix'])) {
        echo 'Invalid prefix: ' . escapeHtml($config['prefix']) . "\n";
        return;
    }
    
    $res = $driver->query('SELECT "name", "type", "manifest_cache" FROM ' .
        $driver->escapeName($config['prefix'] . 'extensions') .
        ' ORDER BY "type", "name";');
    
    $group = null;
    while ($row = $driver->fetchRow($res)) {
        if ($group === null || $row[1] !== $group) {
            $group = $row[1];
            echo "\n";
        }
        
        $manifest_cache = jsonDcode($row[2], true);

        if (!isset($manifest_cache['version'])) {
            $manifest_cache['version'] = 'N/A';
        }

        printf(
            " Found Joomla %s - %s - version: %s\n",
            escapeHtml($row[1]),
            escapeHtml($row[0]),
            escapeHtml($manifest_cache['version'])
        );
    }
    
    $driver->disconnect();
}


// =====================
// checkHosting

function checkHosting()
{
    if (isset($_SERVER['SERVER_ADDR'])) {
         printf("Server Addr: %s\n\n", $_SERVER['SERVER_ADDR']);
    }

    // Detect Hosting provider
    echo "Hosting Provider: ";

    $provider = @ gethostbyaddr($_SERVER['SERVER_ADDR']);
    if (false !== $provider) {
        $providers = array(
            'secureserver.net' => 'GoDaddy',
            'bluehost.com'     => 'BlueHost',
            'hostgator.com'    => 'HostGator',
            'site5.com'        => 'Site5',
            'amazonaws.com'    => 'Amazon',
            'siteground.com'   => 'Siteground',
            'gridserver.com'   => 'MediaTemple',
            'linode.com'       => 'WPEngine',
            '1e100.net'        => 'Google',
            'dreamhost.com'    => 'DreamHost',
        );
    
        $match = "Unknown provider - $provider.";
        foreach ($providers as $host => $name) {
            if (false !== strpos($provider, $host)) {
                $match = $name;
                break;
            }
        }

        echo "$match\n\n";
    } else {
        echo "Unable to determine.\n\n";
    }

    // Check CloudProxy
    echo "CloudProxy Active: ";

    $addr = @ gethostbyname($_SERVER['HTTP_HOST']);
    $host = @ gethostbyaddr($addr);
    echo preg_match('@^cloudproxy[0-9]+\.sucuri\.net$@', $host) ? "Yes\n\n" : "No\n\n";
}

function checkMayBeHacked()
{
    $User_Agent = "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.117 Safari/537.36";
    $Curl = curl_init();
    curl_setopt($Curl, CURLOPT_URL, "https://www.google.com/search?hl=en&tbo=d&site=&source=hp&q=".$_SERVER['HTTP_HOST']);
    curl_setopt($Curl, CURLOPT_USERAGENT, $User_Agent);
    curl_setopt($Curl, CURLOPT_RETURNTRANSFER, TRUE);
    if (!ini_get('safe_mode') && !ini_get('open_basedir')) curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, TRUE);
    $Raw_Google_Output = curl_exec($Curl);
    curl_close($Curl);
    
    $Pattern = "/This site may harm your computer|This site (might|may) be hacked/";
    if (preg_match($Pattern, $Raw_Google_Output, $matches) === 1)
    {
       echo 'Google is flagging this site as \'may be hacked.\'',"\n\n";
       return 1;
    }

    $Pattern2 = "/302 Moved/";
    if (preg_match($Pattern2, $Raw_Google_Output, $matches) === 1)
    {
       echo 'Unable to check alerts on Google SERP.',"\n\n";
       return 2;
    }
    return 0;
}


echo "<pre>\n";
echo "Sucuri version report v1.1.1: " . $myversion . "\n\n";
echo "PHP Version: " . phpversion() . "\n\n";

checkHosting();

if (!isTerminal())  checkMayBeHacked();

$path = '.';
if (isset($_GET['up'])) {
    $path = '..';
} elseif (isset($_GET['upup'])) {
    $path = '../..';
} elseif (isset($_GET['upupup'])) {
    $path = '../../..';
}

runVersionCheck($path, 'printFoundVersion');

echo "\nCompleted.\n";
echo "</pre>\n";
exit(0);
