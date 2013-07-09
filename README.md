CakePHP Facebook API Plugin
=========================

Requirements
------------
[CakePHP v2.x](https://github.com/cakephp/cakephp)   
[Opauth](https://github.com/LubosRemplik/cakephp-opauth)

How to use it
-------------
1.	Install this plugin for your CakePHP app.   
	Assuming `APP` is the directory where your CakePHP app resides, it's usually `app/` from the base of CakePHP.

	```bash
	cd APP/Plugin
	git clone git://github.com/LubosRemplik/CakePHP-Facebook-API-Plugin.git Facebook
	```

2.  Install required plugins with all dependcies and configuration
	[Opauth](https://github.com/LubosRemplik/cakephp-opauth)

3.  Connect facebook's account with your application http://example.org/auth/facebook

4.  Include needed model in your controller or anywhere you want to

	```php
	$uses = array('Facebook.FacebookPage');
	...
	$data = $this->FacebookPage->milestones('onanything');
	debug ($data);
	```

	```php
	$data = ClassRegistry::init('Facebook.FacebookPage')->milestones('onanything');
	debug ($data);
	```

**Note** You have to configure [Opauth](https://github.com/LubosRemplik/cakephp-opauth) correctly
