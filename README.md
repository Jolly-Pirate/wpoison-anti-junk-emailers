# Wpoison (PHP) v1.0 2016-01-18
  
This script is inspired by the perl script Wpoison http://www.monkeys.com/wpoison/  
I don't run CGI/PERL scripts, so I decided to write a php equivalent
which behaves in the same manner as the original Wpoison.  
I added a benchmark for server tweaking. You can keep it or comment it out.  

# Differences vs the original script
- Added a benchmark for server tweaking. You can keep it or comment it out.  
- Improved the calculated pause by changing its position in the code;  
This way, the pseudo web pages (random links) won't appear as soon as the page refreshes,
thereby preventing server overload.  
You can read about Wpoison's potential impact on CPU/bandwidth and how it deals with it:
http://www.monkeys.com/wpoison/safety.html

# Requirements
PHP 5+  
Dictionary file from ftp://ftp.monkeys.com/pub/wpoison/words.gz (or your own, one word per line)  
  
# Install
Download or clone this github repository: git clone https://github.com/budwig/wpoison-anti-junk-emailers  
Create a folder within your website's rootdir (e.g. /var/www/html/members) and put all the files into it.  
Rename or copy wpoison.php to email.php, for this example.  
I use members/email.php to make it look attracting for spammer web crawlers, but it can be anything you want.  
Make sure you edit the .htaccess file accordingly.  
Unpack the words.gz into the same folder: gunzip words.gz

# Usage
Put a link on your main page (or any other page of your website) with a href
http://yourdomain.com/members/email or http://yourdomain.com/members/email/  
Both will work, thanks to the .htaccess rules
  
# Note
The \<BIG\> tag is not supported in HTML5.  
It's a small detail though, if it doesn't work for you, remove it or use CSS instead.
