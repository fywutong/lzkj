-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-11-16 16:23:55
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `lzjh`
--

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_applyrecruit`
--

CREATE TABLE `lzjh_applyrecruit` (
  `id` int(11) NOT NULL,
  `recruitid` int(11) NOT NULL COMMENT '招募id',
  `supply` int(11) NOT NULL COMMENT '供应商id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='申请招募';

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_bidcreate`
--

CREATE TABLE `lzjh_bidcreate` (
  `id` int(11) NOT NULL,
  `btype` int(11) NOT NULL COMMENT '招标类型 1是材料招标 2是专业分包 3是设备租赁 4是劳务分包',
  `pid` int(11) NOT NULL COMMENT '项目id',
  `bname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '招标名称',
  `bmode` int(11) NOT NULL COMMENT '招标方式 1是公开招标 2是邀请招标 3是不招标',
  `sid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '供应商id',
  `iid` int(11) NOT NULL COMMENT '开票id',
  `rname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '采购员姓名',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '联系电话',
  `mtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '物资类型',
  `mlist` text COLLATE utf8_unicode_ci NOT NULL COMMENT '物资清单',
  `requirement` text COLLATE utf8_unicode_ci NOT NULL COMMENT '招标要求',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '截标时间',
  `calibrationtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '定标日期',
  `approachtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '预估进场日期',
  `songbiao` int(11) NOT NULL COMMENT '是否送标 1是送2是不送',
  `songhuo` int(11) NOT NULL COMMENT '是否送货 1是送货 2是不送',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otype` int(11) NOT NULL COMMENT '报价方式 1是固定 2是浮动',
  `floatprice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '浮动报价的填写',
  `payment` text COLLATE utf8_unicode_ci NOT NULL COMMENT '付款方式',
  `invoice` int(11) NOT NULL COMMENT '1是 增值税专用发票 2是增值税普通发票 3是不限',
  `bondtype` int(11) NOT NULL COMMENT '1是不需要 2是需要',
  `bondprice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '保证金价格',
  `enclosure` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '附件链接地址',
  `userid` int(11) NOT NULL COMMENT '用户id',
  `examine` int(11) NOT NULL DEFAULT '1' COMMENT '1是待审核 2是已审核 3是未通过'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='招标表';

--
-- 转存表中的数据 `lzjh_bidcreate`
--

INSERT INTO `lzjh_bidcreate` (`id`, `btype`, `pid`, `bname`, `bmode`, `sid`, `iid`, `rname`, `phone`, `mtype`, `mlist`, `requirement`, `endtime`, `calibrationtime`, `approachtime`, `songbiao`, `songhuo`, `address`, `otype`, `floatprice`, `payment`, `invoice`, `bondtype`, `bondprice`, `enclosure`, `userid`, `examine`) VALUES
(1, 1, 1, '1', 1, '1', 1, '1', '1', '1', '1', '1', '1', '1', '1', 1, 1, '1', 1, '1', '1', 1, 1, '1', '1', 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_code`
--

CREATE TABLE `lzjh_code` (
  `id` int(11) NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='验证码表';

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_inquiry`
--

CREATE TABLE `lzjh_inquiry` (
  `id` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '招募类型1建筑材料2专业分包3设备租赁4劳务分包 ',
  `iname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '询价名称',
  `pname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目名称',
  `cname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人',
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `materialtype` text COLLATE utf8_unicode_ci NOT NULL COMMENT '物资类型',
  `mode` int(11) NOT NULL COMMENT '1平台询价 2清单询价',
  `detailedlist` text COLLATE utf8_unicode_ci NOT NULL COMMENT '物资清单',
  `ptype` int(11) NOT NULL COMMENT '采购类型 1是单次采购 2是长期采购',
  `mdate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '进场时间',
  `edate` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '报价截止时间',
  `starttime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '价格有效期开始时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '价格有效期结束时间',
  `otype` int(11) NOT NULL COMMENT '报价方式 1固定报价 2浮动报价',
  `oprice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '浮动报价价格',
  `orequirement` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '报价要求 1, 报价含税 2报价需要包含运费',
  `payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '付款方式',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '送货地址',
  `itype` int(1) NOT NULL COMMENT '发票类型1是增值税专用发票2是增值税普通发票3是不限',
  `qualifications` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务资质',
  `remarks` text COLLATE utf8_unicode_ci COMMENT '补充说明',
  `enclosure` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '附件',
  `examine` int(11) NOT NULL DEFAULT '1' COMMENT '审核 1是待审核 2是已审核 3是不通过 ',
  `userid` int(11) NOT NULL COMMENT '用户ID '
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `lzjh_inquiry`
--

INSERT INTO `lzjh_inquiry` (`id`, `type`, `iname`, `pname`, `cname`, `tel`, `materialtype`, `mode`, `detailedlist`, `ptype`, `mdate`, `edate`, `starttime`, `endtime`, `otype`, `oprice`, `orequirement`, `payment`, `address`, `itype`, `qualifications`, `remarks`, `enclosure`, `examine`, `userid`) VALUES
(1, 1, '测试询价', '测试项目', '李先生', '13888888888', '测试物资类型', 1, '[{\"name\":\"\\u6d4b\\u8bd5\\u7269\\u8d44\\u540d\\u79f0\",\"model\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"parameter\":\"\\u53c2\\u6570\\u6307\\u6807\",\"brand\":\"\\u54c1\\u724c\",\"address\":\"\\u4ea7\\u5730\",\"unit\":\"\\u5355\\u4f4d\",\"num\":\"5\",\"remarks\":\"\\u5907\\u6ce8\"},{\"name\":\"\\u6d4b\\u8bd5\\u7269\\u8d44\\u540d\\u79f0\",\"model\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"parameter\":\"\\u53c2\\u6570\\u6307\\u6807\",\"brand\":\"\\u54c1\\u724c\",\"address\":\"\\u4ea7\\u5730\",\"unit\":\"\\u5355\\u4f4d\",\"num\":\"5\",\"remarks\":\"\\u5907\\u6ce8\"},{\"name\":\"\\u6d4b\\u8bd5\\u7269\\u8d44\\u540d\\u79f0\",\"model\":\"\\u6d4b\\u8bd5\\u578b\\u53f7\",\"parameter\":\"\\u53c2\\u6570\\u6307\\u6807\",\"brand\":\"\\u54c1\\u724c\",\"address\":\"\\u4ea7\\u5730\",\"unit\":\"\\u5355\\u4f4d\",\"num\":\"5\",\"remarks\":\"\\u5907\\u6ce8\"}]', 1, '2021-11-05', '2021-12-08', '2021-11-05', '2021-12-08', 1, NULL, '1', '微信', '辽宁省沈阳市大东区', 1, NULL, NULL, NULL, 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_instock`
--

CREATE TABLE `lzjh_instock` (
  `id` int(11) NOT NULL,
  `ordermun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单号 合同号',
  `type` int(11) NOT NULL COMMENT '1是合同 2是订单',
  `material` text COLLATE utf8_unicode_ci NOT NULL COMMENT '入库材料',
  `starttime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '入库开始日期',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '入库结束时间',
  `paymenttime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '预计支付日期',
  `personnel` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '操办人员',
  `remarks` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `enclosure` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '入库附件',
  `examine` int(11) NOT NULL COMMENT '1是入库待评价 2是已完成',
  `userid` int(11) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='入库';

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_project`
--

CREATE TABLE `lzjh_project` (
  `id` int(11) NOT NULL,
  `pname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目名称',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT '项目描述',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目地址',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目经理',
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系方式',
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理单位',
  `ptype` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目类型',
  `areacovered` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '占地面积',
  `barea` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '建筑面积',
  `cycle` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '项目周期',
  `images` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目图片',
  `choice` int(1) NOT NULL DEFAULT '1' COMMENT '营改增项目1是是 2是否',
  `state` int(1) NOT NULL DEFAULT '1' COMMENT '项目状态1进行中 2已结束 3未进行',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目价格',
  `examine` int(11) NOT NULL DEFAULT '1' COMMENT '审核 1是待审核 2是已审核 3是不通过',
  `userid` int(11) NOT NULL COMMENT '用户ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='项目表';

--
-- 转存表中的数据 `lzjh_project`
--

INSERT INTO `lzjh_project` (`id`, `pname`, `description`, `address`, `name`, `tel`, `company`, `ptype`, `areacovered`, `barea`, `cycle`, `images`, `choice`, `state`, `price`, `examine`, `userid`) VALUES
(1, '北京采购项目', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1, 1, '1', 1, 3),
(2, '沈阳采购项目', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1, 1, '1', 2, 3),
(3, '沈阳采购项目', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1, 1, '1', 2, 2),
(4, '测试项目名称', '项目描述', '辽宁省沈阳市', '王先生', '13888888888', '网盛生意宝', '测试项目类型', '50', '80', '5', '/public/index/aaa.jpg', 1, 1, '200', 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_recruit`
--

CREATE TABLE `lzjh_recruit` (
  `id` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '招募类型1建筑材料2专业分包3设备租赁4劳务分包',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '招募名称',
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '发布单位',
  `time` date DEFAULT '9999-12-31' COMMENT '截止时间，传空就是长期招募',
  `pid` int(11) NOT NULL COMMENT '项目ID',
  `category` json NOT NULL COMMENT '招募品类，为json字段',
  `itype` int(1) NOT NULL COMMENT '发票类型1是增值税专用发票2是增值税普通发票3是不限',
  `payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '付款方式',
  `mtype` json DEFAULT NULL COMMENT '经营模式',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '供应区域',
  `qualifications` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '服务资质',
  `remarks` text COLLATE utf8_unicode_ci COMMENT '补充说明',
  `enclosure` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '附件',
  `examine` int(1) NOT NULL DEFAULT '1' COMMENT '审核 1是待审核 2是已审核 3是不通过',
  `userid` int(11) NOT NULL COMMENT '用户ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `lzjh_recruit`
--

INSERT INTO `lzjh_recruit` (`id`, `type`, `name`, `company`, `time`, `pid`, `category`, `itype`, `payment`, `mtype`, `address`, `qualifications`, `remarks`, `enclosure`, `examine`, `userid`) VALUES
(1, 1, '测试招募名称', '测试招募单位', '9999-12-30', 4, '[{\"nun\": 1, \"name\": \"品类名称1\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称2\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称3\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}]', 1, '微信', '[2, 4, \"其他\"]', '辽宁省沈阳市', '服务资质', '补充说明', NULL, 1, 3),
(2, 1, '测试招募名称', '测试招募单位', '9999-12-31', 4, '[{\"nun\": 1, \"name\": \"品类名称1\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称2\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称3\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}]', 1, '微信', '[2, 4, \"其他\"]', '辽宁省沈阳市', '服务资质', '补充说明', NULL, 2, 3),
(3, 1, '招募名称', '招募单位', '2021-11-01', 4, '[{\"nun\": 1, \"name\": \"品类名称1\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称2\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称3\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}]', 1, '微信', '[2, 4, \"其他\"]', '辽宁省沈阳市', '服务资质', '补充说明', NULL, 2, 3),
(4, 1, '测试招募名称', '测试招募单位', '2022-11-20', 4, '[{\"nun\": 1, \"name\": \"品类名称1\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称2\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}, {\"nun\": 1, \"name\": \"品类名称3\", \"unit\": 5, \"money\": \"200\", \"remake\": \"需求描述\"}]', 1, '微信', '[2, 4, \"其他\"]', '辽宁省沈阳市', '服务资质', '补充说明', NULL, 2, 3);

-- --------------------------------------------------------

--
-- 表的结构 `lzjh_user`
--

CREATE TABLE `lzjh_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `cname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '企业名称',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人',
  `recommender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '推荐人',
  `mgroup` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '所属集团',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '地址',
  `post` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '职务',
  `type` int(11) NOT NULL COMMENT '类型 1供应商 2采购商'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';

--
-- 转存表中的数据 `lzjh_user`
--

INSERT INTO `lzjh_user` (`id`, `username`, `password`, `cname`, `name`, `recommender`, `mgroup`, `address`, `post`, `type`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', NULL, NULL, '', 1),
(3, '13840463285', 'e10adc3949ba59abbe56e057f20f883e', '浙江网盛生意宝', '李先生', '王先生', NULL, NULL, NULL, 2),
(4, '13844444444', 'e10adc3949ba59abbe56e057f20f883e', '浙江网盛生意宝', '吴先生', '王先生', NULL, NULL, NULL, 1);

--
-- 转储表的索引
--

--
-- 表的索引 `lzjh_applyrecruit`
--
ALTER TABLE `lzjh_applyrecruit`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `lzjh_bidcreate`
--
ALTER TABLE `lzjh_bidcreate`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `lzjh_inquiry`
--
ALTER TABLE `lzjh_inquiry`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `lzjh_instock`
--
ALTER TABLE `lzjh_instock`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `lzjh_project`
--
ALTER TABLE `lzjh_project`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `lzjh_recruit`
--
ALTER TABLE `lzjh_recruit`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `lzjh_user`
--
ALTER TABLE `lzjh_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `lzjh_applyrecruit`
--
ALTER TABLE `lzjh_applyrecruit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `lzjh_bidcreate`
--
ALTER TABLE `lzjh_bidcreate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `lzjh_inquiry`
--
ALTER TABLE `lzjh_inquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `lzjh_instock`
--
ALTER TABLE `lzjh_instock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `lzjh_project`
--
ALTER TABLE `lzjh_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `lzjh_recruit`
--
ALTER TABLE `lzjh_recruit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `lzjh_user`
--
ALTER TABLE `lzjh_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
