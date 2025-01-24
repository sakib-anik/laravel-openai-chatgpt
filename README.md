
https://github.com/FilipQL/cacert.pem

Download cacert.pem

cacert.pem
Fix cURL error 60 SSL certificate problem

If you are getting the following error message:

cURL error 60: SSL certificate problem: unable to get local issuer certificate
Download cacert.pem
Put it in: php\extras\ssl (if you are using XAMPP, put it in: C:\xampp\php\extras\ssl)
In your php.ini set the curl.cainfo to the path of the cacert.pem. For example:
curl.cainfo = "C:\Program Files\PHP\v7.0\extras\ssl\cacert.pem"
... or, if you are using XAMPP:

curl.cainfo = "C:\xampp\php\extras\ssl\cacert.pem"
Restart your webserver/Apache.
