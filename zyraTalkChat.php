<?php
/**
 * Plugin Name: ZyraTalk Chat
 * Description: ZyraTalk Chat Plugin for Wordpress
 * Version: 1.0.0
 * Author: ZyraTalk
 */

 if(!defined("ABSPATH")) exit;

 Class zyraTalkChat{

  function __construct(){
    add_action("admin_menu",[$this,"zyraChatSettingPage"]);
    add_action("admin_init",[$this,"zyraChatSetting"]);
    add_action("wp_enqueue_scripts",[$this,"zyra_chat_script"]);

  }
  function zyra_chat_script(){
    if(get_option("zyra_location")){
      add_action("wp_footer",[$this,"zyrascript"]);
    }else{
      add_action("wp_head",[$this,"zyrascript"]);
    }
   
    ?>
  <?php }
  
  function zyrascript(){
        $chatId = get_option("zyra_chat_id");
        $chatKey = get_option("zyra_chat_key");
        $chatURL = get_option("zyra_chat_url");

        wp_print_script_tag(array(
          'id'        => esc_html($chatId),
          'chatKey' => esc_html($chatKey),
          'src'       => esc_url($chatURL),
          'defer'=> true,
          
      ));
  }

  function zyraChatSetting(){
  add_settings_section( "zyra_position_section", null, null, "zyra-talk-setting-page" );

  //Code Location for Header/Footer
  add_settings_field( "zyra_location", "Code Placed", [$this,"zyraLocationHTML"], "zyra-talk-setting-page","zyra_position_section",null );
  register_setting( "zyraTalkSetting", "zyra_location", ["sanitize_callback"=>"sanitize_text_field","default"=>"0"] );

  //Chat ID
  add_settings_field( "zyra_chat_id", "Chat Id", [$this,"zyrachatHTML"], "zyra-talk-setting-page","zyra_position_section",null );
  register_setting( "zyraTalkSetting", "zyra_chat_id", ["sanitize_callback"=>"sanitize_text_field","default"=>"chatID"] );
  
  //Chat Key
  add_settings_field( "zyra_chat_key", "Chat key", [$this,"zyrachatKeyHTML"], "zyra-talk-setting-page","zyra_position_section",null );
  register_setting( "zyraTalkSetting", "zyra_chat_key", ["sanitize_callback"=>"sanitize_text_field","default"=>"chatKey"] );
  
  //Chat url
  add_settings_field( "zyra_chat_url", "Chat URL", [$this,"zyrachatUrlHTML"], "zyra-talk-setting-page","zyra_position_section",null );
  register_setting( "zyraTalkSetting", "zyra_chat_url", ["sanitize_callback"=>"sanitize_text_field","default"=>"https://abc.com"] );

  }

  function zyrachatUrlHTML(){?>
    <input type="text" name="zyra_chat_url" value="<?php echo esc_attr(get_option("zyra_chat_url")) ?>">
<?php }

  function zyrachatHTML(){?>
      <input type="text" name="zyra_chat_id" value="<?php echo esc_attr(get_option("zyra_chat_id")) ?>">
  <?php }

function zyrachatKeyHTML(){?>
  <input type="text" name="zyra_chat_key" value="<?php echo esc_attr(get_option("zyra_chat_key")) ?>">
<?php }

  function zyraLocationHTML(){?>
    <select name="zyra_location">
        <option value="0" <?php selected( get_option("zyra_location"), "0") ?>>Header</option>
        <option value="1" <?php selected( get_option("zyra_location"), "1") ?>>Footer</option>
    </select>
  <?php }

  function zyraChatSettingPage(){
    add_options_page( "ZyraTalk Page", "ZyraTalk", "manage_options", "zyra-talk-setting-page", [$this,"settingHtmlPage"] );
  }

  function settingHtmlPage(){?>
    <div class="wrap">
      <h1>ZyraTalk Setting</h1>
      <form action="options.php" method="POST">
        <?php 
          settings_fields("zyraTalkSetting");
          do_settings_sections("zyra-talk-setting-page");
          submit_button();
        ?>
      </form>
  </div>
  <?php }

 }
 $zyraTalkChat = new zyraTalkChat();