# WP_Project_Management_Tool
A web application using the Wordpress CMS, written in HTML, CSS, PHP, Javascript and jQuery that allows users to manage projects/tasks, clients, employees, and timesheets.

## Initial Setup (after setting up your database, installing Wordpress, and activating the theme)

In the Dashboard (Settings)
	1) Go to Settings -> Permalinks -> Select "Post name" -> Click the "Save Changes" button
	2) Go to Settings -> General -> Find the "Anyone can register" checkbox and check it (Optional; do not do this if you want to only add users yourself)
	3) Go to Settings -> General -> Select "Subscriber" for the "New User Default Role".
	4) Go to Settings -> Discussion -> Select "Allow people to post comments on new articles"
	5) Go to Settings -> Discussion -> Select "Users must be reigstered and logged in to comment"

In the Dashboard (Forms)
	* Activate your license of Gravity Forms
	* Go to Forms -> New Form/Add New -> Form Title -> "Timesheet" -> Click the Create Form Button
	* Add 6 fields:
		A) Date (Advanced Fields -> Date)
		B) Start Time (Advanced Fields -> Time)
		C) End Time (Advanced Fields -> Time)
		D) Client (Standard Fields -> Drop Down)
		E) Task Description (Standard Fields -> Paragraph Text)
		F) Worker Name (Standard Fields -> Single Line Text)
	* I've added images to show what each of the field settings should be populated with (if you do not see images for an Appearance tab for that field it means that the defaults were used).
imgs
	* Take note of ALL field ID numbers and your form ID number (refer to the image below to get these numbers).
img
	* Go to Forms -> select your "Timesheet" form -> Settings -> Confirmations -> I hope you took note of your form ID number!!! -> Confirmation Type: Text -> Message: [gravityform id="your form ID # goes here" title="false" description="false"] (refer to the image below for clarification).
img
	* OPTIONAL: Go to Forms -> select your "Timesheet" form -> Settings -> Notifications -> toggle the notification slider to OFF.


In the Dashboard (Appearance)
	1) Go to Appearance -> Customize -> Select the Logo & GForms Selection on the left sidebar.
	2) Add/Upload an image to use as your site logo.
	3) I hope you took note of your form ID and field ID numbers from the timesheet form! Enter in the respective IDs to their fields in this section under the site logo selector.
	4) Click the Save & Publish button.

In the Dashboard (Pages):
	1) Add pages with titles: Clients, Tasks Assigned To Me, Timesheet, and Timesheet Review.
	2) For the Clients page assign the "Clients Archive Page" template.
	3) For the Timesheet Review page assign the "Timesheet Admin Page" template.
	4) For the Timesheet page assign the "Timesheet Page" template.
	5) For the Timesheet page add this shortcode to the Visual/WYSIWYG editor: [gravityform id="1" title="false" description="false"]
	6) Go to Settings -> Reading -> Select "A static page (select below)" for the "Front page displays" section.
	7) For "Front page:" select the page "Tasks Assigned To Me". Click the Save Changes button.

In the Dashboard (Appearance)
	1) Go to Appearance -> Menus -> create a new menu.
	2) For the Menu Name input "PM Menu".
	3) Add the pages: Tasks Assigned To Me, Timesheet, Timesheet Review, and Clients.
	4) Select "Custom Links" from the left sidebar and input this url: http://yourdomain.com/wp-login.php?action=logout.
	5) For the Link Text input "Logout".
	6) Under the Menu Settings assign the Display location to Project Management Nav.
	7) Click the Save Menu button.
