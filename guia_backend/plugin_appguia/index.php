<?php

/**
 * @Plugin Name: Guiafloripa APP REDIRECT 
 * @Description: <p>PLUGIN REDIRECT DO APP GUIA - <b>www.experienciasdigitais.com.br</b>. <br>Utilize o Shorcode [guia_app]</p>
 * @author Luis Augusto Machado Moretto <projetos@morettic.com.br>
 * */
/* Start Adding Functions Below this Line */
const DEFAULT_VIEW_URL = "htps://app.guiafloripa.com.br";
const DEFAULT_REST_URL = "https://guiafloripa.morettic.com.br/busca/";
const CACHE_FILE = "guia_cache.json";

/**
 * @Redirect URL using Javascript Script
 */
function guia_app_redirect() {
    $_key = $_GET['key'];
    $permaLink = get_permalink($_key);
    if (empty($permaLink)) {
        $permaLink = DEFAULT_VIEW_URL;
    }
    echo "<h1>Redirecionando</h1>";
    echo "<h4>Caso a página não redirecione clique no link abaixo</h4>";
    echo "<small><a href='$permaLink' target='_blank'>#$permaLink#</a></small>";
    //sleep(0.1);
    echo "<script>this.location.href='" . $permaLink . "';</script>";

    exit;
}

//Register Shortcode on Wordpress
add_shortcode('guia_app', 'guia_app_redirect');

/**
 * @Show Slider with today events
 *  */
function guia_today_events() {
    $txt = json_decode(get_content());
    //var_dump($txt->e);
    //var_dump($txt);
    //die;$vet = $txt['e'];
    ?>
    <div id="carousel">
        <div class="btn-bar">
            <div id="buttons"><a id="prev" href="#"><</a><a id="next" href="#">></a> </div></div>
        <div id="slides">
            <ul>
                <?php
                $vet = $txt->e;
                //var_dump($vet);
                //die;
                foreach ($vet as $a1) {
                    // var_dump($a1);
                    //  die;
                    ?>
                    <li class="slide">
                        <div class="quoteContainer">
                            <p class="quote-phrase"><span class="quote-marks"></span>
                                <?php
                                $deEvent = $a1->deEvent;

                                if (empty($a1->deEvent)) {
                                    $tot = count($a1->movies);
                                    $deEvent = "$tot Filmes em Cartaz<br>";
                                    foreach ($a1->movies as $movie) {
                                        $deEvent .= "<small><small><small><small>" . $movie->deEvent . "</small></small></small></small>";
                                    }
                                }

                                echo $deEvent;
                                echo "<br>";
                                echo $a1->printDate;
                                ?>
                                <span class="quote-marks"></span>

                            </p>
                        </div>
                        <div class="authorContainer">
                            <p class="quote-author"><a href="<?php echo $a1->deWebsite; ?>" target="blank"><?php echo strtoupper($a1->nmPlace); ?></a></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script>
            $(document).ready(function () {
                //rotation speed and timer
                var speed = 5000;

                var run = setInterval(rotate, speed);
                var slides = $('.slide');
                var container = $('#slides ul');
                var elm = container.find(':first-child').prop("tagName");
                var item_width = container.width();
                var previous = 'prev'; //id of previous button
                var next = 'next'; //id of next button
                slides.width(item_width); //set the slides to the correct pixel width
                container.parent().width(item_width);
                container.width(slides.length * item_width); //set the slides container to the correct total width
                container.find(elm + ':first').before(container.find(elm + ':last'));
                resetSlides();


                //if user clicked on prev button

                $('#buttons a').click(function (e) {
                    //slide the item

                    if (container.is(':animated')) {
                        return false;
                    }
                    if (e.target.id == previous) {
                        container.stop().animate({
                            'left': 0
                        }, 1500, function () {
                            container.find(elm + ':first').before(container.find(elm + ':last'));
                            resetSlides();
                        });
                    }

                    if (e.target.id == next) {
                        container.stop().animate({
                            'left': item_width * -2
                        }, 1500, function () {
                            container.find(elm + ':last').after(container.find(elm + ':first'));
                            resetSlides();
                        });
                    }

                    //cancel the link behavior            
                    return false;

                });

                //if mouse hover, pause the auto rotation, otherwise rotate it    
                container.parent().mouseenter(function () {
                    clearInterval(run);
                }).mouseleave(function () {
                    run = setInterval(rotate, speed);
                });


                function resetSlides() {
                    //and adjust the container so current is in the frame
                    container.css({
                        'left': -1 * item_width
                    });
                }

            });
            //a simple function to click next link
            //a timer will call this function, and the rotation will begin

            function rotate() {
                $('#next').click();
            }
        </script>
        <style>
            #carousel {
                background: transparent;
                position: relative;
                width:90%;
                margin:0 auto;
            }

            #slides {
                overflow: hidden;
                position: relative;
                width: 100%;
                height: 250px;
            }

            #slides ul {
                list-style: none;
                width:100%;
                height:250;
                margin: 0;
                padding: 0;
                position: relative;
            }

            #slides li {
                width:100%;
                height:250;
                float:left;
                text-align: center;
                position: relative;
                font-family:lato, sans-serif;
            }
            /* Styling for prev and next buttons */
            .btn-bar{
                max-width: 346px;
                margin: 0 auto;
                display: block;
                position: relative;
                top: 40px;
                width: 100%;
            }

            #buttons {
                padding:0 0 5px 0;
                float:right;
            }

            #buttons a {
                text-align:center;
                display:block;
                font-size:50px;
                float:left;
                outline:0;
                margin:0 60px;
                color:#000;
                text-decoration:none;
                display:block;
                padding:9px;
                width:35px;
            }

            a#prev:hover, a#next:hover {
                color:#28a4c9;
                text-shadow:.5px 0px #b14943;  
            }

            .quote-phrase, .quote-author {
                font-family:sans-serif;
                font-weight:300;
                display: table-cell;
                vertical-align: middle;
                padding: 5px 20px;
                font-family:'Lato', Calibri, Arial, sans-serif;
            }

            .quote-phrase {
                height: 200px;
                font-size:24px;
                color:#000;
                font-style:italic;
                text-shadow:.5px 0px #b14943;  
            }

            .quote-marks {
                font-size:30px;
                padding:0 3px 3px;
                position:inherit;
            }

            .quote-author {
                font-style:normal;
                font-size:20px;
                color:#000;
                font-weight:400;
                height: 30px;
            }

            .quoteContainer, .authorContainer {
                display: table;
                width: 100%;
            }
        </style>

        <?php
    }

    add_shortcode('guia_today', 'guia_today_events');

    /* Stop Adding Functions Below this Line */

    function get_content() {
        //vars
        $current_time = time();
        $expire_time = 24 * 60 * 60;
        $file_time = filemtime(CACHE_FILE);
        //echo $file_time;
        //decisions, decisions
        if (file_exists(CACHE_FILE) && ($current_time - $expire_time < $file_time)) {
            return file_get_contents(CACHE_FILE);
        } else {
            $content = get_url(DEFAULT_REST_URL);

            //echo mb_detect_encoding($content);

            file_put_contents(CACHE_FILE, ($content));
            return ($content);
        }
    }

    /* gets content from a URL via curl */

    function get_url($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $content = curl_exec($ch);
        curl_close($ch);
        $result = iconv("Windows-1251", "UTF-8", $content);
        return $result;
    }
    ?>