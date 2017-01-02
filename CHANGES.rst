Version 1.0.3
Changes:
	Apply DataTables
	Delete button
	Create Table Data for requests adnd users 
		DB Name: ci_request

		
Version 2.0.4
Date 7/24/2016
Changes:
	Implement CRUD on datatanles - OK
	revision of tables
	Under maintenance of calendar and Login
TODO:
	Can't perform calendar - SHOULD CLEAN THIS UP and use OOP technique
	issue @ http://localhost/CI/request_anabelle_v2.0.2/index.php/calendar/getEvents?start=2016-06-26&end=2016-08-07&_=1469419338430
		  @ http://localhost/CI/request_anabelle_v2.0.2/index.php/calendar
		  

Version 2.0.5
Date 7/31/2016
Changes:
	Resolve "index.php" from 
		@ http://www.kodingmadesimple.com/2014/12/codeigniter-remove-index.php-from-url.html
		".htaccess" content
			RewriteEngine On
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteCond %{REQUEST_FILENAME} !-d
			RewriteRule ^(.*)$ index.php/$1 [L]
	Used USER-LOGIN-REGISTER 
		@ https://github.com/hedii/Codeigniter-login-logout-register
	User Update with password but not valided
		(I got 3 hours because of this line 
			url : "<?php echo site_url('user/ajax_edit/')?>/" + id, 
			@ profile.php)
	Change title and name of the site
	Added top panel and user login and registration with validation id user is logged in or not
TODO:
	Make ff. as MODAL:
		Approve and Reject 
		Delete row
	Add GENDER or Date of birth at USER
	Validate all fields including the USER PROFILE and TABLES
	Issue on validatio @ function profile():190 User.php
	EXPORT BUTTON affects the UI of Pagination
	Create Calendar
	Create another page for initiator and requestor
	Set alert flag on the FORMs
		Register, Add request, Delete, Approve/Reject, Update Profile
		LIKE registration form and Login form
	After update on the User, Details should use Javascript to normalize the data presentation

	
	
Version 2.0.6
Date 8/9/2016
Changes:
	Add send_email function at User.php (need to configure who will be the recipients)
	
	
	
Version 2.0.7
Date 8/19/2016
Changes:
	Doing request_view.php 's Modal for Viewing and Request Reject/Accept
Meeting on Wed 24th of August 2016 with Sir Oliver Ktigbak for Briefing od the website
	
	
	
Version 2.0.8
Date 8/22/2016
Changes:
		LINE 297 @ footer.php
		Set the Onlcick using JScript to EDIT that particular Request
		Displaying the Request Details on using LABELS

	
		
Version 2.0.9 FILE/FOLDER (C:\xampp2\htdocs\CI\request_anabelle_v2.0.9)
Date 8/23/2016
Changes:
	View Details - ok
	Reject/Accept Button - ok
TODO:
	1. What specific column should be displayed on the DATE Calendar - All approve activity only
	2. What area column should be assigned to every user/staff from that area of request covered -
	3. What will be the content of the Email to the Recipients or the Initiator
	4. List of Site Name for Request
		- VALERO,CARMONA,BACOOR,SANJUAN

		VALERO EMAIL  : gasemilla@globe.com.ph - george semilla
		CARMONA EMAIL : obkatigbak@globe.com.ph  - oliver katigbak
		BACOOR EMAIL  : mdcabreros@globe.com.ph - Mc cabreros
		SANJUAN EMAIL : eprobles@globe.com.ph - Eden Robles

	5. WHO/WHERE/HOW (FOr server authentication for communication between users and the server)
		// 'protocol' => 'smtp',
		// 'smtp_host' => 'ssl://smtp.googlemail.com',
		// 'smtp_port' => 465,
		// 'smtp_user' => 'ric17101raguine@gmail.com',
		// 'smtp_pass' => '****'
		*Change Date from DateTime to Date only for data manipulation purposes
		Insert Time to Activity Date or Time_end to Date with its respective columns
	6. Which and what is the Start Time and End Time of the Request from the table
		Date = date today ( date activity requested )
		Activity date = date of activity

	Sir Oliver: 8/24/2016 1:30 pm AT Greenwhich Ayala Makati
		ROLES
			Approver:
				Viewing of Data - ok
				Delete Request - ok
				Approving Reject|Accept - ok
				No Create  - ok
				No Modify - ok
			Calendar Role:
				All but can create at
			Requestor:
				Create Request - ok
				Viewing Request - ok
				Delete Request - ok
				Modify  - ok
				No Approve  - ok
		CALENDAR
			all approved only


Version 3.1.0
Date 8/24/2016
Changes:
	Rearrange Columns on the Tables and put the action in front and _status
		LINE 43 - footer.php
			"aoColumnDefs": [
				{ 
					"targets": [ 0 ], //last column -1
					"orderable": false, //set not orderable
					"width": "250",  // set fixed width of last col
					targets: [ 0 ],
				},
			], 
	Remove Date on the request_view.php at Modal Form - ok
	Display only the Accepted Request on the Calendar - ok
TODO:
	Resolve 'NaN-NaN-NaN' on Activity Date Create/Add New at Modal View
	Email to every person/requestor in that particular site_name including their supervisor
	Revise _status to Approved, Rejected, New instead of 0, 1, 2 to better the searchbox performance - ok 
		Since search for the text is not do-able it only accept 012 as search/sort values
QUESTION:
	Should send email on reject?
	Action on Calendar for Requestor and Approver.
	What date will be recorded when date box is clicked on calandar...
		Is it date_requested or activity_date?
	
	
