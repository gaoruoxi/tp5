CREATE TABLE canteen.admin
(
    username varchar(100) COMMENT '账户',
    password varchar(32),
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是 默认0'
);
INSERT INTO canteen.admin (username, password, is_del) VALUES ('123', '520d55c9402441d196c5d789e79b44b0', 0);
INSERT INTO canteen.admin (username, password, is_del) VALUES ('123', '520d55c9402441d196c5d789e79b44b0', 0);
CREATE TABLE canteen.emp
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(100) COMMENT '姓名',
    gender tinyint(1) DEFAULT '1' NOT NULL COMMENT '性别 1-男 2-女 9-其他',
    phone varchar(20) NOT NULL COMMENT '手机号',
    password varchar(32) NOT NULL COMMENT '密码',
    type int(11) DEFAULT '0' NOT NULL COMMENT '工种',
    weixin_avater int(11) COMMENT '微信头像',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是',
    weixin_nickname varchar(100) COMMENT '微信昵称',
    open_id varchar(520) COMMENT 'openid'
);
CREATE UNIQUE INDEX emp_id_uindex ON canteen.emp (id);
CREATE INDEX index_name ON canteen.emp (name);
CREATE INDEX emp_pass ON canteen.emp (password);
CREATE INDEX emp_index ON canteen.emp (is_del);
INSERT INTO canteen.emp (id, name, gender, phone, password, type, weixin_avater, is_del, weixin_nickname, open_id) VALUES (1, '张三', 1, '13032219955', '43a2fa071beeb09cc5144d5d229279de', 0, null, 0, null, null);
INSERT INTO canteen.emp (id, name, gender, phone, password, type, weixin_avater, is_del, weixin_nickname, open_id) VALUES (2, '李四', 2, '4752215556', '43a2fa071beeb09cc5144d5d229279de', 0, null, 0, null, null);
CREATE TABLE canteen.emp_crs
(
    id int(11) DEFAULT '0' NOT NULL,
    name varchar(100) COMMENT '姓名',
    gender tinyint(1) DEFAULT '1' NOT NULL COMMENT '性别 1-男 2-女 9-其他',
    phone varchar(20) NOT NULL COMMENT '手机号',
    password varchar(32) NOT NULL COMMENT '密码',
    type int(11) DEFAULT '0' NOT NULL COMMENT '工种',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是'
);
CREATE TABLE canteen.food
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(100) NOT NULL COMMENT '菜名',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是 默认0',
    is_save tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否入库 0-否 1-是'
);
CREATE UNIQUE INDEX food_id_uindex ON canteen.food (id);
CREATE INDEX index_name ON canteen.food (name);
CREATE INDEX is_del ON canteen.food (is_del);
CREATE INDEX is_save ON canteen.food (is_save);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (1, '菜品1', 0, 1);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (2, '少时诵诗书', 0, 0);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (5, '三生三世', 0, 0);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (6, '三生', 0, 0);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (8, '三生啊啊啊', 0, 1);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (19, '小米粥', 0, 0);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (20, '南瓜粥', 0, 0);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (21, '棒子粥', 0, 0);
INSERT INTO canteen.food (id, name, is_del, is_save) VALUES (22, '小咸菜', 0, 0);
CREATE TABLE canteen.food_menu
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    add_time date NOT NULL COMMENT '新增时间',
    end_time datetime NOT NULL COMMENT '投票截止时间',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是 默认0'
);
CREATE UNIQUE INDEX food_menu_id_uindex ON canteen.food_menu (id);
CREATE INDEX food_menu_index ON canteen.food_menu (is_del);
INSERT INTO canteen.food_menu (id, add_time, end_time, is_del) VALUES (1, '2019-03-19', '2019-03-19 23:49:09', 0);
INSERT INTO canteen.food_menu (id, add_time, end_time, is_del) VALUES (6, '2019-03-20', '2019-03-20 23:59:59', 0);
CREATE TABLE canteen.food_menu_list
(
    id bigint(19) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    menu_id int(11) NOT NULL COMMENT '菜单id',
    food_id int(11) NOT NULL COMMENT '菜品id',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-是 1-否 默认0'
);
CREATE UNIQUE INDEX food_menu_list_id_uindex ON canteen.food_menu_list (id);
CREATE INDEX food_menu_list_index ON canteen.food_menu_list (menu_id, food_id);
CREATE INDEX food_menu_index ON canteen.food_menu_list (is_del);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (1, 1, 1, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (2, 1, 2, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (5, 1, 5, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (6, 1, 6, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (8, 1, 8, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (24, 6, 19, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (25, 6, 20, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (26, 6, 21, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (27, 6, 22, 0);
INSERT INTO canteen.food_menu_list (id, menu_id, food_id, is_del) VALUES (28, 6, 1, 0);
CREATE TABLE canteen.notice
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    content varchar(1024) NOT NULL COMMENT '内容',
    is_roof tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否置顶 0-否 1-是',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是'
);
CREATE UNIQUE INDEX notice_id_uindex ON canteen.notice (id);
INSERT INTO canteen.notice (id, content, is_roof, is_del) VALUES (1, '6666', 0, 0);
INSERT INTO canteen.notice (id, content, is_roof, is_del) VALUES (2, '77778888', 1, 0);
CREATE TABLE canteen.site
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(100) NOT NULL COMMENT '站点名称',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是 默认0'
);
CREATE UNIQUE INDEX site_id_uindex ON canteen.site (id);
CREATE INDEX food_menu_index ON canteen.site (is_del);
INSERT INTO canteen.site (id, name, is_del) VALUES (1, '西港路', 0);
INSERT INTO canteen.site (id, name, is_del) VALUES (2, '河北大街', 0);
INSERT INTO canteen.site (id, name, is_del) VALUES (3, '海阳路', 0);
INSERT INTO canteen.site (id, name, is_del) VALUES (4, '北部', 0);
CREATE TABLE canteen.site_line
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    add_time date NOT NULL COMMENT '日期',
    end_time datetime NOT NULL COMMENT '截止修改时间',
    apply_time date NOT NULL COMMENT '适用时间(开车时间)',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是'
);
CREATE UNIQUE INDEX site_line_column_1_uindex ON canteen.site_line (id);
CREATE INDEX site_line_apply_time ON canteen.site_line (apply_time);
CREATE INDEX food_menu_index ON canteen.site_line (is_del);
INSERT INTO canteen.site_line (id, add_time, end_time, apply_time, is_del) VALUES (1, '2019-03-19', '2019-03-22 11:25:34', '2019-03-23', 0);
INSERT INTO canteen.site_line (id, add_time, end_time, apply_time, is_del) VALUES (2, '2019-03-19', '2019-03-22 11:29:25', '2019-03-24', 0);
CREATE TABLE canteen.site_line_list
(
    id bigint(19) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    site_id int(11) DEFAULT '0' NOT NULL COMMENT '站点id',
    site_line_id int(11) DEFAULT '0' NOT NULL COMMENT '线路id
',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是'
);
CREATE UNIQUE INDEX site_line_list_id_uindex ON canteen.site_line_list (id);
CREATE INDEX site_line_list_index ON canteen.site_line_list (site_id, site_line_id);
CREATE INDEX site_line_list_is_del ON canteen.site_line_list (is_del);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (26, 1, 1, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (27, 2, 1, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (28, 3, 1, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (29, 4, 1, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (34, 1, 3, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (35, 2, 3, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (36, 1, 2, 0);
INSERT INTO canteen.site_line_list (id, site_id, site_line_id, is_del) VALUES (37, 2, 2, 0);
CREATE TABLE canteen.site_vote
(
    id bigint(19) DEFAULT '0' NOT NULL,
    emp_id int(11) DEFAULT '0' NOT NULL COMMENT '员工id',
    site_line_id int(11) DEFAULT '0' NOT NULL COMMENT '路线id',
    site_id int(11) DEFAULT '0' NOT NULL COMMENT '站点id',
    add_time datetime NOT NULL COMMENT '投票时间',
    num int(11) DEFAULT '1' NOT NULL COMMENT '数量',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是'
);
CREATE INDEX site_vote_index ON canteen.site_vote (emp_id, site_line_id, site_id);
CREATE INDEX site_vote_is_del ON canteen.site_vote (is_del);
INSERT INTO canteen.site_vote (id, emp_id, site_line_id, site_id, add_time, num, is_del) VALUES (1, 1, 1, 1, '2019-03-19 08:51:13', 1, 0);
INSERT INTO canteen.site_vote (id, emp_id, site_line_id, site_id, add_time, num, is_del) VALUES (2, 2, 1, 2, '2019-03-19 08:51:25', 2, 0);
INSERT INTO canteen.site_vote (id, emp_id, site_line_id, site_id, add_time, num, is_del) VALUES (3, 3, 1, 2, '2019-03-19 08:51:27', 3, 0);
INSERT INTO canteen.site_vote (id, emp_id, site_line_id, site_id, add_time, num, is_del) VALUES (6, 3, 2, 1, '2019-03-19 08:51:47', 2, 0);
CREATE TABLE canteen.vote
(
    id bigint(19) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    emp_id int(11) DEFAULT '0' NOT NULL COMMENT '员工id',
    menu_id int(11) DEFAULT '0' NOT NULL COMMENT '菜单id',
    food_id int(11) DEFAULT '0' NOT NULL COMMENT '菜品id',
    add_time datetime NOT NULL COMMENT '投票时间',
    is_del tinyint(1) DEFAULT '0' NOT NULL COMMENT '是否删除 0-否 1-是'
);
CREATE UNIQUE INDEX vote_id_uindex ON canteen.vote (id);
CREATE INDEX vote_index ON canteen.vote (emp_id, menu_id, food_id);
CREATE INDEX vote_is_del ON canteen.vote (is_del);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (1, 1, 1, 1, '2019-03-19 08:51:13', 0);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (2, 2, 1, 2, '2019-03-19 08:51:25', 0);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (3, 3, 1, 5, '2019-03-19 08:51:27', 0);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (4, 2, 1, 8, '2019-03-19 08:51:44', 0);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (5, 2, 1, 1, '2019-03-19 08:51:45', 0);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (6, 3, 1, 2, '2019-03-19 08:51:47', 0);
INSERT INTO canteen.vote (id, emp_id, menu_id, food_id, add_time, is_del) VALUES (7, 1, 6, 19, '2019-03-20 08:26:10', 0);