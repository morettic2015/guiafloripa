<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="notice notice-info"> 
        <p><code>Planos</code> disponíveis.</p>
    </div>
    <!--<ul class="products">
    <?php
    /* $args = array(
      'post_type' => 'product',
      'posts_per_page' => 12
      );
      $loop = new WP_Query($args);
      var_dump($loop);
      if ($loop->have_posts()) {
      while ($loop->have_posts()) : $loop->the_post();
      endwhile;
      } else {
      echo __('No products found');
      }
      wp_reset_postdata(); */
    ?>
    </ul>-->
    <div class="container">
        <div class="pricing-table">
            <div class="pricing-table-header">
                <h1>Byte</h1>
            </div>

            <div class="pricing-table-content">
                <ul>
                    <li><span class="dashicons dashicons-nametag"></span>&nbsp;<strong>5 </strong>Eventos mensais cadastrados ou importados do Facebook</li>
                    <li><span class="dashicons dashicons-image-filter"></span>&nbsp;<strong>1 </strong>Negócio cadastrado ou importado do Facebook sem destaque</li>
                    <li><span class="dashicons dashicons-twitter"></span>&nbsp;<strong>600 </strong>Ações mensais automáticas no Twitter</li>
                    <li><span class="dashicons dashicons-groups"></span>&nbsp;<strong>100 </strong>Contatos cadastrados ou importados do Facebook ou Google</li>
                    <li><span class="dashicons dashicons-email"></span>&nbsp;<strong>100 </strong>Emails mensais enviados</li>
                    <li><span class="dashicons dashicons-images-alt2"></span>&nbsp;<strong>5MB </strong>Arquivos nas nuvens (total)</li>
                </ul>
            </div>

            <div class="pricing-table-footer">
                <h2><sup>$</sup>Free</h2>
                <p>por mes</p>
             
            </div>
        </div>


        <div class="pricing-table">
            <div class="pricing-table-header">
                <h1>Mega</h1>
            </div>

            <div class="pricing-table-content">
                <ul>
                    <li><span class="dashicons dashicons-nametag"></span>&nbsp;<strong>15 </strong>Eventos mensais destacados, cadastrados ou importados do Facebook</li>
                    <li><span class="dashicons dashicons-image-filter"></span>&nbsp;<strong>5 </strong>Negócios cadastrados ou importados do Facebook (1 destaque)</li>
                    <li><span class="dashicons dashicons-twitter"></span>&nbsp;<strong>3000 </strong>Ações mensais automáticas no Twitter</li>
                    <li><span class="dashicons dashicons-groups"></span>&nbsp;<strong>1000 </strong>Contatos cadastrados ou importados do Facebook ou Google</li>
                    <li><span class="dashicons dashicons-email"></span>&nbsp;<strong>1000 </strong>Emails mensais enviados</li>
                    <li><span class="dashicons dashicons-images-alt2"></span>&nbsp;<strong>10MB </strong>Arquivos nas nuvens (total)</li>
                    <li><span class="dashicons dashicons-megaphone"></span></span>&nbsp;<strong>150 </strong>Notificações web mensais</li>
                </ul>
            </div>

            <div class="pricing-table-footer">
                <h2><sup>R$</sup>49.99</h2>
                <p>Por Mês</p>
                <a href="#">Contratar</a>
            </div>
        </div>
        <div class="pricing-table">
            <div class="pricing-table-header">
                <h1>Giga</h1>
            </div>

            <div class="pricing-table-content">
                <ul>
                     <li><span class="dashicons dashicons-nametag"></span>&nbsp;Eventos <strong>ilimitados</strong> destacados, cadastrados ou importados do Facebook</li>
                    <li><span class="dashicons dashicons-image-filter"></span>&nbsp;<strong>20 </strong>Negócios cadastrados ou importados do Facebook (5 destaque)</li>
                    <li><span class="dashicons dashicons-twitter"></span>&nbsp;<strong>9000 </strong>Ações mensais automáticas no Twitter</li>
                    <li><span class="dashicons dashicons-groups"></span>&nbsp;<strong>2000 </strong>Contatos cadastrados ou importados do Facebook ou Google</li>
                    <li><span class="dashicons dashicons-email"></span>&nbsp;<strong>5000 </strong>Emails mensais enviados</li>
                    <li><span class="dashicons dashicons-images-alt2"></span>&nbsp;<strong>50MB </strong>Arquivos nas nuvens (total)</li>
                    <li><span class="dashicons dashicons-megaphone"></span></span>&nbsp;<strong>300 </strong>Notificações web mensais</li>
          
                </ul>
            </div>

            <div class="pricing-table-footer">
                <h2><sup>R$</sup>99.99</h2>
               <p>Por Mês</p>
                <a href="#">Contratar</a>
            </div>
        </div>
     <!--   <div class="pricing-table">
            <div class="pricing-table-header">
                <h1>Tera</h1>
            </div>

            <div class="pricing-table-content">
                <ul>
                    <li><strong>75GB</strong> Disk Space</li>
                    <li><strong>50</strong> Email Addresses</li>
                    <li><strong>20</strong> Subdomains</li>
                    <li><strong>50</strong> MySQL Databases</li>
                </ul>
            </div>

            <div class="pricing-table-footer">
                <h2><sup>$</sup>29.99</h2>
                <p>per month</p>
                <a href="#">Sign Up</a>
            </div>
        </div>
    </div>-->
