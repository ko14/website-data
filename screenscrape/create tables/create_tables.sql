CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annday` date DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `eps` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_annday` (`annday`),
  KEY `idx_announcements_symbol` (`symbol`)
) ENGINE=InnoDB AUTO_INCREMENT=16214 DEFAULT CHARSET=latin1;



CREATE TABLE `priceday_sorted` (
  `sort_number` int(11) DEFAULT NULL,
  `priceday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `streak_id` int(11) DEFAULT NULL,
  `priceday` date DEFAULT NULL,
  `open` decimal(10,2) DEFAULT NULL,
  `close` decimal(10,2) DEFAULT NULL,
  `day_return` decimal(10,2) DEFAULT NULL,
  `volume` decimal(20,0) DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `nodata` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_streak_id` (`streak_id`),
  KEY `idx_priceday` (`priceday`),
  KEY `idx_symbol` (`symbol`)
) ENGINE=InnoDB AUTO_INCREMENT=1683554 DEFAULT CHARSET=latin1;



CREATE TABLE `stocks` (
  `symbol` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `lastsale` decimal(20,2) DEFAULT NULL,
  `market_cap` decimal(65,2) DEFAULT NULL,
  `adr_tso` varchar(5) DEFAULT NULL,
  `ipo_year` int(11) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `industry` varchar(200) DEFAULT NULL,
  `summary` varchar(200) DEFAULT NULL,
  `exchange` varchar(20) DEFAULT NULL,
  `add_date` date DEFAULT NULL,
  `delist_date` date DEFAULT NULL,
  PRIMARY KEY (`symbol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `streak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) NOT NULL,
  `active` int(11) DEFAULT '1',
  `type` varchar(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `avg_daily_return` decimal(10,2) DEFAULT NULL,
  `avg_daily_sp500_return` decimal(10,2) DEFAULT NULL,
  `return_diff` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_startdate` (`start_date`),
  KEY `idx_enddate` (`end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

