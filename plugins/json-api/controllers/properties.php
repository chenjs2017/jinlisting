<?php
class JSON_API_Properties_Controller {

    private $post_type;
    private $max_image_count;
    function __construct() {
        include_once('../../../themes/pointfinder/admin/estatemanagement/includes/functions/common-functions.php');
        $this->post_type=PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
        $this->max_image_count=PFSAIssetControl('setup4_submitpage_imagelimit','','pfitemfinder');

    }

    public function get_userinfo(){

        global $json_api;
        $current_user = wp_get_current_user();
        if ( 0 == $current_user->ID ) {
            return "nologin:";
        }

        $user = get_userdata($current_user->ID);
        return array(
            "id" => $user->ID,
            "username" => $user->user_login,
            "nicename" => $user->user_nicename,
            "email" => $user->user_email,
            "url" => $user->user_url,
            "displayname" => $user->display_name,
            "firstname" => $user->user_firstname,
            "lastname" => $user->last_name,
            "nickname" => $user->nickname,
            "address" => $user->__get( "user_address" ),
            "phone" => $user->__get( "user_phone" )
        );
    }

	  
	public function register(){
		global $json_api;	  

		$json = file_get_contents('php://input');
		$obj = json_decode($json, true);
		$username = sanitize_user($obj['username']);
		$email = sanitize_email( $obj['email']);
		$user_pass = sanitize_text_field($obj['password']);
		$seconds = 1209600;//14 days

		if (username_exists( $username ) ) {
			return "warning 用户名已经存在,Username already exists";
		}
		if (email_exists($email)) {
			return "warning 这个邮件地址已经被试用E-mail, address is already in use.";
		}			

		$user['user_login'] = $username;
		$user['user_email'] = $email;
		$user['user_pass'] = $user_pass;
		$user['role'] = get_option('default_role');
		$user_id = wp_insert_user( $user );

		update_user_meta(  $user_id, 'user_phone',sanitize_text_field($obj['phone']));
		update_user_meta(  $user_id, 'user_address',sanitize_text_field($obj['address']));

		$expiration = time() + apply_filters('auth_cookie_expiration', $seconds, $user_id, true);
		$cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
		return array( 
		  "cookie" => $cookie,	
			  "user_id" => $user_id	
			  ); 		  
	} 

    public function generate_auth_cookie() {
        global $json_api;

        if (!$json_api->query->username && !$json_api->query->email) {
            return "error: no username or email";
        }

        if (!$json_api->query->password) {
            return "error: You must include a 'password' var in your request.";
        }

        if ($json_api->query->seconds){
            $seconds = (int) $json_api->query->seconds;
        }
        else {
            $seconds = 1209600;//14 days
        }

        if ( $json_api->query->email ) {
            if ( is_email(  $json_api->query->email ) ) {
                if( !email_exists( $json_api->query->email))  {
                    return "error: no email";
                }

            }else {
                return "error: bad email";
            }

            $user_obj = get_user_by( 'email', $json_api->query->email );
            $user = wp_authenticate($user_obj->data->user_login, $json_api->query->password);
        }else {
            $user = wp_authenticate($json_api->query->username, $json_api->query->password);
        }

        if (is_wp_error($user)) {
            return "error: Invalid username/email and/or password.";
            remove_action('wp_login_failed', $json_api->query->username);
        }
        $expiration = time() + apply_filters('auth_cookie_expiration', $seconds, $user->ID, true);
        $cookie = wp_generate_auth_cookie($user->ID, $expiration, 'logged_in');
        preg_match('|src="(.+?)"|', get_avatar( $user->ID, 512 ), $avatar);

        return array(
            "cookie" => $cookie,
            "cookie_name" => LOGGED_IN_COOKIE,
            "user" => array(
                "id" => $user->ID,
                "username" => $user->user_login,
                "nicename" => $user->user_nicename,
                "email" => $user->user_email,
                "url" => $user->user_url,
                "registered" => $user->user_registered,
                "displayname" => $user->display_name,
                "firstname" => $user->user_firstname,
                "lastname" => $user->last_name,
                "nickname" => $user->nickname,
                "description" => $user->user_description,
                "capabilities" => $user->wp_capabilities,
                "avatar" => $avatar[1],
                "address" => $user->__get( "user_address" ),
                "phone" => $user->__get( "user_phone" )
            ),
        );
    }


    public function save_userinfo() {
        global $json_api;
        $user = wp_get_current_user();
        if ( 0 == $user->ID ) {
            return "nologin";
        }

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        update_user_meta(  $user->ID, 'user_phone', $obj['phone']);
        update_user_meta(  $user->ID, 'user_address', $obj['address']);
        return 1;
    }

    public function get_max_image_count(){
        return $this->max_image_count;
    }

    public function get_my_properties() {
        global $json_api;
        $user = wp_get_current_user();
        if ( 0 == $user->ID ) {
            return "nologin";
        }
        $uname = $user->user_login;
        $post_id = $_REQUEST['post_id'];

        $posts = $json_api->introspector->get_posts(
            array(
                'post_type' => $this->post_type,
                'author_name' => $uname,
                'p' => $post_id
            ));
        return array(
            'posts' => $posts
        );
    }


    public function del() {
        global $json_api;
        $user = wp_get_current_user();
        if ( 0 == $user->ID ) {
            return "nologin";
        }
        $post_id = $_REQUEST['post_id'];
        $uname = $user->user_login;
        $posts = $json_api->introspector->get_posts(
            array(
                'post_type' => $this->post_type,
                'author_name' => $uname,
                'p' => $post_id
            ));

        if (sizeof($posts) == 0) {
            return "warning 信息不存在(no post)";
        }

        if($posts[0]->status == 'publish')
        {
            return "warning 信息已经发布不能删除(this item is published, can not delete)";
        }

        wp_delete_post($post_id);
        return 1;
    }


    public function create_property(){
        global $json_api;
        $user = wp_get_current_user();
        if ( 0 == $user->ID ) {
            return "nologin";
        }

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $obj['type'] = $this->post_type;
        $obj['status']='pendingpayment';

        $post = new JSON_API_Post();
        $id = $post->create($obj);
        add_post_meta($id, 'webbupointfinder_items_address', $obj['address']);
        if (empty($id)) {
            return "error: create property fail";
        }
        return $id;
    }

    public function uploadImage() {
        $post_id = $_REQUEST['post_id'];
        $image_index = $_REQUEST['image_index'];
        include_once ABSPATH . '/wp-admin/includes/file.php';
        include_once ABSPATH . '/wp-admin/includes/media.php';
        include_once ABSPATH . '/wp-admin/includes/image.php';
        $attachment_id = media_handle_upload('attachment', $post_id);
        $attachment_url = wp_get_attachment_url($attachment_id);
        if ($image_index == "0") {
            add_post_meta($post_id, '_thumbnail_id', $attachment_id);
        }
        else {
            add_post_meta($post_id, 'webbupointfinder_item_images', $attachment_id);
        }

        return $attachment_url;
    }
}
?>

