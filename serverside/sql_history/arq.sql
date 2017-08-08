SELECT 
    `dtstart`,`dtend`,
        `a1`.`id` AS `id_cn_filme_post`,
        `a2`.`id` AS `id_cn_filme`,
        `a3`.`ID` AS `id_wp_post`,
        `a3`.`post_title` AS `post_title`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `address`,
        `a3`.`post_content` AS `post_content`,
        `a3`.`ID` AS `ID_POST_`,
        `a1`.`outras_informacoes` AS `outras_informacoes`,
        `a1`.`salas_horarios` AS `salas_horarios`,
        `a2`.`titulo` AS `titulo`,
        `a2`.`titulo_original` AS `titulo_original`,
        `a2`.`ano_producao` AS `ano_producao`,
        `a2`.`duracao` AS `duracao`,
        `a2`.`pais_origem` AS `pais_origem`,
        `a2`.`diretor` AS `diretor`,
        `a2`.`elenco` AS `elenco`,
        `a2`.`sinopse` AS `sinopse`,
        `a2`.`imagem_full` AS `imagem_full`
    FROM
        ((`wp_cn_filme_post` `a1`
        LEFT JOIN `wp_cn_filme` `a2` ON ((`a1`.`id_wp_cn_filme` = `a2`.`id`)))
        LEFT JOIN `wp_posts` `a3` ON ((`a3`.`ID` = `a1`.`id_wp_posts`)))
        
        limit 20




        select *,
         (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `address`,
        
        
         from wp_posts   where state<>NULL and city<>NULL and address <> NULL limit 10;




         SELECT 
    `dtstart`,`dtend`,
        `a1`.`id` AS `id_cn_filme_post`,
        `a2`.`id` AS `id_cn_filme`,
        `a3`.`ID` AS `id_wp_post`,
        `a3`.`post_title` AS `post_title`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_region'))) AS `state`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_locality'))) AS `city`,
        (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_address'))) AS `address`,
        `a3`.`post_content` AS `post_content`,
        `a3`.`ID` AS `ID_POST_`,
        `a1`.`outras_informacoes` AS `outras_informacoes`,
        `a1`.`salas_horarios` AS `salas_horarios`,
        `a2`.`titulo` AS `titulo`,
        `a2`.`titulo_original` AS `titulo_original`,
        `a2`.`ano_producao` AS `ano_producao`,
        `a2`.`duracao` AS `duracao`,
        `a2`.`pais_origem` AS `pais_origem`,
        `a2`.`diretor` AS `diretor`,
        `a2`.`elenco` AS `elenco`,
        `a2`.`sinopse` AS `sinopse`,
        `a2`.`imagem_full` AS `imagem_full`
    FROM
        ((`wp_cn_filme_post` `a1`
        LEFT JOIN `wp_cn_filme` `a2` ON ((`a1`.`id_wp_cn_filme` = `a2`.`id`)))
        LEFT JOIN `wp_posts` `a3` ON ((`a3`.`ID` = `a1`.`id_wp_posts`)))
        
        limit 20