Version 3.1.1
Date 8/30/2016
Changes:
	Add 'is_admin' column in 'is_approver' which is equal - ok
	Approval Status: - ok
		0 - New 		= null
		1 - Accepted	= 1
		2 - Rejected	= 2
TODO:
	Do the Separate Table and creation of Request for Requestor and Approver - ok
	Email sendin to respective AREAs
	SORTABLE column has issue on sorting data from the table!!!
	LINE 232
		ajax_getAreaEmailRecipients
	ADD Remarks to why do you want to reject the request (Onclick of Reject Button on View of Approver)
	OPTIONAL
		PUT THE DECLARATION OF THE GMAIL SSL AND ITS PRIVATE DATA TO CODEIGNITER CONFIG FILE (For better programming practives)
NOTES:
	DB Insertion for 'sites' table
		INSERT INTO `sites` (`id`, `site_name`, `area`) VALUES (NULL, 'BACOOR', ''), (NULL, 'SANJUAN', '');
	TABLE column 0 or the first column is resizing it's row width because not all the columns has its own data therefore therefore
		there are some blanks to that row
	

Version 3.1.2
Date 8/31/2016
Changes:	
	Added 4 sample approvers and set as admin or approver of requests
	Add Area 5 each on both table users and requests
	Set buttons to _button at datTables.buttons.min.js file
		this,b=this.s.dt,c=b.settings()[0],e=this.c._buttons;c._buttons||(c._buttons=[]
		from 
		this,b=this.s.dt,c=b.settings()[0],e=this.c.buttons;c._buttons||(c._buttons=[]
	Add ajax for approver based on their area of assignmnet
	Add username and Id when request has been created
	Separate Approver from Requestor Actions
		Requestor by ID or User/Employee NAme(His request will be displayed only on the table)
		Approver by Area (His Area will only be displayed on the table)
	Add email
		$config['smtp_user'] = "hostexchangeoperations@gmail.com"; 
		$config['smtp_pass'] = "HEOcart2016";
		SMART LAPTOP - [203.87.130.18] Might be the VPN?
	Configure Email Server to Send email to the specified recipients as well its request details
TODO:
	ID Number for every employee (Editable/Auto-increment/Given/Input by User?)
	Add oncreate MySql trigger for user who register
		to add id_num programmatically

	
Version 3.1.3
Date 9/01/2016
Changes:
	Add remarks notes of approval - ok
	Added another page to view for the link on the eamil
		Same Action can be initiated for Both Requestor and Approver
	Email is sending from the page request details but not the link and the remarks
TODO:
	Remarks is not saving and not sending to the email - OK
	Email Link to the Request
	Line 196 from Request_model.php (Re-structure the query for the remarks)
		update_request_with_remarks
	
	
Version 3.1.4
Date 9/02/2016
Changes:
	Fixed Approval Email on Reject and Approved - ok
	Added Email Table for Request Details
TODO:
	Fix the value of 
		Approver's Name
		Actvirt Date
		Time (should be am/pm)
	Table presentation is shit
	Requestor View on Page is not showing the Request's Details for that ID
	
	
Version 3.1.5 ---------------------------------------------------------------------------- OBSELETE
Date 9/05/2016
Changes:
	Requestor's Page in View Page is now ok, I just removed the condition when user is_pprover before SiteDropDownList
	CHANGED else at request_view if logged_in
		<?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>You must be logged in first.
					<a href="<?= base_url('register') ?>">Register</a> or 
					<a href="<?= base_url('login') ?>">Login</a>.
                </div>
            </div>
		<?php endif; ?>
TODO:
	If user do not own the request/
		if that Request ID does not exist
	THIS LINE GIVE ME a nerve ache, shimattta
		$body = $this->load->view('email_template_for_requestor', $data_, TRUE);
	
	
Version 3.1.6 ---------------------------------------------------------------------------- OBSELETE
Date 9/06/2016
Changes:	
	$email = $this->request->send_email_request_to_approver($request_id, $action, $_SESSION['user_id']);
		THis line from Request.php solved the problem of sending an email to the approver as requestor creates a request for a particular area approver assigned
NOTES:
	Debugging TIPS
		Use For Debugging Line for you to debug that line of code then try calling it using this link
			http://localhost/CI/request_anabelle_v2.0.2/request/ajax_send_email_to_approver?action=FOR  APPROVAL&request_id=123
		With the result of:
			{"status":true,"email_status":true,"request_id":"123","action":"FOR APPROVAL"}
		/* Called after creation of Request By Requestor*/
		public function ajax_send_email_to_approver()
		{
			$request_id = $this->input->post('request_id');
			$action = $this->input->post('action');
			// $request_id = $this->input->get('request_id'); // ------------------------ FOR DEBUGGING ------------------------
			// $action = $this->input->get('action');
			$email = $this->request->send_email_request_to_approver($request_id, $action, $_SESSION['user_id']);
			// echo json_encode(array("status" => TRUE, "email_status"=> $email,
					// "request_id" => $request_id, "action" => $action));
		}
	

Version 3.1.5 
Date 9/05/2016
Changes:
	Requestor's Page in View Page is now ok, I just removed the condition when user is_pprover before SiteDropDownList
	CHANGED else at request_view if logged_in
		<?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>You must be logged in first.
					<a href="<?= base_url('register') ?>">Register</a> or 
					<a href="<?= base_url('login') ?>">Login</a>.
                </div>
            </div>
		<?php endif; ?>
TODO:
	If user do not own the request/
		if that Request ID does not exist
	THIS LINE GIVE ME a nerve ache, shimattta
		$body = $this->load->view('email_template_for_requestor', $data_, TRUE);
	
	
Version 3.1.6 (Meeting with Sir Oliver Katigbak)
Date 9/06/2016
Changes:	
	$email = $this->request->send_email_request_to_approver($request_id, $action, $_SESSION['user_id']);
		THis line from Request.php solved the problem of sending an email to the approver as requestor creates a request for a particular area approver assigned
		
NOTES:
	Debugging TIPS
		Use For Debugging Line for you to debug that line of code then try calling it using this link
			http://localhost/CI/request_anabelle_v2.0.2/request/ajax_send_email_to_approver?action=FOR  APPROVAL&request_id=123
			With the result of:
				{"status":true,"email_status":true,"request_id":"123","action":"FOR APPROVAL"}
			/* Called after creation of Request By Requestor*/
			public function ajax_send_email_to_approver()
			{
				$request_id = $this->input->post('request_id');
				$action = $this->input->post('action');
				// $request_id = $this->input->get('request_id'); // ------------------------ FOR DEBUGGING ------------------------
				// $action = $this->input->get('action');
				$email = $this->request->send_email_request_to_approver($request_id, $action, $_SESSION['user_id']);
				// echo json_encode(array("status" => TRUE, "email_status"=> $email,
						// "request_id" => $request_id, "action" => $action));
			}
	
	
Version 3.1.7
Date 9/06/2016
Changes:
	Remove _session on all PAGE
		<?php if (isset($_SESSION)) : ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php var_dump($_SESSION); ?>
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		<?php endif; ?>
	REMOVE _user vardump at profile.php
		<?php var_dump($user); ?>
	REMOVE CALENDAR link
		<a class="navbar-brand" href="<?= base_url('calendar') ?>">Calendar</a>
	CHANGED all approver to OLIVER KATIGBAK as well it's email address
TODO: By Sir OLIVER
	Additional TASK
		1. 1 ADMIN ONLY ( Oliver Katigbak ) obkatigbak@globe.com.ph
		2. No email notification when ADMIN do the ff (DELETED, MODIFY), - ok (USED XAMPP as administration)
		3. ADD email address for Requestor and Approver in EMAIL notification body
		4. Add "Transmission" in Discipline (request table) - ok
	Documents attachments
	SHOULD Configure Sir Oliver as ADMIN user at XAMPP - MySQL Server
		( Oliver Katigbak ) obkatigbak@globe.com.ph
	DO ALL the version changes to VERSION 3.1.6 from V2.0.2
	TEST THESE TWO with error on email	
		http://localhost/CI/request_anabelle_v2.0.2/request/ajax_update_remarks_and_approve?request_id=122&remarkss=FROM URL TES APPROVE
		http://localhost/CI/request_anabelle_v2.0.2/request/ajax_delete?request_id=118
NOTES:
	send_email_request -  for approver - from approver / After Approver's Action
		cc - approver
		to - requestor
	send_email_request_to_approver - from requestor / After Requestor's Action
		cc - requestor
		to - approver
		
		

Version 3.1.8
Date 9/07/2016
Changes:
	Change almost all ajax and not call each ajax using jscript instead use controller and models to do this
	Add Transmission on DropDownList Dsicipline in Forms
	Add more details at emails
	RENAME FORLDER to CART
	Form BUTTON submission on all page is now disabling while doing action
	MULTIPLE ROW DELETION on TABLE
	Implement is_deleted
		The Request will remain on the DATABASE TABLE 'requests' and only changed the value of 'is_deleted'
	Add email_sent and approve_by AFTER email is sent (if connection interupts email_sent is set to 0)
TODO:
	DELETE and Reject/Approve Request is not working on PAGE
PROPOSE:
	DELETE status on table requests
		delete_by
		is_deleted - but will remain the data on the Database
NOTES:
	Once email is not recognized/does'nt exist gmail will notify user if it has an error messages
	QUERY:
		SELECT request_id, is_deleted FROM `requests` WHERE is_deleted=1 // TO SHOW THE REQUEST ID OF WHICH IS DELETED
		
		
Version 3.1.9 (WHEN we presented the RO Project to the BOSS)
Date 9/09/2016
Changes:
	Fix Logged in error messages on both TABLE View and PAGE Detail View
TODO:
	Is approver can change his/her 'area'? on profile update
	Should HASH the password?
		REFERENCE: https://www.codeigniter.com/userguide3/general/compatibility_functions.html#password-hashing
NOTES:
	In creating a request, user must fill-up first the site_name/area for that request 
		in order to send the email for the respective SITE Approvers
		
		
Version 4.2.0
Date 9/12/2016
Changes:		
	Fix time input on CREATE/UPDATE upon request
	Convert 24 Hrs. Format to 12 Hrs Formar AM/PM (Proper Formatting on BOTH TABLE(and COLUMN time) and PAGE)
	ADD activity_types table
		INSERT INTO `activity_types`
			(`activity_type`, `type`)
			VALUES ("Acceptanve(SAT, HAT, iSAT, UAT)",""),
				("Board acceptance",""),
				("Delivery",""),
				("Facilitiea changeout",""),
				("Facilities audit",""),
				("Facilities upgrade",""),
				("Hardware changeout",""),
				("Installation",""),
				("Integration",""),
				("ISDN activation ( ISDN PRI, BERT, Sniffing)",""),
				("Knockdown test",""),
				("Link migration",""),
				("Link provisioning",""),
				("Mock migration",""),
				("NE Integration",""),
				("NE Migration",""),
				("NE New card insertion",""),
				("NE pullout",""),
				("Number definition",""),
				("Parameter modification",""),
				("Patching",""),
				("Port patching",""),
				("Power down (shutdown)",""),
				("Power tapping",""),
				("Preventive maintenance",""),
				("Pull-out",""),
				("Ribg acceptance",""),
				("Site Survey",""),
				("Software patch",""),
				("System upgrade",""),
				("Traffic migration",""),
				("Etc.","")
	Implement DropdownList for activity_types (on PAGE and TABLE)
TODO:
	SHORT Notice Function when user requests less than 24 Hrs.
		testActivityTypeAndDateForShortNotice()
	
	
Version 4.2.1
Date 9/19/2016 (BDAY ni Jasmin)
Changes:	
	Loading PAGE /  TABLE on actions... after 1 sec will terminate the loading (of course if the action AKA ajax is true it will terminate as well)
	EMAIL TEMPLATE
		Acitivity on EMAIL template has been correctly spelled
		Requestr name is changed from email to requestor's name
	Font size UPPPPP from 12 to -> 14
		font-size:14px; // @ bootstrap.min.css
	Approve and Reject Button for new requested request (of course)
	Activity type DropDownList
		Acceptance(SAT, HAT, iSAT, UAT) from Acceptanve...
	Add email callbakc_email_check - to manipulate the format of the email on submission (form_validation) on registration
		with format of @globe.com.ph
	Resize the form inputs shorter on:
		Registration 
		Login
		Profile Update
	Add Deselect button on TABLE for smooth processing
NOTES:
	Use this line on the <input... in order to retain the value you have submitted on the form
		value='<?php echo set_value('firstname')?>' /// THIS IS COOLLLLL!
		<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name" value='<?php echo set_value('firstname')?>'>
TODO:
	Freeze pane?
	Add function for the 2 columns on requests tables:
		deleted_by
		approve_by 
	
	
Version 4.2.2
Date 9/21/2016
Changes:	
	Change only the Criticality to Severity TEXT (not the DB itself)
	New to For Approval (And the DB Contents)
	FOr animation
		<button id="reloadButton" class="btn btn-info" onclick="reload_table()"><i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i> Reload</button>
	USE GET instead of POST for faster processing of AJAX Requests
	Login - retain the value of username as request is error
TODO:
	on profile update, should update the names from the requesrts
	LIMIT the datatables selections on delete
	IS NOT WORKING PROPERLY:::
		testActivityTypeAndDateForShortNotice
	
	
Version 4.2.3
Date 9/22/2016
Changes:
	Approvers can now receive email from their respective area of assignment
	Edit on Both page and table - OK
	DELETE Bug Fixes on LOADING adter action
	
	
Version 4.2.4
Date 9/22/2016
Changes:	
	Remove the footer of the table in order to make the table more readable
	Show or Hide the "Reason for Short Notice"
		minor - hide
		major | critical - show
	Add ajax for query of Activity type that return the severity.
	Freeze Pane -> Remove the Footer of the table
TODO:
	Compute the date and time for "Reason for Short Notice" - OK
		- if less than 24 hours and Severity of the Activity Type is Critical and major
			Show "Reason for Short Notice" 
		- else
			Hide "Reason for Short Notice" 
	
	
Version 4.2.5
Date 9/23/2016
Changes:		
	Short Notice is not ok. And on the Email will be displayed if user input the Reason For short Notice
	Add reject_by to Requests table
	Hidden Criticality/Severty Type for procesiing of Activity Types
	Add google_calendar_link column on the sites table
		for calendar puroposes
TODO:
	Add approved_by on th view?
	reject_by to Requests table??? NOT YET IMPLEMENTED
	Session time out - NOT OK
	DropDownList Button is not working 
		Add modal for the google calendars    
	
	
Version 4.2.6
Date 9/26/2016
Changes:
	Number 1 
		Is not properly stated what is error
	Number 2  
		on TABLE OK
		on PAGE ok
	NUMBER 3
		on TABLE OK
		ON PAGE OK
TODO:
	Eto pala ung mga need pa baguhin kasi napansin ko nung nagtest ako
		1. Pag ung nagsubmit si requestor...walang nareceived c requestor na email kasi ang nakalagay sa notification ng requestors email is ung approver..
		2. Pag nag reject si approver ng activity  ang status sa table ng both requestor at approver ay approved  pa din pero sa email rejected na 
		3. Ung sinabe ko sayo regarding cancellation ng activity
		4. Minsan wala pa ding narereceived na email si approver at minsan kahet si requestor0
		
		Ung sa mga actions lang...
		3. Kunwari approved na ung activity tas ung requestor sa di inaasahang pangyayari hindi matuloy sa target time and 
			ung activity nya.ung approver pwede palitan ung status from accepted to canceled...
			tas sa requestor view canceled na din ung activity pero pwede na shang magmodify at magbago ng date 
			if gusto nya pang ipush ung activity sa ibang araw..ang magiging status nito is for approval na naman pero same id pa din. 
			Kumabaga niresubmit nya lang.....pero kapag hindi na matukiy activity leave as Canceled ung status
			IN SHORT:
				Approver CANCELLED the request if it already lapsed the time alloted...
				Will be able to modify the 'date of activity'
				For approval if being modified
	DISABLE register/login button after action
	CREATE ADMIN, can VIEW all reqeust from all areas
	id_num column on users table, is it really needed???
NOTE:
	Will not work all (PROPERLY) tHe action if the application is run thru local server,, should access thru remote
		- Has no error handler for is_connected to internet////??? Should Have?
	Should have Re-send email?
	Uneditable DATE? on modify??
	REQUEST STATUS:
		0 - For Approval
		1 - Accepted
		2 - Rejected
		3 - Cancelled

	
Version 4.2.7
Date 9/26/2016
Changes:
	Requestor email and username at For Approval Requests - OK
	

	
Version 4.2.8
Date 9/26/2016
Changes:
	DELETE Button has error on 201 but not others
	Redirect on delete on DELETE onError
	

	
Version 4.2.9
Date 9/26/2016
Changes:	
	BUTTONs 
TODO:
	Can't be modified only when CANCELLED status - ok
	
	
	
Version 4.3.0
Date 9/28/2016
TODO:
	BUTTON Actions
	Approver:
		FOR APPROVAL: - ok
			-accept (pwede bang maglay ng note before maaccept ung activity? (Approval note)
			-reject (pwede bang magkagay ng note bago magreject)
			-cancel
		ACCEPTED: - ok
			-cancel 
			+ View Only
		REJECTED: - ok
			-no actions na (need na magreapply ni requestor)
			+ View only
		CANCELLED: - ok
			-no action since need na maging for approval muna ito bago maaccept ulit
			+ View only
	Requestor:
		FOR APPROVAL:
			No actions 
		ACCEPTED:
			No actions
		REJECTED:
			-no actions na (need na magreapply ni requestor
		CANCELLED:
			-pwede na magedit si requestor then resubmit for approval (same request id)

	
	
Version 4.3.1
Date 9/28/2016
Changes:
	Buttons for '_status' is ok but uses the null as statement
NOTES:
	Oncreate of request it is '_status' is set null
TODO: from viber sir oliver
	- calendar 
	- email attachments
	- Short Notice ONLY for AREA of -ok
		- BACOOR
		- CARMONA
	- on approve of rquest - ok
		- all area approver's must receive an email too
		


Version 4.3.2
Date 9/29/2016
Changes:
	Short Notice ONLY for AREA of  - ok (PAGE and TABLE)
		- BACOOR
		- CARMONA
	Improve SEND email
	ALL Area Approver will be notified as one APPROVER approved a request
	Faster Deletion - Selected Rows
	Slower Deletion - on single row
	Dynamic URL base on the domain address
		$this->config->base_url();
		
		

Version 4.3.3
Date 10/5/2016
Changes:
	Working CALENDAR
		- view details
		- view tooltip (partial details like id, user name and area)
		- id only at calendar
		- no edit, no add
		- called at request view and initialized at calendar model
		- color coded REQUESTs (...blue)
	
	

Version 5.3.43
Date 10/11/2016
Changes:
	ADD these and remove the exsiting record in DB
		INSERT INTO `activity_types` (`id`, `activity_type`, `type`, `severity`) VALUES
		(1, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'minor'),
		(2, 'Board acceptance', '', 'minor'),
		(3, 'Card insertion', '', 'critical'),
		(4, 'Card pullout', '', 'minor'),
		(5, 'Delivery and Installation', '', 'minor'),
		(6, 'Hardware changeout', '', 'critical'),
		(7, 'Installation and commissioning ( For New NE)', '', 'minor'),
		(8, 'Integration', '', 'major'),
		(9, 'ISDN activation ( ISDN PRI, BERT, Sniffing)', '', 'minor'),// NOT SAME
		(10, 'Knockdown test', '', 'major'),
		(11, 'Link migration', '', 'major'),
		(12, 'Link provisioning', '', 'major'),
		(13, 'NE Migration', '', 'critical'),
		(14, 'Number definition', '', 'major'),
		(15, 'Parameter modification', '', 'critical'),
		(16, 'Patching', '', 'major'),
		(17, 'Power down (shutdown)', '', 'critical'),
		(18, 'Power tapping', '', 'critical'),
		(19, 'Preventive maintenance', '', 'critical'),
		(20, 'Ring acceptance', '', 'minor'),
		(21, 'Site Survey', '', 'minor'),
		(22, 'Software patch', '', 'critical'),
		(23, 'Software upgrade', '', 'critical'),
		(24, 'Subrack Expansion', '', 'critical'),
		(25, 'System upgrade', '', 'critical');
		
	INSERT INTO `activity_type_sub_categories` (`id`, `activity_type_sub_category`, `activity_type_id`) VALUES
	INSERT INTO `activity_type_sub_categories` VALUES
		(NULL, 'Approved RAAWA', '1'),
		(NULL, 'No major punchlist in equipment installation checklist', '1'),
		(NULL, 'Approved RAAWA', '2'),
		(NULL, 'Approved RAAWA', '3'),
		(NULL, 'Approved MOP', '3'),
		(NULL, 'Secured CFEI approval', '3'),
		(NULL, 'HEO concurrence and validation on Rectifier System/Inverter Sytem loadings', '3'),
		(NULL, 'Approved SACT/Service Order', '3'),
		(NULL, 'Approved RAAWA', '4'),
		(NULL, 'Approved MOP', '4'),
		(NULL, 'Approved Service Order', '4'),
		(NULL, 'Approved CFATA', '4'),
		(NULL, 'Approved TSSR', '5'),
		(NULL, 'GT Representative', '5'),
		(NULL, 'Vendor', '5'),
		(NULL, 'Approved RAAWA', '5'),
		(NULL, 'Approved RAAWA', '6'),
		(NULL, 'Approved MOP', '6'),
		(NULL, 'Approved Service Order', '6'),
		(NULL, 'Approved RAAWA', '7'),
		(NULL, 'Completed HEO UAT', '8'),
		(NULL, 'Completed Acceptance ( HAT,SAT)', '8'),
		(NULL, 'Approved RAAWA ( if on-site activity)', '8'),
		(NULL, 'Zero punchlist on Equipment installation and power tapping checklist', '8'),
		(NULL, 'Approved RAAWA ( If on-site activity)', '9'),
		(NULL, 'Approved MOP', '9'),
		(NULL, 'Approved Service Order', '9'),
		(NULL, 'Approved RAAWA ( If on-site activity)', '10'),
		(NULL, 'Approved MOP', '10'),
		(NULL, 'Approved Service Order', '10'),
		(NULL, 'Approved RAAWA ( If on-site activity)', '11'),
		(NULL, 'Approved MOP', '11'),
		(NULL, 'Approved Service Order', '11'),
		(NULL, 'Approved RAAWA ( If on-site activity)', '12'),
		(NULL, 'Approved MOP', '12'),
		(NULL, 'Approved Service Order', '12'),
		(NULL, 'Approved RAAWA ( if on-site activity)', '13'),
		(NULL, 'Approved MOP', '13'),
		(NULL, 'Approved Service Order', '13'),
		(NULL, 'Approved RAAWA ( If on-site activity)', '14'),
		(NULL, 'Approved MOP', '14'),
		(NULL, 'Approved Service Order', '14'),
		(NULL, 'Approved RAAWA ( If on-site activity)', '15'),
		(NULL, 'Approved MOP', '15'),
		(NULL, 'Approved Service Order', '15'),
		(NULL, 'Approved RAAWA', '16'),
		(NULL, 'Approved MOP', '16'),
		(NULL, 'Approved Service Order', '16'),
		(NULL, 'Approved RAAWA', '17'),
		(NULL, 'Approved MOP', '17'),
		(NULL, 'Approved Service Order', '17'),
		(NULL, 'Zero punchlist on equipment installation checklist', '18'),
		(NULL, 'Passed megger testing', '18'),
		(NULL, 'Approved MOP', '18'),
		(NULL, 'Approved Service Order', '18'),
		(NULL, 'Approved RAAWA', '19'),
		(NULL, 'Approved MOP', '19'),
		(NULL, 'Fault Ticket/Work Order', '19'),
		(NULL, 'Approved RAAWA', '20'),
		(NULL, 'Network Diagram', '20'),
		(NULL, 'Approved Pre-TSSR from CFEI', '21'),
		(NULL, 'Approved RAAWA', '21'),
		(NULL, 'Approved RAAWA ( if on-site activity)', '22'),
		(NULL, 'Approved MOP', '22'),
		(NULL, 'Approved Service Order', '22'),
		(NULL, 'Spare card', '22'),
		(NULL, 'Approved RAAWA ( if on-site activity)', '23'),
		(NULL, 'Approved MOP', '23'),
		(NULL, 'Approved Service Order', '23'),
		(NULL, 'Spare card', '23'),
		(NULL, 'Approved RAAWA', '24'),
		(NULL, 'Approved MOP', '24'),
		(NULL, 'Secured CFEI approval', '24'),
		(NULL, 'HEO concurrence and validation on Rectifier System/Inverter Sytem loadings', '24'),
		(NULL, 'Approved Service Order.', '24'),
		(NULL, 'Approved RAAWA ( if on-site activity)', '25'),
		(NULL, 'Approved MOP', '25'),
		(NULL, 'Approved Service Order', '25'),
		(NULL, 'Spare card', '25');
	

Version 5.3.44
Date 10/14/2016
Changes:
	Add Checklist for Activtyi Type 
		using CheckBox and save to databse as 
			implode with string from behind and 
			explde during rthe rendition of Form
	Modal for color picker using Radio Button
TODO:
	Color of Date to fullCalendar
	Ajax for color renditoin - should it be from another table to render the date colors...
	

Version 5.3.45
Date 10/17/2016
Changes:
	Add Calendar Date Color Coding
		WHITE, GREEN, GREY
	Save Color for Date and Update on Exist (if Date already existed)
	Refreshes date color on create/update of date color
		- Some performance issue on speed might arise using 'prev', 'next' to reRender the dates on the Calendar
	Add another Table for fullCalendar 'activity_calendar_date_color'
	COLOR for fullCalendar 
		white WHITE
		#8CDD81 GREEN
		#C1CDC1 GREY
TODO:
	Check if date(that day) has 3 or more request already, then no more request for all users/requestor - OK
	GREY Button if Activity Pre-requiresites is not Checked else BLUE 
		--- CANT be implemented (will be done sometime)
	

Version 5.3.46
Date 10/18/2016
Changes:
	Change TABLE activity_type_prerequisites and its column to proper naming convention
	Color WHITE for Saturday and Sunday for fullCalendar
	Add validation activity_date onSave
	Can submit when filled in:
		Activity_type and its pre-requisites
		Activity_date
	COLOR (TO show that the date is not available and can't file any request):
		RED when it has more than or equal to three requests from that date
		GREEN when it is available (Ussually mon-fri)
		GREY when approver chose to block that particular date
	Date fix on fullCalendar
		Show only for particular area
TODO:
	CHeck Activity Type if not selected index 0 before submission of request - OK
	Remove REJECT Button by OLIVER - OK
	SHOULD apply this to PAGE from TABLE page
	
	
Version 5.3.47
Date 10/19/2016
Changes:
	Change Header Title for calendar_link_area
		HEO AREA[VALUERO, SANJUAN, ...] CALENDAR
	DATE CALENDAR:
		Red if that date has more than 3 request that has in between 12 am to 6 pm
TODO:
	Test if request per day is working properly
		Create 2 to three request with activity_date to the same day
		Create 2-3 color blocked on date, 
		- wherein user can no longer be able to request/schedule a request for that day
	Rename TITLE Header of fullCalendar Modal - OK
	Check date -> time if has 3 or more value in between 12 am to 6 am on the same date - OK
	testTimeIntervalBeforSubmission ----- not well organized at footer_table.php - OK
		

Version 5.3.48
Date 10/20/2016
Changes:
	Test Forms on submit - APPLIED on both TABLE and PAGE
		- Save
		- Edit
	Checks date if SUNDAY or SATURDAY
		then cannot submit a request for that date
	Checks WINDOW TIME  onSubmit
		Between 12 am to 6 am
	TEST time format
		testTimeFormat(time)
	TEST fullCalendar
		COLOR - set by approver
		Count - count date's with WINDOWs time 
	Reset the color of input fields' label
		resetLabelColorToBlack()
	EMAIL CONTENT:
		Email link is now based on the site_url()
		Activity_date instead date from `requests` TABLE
NOTE:
	RED - Date has 3 or more WINDOWS TIME (can't request another window time)
	GREEN - Available for filing a request on that date
	WHITE - WEEKENDs
	GREY - Blocked by  APPROVER
	SETTING CLASS by ID using JSCRIPT:
		http://stackoverflow.com/questions/195951/change-an-elements-class-with-javascript
	SET DataTable column fixed
		/* TO set the fixness of COLUMNS*/
			table{
				margin: 0 auto;
				width: 100%;
				clear: both;
				border-collapse: collapse;
				table-layout: fixed; // ***********add this
				word-wrap:break-word; // ***********and this
			}
	BOOTSTRAP js draggable, instances and etc.
		https://nakupanda.github.io/bootstrap3-dialog/
TODO:
	Legend for Calendar as POP-UP - OK


Version 5.3.49
Date 10/21/2016
Changes:
	Legend or Help Button in fullCalendar 
		Modal Pop up 
			Color coding of the calendar
		Using this code we added the button in toolbar of fullCalendar:
			/* ADDING Button to the fullCalendar */
			/* HELP BUTTON */
			$('.fc-toolbar .fc-left').prepend(
				$('<button type="button" class="fc-button fc-state-default fc-corner-left fc-corner-right"> ? </button>')
					.on('click', function() {
						/*
						var title = prompt('Room name');
						if (title) {
							$('#calendar').fullCalendar(
								'addResource',
								{ title: title },
								true // scroll to the new resource?
							);
						}
						*/
						var frame_modal = $('#modal_calendar_legend');
						frame_modal.modal('show');
				})
			);
		

Version 5.3.50
Date 10/23/2016
Changes:
	Legend Button for fullCalendar
		change from '?' TO 'Legend'
	Date in FullCalendar
		Occupied Date with 3 window period requests is now in Green but DARKER (#86d77b)
	Hide Toolbar Buttons (especially the delete button, but in this case I hid all) 
		onView request by ID at FullCalendar Dates
	Fix DatePickerColumnWidth in the form
	Buf Fix on Submission 
		Submit on date 
			- not valid, then if another date it is valid after selecting again the first date
		Clean up redundant call of method at testActivityTypeAndDateForShortNotice()
	Alert "It's weekend!" and Modal for Setting the Color of is for Approver ONLY
	Check all pre-requisites on submit
	Change Text [at least one] into [all]
TODO:
	Legend Div Content - OK
		Change content from Oliver Katigbak
	Check All 'checklist' or pre-requisites before submission - OK PAGE and TABLE
	Activity Type is Blank ||  NULL Test - OK PAGE and TABLE
	Add error message on every field on submission of form onFAIL
	Can submit even if it is already blocked - OK
	Orange Label of Legend of Window Period Max 3 - OK
	Date Picker Next and Prevoius Button is not working/showing 
		FROM http://stackoverflow.com/questions/574941/best-way-to-track-onchange-as-you-type-in-input-type-text
	Issue on Initially rendering the Date Events onShow of Modal
		Should not click the "today" in order to show the events of on the fullCalendar
NOTE:
	12 AM to 6:00 IS OK
		12 AM - 5:59 is NOT OK
	BootstrapDialog.alert('I want banana!'); // 
		from 
			http://getbootstrap.com/javascript/#modals
			https://github.com/nakupanda/bootstrap3-dialog/blob/master/examples/index.html
	
	
	
Version 5.3.52
Date 10/24/2016
Changes:
	...
	Email Test ok
	fix PAGE view details of request
		because of = sign on the Listeners
	Fix fullCalendar scrollbar
		By resizing the aspect ration on and after initialization of calendar
		CODE:
			aspectRatio: 2 // TO Resize the Height, then after initialze call 
				// $('#calendar').fullCalendar('option', 'aspectRatio', 2);
TODO:
	fullCalendar scrollbar issue - it is not scrolling once another modal is shown and exit - ok
	Thisngs to modify
		1. Approver calendar 
		 - Need pa ba talagang pindutin ung today bago magappear ung calendar?
		2. Legend - OK
		 - Pakibago ung question mark instead papalitan ng LEGEND
		 - Legend Content
				   Colored Date
					   WHITE  - Weekends (NO activity request,unless urgent)
					   GREEN  - Weekdays (Requestor can file request/s of maximum 3 critical activities on window period )
					   ORANGE - Date already reached it's maximum 3 critical activies 
							(Window period) but may still apply for non- window period activities  
					   GREY  - Date is blocked by approver
				   Colored Request
					   BLUE - Non-window period activity (8am-5pm)
					   RED  - Window period activity (12mn - 6am)
		3. Requestor Calendar 
					   - Need pa ba talagang pindutin ung today bago magappear ung calendar?
		4. Add request - OK
				   Activity Requiremnet Checklist [check at least one] 
				   - Pacheck nalang nito kasi wrong spelling ung requirements at patanggal ng check at least one instead 
				   [ Must be completed to proceed with activity request ]- OK
		5. Add request - OK
				  Activity Requirements Checklist 
				  - kapag kahet isa ang hindi nacheck dito dapat hindi pwede makapagsubmit ng request. 
				  Dapat kumpleto muna ung checklist
		6. Add request 
				  -  Hindi makapag submit ng request , 
				  ang error is please complete the form then submit again kahet complete ko na ung form
		7. Add request
				   - Kapag nakablocked na ung date ( approver ). 
				   Dapat sa requestor kapag sinelect nya ung date na nakablocked na is may magpop up 
				   or inotify si requestor na ung date is blocked and try to select other date. 
				   Kasi napansin ko kahet nakablocked na ung date nakapag proceed pa din sa pag submit eh..
	
	
	
Version 5.3.53
Date 10/25/2016
Changes:
	
NOTES:
	If you don't want the $.ajax() function to return immediately, set the async option to false: -- NOT WORKING
		async: false,
	

Version 5.3.54
Date 10/27/2016
Changes:
	Bug fix on server side checking of data being fed and prompt during and 
		after the submission of the request if any error occurred.
	Remove Reject Button on Page Details
	
	

Version 5.3.55
Date 10/28/2016
Changes:
	Testing of start_time and end_time exhuastively
		12:00 am to 6:00 pm is considered as Windows TIME (Unlike lately, it was set to 5:59 only)
		But for the start_time has no 
	Colored Request Date to ORANGE
	Colored Date to RED
	Fix bug on double submission(second attempt is not necesary to submit the request)
NOTE:	
	TEAM Viewer credentials:
		usr: 10004187
		pwd: shityy99
	//HEO guidelines:
		1. Inform HEO at least 2 days prior the date of activity.
		2. For delivery and installation activities - GT rep must be present since HEO houserules, guidelines, requirements will be discussed in the toolbox meeting.
		3. Bring hardcopy of approved final TSSR
		4. Others - will be discussed during toolbox meeting

		Btw, primary approver for Carmona is Mr. Roberto B. Zamora.
	
	
	
Version 5.3.56 [4 days weekend whoo!]
Date 10/29/2016
Changes:
    Add checking if the Activity Date is in the PAST therefore requestor cannot submit their request
	Remove error on loading a .css file
		Change script tag to link tag, because it was .css file not .js
		<link src="<?php echo base_url('assets/modal/bootstrap-dialog.css')?>"></link>
	Fix Delete Button showing dialog box delayed
		Remove minor bugs on showing the dialog box in asking for DELETIO/Multiple Deletion of requests
	Enable the scroll of the active modal views
		Overflow:auto at bootstrap.min.css
		But Double Scroll bar is shown
	Add Calendar Loading Indicator
		Open and close of the Loading bar for the rendition of the calendar
NOTE:
	Should use popover or tooltips? On DataTables
		http://getbootstrap.com/javascript/#dismiss-on-next-click
TODO:
	Date cell indicator what is the reason for its BLOCKAGE
		I tried everything but it can't do a thing so i just need to make it something to work out 


	
Version 5.3.58 [From gmail, with malware???! JS/Nemucod.TSF @v56]
Date 11/2/2016
Changes:
	Resolve issue of prerequisites that are not showing
	Remove this line as save_color() both success and error
		//loadingPleaseWaitClose();
TODO:
	Test to Sir Oliver and Do the Changes in footer_table.php to footer.php
		Apply TABLE to PAGE changes
	
	
	
Version 5.3.59
Date 11/3/2016
Changes:
	On Save and Update of request column requestor_name will be the fullname
		Still working on profile_update - OK

		
		
Version 5.3.60
Date 11/4/2016
Changes:
	Update User Profile will trigger to change all the Username of the Request Details in the table
	Show and save on edit the Requestor's Name at the Table Page
	Re-organize the details of user's credentials
		Date show the human readable date of creation and last_edit of the account
	Add column width at 10, 11, 12 at Table and change to "150"
	Bug fix at footer.php -- undeclare and unused variable has been handled properly
	Issue on Handling the rendition of fullname at Back-end
		Add methods to handle the needed query to fetch data
TODO:
	Apply all changes to footer_table.php to footer.php
	Clean JSON/CACHE feed from the server
	Filter the color rendered to the date where it should not render GREEN to GREY
	


Version 5.3.61
Date 11/7/2016
Changes:
	Bug fix on rendering the Date Today with Black Boarder - ok
		Use slice to get the last 2 characters from the string return by getDate
		("0" + today.getDate()).slice(-2) // = 02 not 002
		@populateCalendarDateColor function
	clear_cache()
		is not really working, it is not the problem as other PC can't load the calendar and the Page (Deployed via STATIC Link)
TODO:
	Should not save the request on that date if it is SET to GREEN
NOTE:
	LINK to Static address of Sir Oliver's Server:
		http://heocart.ngrok.io/CI/CART/request/view_details/?request_id=



Version 5.3.62
Date 1/2/2017
Changes:
	Defining Application Constants in Codeigniter
		The process is simple:
		Defining a constant. Open config/constants.php and add the following line:
			define('SITE_CREATOR', 'John Doe')
		use this constant in another file using: 
			$myVar = 'This site was created by '.SITE_CREATOR.' Check out my GitHub Profile'