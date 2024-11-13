<?php

namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}

/* fetch critical css for any page */ 
function fn_cwv_generate_critical(){
    global $wpdb;

    $data = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'cwv_criticalfiles WHERE status="open"' );

    if(is_object($data)){

        $http = wp_remote_get('http://critical.corewebvitals.io/critical/critical.php?url='.$data->url.'&version='.WP_CWV_VERSION.'&key='.WP_CWV_LICENCE_KEY , [ 'timeout' => 90 ]);
        $res = json_decode($http['body'],true);
        if($res['css']){

            // clear cache
            $files = glob(WP_CONTENT_DIR.'/cache/wp_cwv/html/*'); 
            foreach($files as $file){ 
                if(is_file($file)) {
                    unlink($file); 
                }
            } 

            // save critical css
            @mkdir ( WP_CONTENT_DIR.'/cache/wp_cwv/critical/', 0777 , true );
            file_put_contents(WP_CONTENT_DIR.'/cache/wp_cwv/critical/'.$data->hash.'.css', $res['css']);
        }

        /* should move this to DbQueries*/
        $table = $wpdb->prefix.'cwv_criticalfiles';
        $tabledata = [
            'status'=> 'done'
        ];
        
        $format = ['%s'];

        $where = [
            'id' => $data->id,
        ];

        $result2 = $wpdb->update($table,$tabledata,$where,$format,$format);



        // load next schedule
        if(!wp_next_scheduled('cwv_generate_critical')){
          wp_schedule_single_event( time() + 10, 'cwv_generate_critical' );
        }

    }
}


function wp_cwv_get_plugin_status(){
    $remote = wp_remote_get(
        add_query_arg( ['license_key' => urlencode(  critical_get_option('cwv_api_key')),'cb'=>microtime(true)], 'https://www.corewebvitals.io/plugin/wp-corewebvitals.json'), 
        array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/json'
        ) )
    );

    $a = json_decode( $remote['body'],true );
    update_option('wp_cwv_licence_state',$a['licence']);
 
    die($remote['body']);
}


/* delete all critical css rules*/
function delete_critical_css_rule(){
    $oCriticalRules = criticalrules::delete($_POST['id']);
}

/* delete all critical css rules*/
function wp_cwv_delete_script_rule(){
    $oCriticalRules = scriptrules::delete($_POST['id']);
}


/* the critical rules are ajax loaded */
function wp_cwv_get_critical_css_rules(){
            $oCriticalRules = criticalrules::findAll();

  ?>
 <table class="form-table">
      <?php foreach($oCriticalRules as $oCriticalRule){?>
      <tr valign="top">
        <th scope="row"><?php echo WP_CWV_SITE_URL;?>/</th>
        <td><input type="text" name="criticalcssrules[<?php echo $oCriticalRule->id;?>]" value="<?php echo esc_attr($oCriticalRule->rule); ?>"/></td>
        <td><span class="deleterule button button-primary" data-id="<?php echo $oCriticalRule->id;?>">X</span></td>
      </tr>     
      <?php } ?>
       <tr valign="top">
        <th scope="row"><?php echo WP_CWV_SITE_URL;?>/</th>
        <td><input type="text" name="criticalcssrules[new]" value=""/></td>
      </tr>     
  </table>

  <?php 
  die();
}

function wp_cwv_get_script_rules(){
            $oCriticalRules = scriptrules::findAll();
  ?>
 <table class="bordered form-xtable">
  <tr valign="top">
    <th>Regex</th>
    <th>Trigger</th>
    <th>Selector</th>
    <th></th>
  </tr>
      <?php foreach($oCriticalRules as $oCriticalRule){?>
      <tr valign="top">
        <td width="35%"><input type="text" name="scriptrules[<?php echo $oCriticalRule->id;?>][scriptregex]" value="<?php echo esc_attr($oCriticalRule->scriptregex); ?>"/></td>
                <td>
          <select name="scriptrules[<?php echo $oCriticalRule->id;?>][scripttrigger]">
            <option <?php echo ($oCriticalRule->scripttrigger == 'interactionobserver')?'selected':''?> value="interactionobserver">Scroll into view</option>
            <option <?php echo ($oCriticalRule->scripttrigger == 'hover')?'selected':''?> value="hover">Hover / Click</option>
            <option <?php echo ($oCriticalRule->scripttrigger == 'idle')?'selected':''?> value="idle">Load when browser is idle</option>
            <option <?php echo ($oCriticalRule->scripttrigger == 'remove')?'selected':''?> value="remove">Remvoe this script</option>
          </select>
        </td>
        <td><input type="text"  name="scriptrules[<?php echo $oCriticalRule->id;?>][scriptselector]" value="<?php echo esc_attr($oCriticalRule->scriptselector); ?>"/></td>
        <td><span class="deleterule button button-primary" data-id="<?php echo $oCriticalRule->id;?>">X</span></td>
      </tr>     
      <?php } ?>
       <tr valign="top">
        <td><input type="text" name="scriptrules[new][scriptregex]" value=""/></td>
        <td>
          <select name="scriptrules[new][scripttrigger]">
            <option value="interactionobserver">Scroll into view</option>
            <option value="hover">Hover / Click</option>
            <option value="idle">Load when browser is idle</option>
            <option value="remove">Remove this script</option>
          </select>
        </td>
        <td><input type="text" name="scriptrules[new][scriptselector]" value=""/></td>
        <td></td>
      </tr>     
  </table>

  <?php 
  die();
}

