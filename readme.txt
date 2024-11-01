=== Matterport Shortcode ===
Contributors: MPEmbed, AntiochInteractive
Tags: matterport, shortcode
Requires at least: 4.0.0
Tested up to: 6.5.3
Stable Tag: 2.2.2
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embed Matterport 3D Spaces as Galleries with cached thumbnails, titles and addresses that open in a lightbox!  Responsive, 1 - 4 columns.

== Description ==
Easily embed Matterport Spaces with preview image and a pop-up.  Easily include address information and # of scans sourced directly from your Matterport tours.  Optimized with information caching to make a portfolio page load fast!  Includes a great admin page for refreshing cached information and quick access to your models @ MyMatterport.com.

New in v2.0 - MPEmbed.com enhancements including Minimaps, Image Enhancement Filters and deep integration of Google Analytics!

= Examples =

Single Tour:

`[matterport src="uKDy9xrMRCi" width="900"]`

Tour Gallery:

`[matterport cols="3" src="uKDy9xrMRCi,wV4vX743ATF"]`

Embed without Pop-Up:

`[matterport embed="true" src="uKDy9xrMRCi" width="900"]`

Embed with Labels:

`[matterport cols="3" src="uKDy9xrMRCi,wV4vX743ATF" showdate="true" address="1" showstats="1"]`

Embed with Parameters:

`[matterport cols="3" src="uKDy9xrMRCi,wV4vX743ATF" qs="1" hhl="1" title="2"]`

Embed with MPEmbed Parameters:

`[matterport cols="3" src="uKDy9xrMRCi,wV4vX743ATF" qs="1" minimap="1" filter="oversaturate"]`


= Required =

**src** (required)

* uKDy9xrMRCi - (Single Tour by ID)
* uKDy9xrMRCi,uKDy9xrMRCi,uKDy9xrMRCi - (Multiple tours by ID separated by commas)
* https://my.matterport.com/show/?m=uKDy9xrMRCi - Full URL (unnecessary, but supported)
* https://mpembed.com/show/?m=uKDy9xrMRCi - Full MPEmbed URL (if you're using Mattertags to set options or MPEmbed Premium)

= Display =

**cols**

* 1 (default) - Show tour(s) in single column
* 2, 3, 4 - Show tour(s) in multiple columns

**embed**

* false (default) - Display tour in lightbox popup on click
* true - Replace thumbnail with tour on click

**height**

* 540 (default) - Thumbnails load at 540 height and display responsively
* 360 (default for cols=2 or greater)
* ### - Set alternate height -- IT IS NOT NECESSARY TO SET BOTH WIDTH AND HEIGHT.

**width**

* 960 (default) - Thumbnails load at 960 width and display responsively
* 640 (default for cols=2 or greater)
* ### - Set alternate width

**window**

* NULL (default) - Open tours in an overlay
* _blank - Open tours in a blank tab/window
* customname - Open tours in an embedded iframe by id


= Customize =

**address**

* NULL (default) - Do not show address
* 1 - Show caption beneath thumbnail with Street, City, State ZIP

**label**

* NULL (default) - Source titles from Tour
* "My Tour" - Use shortcode defined title on tour
* "My Tour;My Second Tour;My Third Tour" - Use multiple titles separated by semicolons for multiple tours
* "hidden" - Do not show titles or any information below tour.

**showdate**

* NULL (default) - Do not show date.
* true - Show date of upload to my.matterport.com in caption
* modified - Show last modified date in caption

**showstats**

* NULL (default) - Do not show # of Scans
* 1 - Show # of Scans after address in caption

**welcome**

* Explore 3D Space - Replace 'Explore 3D Space' message with custom message.


= Matterport Showcase Configuration Parameters  =

All parameters  are fully supported as of 02/01/19.

