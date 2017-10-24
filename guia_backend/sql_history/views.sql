/*CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_cultura_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        ((`wp_terms`.`name` LIKE '%Exposições%')
                            OR (`wp_terms`.`name` LIKE '%Teatro%')))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;

   /* CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_destaque_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        ((`wp_terms`.`name` LIKE '%Workshops e Oficinas%')
                            OR (`wp_terms`.`name` LIKE '%Atendimento%')))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;*/

   /* CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_esportes_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        (`wp_terms`.`name` LIKE '%Esportes%'))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`*/
   /* ORDER BY `wp_term_relationships`.`object_id`;

    CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_eventos_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        ((`wp_terms`.`name` LIKE '%Cursos%') OR
                         (`wp_terms`.`name` LIKE '%Cursos Permanentes%') OR
                         (`wp_terms`.`name` LIKE '%Permantes%')))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;

    CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_gratuitos_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        ((`wp_terms`.`name` LIKE '%Gratuito%')))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;

    CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_infantil_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        (`wp_terms`.`name` LIKE '%Infantil%'))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;


    CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `view_lazer_ids` AS
    SELECT
        `wp_term_relationships`.`object_id` AS `object_id`
    FROM
        `wp_term_relationships`
    WHERE
        `wp_term_relationships`.`term_taxonomy_id` IN (SELECT
                `wp_term_taxonomy`.`term_taxonomy_id`
            FROM
                `wp_term_taxonomy`
            WHERE
                (`wp_term_taxonomy`.`term_id` IN (SELECT
                        `wp_terms`.`term_id`
                    FROM
                        `wp_terms`
                    WHERE
                        ((`wp_terms`.`name` LIKE '%Festas e Baladas%')
                            OR (`wp_terms`.`name` LIKE '%Casas Noturnas e Boates%')
                            OR (`wp_terms`.`name` LIKE '%Happy Our%')
                            OR (`wp_terms`.`name` LIKE '%Shows%')
                            OR (`wp_terms`.`name` LIKE '%Bares e Pubs%')))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;*/

