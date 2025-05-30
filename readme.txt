Plugin Name: Hordes
Plugin URI: http://themes.tradesouthwest.com/wordpress/plugins/client
Description: Add curated list of links with titles icons and categories.
Version: 1.0.5
Requires PHP: 7.5
Requires CP: 2.1
Demo: https://plugins.classicpress-themes.com
Author: tradesouthwest
Author URI: http://tradesouthwest.com/
Tags: bookmark, save links, link, organize, directory, library, marker, digest, favorites 

== Description ==
Creates a front side submitted form that allows logged in user to add links or bookmarks of their favorite websites. 
Just copy and paste your address into the link text box and add then a title. Hordes will do the rest. 
There are many options including the ability to show all the data about your link, 
or to only show the title and the link which is handy to show more links on the page when you know what 
they are by only looking at the title and the link. 

If you need to search for a title or a link or any of the tags you can do so using the search box 
or Horde's convenient Alphbetic search tool. Kind of like a indexing system that shows you everything that is under "A" for example.

Store all this information with quick search reminder tags such as the name of the site or the name of the subject for which you wanted to remember the site for.


== Features ==
* Create a curated list that is easy to navigate
* Find anything using category, tag, link or title hints
* Save all your favorite links - catalog style
* Use to index company or group reference links 
* Front Side Submit Form
* Tall list shows title, link, favicon from site, all metadata
* Shorter list displays only the title and the link.
* Category and Tag cloud widget included for sidebars
* Alpha Checkbox Search Bar
* Auto inserts favicon for any saved site
* Color options for List Title
* Color options for List Links
* Check to not show favicons in the Tall list 
* Not training wheels required - just add shortcode to page
* shortcode 'hordes_list'
* shortcode 'hordes_submit_post'
* shortcode 'hordes_search_bar'
* "Success" message with navigation appears after submitting your new link
* Set site login to be redirected instantly to form submittal page


== Installation ==
1. Upload hordes.zip to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Look for link to plugin from the "Tools" Menu

== Setup ==
    This section describes how to install the plugin and get it working.
    1. The shortcode to add inside of your post or page to show list is: [hordes_list] 
    2. The shortcode to add inside of your post or page to show a custom alphabetic search bar is: [hordes_search_bar] 
    3. To add a front end form to a page use shortcode: [hordes_submit_post] 
    4. Go through all options in Hordes Settings to activate what you want to use.
    5. All Categories must be set up from the Admin Dashboard! 
    6. Tags can be added from the front side form. See FAQ below.

== Instructions ==    
*Check to not show favicons in the Tall list (Optional)
    By removing favicons in your list it saves some bandwidth. Favicons are loaded from the Google favicons generator. More info at: https://www.labnol.org/internet/get-favicon-image-of-websites-with-google/4404/

*Check to Show a lower profile list of links.
    Shorter list displays only the title and the link. .

*Color for List Title
    If field is left unchanged then the titles will stay the same as the theme default titles color.

*Color for List Links
    Colors can be set to help brand your page to match your theme.

*What Page is shortcode 'hordes_list' on?
    This must be set if you want a link on the form page. The link will show on the popup "Success" message after submitting your new link.

*What Page is shortcode 'hordes_submit_post' on?
    Set page to be redirected upon login. Turn on or off Using the next setting below.
    This is only a convenience to administrators to save time when you are in a hurry to add links.

*Redirect on Login
    Check to Redirect directly to Form Submit Page. Only works for logged In Administrators. 

*Front Side Submit Form
    To add a front end form to a page use shortcode: [hordes_submit_post]
    The form will allow you to add title, link and tags to your post, but, only Administrators and  Editors will see the form on the public side of your Website. A Featured Image maybe added to every listing but you will need to do this from the editor so that you can control the assets for each picture.

*Show Alpha Checkbox Search Bar
    The shortcode to add inside of your post or page to show a custom alphabetic search bar is: [hordes_search_bar]
    Works for categories as well as links and titles.

== F. A. Qs. ==
*Q I added a new tag to my listing using the WordPress editor from the admin side and now I do not see the new tag on the front side pages.
*A Because of the type of security used for front side posting of your form, a tag will only be seen on a listing if it was entered from the front side form.
If you enter any additional tags from the admin side (editor) then you will not see them buy will find your listing if you click or search using any new tag.
line 26 hordes-formpage <i> | </i><em class="hrds-author"><?php the_author(); ?></em>

== Screenshots ==
1. hordes-talllist-a1.png:      tall list
2. hordes-front-short-1.png: short list
3. hordes-search-1.png:      search page
4. hordes-singlepg.png:      single item page -
1. hordes-adminpanel-a1.png: admin panel
2. hordes-alpha.png:         alphabetic search bar
3. hordes-editor-1.png:      editing page -
4. hordes-export.png:        export capabilities -
5. hordes-success1.png:       front side form -
5. hordes-form-2.png:        front side form -

== Change Log ==
May 24 2024
* Add search functions
Dec 26 2018
* font changes in tag cloud
