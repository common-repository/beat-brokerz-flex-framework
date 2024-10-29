<div class="wrap">
  <div id="icon-users" class="icon32"></div>
  <h2>Beat Brokerz Flex Settings</h2>
  <p style="max-width:800px">The Beat Brokerz flex framework allows you to stream and license music directly on your website. 
     You must create an app in the Beat Brokerz system first, which will control the music and
     other display settings for your site. Once you have an app configured on Beat Brokerz,
     save the app ID here to enable the framework for your site.
  </p>
  <center>
  
  <?php 
    $option_name = 'bbflex_setting';

    if (isset($_POST['save'])) {
    
      $new_value = array(
        'pages'=> $_POST['pages'],
        'app-id'=> $_POST['app-id'],
	'enable-shortcodes' => $_POST['enable-shortcodes'],
	'match-mode' => $_POST['match-mode'],
	'match-paths' => $_POST['match-paths'],
	'exclude-paths' => $_POST['exclude-paths'],
      );

      if ( get_option( $option_name ) !== false ) {
      
        // The option already exists, so we just update it.
        update_option( $option_name, $new_value );
	
      } else {
      
	// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        add_option( $option_name, $new_value, $deprecated, $autoload );
	
      }
      
    }

    $options = get_option( $option_name );
    ?>
    <form method="post">
      <table class="widefat" align="center">
        <thead>
        <tr><th colspan="2" align="center">Flex Framework Settings</th></tr>
        </thead>
         <tbody>
         
          <tr><td> AppID:</td><td> 
	    <input type="text" name="app-id" value="<?php echo $options['app-id'];?>" placeholder="Enter App ID" /> 
	    <?php if ($options['app-id']) { ?><a class="button" href="http://www.beatbrokerz.com/node/<?php print $options['app-id'] ?>/edit">Edit This App</a><?php } else { ?><a class="button button-primary" href="http://www.beatbrokerz.com/node/add/flexstore">Create New App</a><?php } ?>
	  </td></tr>
          <tr><td> Enable Shortcodes:</td><td> <input type="checkbox" id="shortcodes" name="enable-shortcodes" value="1" <?php if ($options === false || $options['enable-shortcodes']) { ?>checked<?php } ?>/>
	    <label for="shortcodes"> Check here to enable shortcodes</label>
	    <p style="max-width:400px">Shortcodes allow you to easily insert flex powered music widgets into your content
	    using the Wordpress shortcode notation. Read about flex widgets at <a href="http://www.beatbrokerz.com/flex/widgets">beatbrokerz.com/flex/widgets</a>.</p>
	  </td></tr>
          <tr><td> Load Options:</td><td>
	    <input type="radio" name="match-mode" id="mode0" value="0" <?php if ($options === false || $options['match-mode'] == 0) { ?>checked<?php } ?>/><label for="mode0"> Load framework on all pages</label><br>
	    <input type="radio" name="match-mode" id="mode1" value="1" <?php if ($options['match-mode'] == 1) { ?>checked<?php } ?>/><label for="mode1"> Load only on the following pages:</label><br><br>
	    <textarea style="width:400px; height:150px; max-width:100%;" name="match-paths"><?php echo htmlentities($options['match-paths']); ?></textarea><br>
	    <p style="max-width:400px">
	    Enter each path on a separate line. Only enter the portion of the path that comes after your domain, and without a leading slash. 
	    You can use the "*" character as a wildcard to target multiple pages. You can also use "&lt;front&gt;" to target your homepage.<br>
	    </p>
	    <strong>Example paths:</strong><br>
	    <table style="max-width:500px;">
	      <tr><td>&lt;front&gt;</td><td> (target the front page)</td></tr>
	      <tr><td>category/*</td><td> (target every page that begins with 'category/')</td></tr>
	      <tr><td>category*</td><td> (same as above, but also targets the 'category' page)</td></tr>
	      <tr><td>*feed</td><td> (target every page ending with 'feed')</td></tr>
	    </table>
	    <hr><br>
	    <p style="max-width:400px"><strong>Exclusions</strong>: specifically prevent the flex framework from loading on the following pages:</p>
	    <textarea style="width:400px; height:150px; max-width:100%;" name="exclude-paths"><?php echo htmlentities($options['exclude-paths']); ?></textarea><br>
	    <p>Enter paths as described above.</p>
	    </td></tr>
          <tr><td colspan="2" align="center"><input type="submit" name="save" value="Save" /></td></tr>
         
          </tbody>
        </table>
         </form>
        </center>
