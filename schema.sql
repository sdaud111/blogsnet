-- Create database
CREATE DATABASE blol;
USE blol;

-- Create users table
CREATE TABLE users (
    uid INT AUTO_INCREMENT,
    uname VARCHAR(50) NOT NULL,
    uemail VARCHAR(100) NOT NULL UNIQUE,
    uphone VARCHAR(100),
    upassword VARCHAR(255) NOT NULL,
--     uinstagram_id VARCHAR(255) DEFAULT NULL,
--     utwitter_id VARCHAR(255) DEFAULT NULL,
--     ufacebook_id VARCHAR(255) DEFAULT NULL,
    uverification_token VARCHAR(200) NOT NULL,
    uverification_status INT DEFAULT 0,
    ucreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT blol_users_uid_pk PRIMARY KEY(uid)
) AUTO_INCREMENT = 400000;


-- Create blog table
CREATE TABLE blog (
	bid INT AUTO_INCREMENT,
    uid INT NOT NULL,
    btitle TEXT NOT NULL,
    bcontent MEDIUMTEXT NOT NULL,
    bcreated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT blol_blog_bid_pk PRIMARY KEY(bid),
    CONSTRAINT blol_blog_uid_fk FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT = 10001; 

-- Create faq table
CREATE TABLE FAQ (
	fid INT AUTO_INCREMENT,
    uid INT NOT NULL,
    fquestion TEXT NOT NULL,
    fanswer TEXT NOT NULL,
    fcat VARCHAR(255),
    CONSTRAINT blol_faq_fid_pk PRIMARY KEY(fid),
    CONSTRAINT blol_faq_uid_fk FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT = 1;

CREATE TABLE gender (
	uid INT NOT NULL,
    gender VARCHAR(10),
    CONSTRAINT blol_gender_uid_pk PRIMARY KEY(uid),
    CONSTRAINT blol_gender_uid_fk FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE blog_comment (
	cid INT AUTO_INCREMENT,
    uid INT NOT NULL,
    bid INT NOT NULL,
    comment_text TEXT,
    CONSTRAINT blol_blog_comment_cid_pk PRIMARY KEY(cid),
    CONSTRAINT blol_blog_comment_uid_fk FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT blol_blog_comment_bid_fk FOREIGN KEY(bid) REFERENCES blog(bid) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT = 1;
CREATE TABLE blog_like (
	lid INT AUTO_INCREMENT,
    uid INT NOT NULL,
    bid INT NOT NULL,
    CONSTRAINT blol_blog_like_lid_pk PRIMARY KEY(lid),
    CONSTRAINT blol_blog_like_uid_fk FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT blol_blog_like_bid_fk FOREIGN KEY(bid) REFERENCES blog(bid) ON DELETE CASCADE
) AUTO_INCREMENT = 1;

CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT,
    uid INT NOT NULL,
    activity_type VARCHAR(50) NOT NULL, -- e.g., BLOG_POST, COMMENT, LIKE
    reference_id INT DEFAULT NULL, -- ID of the blog, comment, etc., related to the activity
    activity_description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT activity_log_pk PRIMARY KEY (log_id),
    CONSTRAINT activity_log_uid_fk FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE 
);

CREATE TABLE admin_log (
    alid INT AUTO_INCREMENT,
    admin_id INT NOT NULL,               -- Admin ID
    action_type VARCHAR(50) NOT NULL,   -- action by the admin.
    action_description TEXT,            -- description of the action
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- action time
    CONSTRAINT blol_admin_log_alid_pk PRIMARY KEY(alid),
    CONSTRAINT blol_admin_log_admin_id_fk FOREIGN KEY(admin_id) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE CASCADE
) AUTO_INCREMENT = 1;
select * from activity_log;
