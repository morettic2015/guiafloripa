
# Project Name

Guia Floripa APP Wordpress Redirect Plugin

https://app.guiafloripa.com.br

## About

Shortcode For Wordpress

Download: https://play.google.com/store/apps/details?id=br.com.morettic.guiafloripa.CityWatch

## How it Woks

Get Post ID and redirects to Permalink.

## Author

https://morettic.com.br

https://experienciasdigitais.com.br

## Version

Beta 1 2017

+-------+---------------------+------------+------------+
| id    | dt_formated         | dtStart    | dtEnd      |
+-------+---------------------+------------+------------+
| 61363 | 15/03/2018 08:03:48 | 1514786520 | 1514804520 |
| 61365 | 15/03/2018 05:03:26 | 1523140200 | 1523160000 |
| 61369 | 15/03/2018 09:03:56 | 1514768400 | 1514768400 |
| 61371 | 15/03/2018 09:03:01 | 1521284400 | 1521309600 |
+-------+---------------------+------------+------------+

SELECT DATE_FORMAT(a.post_modified, '%d/%m/%Y %H:%m:%s') as dt_formated, DATE_FORMAT((select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtstart') - (2*3600), '%d/%m/%Y %H:%m:%s') as dtStart, (select meta_value from wp_postmeta where post_id = a.id and meta_key = 'vevent_dtend') - (2*3600) as dtEnd FROM wp_posts as a where id in (58953,61201,61205,61209,61213,61217,61227,61231,61235,61239,61245,61249,61253,61257,61259,61261,61263,61271,61275,61279,61283,61287,61291,61293,61297,61299,61303,61305,61309,61313,61317,61321,61327,61337,61341,61345,61349,61353,61357,61363,61365,61369,61371,-1)