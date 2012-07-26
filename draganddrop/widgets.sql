CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL auto_increment,
  `column_id` int(11) NOT NULL,
  `sort_no` int(11) NOT NULL,
  `collapsed` tinyint(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `column_id`, `sort_no`, `collapsed`, `title`) VALUES
(1, 2, 0, 1, 'Widget 1'),
(2, 1, 0, 0, 'Widget 2'),
(3, 2, 1, 0, 'Widget 3'),
(4, 2, 2, 0, 'Widget 4'),
(5, 1, 1, 1, 'Widget 5');