[Matterport URL Parameters Reference](https://support.matterport.com/hc/en-us/articles/209980967-URL-Parameters)

With MPEmbed, you also can set &lang=it for the UI in Italian.

= MPEmbed Premium Parameters =

**mpembed**

* 1 - Force MPEmbed.  This is only useful if you are using MPEmbed Premium or MPEmbed Hidden Settings Mattertags and are not using other parameters.  Otherwise, using any of the MPEmbed parameters will automatically set this space to use MPEmbed.

**mpu**

* Premium User ID - Loads an MPEmbed Premium Space via your User ID

**mpv**

* Premium Space Version - Loads an MPEmbed Premium Space with Version #


= MPEmbed (Free) Parameters =

MPEmbed.com is a service created by the author of this plugin!  It uses the Matterport SDK to provide new features for your Matterport Spaces.

For a list of all supported MPEmbed Parameters, please visit the MPEmbed Documentation Page:

[MPEmbed Documentation](https://mpembed.com/docs/)

**pin**

* 0 - Disable 360 Placement Pins in Dollhouse / Floorplan Mode (undocumented)

**portal**

* 0 - Disable 360 Placement Portals in Walkthrough Mode (undocumented)



== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/wp-matterport-shortcode` directory, or install the plugin 
through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the [matterport] shortcode within any post or page on your site!

== Frequently Asked Questions ==

**Q: I've changed the title of my tour in my.matterport.com, but it won't change on my site!**
A: Visit Admin > Settings > WP Matterport Shortcode to refresh!

**Q: What is MPEmbed.com**
A: MPEmbed is an enhancement for Matterport Spaces that serves as an overlay that uses the Showcase SDK to add new features.  It's another project by the author of this Wordpress Plugin!

**Q: How do I use MPEmbed with WP Matterport Shortcode**
A: It's easy!  If you use any parameters that require MPEmbed, your tour will automatically load via MPEmbed!

**Q: Does WP Matterport Shortcode support MPEmbed Premium? **
A: Yes, simply use a full MPEmbed URL in the 'src' parameter.

**Q: I love the lightbox overlay thing.**
A: Thanks, it's Magnific Popup by Dmitry Semenov.  Go check out his site.  He makes some awesome stuff! 
http://dimsemenov.com/plugins/magnific-popup/

**Q: I'm already using Magnific Popup on my site and this plugin is causing issues.**
A:  wp_dequeue_script('magnific'); wp_dequeue_style('magnific');

**Q: Can you add features?**
A: For suggestions or inquiries, email support@mpembed.com

== Screenshots ==
1. Sample Output.
2. Sample of Shortcode in Editor.

== Changelog ==

= 2.2.2 =
* Bug fix for multi columns

= 2.2.1 =
* Added fixes to escape variable outputs
* Replaced cURL call with wp_remote_get
* Several minor fixes

= 2.2.0 =
* Added fix for Cross Site Request Forgery (CSRF) vulnerability using nonces

= 2.1.9 =
* Added fix for crashes in plugin admin
* Added fix for Cross Site Request Forgery (CSRF) vulnerability 

= 2.1.8 =
* Added fix for 'src' Cross Site Scripting (XSS) vulnerability

= 2.1.7 =
* Bug fix for embed parameter

= 2.1.6 =
* Added fix for Cross Site Scripting (XSS) vulnerability

= 2.1.5 =
* Added fix for 'src' Cross Site Scripting (XSS) vulnerability
* Added fix for broken thumbnail

= 2.1.4 =
* Added fix for 'mpv' (MPEmbed Version ID)
* Added url encoding for image, logo, bgmusic, minimapurl
* Added MPEmbed parameter support for compactdetails, openmt, bgmusicpaused, bgmusicpauseonmedia

= 2.1.3 =
* Resolved Admin Bug

= 2.1.2 =
* Resolved potential conflict with other plugins over a generic function name

= 2.1.1 =
* Added fix for 'mpu' (MPEmbed User ID)

= 2.1.0 =
* Added &showcase_version to force Showcase 3
* Added support for new Showcase 3.0.6 params: portal, pin
* Added support for MPEmbed Premium (mpv, mpu)
* Added support for all published MPEmbed (Free) parameters (https://mpembed.com/free-version/)

= 2.0.3 =
* "welcome" parameter now works.  Thanks marchettia

= 2.0.2 =
* Resolved error notices for tours without certain portions of addresses being available.

= 2.0.1 =
* Fixed - Seems all spaces were running through MPEmbed.  Not the worst idea in the world, but not what I was hoping to achieve.

= 2.0 =
* Adds support for MPEmbed.com
* Adds MPEmbed parameter support for info, details, mdir, mdirsearch, mt, hdir, logo, image, reels, nofade, ga, minimap, minimapurl, minimapfilter, fadehotspots, hotspots, filter, copyright, tint, c

= 1.9.3 = 
Fixed CSS that added a small black line below tours without labels.

= 1.9.2 =
Add welcome= parameter.  Replace 'Explore 3D Space' with a custom message.  (Replace spaces with %20)

= 1.9.1 =
* Fixed tiny bug where embedded galleries with multiple manually set titles were only displaying the first title.

= 1.9 = 
* Added 'embed=true' parameter to enable displaying Matterport Tour in place (without an overlay)

= 1.8.5 =
* Added formatted error messages when an invalid, or private tour is embedded.
* Fixed ts=# parameter

= 1.8.2 =
* Fixed a few PHP Notice Messages.

= 1.8.1 =
* Added 'allow="vr"' parameter to IFRAME to allow WebVR support for Chrome v62+ on mobile.  This only affects tablets as default behavior on small screens is to open in a new window.

= 1.8 =
* Swapped WeServ.nl for Matterport CDN with Image Resizing (new!)
* Added Params: width, height (default 940, 540)
* Removed Param: nocache
* Fixed PHP Warnings related to &title

= 1.7.1 =
* Added Params: dh, gt, hr, mt, title
* &mls=2 now supported
* Changed plugin-specific use of 'title' param to 'label'
* Legacy use of 'title' to label tours still supported if non-numeric

= 1.7.0 =
* Plugin name changed to: WP Matterport Shortcode (was: WP Matterport Shortcode Gallery Embed)
* Updated Banner, Wordpress.org Icons, and Admin Icon
* Removed unused VR icons.

= 1.6.9 =
* &lang - Now accepts any parameters (previous es, fr only)
* Fixed z-index conflicts with sticky menu themes with z-index: 999

= 1.6.8 =
* Fixed window parameter again... sorry, seems like the overlay broke.

= 1.6.7 =
* Fixed mls and title parameters
* Fixed 'undefined variable' bug when clearing admin cache.

= 1.6.6 = 
* Added 'nocache' parameter to bypass image caching for when you change the default thumbnail and it won't refresh.

= 1.6.5 = 
* Fixed window parameter... because coding and not testing is stupid.

= 1.6.4 =
* Added 'window' parameter to allow users to open tours in a new window or existing embedded iframe

= 1.6.3 =
* Faster loading images fixed.  Found a much easier method to seve from images.weserv.nl

= 1.6.1 =
* Faster loading images -- LINUX INSTALLS ONLY
* Now uses images.weserv.nl for image resizing and caching -- LINUX APACHE ONLY

= 1.5 =
* Now supports all parameters from https://support.matterport.com/hc/en-us/articles/209980967-URL-Parameters
* Added hhl, minzoom, maxzoom and zoomtrans
* Removed 'unbranded' parameter.  Please use 'brand'
* Removed 'floors' parameter.  Please use 'f'

= 1.4.11 =
* Added 'lang' parameter

= 1.4.10 =
* Added 'nozoom' parameter
* Removed 'VR Ready' Tag as all tours contain CoreVR
* Fixed 'start' parameter and limited to only work on single tour embeds.

= 1.4.9 =
* Fixed bug that was showing all tours unbranded.  Sorry about that.

= 1.4.8 =
* Fixed errors when displaying addresses
* Added QuickStart parameter (qs=1)
* Removed floors parameter
* Removed OpenGraph code (unnecessary)
* Changed unbranded parameter to brand 

= 1.4.7 = 
* Fixed error message caused by meta data change to address.

= 1.4.6 =
* Forced use of OpenMetaGraph tags for images after plugin broke.

= 1.4.5 =
* Tour will skip Lightbox when window is < 600px. (mobile)

= 1.4.4 =
* Fixed non-dollhouse thumbnail generation (broken in 1.4.3)

= 1.4.3 =
* Added support for showing default generated dollhouse thumbnail

= 1.4.2 =
* Added !important to lightbox max-width 1200px

= 1.4.1 =
* 'VR Ready' status appears on tours enhanced for Samsung VR
* Added showdate parameter (false/true/modified)
* Admin - Cached Tour Information displays by date created
* FIX - Duplicate database entries no longer generated on tours with short titles.

= 1.4 = 
* WPMS now saves and retrieves cached data to custom database table - wpms
* Admin - Moved to Top Level with a recognizable icon
* Admin - Plugins Page - Added Link to 'Settings / Cache Management'
* Admin - Added Screen Options - Columns 1,2,3,4 for fun!
* CSS Fix: Forced 'clear: both' to new rows in 2, 3 and 4 column layouts

= 1.3.1 =
* Added title="hidden" option to hide title area.

= 1.3 =
* Added WP Matterport Shortcode Admin Page
* Added ability to refresh data via Admin
* Added ability to quickly access model on MyMatterport.com via Admin
* Removed expiration on cached data.
* Fixed address="true" parameter.  Addresses now display.
* Added margin-bottom: 0 to .wpm img -- to override themes adding space below image.

= 1.2.1 =
* Automatically enqueues jQuery if not included by theme.
* Separated Magnific Pop-Up Javascript/CSS, enqueued as 'magnific' - so that it can be disabled via theme -- if perhaps one uses WF Magnific or IW Magnific plugins.
* Changed line-height to 56px for Arrow -- tnx IBAdvantage

= 1.2 =
* Title and Image URL cached as transients - much faster!
* Added address option: address=TRUE to show street/city/state/zip
* Added showStats option: showStats=TRUE to show XXX Scans
* Fixed source image sizes to 960 width in 1 Column Mode; 640x320 for 2 and higher.
* Added retrieval of Title/Address/# va JSON with OpenGraph fallback
* Changed CSS prefix to wpm- as a universal prefix.
* Updated MagnificPopup to v1.1.0

= 1.1.1 =
* Featured: Added title parameter.  Add a title from the shortcode to single or multiple tours (separate with semi-colon)
* Feature: Added Spanish, French and German internationalization of the ONE line of text -- Explore 3D Space

= 1.0.3 =
* Feature: Added class - 'wpm[matterport ID]' to containers
* Fix: Internet Explorer - Fixed thumbnails by disabling use of Google Image Cache in IE.
* Fix: Added 1em of space below each tour when columns become 100% width (< 740px)
* Optimization: Thumbnail image size set to 600 if using columns (Instead of 900)

= 1.0.1 =
* Added floors, guides help and start parameters.
* Added 1em of margin below shortcode output.

= 1.0 =
* Initial Release.
