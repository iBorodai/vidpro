<?php $this->reg=array (
	'controls' => array (
		'meta' => array (
			'class' => 'proj_get_meta',
			'tpl' => 'meta.htm',
			'modes' => 'author=last&keywords=rjoin&description=rjoin&title=last&js=join&rss=join',
			'order' => '777',
		),
		'meta_edit' => array (
			'class' => 'meta_edit',
			'tpl' => '_sys/meta_edit.htm',
			'include' => 'lib/ui/meta_edit.php',
		),
		'img' => array (
			'class' => 'img',
		),
		'replacer' => array (
			'class' => 'replacer',
			'section' => '',
		),
		'link' => array (
			'class' => 'lnk',
			'link' => '',
		),
		'input' => array (
			'class' => 'form_input',
		),
		'select' => array (
			'class' => 'form_select',
		),
		'options' => array (
			'class' => 'select_option',
		),
		'optiongroup' => array (
			'class' => 'select_grp_option',
		),
		'option' => array (
			'class' => 'select_option',
		),
		'textarea' => array (
			'class' => 'form_text',
		),
		'bugtrack' => array (
			'class' => 'bugtrack',
			'tpl' => '_sys/debug.htm',
			'vars' => 'bfdel=&bffix=&bfunfix=&bfpage=&bfall=2',
			'include' => 'lib/ui/bugtrack.php',
		),
		'panel' => array (
			'class' => 'panel',
			'pg' => '',
		),
		'dongle' => array (
			'class' => 'dongle',
			'tpl' => '_sys/dongle.htm',
		),
		'icontrol' => array (
			'class' => 'icontrol',
		),
		'handler' => array (
			'class' => 'handler',
		),
		'reg_handler'=> array (
			'class' => 'handler',
   		'include' => 'lib/reg_wizard.php',
		),
		'error' => array (
			'class' => 'error',
			'types' => array (
				'message' => '<span class="err_msg">{msg}</span>',
				'warning' => '<span class="err_wrn">{msg}</span>',
				'error' => '<span class="err_err">{msg}</span>',
			),
			'order' => -1,
		),
		'msg' => array (
			'class' => 'cs_macro',
		),
		'form' => array (
			'class' => 'form',
			'valid_error' => 'sys:err.valid_error',
			'on_missing' => 'sys:err.field_missing',
			'on_error' => 'sys:err.field_error',
			'no_field' => 'sys:err.no_fl_error',
			'cs_mode' => 'none',
		),
		'menu' => array (
			'class' => 'menu',
			'ctrl' => 'Jlib_target',
			'vars' => 'Jlib_target=',
		),
		'page_selector' => array (
			'class' => 'page_selector',
			'vars' => 'Jlib_target=',
			'include' => 'lib/ui/page_sel.php',
		),
		'path' => array (
			'class' => 'show_path',
			'include' => 'lib/ui/show_path.php',
			'tpl' => 'path_tpl.htm',
		),
		'struct_viewer' => array (
			'class' => 'struct_viewer',
		),
		'struct_editor' => array (
			'class' => 'struct_editor',
			'page_tpl' => 'page_tpl',
		),
		'content' => array (
			'class' => 'content',
			'dir_name' => 'content',
		),
		'content_editor' => array (
			'class' => 'content_editor',
			'dir_name' => 'content',
			'ctrl' => 'id',
		),
		'user_info' => array (
			'class' => 'user_info',
			'vars' => 'logout',
			'security' =>'site_auth',
			'auth_tpl' => 'user_info.htm',
			'tpl' =>'user_info.htm',
		),
		'list_viewer' => array (
			'class' => 'list_viewer',
			'page_selector_tpl' => 'pages.htm',
		),
		'list_viewer_noucl' => array (
			'class' => 'list_viewer_noucl',
			'page_selector_tpl' => 'pages.htm',
		),
		'item_viewer' => array (
			'class' => 'item_viewer',
		),
		'item_editor' => array (
			'class' => 'item_editor',
		),
		'upload_editor' => array (
			'class' => 'upload_editor',
		),
		'sys_msg_edit' => array (
      'class' => 'msg_edit',
      'vars' => 'msg_id=',
      'url' => 'msg_id',
      'include' => 'lib/msg_edit.php',
      'from' => 'self',
      'tpl' =>'_sys/msg_edit.htm',
      'ucl_get' => 'sql:sys_msg?msg_id=\'{id}\'$auto_query=no shrink=no id=ln',
      'ucl_set' => 'sql:sys_msg?msg_id=\'{id}\' AND ln=\'{ln}\'$auto_query=no shrink=no',
		),
		'uploader' => array (
			'class' => 'uploader',
		),
		'show_data' => array (
			'class' => 'show_data',
		),
		'lite_reg' => array (
			'class' => 'lite_reg',
			'name' => 'reg',
			'vars'=>'step&unlock&m',
			'url'=>'step',
			'ctrl'=>'step',
		  'ctrl_steps'=>'step',
			'tpl' => 'registration.htm',
			'include' => 'lib/reg_wizard.php',
			/*
			'insert_ucl' => 'sql:sallers
											#s_id,s_email,s_pwd,s_type,s_img,s_name,s_desc,s_phone1,s_phone2,s_phone3,s_map,s_regdate,s_maillock
											$auto_query=no default="s_regdate=NOW()"',
			'update_ucl' => 'sql:sallers
											#{pwd}s_id,s_email,s_type,s_img,s_name,s_desc,s_phone1,s_phone2,s_phone3,s_map
											$auto_query=no',
			*/
			'email_tpl' => 'mail_reg_saller.htm',
		),
		'passreminder' => array (
			'class' => 'passreminder',
			'include' => 'lib/auth.php',
			'email_tpl'=>'user_remind.txt',
			'tpl'=>'user_remind.htm',
		),
    'subscribe' => array (
      'class' => 'subscriber',
      'email_tpl' => 'subscribe_mail.txt',
      'tpl' => 'subscribe.htm',
    ),
		'function' => array (
			'class' => 'jFuncCall',
			'order' => 100,
		),
		'feedback_form' => array (
			'class' => 'feedback_form',
		),
		'imenu' => array (
			'class' => 'imenu',
			'ctrl' => 'Jlib_target',
			'vars' => 'Jlib_target=',
		),
		'ajax' => array(
			'class' => 'ajax',
			'include' => 'lib/ajax.php'
		),
		'get_form' =>array(
			'class' =>'get_form',
		),
		'point'=>array(
		  'include' => 'lib/project.php',
		  'class'=>'point',
		),
		'search_form'=>array(
		  'include' => 'lib/project.php',
		  'class'=>'search_form',
		),
		'project_list_viewer' => array (
		  'include' => 'lib/project.php',
			'class' => 'proj_list_viewer',
			'page_selector_tpl' => 'pages.htm',
		),
		'nav_cats'=>array(
		  'class' => 'nav_cats',
		),
	),
	'forms' => array (
		'regexes' => array (
			'input' => '/<(input)()\\s?([^>]*)>/',
			'select' => '|<(select)()\\s?([^>]*)>(.*)</select>|msU',
			'textarea' => '|<(textarea)()\\s?([^>]*)>(.*)</textarea>|msU',
		),
		'select' => array (
			0 => '|<(option)()\\s?([^>]*)>(.*)</option>|msU',
			1 => '|<(options)()\\s?([^>]*)>|',
			2 => '|<(optiongroup)()\\s?([^>]*)>|',
		),
		'types' => array (
			'any' => array (
				'regex' => '/.*/',
				'processor' => 'regex',
				'on_error' => 'sys:err.any_error',
			),
			'html' => array (
				'regex' => '/.*/',
				'processor' => 'regex',
				'on_error' => 'sys:err.any_error',
			),
			'danger_html' => array (
				'regex' => '/.*/',
				'processor' => 'regex',
				'on_error' => 'sys:err.any_error',
			),
			'phone' => array (
				//'regex' => '/(\\+[0-9])? ?(\\([0-9]{0,3}\\)) ?([0-9| |\\-]{5,8})/',
				'regex' => '/^\\+?([0-9|\\(\\) |\\-]+)$/',
				'processor' => 'regex',
				'on_error' => 'sys:err.phone_error',
			),
			'phone_hard' => array (
				//'regex' => '/^\\(\d{3}\\) \d{3}-\d{2}-\d{2}$/',
				'regex' => '/^\+3\d+\s*\\(?\d+\\)?\s*\d{3}-\d{2}-\d{2}$/',
				'processor' => 'regex',
				'on_error' => 'sys:err.phone_error',
			),
			'login' => array (
				'regex' => '/^([a-zA-Z])([A-Za-z0-9_]|\\-|\\.)*$/',
				'processor' => 'regex',
			),
			'email' => array (
				'regex' => '/^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$/i',
				'processor' => 'regex',
				'on_error' => 'sys:err.email_error',
			),
			'url' => array (
				//'regex' => '|^(http://){0,1}(www.){0,1}(([a-z0-9_-])+\\.)+[a-z]{2,4}$|i',
				'processor' => 'url_validate',
				'on_error' => 'sys:err.url_error',
			),
			'number' => array (
				'regex' => '/^[+-]?[[:digit:]]+/',
				'processor' => 'regex',
				'on_error' => 'sys:err.number_error',
			),
			'date' => array (
				'regex' => '/([0-9]{2})[\\/|\\.|-]([0-9]{2})[\\/|\\.|-]([0-9]{2}|[0-9]{4})/',
				'processor' => 'regex',
				'on_error' => 'sys:err.date_error',
			),
			'datetime' => array (
				'regex' => '/[\d]{2}\.[\d]{2}\.[\d]{2,4} [\d]{2}:[\d]{2}/',
				'processor' => 'regex',
				'on_error' => 'sys:err.date_error',
			),
			'word_latin' => array (
				'regex' => '/^([a-zA-Z])([A-Za-z0-9_-])*/',
				'processor' => 'regex',
				'on_error' => 'sys:err.date_error',
			),
			'md5' => array (
				'regex' => '/.*/',
				'processor' => 'regex',
				'on_error' => 'sys:err.any_error',
			),
			'capcha' => array (
				'regex' => '',
				'processor' => 'capcha_test',
				'on_error' => 'sys:err.wrong_capcha',
			),
			'password'=> array (
				'regex' => '/^.{6,50}/',
				'processor' => 'regex',
				'on_error' => 'sys:err.wrong_password',
			),
		),
	),
	'suppliers' => array(
		'sql' => array (
			'class' => 'cs_sql',
			'db' => 'ww',
			'init_on_demand' => 'no',
			'auto_query' => 'no',
			'shrink' => 'no',
			'auto_queries' => array (
				'lang' => array (
					'db_field' => 'ln=',
					'var_type' => 'global',
					'var_name' => 'Jlib_lang',
				),
			),
			'use_mapping' => 'public',
			'mapping' => array (
				'get' => array (
					'command' => 'SELECT',
					'fields' => '',
					'tables' => 'FROM',
					'query' => 'WHERE',
					'auto_query' => 'AND',
					'group' => 'GROUP BY',
					'having' => 'HAVING',
					'order' => 'ORDER BY',
					'limit' => 'LIMIT',
				),
				'update' => array (
					'command' => 'UPDATE',
					'tables' => '',
					'fields' => 'SET',
					'query' => 'WHERE',
					'auto_query' => 'AND',
				),
				'insert' => array (
					'command' => 'INSERT',
					'tables' => '',
					'fields' => 'SET',
				),
				'replace' => array (
					'command' => 'REPLACE',
					'tables' => '',
					'fields' => 'SET',
				),
				'delete' => array (
					'command' => 'DELETE',
					'tables' => 'FROM',
					'query' => 'WHERE',
					'auto_query' => 'AND',
				),
				'delete_ex' => array (
					'command' => 'DELETE',
					'fields' => '',
					'tables' => 'FROM',
					'query' => 'WHERE',
					'auto_query' => 'AND',
				),
			),
		),
		'sql_lite' => array (
			'class' => 'cs_sql_lite',
			'table' => 'sys_msg',
			'field' => 'msg',
			'query' => 'msg_id=',
			'extra' => 'LIMIT 0,1',
			'shrink' => 'no',
		),
		'msg' => array (
			'class' => 'cs_msg',
			'preload' => 'no',
			'table' => 'sys_msg',
			'field' => 'msg',
			'query' => 'msg_id=',
			'extra' => 'LIMIT 0,1',
			'shrink' => 'yes',
		),
		'sys' => array (
			'class' => 'cs_sys',
			'table' => 'sys_err',
			'field' => 'msg',
			'query' => 'err_id=',
			'extra' => 'LIMIT 0,1',
			'shirnk' => 'yes',
			'errors' => array (
				'no_err' => 'Undefined error code: \'',
				'db_con' => 'Database server connection error! Host \'{1}\', user \'{2}\'.',
				'db_use' => 'Database \'{1}\' not found!',
				'db_sql' => 'Wrong SQL query. {1} <br> Query is: {2}',
				'ld_err' => 'File not found: {1} !',
				'pg_none' => '404 - page not found ({1}).',
				'fr_none' => 'Frame not found ({1}).',
				'obj_none' => 'Object \'{1}\' is missing!',
				'cls_none' => 'Class \'{1}\' not found!',
				'dir_not_found' => 'Directory \'{1}\' description not found in registry',
				'rule_error' => 'Error in a condition! Rule: \'{1}\', expression: \'{2}\'.',
				'hdl_not_found' => 'Handler \'{1}\' not found!',
				'hdl_empty' => 'Empty handler action! Handler \'{1}\', rule: \'{2}\'.',
			),
		),
		'search' => array (
			'class' => 'cs_search',
			'auto_query' => 'no',
			'use_mapping' => 'public',
		),
	),
	'databases' => array (
		'db' => array (
			'class' => 'mysql_db',
			'server' => '192.168.0.1',
			'db' => 'vidguk',
			'usn' => 'root',
			'pwd' => '',
			'set_names' => 'utf-8',
		),
		'self' => array (
			'class' => 'mysql_db',
			'server' => 'localhost',
			'db' => 'vidguk',
			'usn' => 'root',
			'pwd' => '',
			'set_names' => 'utf-8',
		),
		'host'=>array(
			'class' => 'mysql_db',
			'server' => 'vidguk.mysql.ukraine.com.ua',
			'db' => 'vidguk_db',
			'usn' => 'vidguk_db',
			'pwd' => '2kmvSvYB',
			'set_names' => 'utf-8',
		),
	),
	'directory' => array (
	  'comms_list_last'=>array(
	    'ctrl'=>'p_id',
	    'vars'=>'p_id',
	    'url'=>'p_id',
			'ucl'=>'sql:point LEFT JOIN (
										SELECT	com_key_obj last_obj, max(com_id) max_com_id, com_key_u last_com_uid
								    FROM		comment
								    WHERE		com_type=\'pnt\'
								    GROUP BY com_key_obj
								)cm ON (last_obj=p_id) LEFT JOIN
								comment ON ( com_id=max_com_id ) LEFT JOIN
								user ON ( com_key_u = u_id ) LEFT JOIN
								likes ON ( l_key_obj = p_id AND l_type = \'pnt\' ) LEFT JOIN
								user2point ON( u2p_key_p=p_id AND ( u2p_key_u=\'{auth_u_id}\' ) ),
								region,
								point2theme,
								theme
							#p_id, p_url, p_fsid, p_name, p_img, p_dscr, p_key_reg, p_addr, p_lat, p_lng,
								p_createdate,
								com_id, com_type, com_date, com_short, com_cachelikes, com_cahecomms,
								u_id, u_grp, u_url, u_name, u_img, u_gender, u_createdate, u_lastlogin,
								r_id, r_name, r_url, r_lat, r_lng,
								u2p_key_p,
							 	COUNT( com_id ) p_comms, SUM( l_weight ) p_weight, COUNT( l_weight ) p_votes,
								(
									SELECT COUNT( l1.l_key_obj ) FROM likes l1 WHERE l1.l_key_obj = p_id AND l1.l_type = \'pnt\' AND l_weight >0
								)p_plus_cnt
							?p_key_reg=r_id AND
							 p2t_key_p=p_id AND t_id=p2t_key_t {queries}
							$group=p_id order=com_date direction=desc',
							
			'ucl_themes'=>' p2t_key_t IN({themes}) ',
			'ucl_city'=>' r_url IN( {city} ) ',
	    //'ucl_cats'
	    'tpl'=>'point_comm_list.htm',
	    'quantity'=>10,
	    'filter'=>array(
	      'theme'		=> array(' = ','t_url',false,true)
	      //'search'	=> array(' LIKE ','u_login','as_start',true)
			),
			'line_tuner'=>'comms_list_last_ltuner',
			'sections'=>array(
			  'com_short'=>'any',
			  'u2p_key_p'=>'any',
			),
		),
		'comms_user_subscribed'=>array(
	    'ctrl'=>'p_id',
	    'vars'=>'p_id',
	    'url'=>'p_id',
			'ucl'=>'sql:point JOIN
								comment ON ( p_id=com_key_obj AND com_type=\'pnt\' ) JOIN
								user ON ( com_key_u = u_id ) JOIN
								user2user ON ( u2u_sub={auth_u_id} AND u2u_sig=u_id )	LEFT JOIN
								likes ON ( l_key_obj = p_id AND l_type = \'pnt\' ) LEFT JOIN
								user2point ON( u2p_key_p=p_id AND ( u2p_key_u=\'{auth_u_id}\' ) ),
								region
							#p_id, p_url, p_fsid, p_name, p_img, p_dscr, p_key_reg, p_addr, p_lat, p_lng,
								p_createdate,
								com_id, com_type, com_date, com_short, com_cachelikes, com_cahecomms,
								u_id, u_grp, u_url, u_name, u_img, u_gender, u_createdate, u_lastlogin,
								r_id, r_name, r_url, r_lat, r_lng,
								u2p_key_p,
							 	COUNT( com_id ) p_comms, SUM( l_weight ) p_weight, COUNT( l_weight ) p_votes,
								(
									SELECT COUNT( l1.l_key_obj ) FROM likes l1 WHERE l1.l_key_obj = p_id AND l1.l_type = \'pnt\' AND l_weight >0
								)p_plus_cnt
							?p_key_reg=r_id
							$group=p_id order=com_date direction=desc',
	    'tpl'=>'point_user_subscribed.htm',
	    'quantity'=>10,
			'line_tuner'=>'comms_list_last_ltuner',
			'sections'=>array(
			  'com_short'=>'any',
			  'u2p_key_p'=>'any',
			),
		),
		'comms_points_subscribed'=>array(
	    'ctrl'=>'p_id',
	    'vars'=>'p_id',
	    'url'=>'p_id',
			'ucl'=>'sql:user2point, point LEFT JOIN
								likes ON ( l_key_obj = p_id AND l_type = \'pnt\' ) JOIN
								comment ON ( p_id=com_key_obj AND com_type=\'pnt\' ) JOIN
								user ON ( com_key_u = u_id ),
								region
							#p_id, p_url, p_fsid, p_name, p_img, p_dscr, p_key_reg, p_addr, p_lat, p_lng,
								p_createdate,
								com_id, com_type, com_date, com_short, com_cachelikes, com_cahecomms,
								u_id, u_grp, u_url, u_name, u_img, u_gender, u_createdate, u_lastlogin,
								r_id, r_name, r_url, r_lat, r_lng,
								u2p_key_p,
							 	COUNT( com_id ) p_comms, SUM( l_weight ) p_weight, COUNT( l_weight ) p_votes,
								(
									SELECT COUNT( l1.l_key_obj ) FROM likes l1 WHERE l1.l_key_obj = p_id AND l1.l_type = \'pnt\' AND l_weight >0
								)p_plus_cnt
							?p_key_reg=r_id AND u2p_key_p=p_id AND u2p_key_u={auth_u_id}
							$debug=yes group=p_id order=com_date direction=desc',
	    'tpl'=>'point_user_subscribed.htm',
	    'quantity'=>10,
			'line_tuner'=>'comms_list_last_ltuner',
			'sections'=>array(
			  'com_short'=>'any',
			  'u2p_key_p'=>'any',
			),
		),
		'point'=>array(
		  'ctrl'=>'p_url',
		  'vars'=>'p_url',
		  'url'=>'p_url',
		  'tpl'=>'point.htm',
		  'sections'=>array(
		    'p_timeframes'=>'any',
		    'p_phone'=>'any',
		    'p_site'=>'any',
		    'p_fs_reasons'=>'any',
		    'p_fs_atts'=>'any',
		    
		    'p_menu'=>'any',
				'p_cards'=>'any',
				'p_wifi'=>'any',
				'p_summerplace'=>'any',
				'p_dscr'=>'any',
			),
		),
		'search_fs_points'=>array(
		  'ctrl'=>'p_id',
		  'vars'=>'p_id=&query=&region=&region_other',
		  'url'=>'p_id',
		  'tpl'=>'search_result.htm',
		  'get_data'=>'project_search_points',
		  'sections'=>array(
		    'p_id'=>'any',
		    'com_id'=>'any',
		    'p_comms'=>'any',
			),
		),
		'point_edit'=>array(
		  'ctrl'=>'p_id',
		  'vars'=>'p_id',
		  'url'=>'p_id',
		  'ucl'=>'sql:point#p_id,p_name,p_dscr,p_addr,p_more?p_url=\'{p_id}\'',
		  'before_form_create'=>'point_edit_before_form',
		  'before_save'=>'point_edit_before_save',
		  'after_save'=>'point_edit_after_save',
		),
	),

	'security' => array (
		'class' => 'security',
		'include' => 'lib/auth.php',
		'site_auth' => array (
			'class' => 'site_sd',
			'tpl' => 'login.htm',
			'auth_class' => 'form',
			'auth_var' => 'usr',
		),
		'admin_auth' => array (
			'class' => 'site_sd',
			'tpl' => '_sys/login.htm',
			'auth_class' => 'form',
			'auth_var' => 'usr',
		),
		'undercon' => array (
			'class' => 'undercon',
			'tpl' => 'ustudio_undercon.htm',
			'auth_class' => 'form',
			'auth_var' => 'usr',
		),
	),

	'default' => array (
		'page_404' => 'no404',
		'page' => 'default',
		'starter' => 'starter',
		'cms_root' => 'admin',
		'database' => 'db',
		'lang' => 'RU',
		'langset' => 'RU',
		'skin' => '',
		'skinset' => 'pda',
		'set_names' => 'utf8',
		//'proj_email'=>'mailbox@vidguk.pro',
		'proj_email'=>'kronius@yandex.ru',
		'proj_email_name'=>'vidguk.pro',
	),

	'projects' => array (
		array (
			'ptn' => 'vidguk.pro',
			'where' => 'SERVER_NAME',
			'database' => 'host',
			'proj' => 'local',
			'set_names' => 'utf8',
		),
	),
	
	'system' => array (
		'define' => array (
			'Jlib_OPEN_TAG' => '{',
			'Jlib_CLOSE_TAG' => '}',
			'Jlib_MAIN_PTN' => '#-(\\w*):(\\w*)((?:\\s+\\w+=(?:".*"|.*))*)\\s*-#(?:(.*(?=#-/\\1-#))|)',
			'Jlib_MAIN2_PTN' => '(\\w*):(\\w*)(.*)',
			'Jlib_PG_CTRL' => 'Jlib_target',
			'Jlib_LN_CTRL' => 'Jlib_lang',
			'Jlib_SKIN_CTRL' => 'Jlib_skin',
			'Jlib_MOD_REWRITE' => 1,
			'Jlib_USE_SESSION' => 1,
			'Jlib_USE_META' => 1,
			'Jlib_ALLOW_USER_REG' => 0,
			'Jlib_USE_HISTORY' => 0,
			'Jlib_USE_SECURITY' => 1,
			'Jlib_CACHE_STRUCT' => 0,
			'Jlib_MULTILANG' => 1,
			'Jlib_ALWAYS_USE_LANG' => 0,
			'Jlib_OPEN_MRK' => '[',
			'Jlib_CLOSE_MRK' => ']',
			'Jlib_MRK_PTN' => '|\\#1(.*)#2|U',
		),
		'load' => array (
			'cm' => 'cm',
			'cache' => 'cache',
		),
		'usr_reg_allowed' => array (
			'frames' => 'add',
			'pages' => 'add',
			'menus' => 'add',
			'wizards' => 'add',
			'structure' => 'add',
			'handlers' => 'add',
		),
		'meta' => array (
			'site' => 'global',
			'page' => 'extra',
			'metas' => 'author,keywords,description,title',
			'ucl_get' => 'sql:sys_meta#mt_typ,mt_cnt,mt_ovr?mt_pg=\'{pg}\' AND (ln=\'XX\' OR ln=\'{lang}\')$shrink=no order=mt_order,mt_id direction=asc,asc ',
			'ucl_edit_get' => 'sql:sys_meta#mt_typ,mt_cnt,mt_ovr?mt_pg=\'{pg}\' AND ln=\'{lang}\'$shrink=no	',
			'ucl_set' => 'sql:sys_meta#mt_typ,mt_cnt,mt_ovr,ln,mt_pg?mt_pg=\'{pg}\'$shrink=no defaults="ln=\'{lang}\'" ',
		),
		'struct_rules' => array (
			'pub' => array (
				'yes' => array (
					0 => 1,
					1 => 1,
				),
				'skip' => array (
					0 => 1,
					1 => 0,
				),
				'sys' => array (
					0 => 1,
					1 => 0,
				),
				'special' => array (
					0 => 1,
					1 => 0,
				),
				'cms_hide' => array (
					0 => 1,
					1 => 1,
				),
				'block' => array (
					0 => 0,
					1 => 0,
				),
				'none' => array (
					0 => 0,
					1 => 0,
				),
			),
			'cms' => array (
				'yes' => array (
					0 => 1,
					1 => 1,
				),
				'skip' => array (
					0 => 1,
					1 => 1,
				),
				'sys' => array (
					0 => 1,
					1 => 0,
				),
				'special' => array (
					0 => 1,
					1 => 0,
				),
				'cms_hide' => array (
					0 => 1,
					1 => 0,
				),
				'block' => array (
					0 => 1,
					1 => 1,
				),
				'none' => array (
					0 => 0,
					1 => 0,
				),
			),
		),
		'pics' => array (
			'tmb_x' => '75',
			'tmb_y' => '75',
			'pic_px' => '640',
			'pic_py' => '480',
			'pic_lx' => '480',
			'pic_ly' => '640',
			'no_pic' => 'nophoto',
			'path' => 'img/usr/images',
		),
		'conf_file_managment' => array (
			'base_dir' => 'img/usr',
			'icons_dir' => 'img/ext',
			'img_processor_run' => 'jpg,jpeg,png,gif',
			'exeptions' => array (
				'files' => '.,..',
				'dirs' => '.,..,.svn',
				'ext' => 'exe',
			),
			'upload_resize' => 'jpg,jpeg,png,bmp',
			'upload_types' => '',
			'upload_max_size' => 0,
		),
		'format' => array (
			'date' => array (
				'processor' => 'date_processor',
				'proc_type' => 'func',
				'store' => 'Y-m-d',
				'display' => 'd.m.Y',
				'EN' => array (
					'display' => 'm/d/Y',
				),
			),
			'datetime' => array (
				'processor' => 'datetime_processor',
				'proc_type' => 'func',
				'store' => 'Y-m-d H:i',
				'display' => 'd.m.Y H:i',
			),
			'md5' => array (
				'processor' => 'md5_proc',
				'proc_type' => 'func',
			),
			'quotes' => array(
				'processor' => 'quotes_processor',
				'proc_type' => 'func',
			),
			'as_like' => array(
				'processor' => 'as_like',
				'proc_type' => 'func',
			),
			'as_start' => array(
				'processor' => 'as_start',
				'proc_type' => 'func',
			),
			'brs' => array(
				'processor' => 'brs',
				'proc_type' => 'func',
			),
			'nohtml' => array(
				'processor' => 'clean_html',
				'proc_type' => 'func',
			),
			'htmlspec' => array(
				'processor' => 'html_spec',
				'proc_type' => 'func',
			),
			'html' => array(
				'processor' => 'safe_html',
				'proc_type' => 'func',
			),
			'danger_html' =>array(
				'processor' => 'danger_html',
				'proc_type' => 'func',
			),
		),
	),
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------/ F R A M E S \-------------------------------------------------------------------
	'frames' => array (
		'default' => array (
			'class' => 'icontrol',
			'tpl' => 'index.htm',
			'security' => 'undercon',
			'content' => array (
			),
		),
		'inside' => array (
			'class' => 'icontrol',
			'tpl' => 'inside.htm',
			'security' => 'undercon',
			'content' => array (
			),
		),
		'ajax' => array (
			'class' => 'icontrol',
			'pg' => '{panel:block}',
			'content' => array (
     		'block' => 'ajax: tpl=ajax_output.htm',
			),
		),
	),
// --------------------------------------------------------------------\ F R A M E S /-------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------------------
	'pages' => array (
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------/ P A G E S \--------------------------------------------------------------------
		'default' => array (
			'frame' => 'default',
			'class' => 'reg_handler',
			'content' => array(
			  'logo_nav'=>'nav_cats: tpl="nav_cats.htm" vars="theme&users&points" ',
     		'block1'=>'icontrol: tpl=index_layout.htm',
			),
		),
		'static_content' => array (
			'frame' => 'default',
			'content' => array(
				'center' => 'content: ',
			),
		),
		'static_content_edit' => array (
			'frame' => 'inside',
			'content' => array(
				'center' => 'content_editor: dir_name=content tpl=content_edit.htm',
			),
		),
		'ajax' => array (
			'frame' => 'ajax',
			'content' => array (),
		),
		'page_tpl' => array (
			'frame' => 'inside',
			'content' => array (
			),
		),
		'no404' => array (
			'frame' => 'empty',
			'tpl' => '404.htm',
			'caption' => '404',
			'content' => array (
			),
		),
		'bugtrack' => array (
			'caption' => 'Bugtracker main',
			'frame' => 'empty',
			'class' => 'icontrol',
			'pg' => '{bugtrack:bug}',
		),
		'default_point' => array (
			'frame' => 'default',
			'content' => array(
			  'search_form'=>'function: name=point_stat tpl=point.htm',
				'block1' => 'point: dir_name=point',
				'under_wrapper'=>'replacer: tpl=point.htm section=mapbox',
			),
		),
		'point_edit' => array (
			'frame' => 'empty',
			'class' => 'item_editor',
			'dir_name'=> 'point_edit',
			'tpl' => 'point_edit.htm',
			'security'=>'admin_auth',
			'content' => array(
			),
		),

		'point_add'=>array(
		  'frame' => 'empty',
		  'class'=>'point_add',
		),
		'default_search' => array (
			'frame' => 'default',
			'content' => array(
				'block1' => 'project_list_viewer: dir_name=search_fs_points',
			),
		),
		'default_reminder'=>array(
			'frame' => 'default',
			'class' => 'icontrol',
			'security'=>'',
			'content' => array(
			  'block1'=>'passreminder: ',
			),
		),
		'default_auth'=>array(
			'frame' => 'default',
			'class' => 'icontrol',
			'security'=>'',
			'content' => array(
			  'block1'=>'panel: security=site_auth auth_redirect=default auth_tpl=login_short.htm',
			  'block2'=>'function: name=auth_redirect',
			),
		),

// ------------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------\ P A G E S /--------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------------------
	),
	'menus' => array (
		'nav_main' => array(
			'base' => 'struct',
			'location' => '',
			'show_thread' => 'yes',
			'item_def' => array (
				'name_proc' => 'msg:',
			),
			'additions' => array (
				'default' => array (
					//'status' => 'sys',
					'caption'=>'about',
					'order'=>'1',
				),
			),
			'tpl' => 'nav_main.htm',
		),
	),
	'structure' => array (
		'admin' => array (
			'page' =>'default_admin',
			'status' => 'sys',
			'content' => array(),
		),
		'RU' => array (
			'default' => array (
				'content' => array (
          'ajax' => array(
              'page' => 'ajax',
              'status' => 'special',
              'content' => array(),
          ),
					'bugtrack' => array (
						'status' => 'special',
						'order' => '295',
						'link' => '',
						'target' => '',
					),
					'admin' => array (
						'struct_base' => 'admin',
						'order' => '300',
						'status' => 'special',
						'link' => '',
						'target' => '',
					),
					'about' =>array(
						'page' => 'static_content',
						'status'=>'sys',
					),
					'contacts' =>array(
						'page' => 'static_content',
						'status'=>'sys',
					),
					'registration'=>array(
					  'page' => 'default_reg',
						'status'=>'sys',
					),
					'point'=>array(
					  'page' => 'default_point',
						'status'=>'sys',
						'handle' => array (
							array (
								'case' => " '{1}'=='edit' ",
								'page' => 'point_edit',
							),
						),
						'content'=>array(
						  'add'=>array(
						  	'page'=>'point_add'
						  ),
						),
					),
					'search'=>array(
					  'page' => 'default_search',
					),
					'reminder'=>array(
					  'page' => 'default_reminder',
					),
					'auth'=>array(
					  'page' => 'default_auth',
					)
				),
			),
		),//end of RU
	),
	'handlers' => array (
	),
	'wizards'=>array(
		'registration' => array(
		  'tpl' => 'registration.htm',
			'vars'=>'step&unlock&m',
			'url'=>'step',
			'ctrl'=>'step',
		  'ctrl_steps'=>'step',
		  'get_data'=>array(
		    'sql:users
				 #u_name,u_email
				 ?u_key_u={auth_u_id}
				 $',
			),
		  'steps' => array(
		    'name' => array(
		      'tpl' => 'body',
				  //'processor' => false,
				  'validator' => 'reg_check_name',
				),
				'catigories'=>array(
				  'tpl'=>'categories',
					//'processor' => false,
				  //'validator' => false,
				  'builder'=>'reg_build_cats',
				  //'store_step'=>'store_visit_calendar',
				  //'validator'=>'valid_calendar',

				),
			),
		),
	)
); ?>