<?php

include dirname(__FILE__) . "/config.php";

mysql_query("DROP TABLE ruang_jurusan");

mysql_query("CREATE TABLE IF NOT EXISTS `ruang_jurusan` (
  `id_r_jur` int(3) NOT NULL AUTO_INCREMENT,
  `id_jurusan` varchar(5) NOT NULL,
  `id_ruangan` int(3) NOT NULL,
  PRIMARY KEY (`id_r_jur`)
)");

mysql_query("INSERT INTO `ruang_jurusan` (`id_r_jur`, `id_jurusan`, `id_ruangan`) VALUES
(7, '05503', 8),
(8, '05503', 9),
(9, '05503', 5),
(52, '05502', 7),
(53, '05502', 2),
(54, '05502', 11),
(55, '05502', 12),
(56, '05502', 3),
(57, '05502', 13),
(58, '05502', 5)");

?>

