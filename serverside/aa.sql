   select ID as event_id, a.post_title as event_tit, post_content as event_info,
     (SELECT  
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_address'))) as event_endereco,
	 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_tel'))) as event_phone,
	 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    -- AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS `address`
					   and (meta_key = 'vcard_locality'))) as event_city,
	 (SELECT 
                `wp_postmeta`.`meta_value` AS `state`
            FROM
                `wp_postmeta`
            WHERE
                ((`wp_postmeta`.`post_id` = `a`.`ID`)
                    AND (`wp_postmeta`.`meta_key` = 'vevent_location'))) AS event_id_place
					   -- and (meta_key = 'vcard_email'))) as email
  from wp_posts as a where a.post_type = 'evento' 
  -- from wp_posts as a where ID = 14747;