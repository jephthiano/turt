<?php
require_once(file_location('inc_path','connection.inc.php'));
@$conn = dbconnect('admin','PDO');


//FOR ADMIN AND RELATED

////CREATE ADMIN TABLE AND INSERT ADMIN
//$sql = "CREATE TABLE IF NOT EXISTS admin_table(
//    ad_id INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//    ad_email VARCHAR(50) NOT NULL,
//    ad_username VARCHAR(50) NOT NULL,
//    ad_password VARCHAR(100) NOT NULL,
//    ad_fullname VARCHAR(50) NOT NULL,
//    ad_level ENUM('1','2','3'),
//    ad_status ENUM('suspended','active') DEFAULT 'active',
//    ad_registered_by INT(100) NOT NULL,
//    
//    UNIQUE(ad_id),
//    UNIQUE(ad_email),
//    UNIQUE(ad_username),
//    FULLTEXT KEY (ad_email,ad_username,ad_fullname)
//    ) ENGINE=InnoDB";
//@$conn->exec($sql);
//    
//// CREATE ADMIN MEDIA TABLE
//$sql = "CREATE TABLE IF NOT EXISTS admin_media_table(
//    am_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//    am_link_name VARCHAR(100) NOT NULL,
//    am_extension VARCHAR(50) NOT NULL,
//    ad_id INT(100) NOT NULL,
//            
//    UNIQUE(am_id),
//    UNIQUE(am_link_name),
//    UNIQUE(ad_id),
//    FOREIGN KEY (ad_id) REFERENCES admin_table(ad_id) ON UPDATE CASCADE ON DELETE CASCADE
//    )ENGINE=InnoDB";
//@$conn->exec($sql);
// insert the grand admin
//$admin = new admin('admin');
//$admin->id = get_xml_data('id');
//$admin->new_email = get_xml_data('email');
//$admin->new_username = get_xml_data('username');
//$admin->new_password = hash_pass(get_xml_data('pass'));
//$admin->fullname = get_xml_data('fullname');
//$admin->level = get_xml_data('level');
//$admin->registered_by = get_xml_data('registered_by');
//$admin->auto_insert_update();

////CREATE LOG TABLE
//$sql = "CREATE TABLE IF NOT EXISTS log_table(
//   l_id INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//   l_brief VARCHAR(100) NOT NULL,
//	l_details VARCHAR(200) NOT NULL,
//	l_regdatetime DATETIME DEFAULT NOW(),
//	l_ip_address VARCHAR(200) NOT NULL,
//	ad_username VARCHAR(50) NOT NULL,
//   ad_id INT(100) NOT NULL,
//    
//   UNIQUE(l_id),
//	FULLTEXT KEY (l_brief,l_details,l_ip_address,ad_username)
//   ) ENGINE=InnoDB";
//@$conn->exec($sql);
   
   
   

   
//FOR USER AND RELATED

// CREATE USER TABLE
$sql = "CREATE TABLE IF NOT EXISTS user_table(
         u_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
         u_phnumber VARCHAR(250) NOT NULL,
         u_email VARCHAR(250),
         u_username VARCHAR(20) NOT NULL,
         u_password VARCHAR(100) NOT NULL,
         u_fullname VARCHAR(50) NOT NULL,
         u_bio VARCHAR(200),
         u_state VARCHAR(50),
         u_website VARCHAR(70),
         u_gender ENUM('male','female','prefer not to say') DEFAULT 'prefer not to say',
         u_dob VARCHAR(12),
         u_status ENUM('suspended','active','not active','deactivated') DEFAULT 'active',
         u_verify ENUM('no','yes') DEFAULT 'no',
         u_regdatetime DATETIME DEFAULT NOW(),
         
         UNIQUE(u_id),
         UNIQUE(u_phnumber),
         UNIQUE(u_username),
         FULLTEXT KEY (u_fullname,u_username)
         ) ENGINE=InnoDB";
@$conn->exec($sql);
   
// CREATE USER DUPLICATE TABLE
    $sql = "CREATE TABLE IF NOT EXISTS user_duplicate_table(
            ud_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            ud_phnumber VARCHAR(250) NOT NULL,
            ud_username VARCHAR(20) NOT NULL,
            ud_fullname VARCHAR(50) NOT NULL,
            u_id INT(100) NOT NULL,
            
            UNIQUE(ud_id),
            FULLTEXT KEY (ud_fullname,ud_username,ud_phnumber)
            ) ENGINE=InnoDB";
	@$conn->exec($sql);
      
