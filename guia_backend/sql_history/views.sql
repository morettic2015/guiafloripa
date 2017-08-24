CREATE
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
                        ((`wp_terms`.`name` LIKE '%Cursos%')
                            OR (`wp_terms`.`name` LIKE '%Exposição%')
                            OR (`wp_terms`.`name` LIKE '%Inscrições%')))
                    AND (`wp_term_taxonomy`.`taxonomy` = 'segmento')))
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;

    CREATE
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
    ORDER BY `wp_term_relationships`.`object_id`;

    CREATE
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
    GROUP BY `wp_term_relationships`.`object_id`
    ORDER BY `wp_term_relationships`.`object_id`;

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
                        ((`wp_terms`.`name` LIKE '%Palestra%')
                            OR (`wp_terms`.`name` LIKE '%Exposições%')
                            OR (`wp_terms`.`name` LIKE '%Workshop%')
                            OR (`wp_terms`.`name` LIKE '%Inscrições%')
                            OR (`wp_terms`.`name` LIKE '%Evento%')))
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
                        ((`wp_terms`.`name` LIKE '%Gratuito%')
                            OR (`wp_terms`.`name` LIKE '%Outras%')))
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
    ORDER BY `wp_term_relationships`.`object_id`;

    