/*SELECT object_id 
FROM `guilafloripa.com.br`.wp_term_relationships 
where term_taxonomy_id IN 
 
	(select term_taxonomy_id from wp_term_taxonomy where term_id IN 

    (select term_id from wp_terms 
    where name like '%Festas e Baladas%' or 
    name like '%Happy Our%' or  name like '%Shows%' or 
    name like '%Bares e Pubs%') and taxonomy = 'segmento')
    
    group by object_id order by object_id asc*/
    
   -- group by object_id
    
        
    
    
   select ID, a.post_title as tit, post_content as info,
     (SELECT  
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_address'))) as endereco,
	 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_tel'))) as telefone,
	 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_locality'))) as cidade,
	 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_email'))) as email
  -- from wp_posts as a where a.post_type = 'evento' limit 50
  from wp_posts as a where ID = 14747;
    
    
    /*select * from wp_posts where post_type = 'anuncio';*/
    
 --  select distinct meta_key from wp_postmeta;
   
  --  select meta_value,meta_key from wp_postmeta where meta_key in('url');
    
    /**
    
    
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
                    AND (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `phone`,
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
                    AND (`wp_postmeta`.`meta_key` = 'vcard_postalcode'))) AS `cep`,
		(SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,
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
        
        where a3.ID is not null and dtstart <> ''
        
        order by post_title ASC;
    
    */
    
    
select 
	ID,post_date,post_content,post_title,post_name ,
     (SELECT `wp_postmeta`.`meta_value` AS `state`
	  FROM   `wp_postmeta` WHERE
	 ((`wp_postmeta`.`post_id` = `ID`) AND (`wp_postmeta`.`meta_key` = 'vevent_dtstart'))) AS `dtstart`,
      (SELECT `wp_postmeta`.`meta_value` AS `state`
	  FROM   `wp_postmeta` WHERE
	 ((`wp_postmeta`.`post_id` = `ID`) AND (`wp_postmeta`.`meta_key` = 'vevent_dtend'))) AS `dtend`
from 
	wp_posts 
where 
	id in(
			SELECT object_id FROM `guilafloripa.com.br`.wp_term_relationships 
			where term_taxonomy_id IN 
				(select term_taxonomy_id from wp_term_taxonomy where term_id IN 
				(select term_id from wp_terms 
					where name like '%Festas e Baladas%' or 
					name like '%Happy Our%' or  name like '%Shows%' or 
					name like '%Bares e Pubs%') and taxonomy = 'segmento')
				
					group by object_id order by object_id asc)
                    
                    
                    
                    
                    
                    
                    /**
                    
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
                    AND (`wp_postmeta`.`meta_key` = 'vcard_tel'))) AS `phone`,
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
                    AND (`wp_postmeta`.`meta_key` = 'vcard_postalcode'))) AS `cep`,
		(SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a3`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vcard_email'))) AS `email`,
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
        
        where a3.ID is not null and dtstart <> ''
        
        order by post_title ASC;
                    
                    
                    
                    
                    */