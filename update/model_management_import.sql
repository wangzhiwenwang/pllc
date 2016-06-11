/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  wangzhiwen
 * Created: 2016-5-5
 */

--
-- 表的结构 `cmf_model`
--

CREATE TABLE IF NOT EXISTS `cmf_model` (
`id` tinyint(3) unsigned NOT NULL,
  `siteid` smallint(5) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `tablename` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `listorder` smallint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `cmf_model`
--

INSERT INTO `cmf_model` (`id`, `siteid`, `name`, `tablename`, `description`, `listorder`, `status`) VALUES
(27, 1, '资讯', 'news', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cmf_model_field`
--

CREATE TABLE IF NOT EXISTS `cmf_model_field` (
`fieldid` mediumint(8) unsigned NOT NULL,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `field` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `tips` text,
  `css` varchar(30) NOT NULL DEFAULT '',
  `minlength` int(10) unsigned NOT NULL DEFAULT '0',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0',
  `pattern` varchar(255) NOT NULL DEFAULT '',
  `errortips` varchar(255) NOT NULL DEFAULT '',
  `formtype` varchar(20) NOT NULL DEFAULT '',
  `setting` mediumtext,
  `formattribute` varchar(255) NOT NULL DEFAULT '',
  `unsetgroupids` varchar(255) NOT NULL DEFAULT '',
  `unsetroleids` varchar(255) NOT NULL DEFAULT '',
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isunique` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isbase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issearch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islist` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isfulltext` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isposition` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `listorder` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isomnipotent` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=219 ;

--
-- 转存表中的数据 `cmf_model_field`
--

INSERT INTO `cmf_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `islist`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES
(203, 27, 1, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', '', '', '', '', 0, 1, 0, 1, 1, 1, 1, 1, 1, 4, 0, 0),
(204, 27, 1, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''datetime'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''0'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 0, 12, 0, 0),
(205, 27, 1, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''fieldtype'' => ''datetime'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''0'',\n)', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 1, 17, 0, 0),
(206, 27, 1, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 0, 51, 0, 0),
(207, 27, 1, 'text', '单行文本', '', '', 0, 0, '', '', 'text', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(208, 27, 1, 'textarea', '多行文本', '', '', 0, 0, '', '', 'textarea', 'array (\n  ''width'' => ''98'',\n  ''height'' => ''46'',\n  ''defaultvalue'' => '''',\n  ''enablehtml'' => ''0'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(209, 27, 1, 'editor', '编辑器', '', '', 0, 0, '', '', 'editor', 'array (\n  ''toolbar'' => ''basic'',\n  ''defaultvalue'' => '''',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => ''1'',\n  ''link_mode'' => ''0'',\n  ''enablesaveimage'' => ''0'',\n  ''height'' => ''200'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(210, 27, 1, 'select', '选线', '', '', 0, 0, '', '', 'box', 'array (\n  ''options'' => ''选项名称1|选项值1\r\n选项名称2|选项值2\r\n选项名称3|选项值3\r\n选项名称4|选项值4'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''varchar'',\n  ''minnumber'' => ''1'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => '''',\n  ''outputtype'' => ''0'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(211, 27, 1, 'image', '图片', '', '', 0, 0, '', '', 'image', 'array (\n  ''size'' => '''',\n  ''defaultvalue'' => '''',\n  ''show_type'' => ''0'',\n  ''upload_allowext'' => ''gif|jpg|jpeg|png|bmp'',\n  ''watermark'' => ''0'',\n  ''isselectimage'' => ''1'',\n  ''images_width'' => '''',\n  ''images_height'' => '''',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(212, 27, 1, 'mutile_image', '多图上传', '', '', 0, 0, '', '', 'images', 'array (\n  ''upload_allowext'' => ''gif|jpg|jpeg|png|bmp'',\n  ''isselectimage'' => ''0'',\n  ''upload_number'' => ''10'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(213, 27, 1, 'date', '日期', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''fieldtype'' => ''date'',\n  ''format'' => ''Y-m-d Ah:i:s'',\n  ''defaulttype'' => ''0'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(214, 27, 1, 'linkage', '联动菜单', '', '', 0, 0, '', '', 'linkage', 'array (\n  ''linkageid'' => ''3360'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 0, 5, 0, 0),
(215, 28, 2, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', '', '', '', '', 0, 1, 0, 1, 1, 1, 1, 1, 1, 4, 0, 0),
(216, 28, 2, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''datetime'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''0'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 0, 12, 0, 0),
(217, 28, 2, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''fieldtype'' => ''datetime'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''0'',\n)', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 1, 17, 0, 0),
(218, 28, 2, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 0, 51, 0, 0);


--
-- Indexes for table `cmf_model`
--
ALTER TABLE `cmf_model`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cmf_model_field`
--
ALTER TABLE `cmf_model_field`
 ADD PRIMARY KEY (`fieldid`), ADD KEY `modelid` (`modelid`,`disabled`), ADD KEY `field` (`field`,`modelid`);

--
-- AUTO_INCREMENT for table `cmf_model`
--
ALTER TABLE `cmf_model`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `cmf_model_field`
--
ALTER TABLE `cmf_model_field`
MODIFY `fieldid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=219;
