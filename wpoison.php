<?php

/*
  Wpoison (PHP) v1.0 2016-01-18

  This script is inspired by the perl script Wpoison http://www.monkeys.com/wpoison/
  I don't run CGI/PERL scripts, so I decided to write a php equivalent
  which behaves in the same manner as the original Wpoison.

  Differences vs the original script:
  - Added a benchmark for server tweaking. You can keep it or comment it out.
  - Improved the calculated pause by changing its position in the code;
  This way, the pseudo web pages (random links) won't appear as soon as the page refreshes,
  thereby reducing stress on the server.
  You can read about Wpoison's potential impact on CPU/bandwidth and how it deals with it:
  http://www.monkeys.com/wpoison/safety.html

  Requirements:
  PHP 5+
  Dictionary file from ftp://ftp.monkeys.com/pub/wpoison/words.gz (or your own, one word per line)

  Install:
  Download or clone this github repository: git clone https://github.com/budwig/wpoison-anti-junk-emailers
  Create a folder within your website's rootdir (e.g. /var/www/html/members) and put all the files into it.
  Rename or copy wpoison.php to email.php, for this example.
  I use members/email.php to make it look attracting for spammer web crawlers, but it can be anything you want.
  Make sure you edit the .htaccess file accordingly.
  Unpack the words.gz into the same folder.

  Usage:
  Put a link on your main page (or any other page of your website) with a href to:
  http://yourdomain.com/members/email or http://yourdomain.com/members/email/
  both will work, thanks to the .htaccess rules

  Note:
  The <BIG> tag is not supported in HTML5.
  It's a small detail though, if it doesn't work for you, remove it or use CSS instead.

 */

ob_end_flush(); // disable output buffering for this page, needed for the flush() and sleep() to work properly below...

$start_time = microtime(true); // Benchmark start

$randomBGCOLOR = '#' . strtoupper(dechex(mt_rand(0, 10000000)));
$randomTEXT = '#' . strtoupper(dechex(mt_rand(0, 10000000)));
$randomLINK = '#' . strtoupper(dechex(mt_rand(0, 10000000)));
$randomVLINK = '#' . strtoupper(dechex(mt_rand(0, 10000000)));

echo
"<HTML>
<HEAD>
<TITLE>";
randomwords(3, 7);
echo
"</TITLE>
<META NAME='ROBOTS' CONTENT='NOINDEX, NOFOLLOW'>
</HEAD>
<BODY BGCOLOR=$randomBGCOLOR TEXT=$randomTEXT LINK=$randomLINK VLINK=$randomVLINK>
<BIG>
";

// Edit to your liking, check the benchmark to tweak performance according to your server
randomwords(10, 30);
print ("<P>\n");
randomemails(10, 30);
print ("<P>\n");
randomwords(10, 30);
print ("<P>\n");

//Calculated Pause with "flush and sleep"
//improvement vs the original script, put the 4 second delay here, 
//so the "trapping" random links are delayed before the page finishes
flush();
sleep(4); //Sleep for four seconds to avoid server overload.
randomlinks(5, 10);

print ("<P>\n");
randomwords(10, 30);
print ("<P>\n");

// Benchmark end
echo "This page was generated in " . (number_format(microtime(true) - $start_time, 4) * 1000) . "ms.\n";

print ("</BIG>\n</BODY>\n</HTML>\n");

// end of the HTML part
// Functions
function randomwords($min, $max) {
  $lines = file("words"); // dictionary file
  for ($a = 0; $a <= mt_rand($min, $max); $a++) {
    $string .= str_replace("\n", '', $lines[mt_rand(1, 235880)]) . " "; // concatenate the words while removing the carriage return from them
  }
  echo $string;
}

function randomlinks($min, $max) {
  // script name without the php extension, IF NEEDED
  // $_SERVER["SCRIPT_NAME"] /folder/script.php using SCRIPT_NAME is better, takes care of any subfolders the script might be in
  // $_SERVER["SCRIPT_FILENAME"] // /var/www/html/folder/script.php
  $scriptname = substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "."));
  $lines = file("words");
  for ($b = 0; $b <= mt_rand($min, $max); $b++) {
    $string = ""; //clear the string first to avoid incremental appending to it
    for ($a = 0; $a <= mt_rand($min, $max); $a++) {
      $string .= str_replace("\n", '', $lines[mt_rand(1, 235880)]) . " "; // concatenate the words while removing carriage return from them
      $word = str_replace("\n", '', $lines[mt_rand(1, 235880)]);
    }
    echo "<A HREF=\"" . $scriptname . "/" . $word . "\">" . $string . "</A><BR>\n"; // without
  }
}

function randomemails($min, $max) {
  // array of possible top-level domains
  $tld = ARRAY("com", "biz", "info", "org", "gov", "net",
      "uk", "su",
      "af", "al", "dz", "as", "ad", "ao", "ai", "aq", "ag", "ar", "am", "aw", "au",
      "at", "az", "bs", "bh", "bd", "bb", "by", "be", "bz", "bj", "bm", "bt", "bo",
      "ba", "bw", "bv", "br", "io", "bn", "bg", "bf", "bi", "kh", "cm", "ca", "cv",
      "ky", "cf", "td", "cl", "cn", "cx", "cc", "co", "km", "cg", "ck", "cr", "ci",
      "hr", "cu", "cy", "cz", "dk", "dj", "dm", "do", "tp", "ec", "eg", "sv", "gq",
      "er", "ee", "et", "fk", "fo", "fj", "fi", "fr", "fx", "gf", "pf", "tf", "ga",
      "gm", "ge", "de", "gh", "gi", "gr", "gl", "gd", "gp", "gu", "gt", "gn", "gw",
      "gy", "ht", "hm", "hn", "hk", "hu", "is", "in", "id", "ir", "iq", "ie", "il",
      "it", "jm", "jp", "jo", "kz", "ke", "ki", "kp", "kr", "kw", "kg", "la", "lv",
      "lb", "ls", "lr", "ly", "li", "lt", "lu", "mo", "mk", "mg", "mw", "my", "mv",
      "ml", "mt", "mh", "mq", "mr", "mu", "yt", "mx", "fm", "md", "mc", "mn", "ms",
      "ma", "mz", "mm", "na", "nr", "np", "nl", "an", "nc", "nz", "ni", "ne", "ng",
      "nu", "nf", "mp", "no", "om", "pk", "pw", "pa", "pg", "py", "pe", "ph", "pn",
      "pl", "pt", "pr", "qa", "re", "ro", "ru", "rw", "kn", "lc", "vc", "ws", "sm",
      "st", "sa", "sn", "sc", "sl", "sg", "sk", "si", "sb", "so", "za", "gs", "es",
      "lk", "sh", "pm", "sd", "sr", "sj", "sz", "se", "ch", "sy", "tw", "tj", "tz",
      "th", "tg", "tk", "to", "tt", "tn", "tr", "tm", "tc", "tv", "ug", "ua", "ae",
      "gb", "us", "um", "uy", "uz", "vu", "va", "ve", "vn", "vg", "vi", "wf", "eh",
      "ye", "yu", "zr", "zm", "zw");
  // create a random number of emails
  for ($j = 0; $j < mt_rand($min, $max); $j++) {
    // min and max random length can be changed of course, as well as the characters list for the shuffle
    $a = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, mt_rand(5, 12));
    $a .= "@";
    $a .= substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, mt_rand(5, 12));
    $a .= ".";
    $a .= $tld[mt_rand(0, (sizeof($tld) - 1))];
    echo "<A HREF=\"mailto:" . $a . "\">" . $a . "</A><BR>\n";
  }
}

?>