// CREATE USER MEDIA TABLE
   $sql ="CREATE TABLE IF NOT EXISTS user_media_table(
            um_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            um_profilepics_link_name VARCHAR(100),
            um_coverpics_link_name VARCHAR(100),
            um_profilepics_extension VARCHAR(5),
            um_coverpics_extension VARCHAR(5),
            u_id INT(100) NOT NULL,
            
            UNIQUE(um_id),
            UNIQUE(um_profilepics_link_name),
            UNIQUE(um_coverpics_link_name),
            UNIQUE(u_id),
            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
   @$conn->exec($sql);

// CREATE SETTING TABLE
   $sql ="CREATE TABLE IF NOT EXISTS setting_table(
            s_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            s_private_account ENUM('on','off') DEFAULT 'off' NOT NULL,
            s_lock_inbox ENUM('on','off') DEFAULT 'off' NOT NULL,
            s_disable_returt ENUM('on','off') DEFAULT 'off' NOT NULL,
            s_unlink_account ENUM('on','off') DEFAULT 'off' NOT NULL,
            s_2fa_email ENUM('on','off') DEFAULT 'off' NOT NULL,
            s_2fa_text ENUM('on','off') DEFAULT 'off' NOT NULL,
            s_login_email ENUM('on','off') DEFAULT 'off' NOT NULL,
            u_id INT(100) NOT NULL,
            
            UNIQUE(s_id),
            UNIQUE(u_id),
            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);

// CREATE EMAIL CODE TABLE
   $sql ="CREATE TABLE IF NOT EXISTS token_code_table(
            c_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            c_code INT(6) NOT NULL,
            c_content VARCHAR(50) NOT NULL,
            c_verify ENUM('no','yes') DEFAULT 'no',
            c_regdatetime DATETIME DEFAULT NOW(),
            
            UNIQUE(c_id),
            UNIQUE(c_code),
            UNIQUE(c_content)
            )ENGINE=InnoDB";
    @$conn->exec($sql);

// CREATE COOKIE DATA TABLE
   $sql ="CREATE TABLE IF NOT EXISTS cookie_data_table(
            cd_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            cd_token VARCHAR(70) NOT NULL,
            cd_selector VARCHAR(70) NOT NULL,
            cd_ipaddress VARCHAR(70) NOT NULL,
            cd_device_type VARCHAR(70),
            cd_browser_type VARCHAR(70),
            cd_country VARCHAR(70) NOT NULL,
            cd_state VARCHAR(70) NOT NULL,
            cd_login_time DATETIME DEFAULT NOW(),
            cd_expiretime VARCHAR(70) NOT NULL,
            u_id INT(100) NOT NULL,
            
            UNIQUE(cd_id),
            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);
    
//CREATE LAST REFRESH TABLE
    $sql ="CREATE TABLE IF NOT EXISTS last_refresh_table(
            lr_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            lr_homepage_datetime DATETIME DEFAULT NOW(),
            lr_all_datetime DATETIME DEFAULT NOW() ON UPDATE NOW(),
            u_id INT(100) NOT NULL,            
            UNIQUE(lr_id),
            UNIQUE(u_id),
            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);