</div>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #32363c;	
        color: #5f6062;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1em;
    }

    .container {
        margin: 0 auto;
        width: 100%;
    }

    .pricing-table {
        top: 0px;
        -webkit-box-shadow: 0px 0px 3px #26292e;
        box-shadow: 0px 0px 3px #26292e;
        display: inline-block;
        margin: 8px 8px;
        width: 31%;
        vertical-align: top;
        min-width: 230px;
    }

    .featured {
        -webkit-transform: scale(1.1, 1.1);
        -moz-transform: scale(1.1, 1.1);
        -ms-transform: scale(1.1, 1.1);
        -o-transform: scale(1.1, 1.1);
        transform: scale(1.1, 1.1);
    }

    .pricing-table-header {
        background: #65707f; /* Old browsers */
        background: -moz-linear-gradient(top,  #65707f 0%, #4a5564 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#65707f), color-stop(100%,#4a5564)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #65707f 0%,#4a5564 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #65707f 0%,#4a5564 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #65707f 0%,#4a5564 100%); /* IE10+ */
        background: linear-gradient(to bottom,  #65707f 0%,#4a5564 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#65707f', endColorstr='#4a5564',GradientType=0 ); /* IE6-9 */
        background-color: #586272;
        -webkit-border-radius: 5px 5px 0px 0px;
        -moz-border-radius: 5px 5px 0px 0px;
        padding: 16px;
        text-align: center;	
    }

    .pricing-table-header h1 {
        color: #fff;
        font-size: 14px;
        text-transform: uppercase;
    }

    .pricing-table-content {
        background-color: #fff;
    }

    .pricing-table-content ul {
        list-style: none;	
    }

    .pricing-table-content ul li {
        border-bottom: 1px solid #efeff0;
        font-size: 14px;
        padding: 10px 20px;
    }

    .pricing-table-footer {
        background-color: #f5f7f8;
        -webkit-border-radius: 0px 0px 5px 5px;
        -moz-border-radius: 0px 0px 5px 5px;
        border-radius: 0px 0px 5px 5px;
        padding: 16px 0;
    }


    .pricing-table-footer {
        text-align: center;	
    }

    .pricing-table-footer p {
        font-size: 12px;
        text-transform: uppercase;	
    }

    .pricing-table-footer a {
        background: #50b7e4; /* Old browsers */
        background: -moz-linear-gradient(top,  #50b7e4 0%, #3098c4 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#50b7e4), color-stop(100%,#3098c4)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #50b7e4 0%,#3098c4 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #50b7e4 0%,#3098c4 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #50b7e4 0%,#3098c4 100%); /* IE10+ */
        background: linear-gradient(to bottom,  #50b7e4 0%,#3098c4 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#50b7e4', endColorstr='#3098c4',GradientType=0 ); /* IE6-9 */
        background-color: #3ea6d2;
        border: 1px solid #1481b0;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        font-weight: bold;
        margin-top: 10px;
        padding: 10px;
        text-decoration: none;
    }
</style>