/*CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_comer_beber` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_posts`.`guid` from `wp_posts` where ((`wp_posts`.`post_parent` = `a`.`ID`) and (`wp_posts`.`post_type` = 'attachment') and (`wp_posts`.`guid` is not null) and (`wp_posts`.`guid` like 'http%')) limit 1) AS `logo` from `wp_posts` `a` where (`a`.`ID` in (select `wp_term_relationships`.`object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_id` from `wp_term_taxonomy` where `wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Bares e Pubs%') or (`wp_terms`.`name` like '%Refeições Delivery%') or (`wp_terms`.`name` like '%Bebidas%') or (`wp_terms`.`name` like '%Restaurantes%') or (`wp_terms`.`name` like '%Food Trucks%') or (`wp_terms`.`name` like '%Pizzarias%') or (`wp_terms`.`name` like '%Lanchonetes%') or (`wp_terms`.`name` like '%Buffet de Sorvetes%') or (`wp_terms`.`name` like '%Vinhos%') or (`wp_terms`.`name` like '%Padaria%') or (`wp_terms`.`name` like '%Chef em Casa%'))))) and (`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish'));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cultura_ids` AS select `wp_term_relationships`.`object_id` AS `object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_taxonomy_id` from `wp_term_taxonomy` where (`wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Cursos%') or (`wp_terms`.`name` like '%Exposição%') or (`wp_terms`.`name` like '%Teatro%') or (`wp_terms`.`name` like '%Inscrições%') or (`wp_terms`.`name` like '%Livraria%'))) and (`wp_term_taxonomy`.`taxonomy` = 'segmento'))) group by `wp_term_relationships`.`object_id` order by `wp_term_relationships`.`object_id`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_eventos_ids` AS select `wp_term_relationships`.`object_id` AS `object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_taxonomy_id` from `wp_term_taxonomy` where (`wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like 'Cursos%') or (`wp_terms`.`name` like 'Eventos%') or (`wp_terms`.`name` like 'Atendimentos%') or (`wp_terms`.`name` like 'Evento%') or (`wp_terms`.`name` like 'Wordkshop%') or (`wp_terms`.`name` like 'Palestras%') or (`wp_terms`.`name` like 'Inscrições%') or (`wp_terms`.`name` like 'Outras%'))) and (`wp_term_taxonomy`.`taxonomy` = 'segmento'))) group by `wp_term_relationships`.`object_id` order by `wp_term_relationships`.`object_id`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_events` AS select `a`.`ID` AS `event_id`,`a`.`post_title` AS `event_tit`,`a`.`post_content` AS `event_info`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vevent_dtend'))) AS `event_dtend`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vevent_dtstart'))) AS `event_dtstart`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `event_id_place` from `wp_posts` `a` where ((`a`.`post_type` = 'evento') and (`a`.`post_status` = 'publish')) order by `a`.`ID`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_gratuitos_ids` AS select `wp_term_relationships`.`object_id` AS `object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_taxonomy_id` from `wp_term_taxonomy` where (`wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where (`wp_terms`.`name` like '%Gratuito%')) and (`wp_term_taxonomy`.`taxonomy` = 'segmento'))) group by `wp_term_relationships`.`object_id` order by `wp_term_relationships`.`object_id`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_hospedagem` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_posts`.`guid` from `wp_posts` where ((`wp_posts`.`post_parent` = `a`.`ID`) and (`wp_posts`.`post_type` = 'attachment') and (`wp_posts`.`guid` is not null) and (`wp_posts`.`guid` like 'http%')) limit 1) AS `logo` from `wp_posts` `a` where (`a`.`ID` in (select `wp_term_relationships`.`object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_id` from `wp_term_taxonomy` where `wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Traslados e Passeios%') or (`wp_terms`.`name` like '%Pousada%') or (`wp_terms`.`name` like '%Aluguel Temporada%') or (`wp_terms`.`name` like '%Hotéis%'))))) and (`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish'));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_infantil_ids` AS select `wp_term_relationships`.`object_id` AS `object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_taxonomy_id` from `wp_term_taxonomy` where (`wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where (`wp_terms`.`name` like '%Infantil%')) and (`wp_term_taxonomy`.`taxonomy` = 'segmento'))) group by `wp_term_relationships`.`object_id` order by `wp_term_relationships`.`object_id`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_lazer_ids` AS select `wp_term_relationships`.`object_id` AS `object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_taxonomy_id` from `wp_term_taxonomy` where (`wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like 'Bares%') or (`wp_terms`.`name` like 'Restaurante%') or (`wp_terms`.`name` like 'Festas e Baladas%') or (`wp_terms`.`name` like 'Shows%') or (`wp_terms`.`name` like 'Casas Noturnas%') or (`wp_terms`.`name` like 'Shows%') or (`wp_terms`.`name` like 'happy%'))) and (`wp_term_taxonomy`.`taxonomy` = 'segmento'))) group by `wp_term_relationships`.`object_id` order by `wp_term_relationships`.`object_id`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_places` AS select `a`.`ID` AS `ID`,`a`.`post_title` AS `tit`,`a`.`post_content` AS `info`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email` from `wp_posts` `a`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_places_data` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,`a`.`guid` AS `guid`,`a`.`post_status` AS `post_status`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `tel`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `addres` from `wp_posts` `a` where ((`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish'));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_places_info` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,`a`.`guid` AS `guid`,`a`.`post_status` AS `post_status`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `tel`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_postmeta`.`meta_value` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `addres` from `wp_posts` `a` where ((`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish'));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_servico_turistico` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_posts`.`guid` from `wp_posts` where ((`wp_posts`.`post_parent` = `a`.`ID`) and (`wp_posts`.`post_type` = 'attachment') and (`wp_posts`.`guid` is not null) and (`wp_posts`.`guid` like 'http%')) limit 1) AS `logo` from `wp_posts` `a` where (`a`.`ID` in (select `wp_term_relationships`.`object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_id` from `wp_term_taxonomy` where `wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Aluguel de Carros%') or (`wp_terms`.`name` like '%Rent a Car%') or (`wp_terms`.`name` like '%Vans%') or (`wp_terms`.`name` like '%Traslados%') or (`wp_terms`.`name` like '%Turismo%') or (`wp_terms`.`name` like '%Passagens%') or (`wp_terms`.`name` like '%Escuna%') or (`wp_terms`.`name` like '%Cambio%') or (`wp_terms`.`name` like '%Ecoturismo%'))))) and (`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish'));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_tax_post_id` AS select `a`.`object_id` AS `object_id`,`c`.`name` AS `de_tax` from ((`wp_term_relationships` `a` left join `wp_term_taxonomy` `b` on((`a`.`term_taxonomy_id` = `b`.`term_taxonomy_id`))) left join `wp_terms` `c` on((`c`.`term_id` = `b`.`term_id`)));
*/

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_comer_beber` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_posts`.`guid` from `wp_posts` where ((`wp_posts`.`post_parent` = `a`.`ID`) and (`wp_posts`.`post_type` = 'attachment') and (`wp_posts`.`guid` is not null) and (`wp_posts`.`guid` like 'http%')) limit 1) AS `logo` from `wp_posts` `a` where (`a`.`ID` in (select `wp_term_relationships`.`object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_id` from `wp_term_taxonomy` where `wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Bares e Pubs%') or (`wp_terms`.`name` like '%Refeições Delivery%') or (`wp_terms`.`name` like '%Bebidas%') or (`wp_terms`.`name` like '%Restaurantes%') or (`wp_terms`.`name` like '%Food Trucks%') or (`wp_terms`.`name` like '%Pizzarias%') or (`wp_terms`.`name` like '%Lanchonetes%') or (`wp_terms`.`name` like '%Buffet de Sorvetes%') or (`wp_terms`.`name` like '%Vinhos%') or (`wp_terms`.`name` like '%Padaria%') or (`wp_terms`.`name` like '%Chef em Casa%'))))) and (`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish') and ((select `meta`.`meta_value` from `wp_postmeta` `meta` where ((`meta`.`post_id` = `a`.`ID`) and (`meta`.`meta_key` = 'tipo_anuncio'))) < 1));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_hospedagem` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_posts`.`guid` from `wp_posts` where ((`wp_posts`.`post_parent` = `a`.`ID`) and (`wp_posts`.`post_type` = 'attachment') and (`wp_posts`.`guid` is not null) and (`wp_posts`.`guid` like 'http%')) limit 1) AS `logo` from `wp_posts` `a` where (`a`.`ID` in (select `wp_term_relationships`.`object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_id` from `wp_term_taxonomy` where `wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Traslados e Passeios%') or (`wp_terms`.`name` like '%Pousada%') or (`wp_terms`.`name` like '%Aluguel Temporada%') or (`wp_terms`.`name` like '%Hotéis%'))))) and (`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish') and ((select `meta`.`meta_value` from `wp_postmeta` `meta` where ((`meta`.`post_id` = `a`.`ID`) and (`meta`.`meta_key` = 'tipo_anuncio'))) < 1));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_servico_turistico` AS select `a`.`ID` AS `ID`,`a`.`post_content` AS `post_content`,`a`.`post_title` AS `post_title`,`a`.`post_excerpt` AS `post_excerpt`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `endereco`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `telefone`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `cidade`,(select `wp_postmeta`.`meta_value` AS `state` from `wp_postmeta` where ((`wp_postmeta`.`post_id` = `a`.`ID`) and (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,(select `wp_posts`.`guid` from `wp_posts` where ((`wp_posts`.`post_parent` = `a`.`ID`) and (`wp_posts`.`post_type` = 'attachment') and (`wp_posts`.`guid` is not null) and (`wp_posts`.`guid` like 'http%')) limit 1) AS `logo` from `wp_posts` `a` where (`a`.`ID` in (select `wp_term_relationships`.`object_id` from `wp_term_relationships` where `wp_term_relationships`.`term_taxonomy_id` in (select `wp_term_taxonomy`.`term_id` from `wp_term_taxonomy` where `wp_term_taxonomy`.`term_id` in (select `wp_terms`.`term_id` from `wp_terms` where ((`wp_terms`.`name` like '%Aluguel de Carros%') or (`wp_terms`.`name` like '%Rent a Car%') or (`wp_terms`.`name` like '%Vans%') or (`wp_terms`.`name` like '%Traslados%') or (`wp_terms`.`name` like '%Turismo%') or (`wp_terms`.`name` like '%Passagens%') or (`wp_terms`.`name` like '%Escuna%') or (`wp_terms`.`name` like '%Cambio%') or (`wp_terms`.`name` like '%Ecoturismo%'))))) and (`a`.`post_type` = 'anuncio') and (`a`.`post_status` = 'publish') and ((select `meta`.`meta_value` from `wp_postmeta` `meta` where ((`meta`.`post_id` = `a`.`ID`) and (`meta`.`meta_key` = 'tipo_anuncio'))) < 1));


SELECT 
  posts.ID,
  posts.post_title AS title,
  files.meta_value AS filepath
FROM
  wp_posts posts
  INNER JOIN wp_posts attachments ON posts.ID = attachments.post_parent
  INNER JOIN wp_postmeta files ON attachments.ID = files.post_id
WHERE posts.post_type = '_wp_attached_file'




select ID,post_title, post_parent, meta_value from wp_posts left join wp_postmeta on ID = post_id where post_type = 'attachment' and meta_key = '_wp_attachment_metadata';

a:6:{s:5:"width";s:3:"100";s:6:"height";s:3:"100";s:14:"hwstring_small";s:22:"height='96' width='96'";s:4:"file";s:29:"2013/09/pousadacorrea_100.jpg";s:5:"sizes";a:2:{s:11:"thumb-75-75";a:3:{s:4:"file";s:27:"pousadacorrea_100-75x75.jpg";s:5:"width";s:2:"75";s:6:"height";s:2:"75";}s:12:"thumb-75-75p";a:3:{s:4:"file";s:27:"pousadacorrea_100-75x75.jpg";s:5:"width";s:2:"75";s:6:"height";s:2:"75";}}s:10:"image_meta";a:10:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";}}