// CREATE FOLLOW TABLE (followee is the followed person while follower is the person that is following the followee)
    $sql ="CREATE TABLE IF NOT EXISTS follow_table(
            f_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            follower_id INT(100) NOT NULL,
            followee_id INT(100) NOT NULL,
            
            UNIQUE(f_id),
            FOREIGN KEY (follower_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (followee_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);
   
    
// CREATE BLOCK TABLE  (blockee is the person that is block while blocker is the person that blocks blockee)
   $sql ="CREATE TABLE IF NOT EXISTS block_table(
            b_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            blocker_id INT(100) NOT NULL,
            blockee_id INT(100) NOT NULL,
            
            UNIQUE(b_id),
            FOREIGN KEY (blocker_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (blockee_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);    
    
    
    
    
// FOR TURT AND RELATED

//// CREATE TURT TABLE
//$sql = "CREATE TABLE IF NOT EXISTS turt_table(
//            t_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            t_original_f_id INT(100) NOT NULL DEFAULT 0,
//            t_turt MEDIUMTEXT,
//            t_type ENUM('sucessRedirect','promoted') DEFAULT 'sucessRedirect',
//            t_mode ENUM('original','shared') DEFAULT 'original',
//            t_status ENUM('active','suspended') DEFAULT 'active',
//            t_regdatetime DATETIME DEFAULT NOW(),
//            u_id INT(100) NOT NULL,
//            
//            UNIQUE(t_id),
//            FULLTEXT KEY (t_turt),
//            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
//            ) ENGINE = InnoDB";
//		@$conn->exec($sql);
//
//// CREATE TURT MEDIA TABLE
//$sql ="CREATE TABLE IF NOT EXISTS turt_media_table(
//            tm_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            tm_link_name VARCHAR(100) NOT NULL,
//            tm_type ENUM('image','video') NOT NULL,
//            tm_extension VARCHAR(50) NOT NULL,
//            t_id INT(100) NOT NULL,
//            
//            UNIQUE(tm_id),
//            UNIQUE(tm_link_name),
//            FOREIGN KEY (t_id) REFERENCES turt_table(t_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//      
//// CREATE TURT COMMENT TABLE
//    $sql ="CREATE TABLE IF NOT EXISTS comment_table(
//            c_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            c_comment VARCHAR(255) NOT NULL,
//            c_type ENUM('text','media') DEFAULT 'text',
//            c_status ENUM('active','suspended') DEFAULT 'active',
//            c_datetime DATETIME DEFAULT NOW(),
//            t_id INT(100) NOT NULL,
//            u_id INT(100) NOT NULL,
//            
//            UNIQUE(c_id),
//            FULLTEXT KEY (c_comment),
//            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
//            FOREIGN KEY (t_id) REFERENCES turt_table(t_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//        
//// CREATE COMMENT MEDIA TABLE
//    $sql ="CREATE TABLE IF NOT EXISTS comment_media_table(
//            cm_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            cm_type ENUM('image','video','voicenote') NOT NULL,
//            cm_link_name VARCHAR(100),
//            cm_extension VARCHAR(50),
//            c_id INT(100) NOT NULL,
//
//            UNIQUE(cm_id),
//            UNIQUE(cm_link_name),
//            FOREIGN KEY (c_id) REFERENCES comment_table(c_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//
//// CREATE REPLY TABLE
//    $sql ="CREATE TABLE IF NOT EXISTS reply_table(
//            r_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            r_comment VARCHAR(255) NOT NULL,
//            r_type ENUM('text','media') DEFAULT 'text',
//            r_status ENUM('active','suspended') DEFAULT 'active',
//            r_datetime DATETIME DEFAULT NOW(),
//            c_id INT(100) NOT NULL,
//            u_id INT(100) NOT NULL,
//            
//            UNIQUE(r_id),
//            FULLTEXT KEY (r_comment),
//            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
//            FOREIGN KEY (c_id) REFERENCES comment_table(c_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//    
//// CREATE REPLY MEDIA TABLE
//    $sql ="CREATE TABLE IF NOT EXISTS reply_media_table(
//            rm_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            rm_type ENUM('image','video','voicenote') NOT NULL,
//            rm_link_name VARCHAR(100),
//            rm_extension VARCHAR(50),
//            r_id INT(100) NOT NULL,
//
//            UNIQUE(rm_id),
//            UNIQUE(rm_link_name),
//            FOREIGN KEY (r_id) REFERENCES reply_table(r_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//
//// CREATE LIKE TABLE
//   $sql ="CREATE TABLE IF NOT EXISTS like_table(
//            l_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            l_type ENUM('turt','comment','reply') NOT NULL,
//            content_id INT(100) NOT NULL,
//            u_id INT(100) NOT NULL,
//            
//            UNIQUE(l_id),
//            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//    
//// CREATE TURT SPONSORED TABLE
//     $sql = "CREATE TABLE IF NOT EXISTS turt_sponsored_table(
//            ts_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            ts_trans_id VARCHAR(30) NOT NULL,
//            ts_amount FLOAT(20) NOT NULL,
//            ts_currency VARCHAR(20) NOT NULL,
//            ts_payment_method VARCHAR(55) NOT NULL,
//            ts_country VARCHAR(255) NOT NULL,
//            ts_state VARCHAR(255) NOT NULL,
//            ts_status ENUM('pending','active','suspended','expired') DEFAULT 'pending',
//            ts_duration VARCHAR(3) NOT NULL,
//            ts_regdatetime DATETIME DEFAULT NOW() ON UPDATE NOW(),
//            t_id INT(100) NOT NULL,
//            
//            UNIQUE(ts_id),
//            UNIQUE(t_id),
//            FOREIGN KEY (t_id) REFERENCES turt_table(t_id) ON UPDATE CASCADE ON DELETE CASCADE
//            ) ENGINE = InnoDB";
//		@$conn->exec($sql);
//   
//// CREATE TRANSACTION TABLE
//   $sql = "CREATE TABLE IF NOT EXISTS transaction_table(
//            t_id INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            t_status ENUM('pending','success','fail') DEFAULT 'pending',
//            t_amount FLOAT(20),
//            t_currency VARCHAR(20),
//            t_ref_id VARCHAR(30),
//            t_trans_id VARCHAR(30) NOT NULL,
//            t_payment_method VARCHAR(55),
//            t_account_name VARCHAR(55),
//            t_account_number VARCHAR(15),
//            t_bank VARCHAR(100),
//            t_brand VARCHAR(100),
//            t_ipaddress VARCHAR(30),
//            t_regdatetime DATETIME DEFAULT NOW() ON UPDATE NOW(),
//            c_type VARCHAR(10) NOT NULL,
//            c_id INT(100) NOT NULL,
//            sp_id INT(100) NOT NULL,
//            u_id INT(100) NOT NULL,
//            
//            UNIQUE(t_id),
//            UNIQUE(t_ref_id),
//            UNIQUE(t_trans_id),
//            FULLTEXT KEY (t_trans_id,t_ref_id)
//            ) ENGINE = InnoDB";
//            @$conn->exec($sql);
            




// FOR MISC

// CREATE NOTIFICATION TABLE
    $sql ="CREATE TABLE IF NOT EXISTS notification_table(
            n_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            n_type ENUM('follow','post','comment','reply','returt','like') NOT NULL,
            n_status ENUM('sent','awared','seen') DEFAULT 'sent',
            n_content_id INT(100) NOT NULL,
            n_regdatetime DATETIME DEFAULT NOW(),
            receiver_id INT(100) NOT NULL,
            sender_id INT(100) NOT NULL,
            
            UNIQUE(n_id),
            FOREIGN KEY (receiver_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (sender_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);
//    
// CREATE MESSAGE TABLE
    $sql ="CREATE TABLE IF NOT EXISTS message_table(
            m_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            m_message MEDIUMTEXT NOT NULL,
            m_type ENUM('text','image','video','voicenote') DEFAULT 'text',
            m_status ENUM('sent','delivered','awared','seen') DEFAULT 'sent',
            m_regdate DATE DEFAULT NOW(),
            m_regdatetime DATETIME DEFAULT NOW(),
            sender_id INT(100) NOT NULL,
            receiver_id INT(100) NOT NULL,

            UNIQUE(m_id)
            )ENGINE=InnoDB";
    @$conn->exec($sql);
        
// CREATE MESSAGE MEDIA TABLE
   $sql ="CREATE TABLE IF NOT EXISTS message_media_table(
            mm_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            mm_type ENUM('image','video','voicenote') NOT NULL,
            mm_link_name VARCHAR(100),
            mm_extension VARCHAR(50),
            m_id INT(100) NOT NULL,

            UNIQUE(mm_id),
            UNIQUE(mm_link_name),
            FOREIGN KEY (m_id) REFERENCES message_table(m_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);

// CREATE REPORT TABLE (reportee is the person that is reported while reporter is the person that reports)
    $sql ="CREATE TABLE IF NOT EXISTS report_table(
            rp_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            rp_type ENUM('user','turt','comment','reply') NOT NULL,
            rp_status ENUM('new','solved') DEFAULT 'new' NOT NULL,
            rp_content_id INT(100) NOT NULL,
            rp_report VARCHAR (100) NOT NULL,
            rp_regdatetime DATETIME DEFAULT NOW(),
            reportee_id INT(100) NOT NULL,
            reporter_id INT(100) NOT NULL,
            
            UNIQUE(rp_id),
            FOREIGN KEY (reportee_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (reporter_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);

//// CREATE BOOKMARK TABLE
//    $sql ="CREATE TABLE IF NOT EXISTS bookmark_table(
//            b_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            b_type ENUM('turt','comment','reply') NOT NULL,
//            b_content_id INT(100) NOT NULL,
//            u_id INT(100) NOT NULL,
//
//            UNIQUE(b_id),
//            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
//

// CREATE SEARCH HISTORY TABLE
   $sql ="CREATE TABLE IF NOT EXISTS search_history_table(
            sh_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            sh_text MEDIUMTEXT,
            u_id INT(100) NOT NULL,
            
            UNIQUE(sh_id),
            FOREIGN KEY (u_id) REFERENCES user_table(u_id) ON UPDATE CASCADE ON DELETE CASCADE
            )ENGINE=InnoDB";
    @$conn->exec($sql);
        
//// CREATE FEEDBACK TABLE
//   $sql ="CREATE TABLE IF NOT EXISTS feedback_table(
//            fb_id INT(100) AUTO_INCREMENT PRIMARY KEY NOT NULL,
//            fb_content MEDIUMTEXT NOT NULL,
//            fb_sender_name VARCHAR(70) NOT NULL,
//            fb_sender_email VARCHAR(50) NOT NULL,
//            fb_status ENUM('new','solved') DEFAULT 'new',
//            fb_regdatetime DATETIME DEFAULT NOW(),
//            
//            UNIQUE(fb_id),
//            FULLTEXT KEY (fb_content,fb_sender_name,fb_sender_email)
//            )ENGINE=InnoDB";
//    @$conn->exec($sql);
?>