function fn_critical_save_options(){

    foreach($_POST['criticalcssrules'] as $k => $v){
        if($k == 'new' && strlen($v) > 0){
            criticalrules::insert(['rule'=>$v]);
        } else if(strlen($v) > 0){
            criticalrules::update(['rule'=>$v],$k);
        }
    }


    foreach($_POST['scriptrules'] as $k => $v){
        if($k == 'new' && strlen($v['scriptregex']) > 0){
            scriptrules::insert(['scriptregex'=>$v['scriptregex'],'scripttrigger'=>$v['scripttrigger'],'scriptselector'=>$v['scriptselector']]);
        } else if(strlen($v['scriptregex']) > 0){
            scriptrules::update(['scriptregex'=>$v['scriptregex'],'scripttrigger'=>$v['scripttrigger'],'scriptselector'=>$v['scriptselector']],$k);
        }
    }



    unset($_POST['rules']);
    unset($_POST['criticalcssrules']);
    unset($_POST['scriptrules']);

    //add_option('wp_cwv_options',json_encode($_POST));
    update_option('wp_cwv_options',json_encode($_POST));
    die('just saving da options asd');
}

/* remove all css and html cache */
function fn_critical_clear_critical(){
global $wpdb;

  $wpdb->query("TRUNCATE TABLE ".$wpdb->prefix.'cwv_criticalfiles');

  $files = glob(WP_CONTENT_DIR.'/cache/wp_cwv/html/*'); 

  foreach($files as $file){ 
    if(is_file($file)) {
      unlink($file); 
    }
  }  

  $files = glob(WP_CONTENT_DIR.'/cache/wp_cwv/critical/*'); 

  foreach($files as $file){ 
    if(is_file($file)) {
      unlink($file); 
    }
  }

  $files = glob(WP_CONTENT_DIR.'/cache/wp_cwv/css/*'); 

  foreach($files as $file){ 
    if(is_file($file)) {
      unlink($file); 
    }
  } 

    die('done');
}

function fn_critical_clear_cache(){
    $files = glob(WP_CONTENT_DIR.'/cache/wp_cwv/css/*'); 

  foreach($files as $file){ 
    if(is_file($file)) {
      unlink($file); 
    }
  } 

  $files = glob(WP_CONTENT_DIR.'/cache/wp_cwv/html/*'); 

  foreach($files as $file){ 
    if(is_file($file)) {
      unlink($file); 
    }
  }
    die('done');
}







function cwv_toolbar($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'wp_cwv_plugin',
        'title' => 'WP Core Web Vitals',
        'href'  => '#'
    ));

    $admin_bar->add_menu( array(
        'id'    => 'wp_cwv_plugin_settings',
        'parent' => 'wp_cwv_plugin',
        'title' => 'Settings',
        'href'  => get_admin_url() . 'options-general.php?page=criticalcss'
    ));

    $admin_bar->add_menu( array(
                'meta'=>[
            'onclick'=>'var c1t = this; this.style.color = "#0a0a0a";jQuery.post("'.esc_url(admin_url('admin-ajax.php')).'", {"action":"critical_clear_cache"},function(){c1t.style.color = "green"});return false;',
        ],
        'id'    => 'critical_clear_cache',
        'parent' => 'wp_cwv_plugin',
        'title' => 'Clear cache',
        'href'  => get_admin_url() . 'options-general.php?page=corewebvitals&cwv_cc=true'
    ));

    $admin_bar->add_menu( array(
        'meta'=>[
            'onclick'=>'var c2t = this; this.style.color = "#0a0a0a";jQuery.post("'.esc_url(admin_url('admin-ajax.php')).'", {"action":"critical_clear_critical"},function(){c2t.style.color = "green"});return false;'
        ],
        'id'    => 'critical_clear_critical',
        'parent' => 'wp_cwv_plugin',
        'title' => 'Clear Critcal CSS',
        'href'  => get_admin_url() . 'options-general.php?page=criticalcss&cwv_ccrit=true'
    ));
}

