# Etsy XML Feed

Output an Etsy shop's listings as an XML Feed using Etsy's API, JSON and PHP.

How to use
----------

Register a provisional app with Etsy Developers at https://www.etsy.com/developers/register. For more information about this process, read Etsy's handbook at https://www.etsy.com/developers/documentation/getting_started/register. The app needs the following settings:

1. What type of application are you building? - **Seller Tools**
- Is your application commercial? Will you charge people to access the application? - **No**
- Who will be the users of this application? - **Just myself or colleagues**

Open and edit the etsyxml.php document. Replace the following variables:

    $api_key = "api_key";
    $username = "etsy_username";

When saved view the source of the PHP page to see the XML output.

Demo
----------

View the demo at http://files.katherinecorydesign.com/etsyxml.php using **[marymaryhandmade](http://www.etsy.com/shop/marymaryhandmade)** as an example store.

Contact / History
----------

I created this script a few years ago to import a shop's Etsy listings into Drupal. I'm sharing this code because I remember struggling to find another solution to the issue of exporting Etsy data into XML.

If you have any questions or improvements feel free to leave an issue, fork this project or create a pull request. I can also be reached at hello@katherinecory.com
