<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- css critico -->
    <style>
        :root {
            --header-bg: #0D0D0B;
            --text: #fff;
            --submenu: #0D0D0B;
            --border: rgba(255, 255, 255, .08);
            --transition: .3s ease
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            background: var(--header-bg)
        }

        /* Mobile first: 20px de respiro de cada lado no celular; a partir de 800px valem os 95% de sempre */
        .container {
            width: min(95%, calc(100% - 40px));
            max-width: 1320px;
            margin: 0 auto;
        }

        .container-menu {
            max-width: 1820px;
            width: min(95%, calc(100% - 40px));
            margin: 0 auto;
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 999;
            background: var(--header-bg);
            transition: background var(--transition);
            display: flow-root;
        }

        .header>.container-menu {
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            margin-top: 10px;
        }


        .logo svg {
            display: block;
            height: 43px;
            width: 140px
        }

        .nav {
            margin-inline: auto
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 40px;
            list-style: none
        }

        .menu li {
            position: relative
        }

        .menu a,
        .menu button {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text);
            background: none;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            font-size: 16px;
            line-height: 160%;
            letter-spacing: 0%;
            text-align: center;
            color: #A09F9B;
            transition: var(--transition)
        }



        .menu svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            transition: var(--transition)
        }

        .has-submenu:hover>button svg {
            transform: rotate(180deg)
        }

        .submenu {
            position: absolute;
            top: calc(100% + 18px);
            left: 0;
            min-width: 220px;
            background: var(--submenu);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 0;
            display: none;
            list-style: none
        }

        .has-submenu:hover>.submenu {
            display: block
        }

        .submenu li {
            width: 100%
        }

        .submenu a {
            display: block;
            padding: 12px 18px;
            white-space: nowrap
        }

        .submenu a:hover {
            background: rgba(255, 255, 255, .05)
        }

        .btn-header {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 48px;
            padding: 0 32px;
            border: 1px solid #FFFFFF66;
            border-radius: 999px;
            text-decoration: none;
            transition: var(--transition);
            font-family: 'Manrope', sans-serif;
            font-weight: 600;
            font-size: 16px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #EDECE6;
            text-align: center;
        }

        .btn-header:hover {
            background: #fff;
            color: #111
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: 0;
            color: #fff;
            font-size: 30px;
            cursor: pointer
        }


        .dropdown {
            display: flex;
            visibility: hidden;
            opacity: 0;
            transform: translateY(-8px);
            position: fixed;
            top: 70px;
            left: 0px;
            width: 100%;
            height: 508px;
            background-color: #fff;
            transition: opacity 0.2s, transform 0.2s, visibility 0.2s;
            border-top: 1px solid #e0e0e0;
        }

        .dropdown__inner {
            display: flex;
            width: 1280px;
            flex-direction: row;
            max-width: 1280px;
            gap: 32px;
            margin: 0 auto;
            padding: 32px;
        }

        .dropdown__coluna {
            display: flex;
            flex-direction: column;
            align-self: flex-start;
            gap: 24px;
            flex: 1 1 0%;
            list-style: none;
            padding: 0px;
            margin: 0px;
        }

        .dropdown__coluna-titulo {
            font-family: 'Open Sans';
            font-size: 13px;
            font-weight: 600;
            line-height: 160%;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #A09F9B;
            margin-bottom: 8px;
        }

        .dropdown__coluna li {
            display: flex;

            padding: 8px 0px;
            transition: color 0.2s;

            font-family: 'Inter';
            font-weight: 600;
            font-style: Semi Bold;
            font-size: 18px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #292928 !important;

        }

        .dropdown__coluna li a {
            color: inherit;
            text-decoration: none;
        }

        .dropdown__coluna-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .header:has(.has-submenu:hover .dropdown) {
            background: #fff !important;
        }


        @media (min-width:992px) {

            header:hover .container-menu {
                box-shadow: none;
                background-color: #fff;
                border-radius: 9999px;
                padding: 0 10px 0 20px;
            }



            header:hover .container-menu a,
            header:hover .container-menu li,
            header:hover .container-menu button {
                color: #666663;
            }



            header:hover .btn-header {
                background: #141414;
                color: #EDECE6 !important;
            }

            header:hover .logo svg path {
                fill: #292928;
            }



            .has-submenu:hover .dropdown {
                visibility: visible;
                opacity: 1;
                transform: translateY(0px);
                margin-top: -5px;
            }

        }

        @media (max-width:992px) {
            .header>.container {
                height: 72px
            }

            .mobile-toggle {
                display: block;
                z-index: 1001
            }

            .btn-header {
                display: none
            }

            .logo {
                position: relative;
                z-index: 1002;
            }

            .nav {
                position: fixed;
                inset: 0;
                background: #111;
                padding: 100px 32px 40px;
                transform: translateX(100%);
                transition: .35s ease;
                overflow: auto;
                margin: 0;
            }

            .nav.active {
                transform: translateX(0)
            }

            .menu {
                flex-direction: column;
                align-items: flex-start;
                gap: 0;
                width: 100%;
            }

            .menu li {
                width: 100%;
                border-bottom: 1px solid rgba(255, 255, 255, .08)
            }

            .menu a,
            .menu button {
                width: 100%;
                padding: 18px 0;
                justify-content: space-between;
                font-size: 18px
            }

            .submenu {
                position: static;
                display: none;
                background: none;
                border: none;
                padding: 0 0 12px 20px;
                border-radius: 0
            }

            .has-submenu.open>.submenu {
                display: block
            }

            .has-submenu.open>button svg {
                transform: rotate(180deg)
            }

            .submenu a {
                padding: 12px 0;
                color: rgba(255, 255, 255, .75)
            }

            .dropdown {
                position: static;
                display: none;
                background: none;
                border: none;
                width: auto;
                height: auto;
                visibility: visible;
                opacity: 1;
                transform: none;
                padding: 0 0 12px 20px;
            }

            .has-submenu.open>.dropdown {
                display: block;
            }

            .dropdown__inner {
                display: flex;
                flex-direction: column;
                width: auto;
                max-width: none;
                padding: 0;
                gap: 20px;
                margin: 0;
            }

            .dropdown__coluna {
                gap: 12px;
            }

            .dropdown__coluna-titulo {
                font-size: 14px;
                margin-bottom: 4px;
            }

            .dropdown__coluna li {
                color: rgba(255, 255, 255, .75) !important;
                font-size: 16px;
                padding: 6px 0;
            }
        }




        /*hero*/

        .hero {
            padding-top: 84px;
        }

        .badge-hero {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 33px;
        }

        .txt-badge {
            display: flex;
            align-items: start;
            flex-direction: column;


            font-family: 'Manrope';
            font-weight: 400;
            font-size: 14px;
            line-height: 130%;
            letter-spacing: 0%;
            color: #fff;
        }

        .txt-badge strong {
            font-weight: 700;
            font-size: 18px;
        }

        .hero-txt {
            max-width: 1000px;
            margin: 0 auto;
        }

        .hero-txt h1 {
            font-family: 'Manrope';
            font-weight: 500;
            font-size: clamp(40px, 5vw, 54px);
            line-height: 120%;
            letter-spacing: 0%;
            text-align: center;
            color: #EDECE6;
            margin-bottom: 24px;

        }

        .hero-txt p {
            font-family: 'Manrope';
            font-weight: 500;
            font-size: 18px;
            line-height: 150%;
            letter-spacing: 0%;
            text-align: center;
            color: #A09F9B;
            max-width: 900px;
            margin: 0 auto;

        }

        .btn-hero {
            margin-top: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            gap: 8px;

            font-family: 'Manrope';
            font-weight: 600;
            font-size: 20px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #292928;
            text-decoration: none;
            background: #FFEC33;
            height: 52px;
            padding: 0 32px;
            border-radius: 160px;
            max-width: max-content;
        }

        /* No celular o botão cabe numa linha; se o texto for longo, cresce em altura em vez de espremer */
        @media (max-width: 480px) {
            .btn-primary {
                font-size: 18px;
                line-height: 120%;
                height: auto;
                min-height: 52px;
                padding: 8px 24px;
            }
        }

        .hero-image img {
            max-width: 100%;
        }

        .hero-image {
            margin-top: -55px;
        }

        .badge-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            font-size: 13px;
            line-height: 160%;
            color: #EDECE6;
            padding: 2px 12px;
            border: 1px solid #FFFFFF33;
            max-width: max-content;
            margin: 0 auto;
            border-radius: 160px;
        }
    </style>
    <?php if (is_page_template('page-home.php') || is_page('home')) :
        $mosaic_image_id = get_post_meta(get_the_ID(), 'agencia_hero_mosaic_image_id', true);
        $mosaic_image_url = '';
        if ($mosaic_image_id) {
            $mosaic_image_src = wp_get_attachment_image_src($mosaic_image_id, 'full');
            if ($mosaic_image_src) {
                $mosaic_image_url = $mosaic_image_src[0];
            }
        }
        if (!$mosaic_image_url) {
            $mosaic_image_url = get_post_meta(get_the_ID(), 'agencia_hero_mosaic_image', true);
        }
        if ($mosaic_image_url) :
            $imagesrcset = $mosaic_image_id ? wp_get_attachment_image_srcset($mosaic_image_id, 'full') : '';
            $imagesizes = $mosaic_image_id ? wp_get_attachment_image_sizes($mosaic_image_id, 'full') : '';
            $preload_attrs = 'as="image" fetchpriority="high"';
            if ($imagesrcset && $imagesizes) {
                $preload_attrs .= ' imagesrcset="' . esc_attr($imagesrcset) . '" imagesizes="' . esc_attr($imagesizes) . '"';
            }
    ?>
            <link rel="preload" href="<?php echo esc_url($mosaic_image_url); ?>" <?php echo $preload_attrs; ?>>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (is_page_template('page-agencia.php') || is_page('agencia')) :
        $mosaico_imagens = get_post_meta(get_the_ID(), 'agencia_pag_mosaico_grupo', true);
        if (!empty($mosaico_imagens) && is_array($mosaico_imagens)) :
            $max_preload = wp_is_mobile() ? 1 : 2; // Precarrega apenas 1 imagem no mobile (evita congestionar conexão lenta) e 2 no desktop
            $counter = 1;
            foreach ($mosaico_imagens as $item) :
                if ($counter > $max_preload) break;
                $img_url = isset($item['imagem']) ? $item['imagem'] : '';
                $img_id  = isset($item['imagem_id']) ? $item['imagem_id'] : 0;
                if (is_numeric($img_url)) {
                    $img_id  = $img_url;
                    $img_url = wp_get_attachment_image_url($img_url, 'full');
                }
                // O preload precisa do mesmo srcset da <img>, senão o navegador baixa a imagem duas vezes
                $img_srcset = $img_id ? wp_get_attachment_image_srcset($img_id, 'full') : '';
                if ($img_url) :
    ?>
                    <link rel="preload" href="<?php echo esc_url($img_url); ?>" as="image" fetchpriority="high"<?php if ($img_srcset) : ?> imagesrcset="<?php echo esc_attr($img_srcset); ?>" imagesizes="<?php echo esc_attr(wp_get_attachment_image_sizes($img_id, 'full')); ?>"<?php endif; ?>>
    <?php
                endif;
                $counter++;
            endforeach;
        endif;
    endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="header">
        <div class="container-menu">
            <a href="/" class="logo" aria-label="Agência R8 - página inicial">
                <svg width="117" height="23" viewBox="0 0 117 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M103.009 6.21464C103.01 5.39889 102.849 4.59105 102.538 3.83725C102.226 3.08345 101.768 2.39845 101.192 1.82137C100.615 1.24429 99.9307 0.786417 99.1772 0.473906C98.4237 0.161395 97.616 0.000361835 96.8002 0H90.5939V2.51617H96.8002C97.2939 2.50269 97.7852 2.58827 98.2452 2.76787C98.7052 2.94746 99.1246 3.21742 99.4785 3.56181C99.8324 3.90619 100.114 4.31801 100.306 4.77294C100.498 5.22787 100.597 5.71669 100.597 6.21051C100.597 6.70433 100.498 7.19315 100.306 7.64808C100.114 8.10301 99.8324 8.51483 99.4785 8.85921C99.1246 9.2036 98.7052 9.47356 98.2452 9.65315C97.7852 9.83275 97.2939 9.91833 96.8002 9.90485H93.0549V4.89455L90.5415 7.41623C90.5415 7.47411 90.5415 9.82768 90.5415 9.89658C90.5415 9.96548 90.5415 10.0206 90.5415 10.084V12.1261C90.5415 12.1868 90.5415 12.2502 90.5415 12.3135C90.5415 12.3769 90.5415 12.4293 90.5415 12.4872V17.3045H93.0604V12.4155H96.4833L100.697 17.2963H104.252L99.3743 11.8505C100.457 11.3588 101.375 10.566 102.02 9.56671C102.664 8.5674 103.008 7.40378 103.009 6.21464Z" fill="#FFE700" />
                    <path d="M78.1866 4.89455C77.1655 4.89445 76.1601 5.14619 75.2595 5.62749C74.3589 6.10878 73.5909 6.80476 73.0235 7.65378C72.4561 8.5028 72.1069 9.47864 72.0068 10.4949C71.9067 11.5111 72.0587 12.5363 72.4495 13.4797C72.8402 14.4231 73.4577 15.2556 74.247 15.9034C75.0364 16.5512 75.9733 16.9944 76.9748 17.1935C77.9764 17.3927 79.0116 17.3418 79.9887 17.0454C80.9659 16.7489 81.8548 16.216 82.5768 15.4939L84.3958 17.3045V11.1037C84.3958 10.2883 84.2352 9.48088 83.9231 8.72755C83.6111 7.97422 83.1537 7.28973 82.5771 6.71316C82.0006 6.13659 81.3161 5.67923 80.5628 5.36719C79.8094 5.05515 79.002 4.89455 78.1866 4.89455ZM81.8796 11.1037V11.156C81.8727 12.1405 81.4758 13.0821 80.776 13.7745C80.0763 14.467 79.1305 14.8538 78.1461 14.8504C77.1616 14.8469 76.2186 14.4534 75.5237 13.756C74.8288 13.0587 74.4386 12.1143 74.4386 11.1299C74.4386 10.1454 74.8288 9.20104 75.5237 8.50369C76.2186 7.80634 77.1616 7.41283 78.1461 7.40937C79.1305 7.4059 80.0763 7.79277 80.776 8.48521C81.4758 9.17766 81.8727 10.1192 81.8796 11.1037Z" fill="#FFE700" />
                    <path d="M6.20975 4.89455C5.18861 4.89445 4.1832 5.14619 3.2826 5.62749C2.38199 6.10878 1.61399 6.80476 1.04662 7.65378C0.47926 8.5028 0.130048 9.47864 0.0299219 10.4949C-0.0702037 11.5111 0.0818486 12.5363 0.472609 13.4797C0.86337 14.4231 1.48078 15.2556 2.27013 15.9034C3.05949 16.5512 3.99643 16.9944 4.99796 17.1935C5.99949 17.3927 7.03468 17.3418 8.01184 17.0454C8.989 16.7489 9.87795 16.216 10.6 15.4939L12.4161 17.3045V11.1037C12.4161 9.45739 11.7623 7.87849 10.5985 6.71414C9.43464 5.54978 7.85604 4.89528 6.20975 4.89455ZM9.89995 11.1037V11.156C9.89303 12.0915 9.51566 12.9861 8.85049 13.6439C8.18533 14.3018 7.28658 14.6692 6.35109 14.6657C5.41559 14.6622 4.51959 14.2882 3.85932 13.6255C3.19904 12.9627 2.82831 12.0654 2.82831 11.1299C2.82831 10.1944 3.19904 9.29698 3.85932 8.63426C4.51959 7.97153 5.41559 7.59748 6.35109 7.59402C7.28658 7.59055 8.18533 7.95796 8.85049 8.61578C9.51566 9.27359 9.89303 10.1682 9.89995 11.1037Z" fill="#FFE700" />
                    <path d="M6.20975 9.92138C5.9788 9.92141 5.75302 9.9897 5.56078 10.1177C5.36854 10.2457 5.21842 10.4276 5.1293 10.6407C5.04019 10.8538 5.01605 11.0884 5.05992 11.3151C5.10379 11.5419 5.21371 11.7506 5.37587 11.915C5.53802 12.0795 5.74517 12.1923 5.97128 12.2394C6.19738 12.2864 6.43235 12.2656 6.64664 12.1794C6.86093 12.0933 7.04497 11.9458 7.17564 11.7554C7.30631 11.5649 7.37776 11.3401 7.38102 11.1092V11.0927C7.38102 10.782 7.25762 10.4841 7.03797 10.2644C6.81831 10.0448 6.52039 9.92138 6.20975 9.92138Z" fill="#FFE700" />
                    <path d="M53.3722 11.123V11.1037C53.4074 10.2674 53.2732 9.43258 52.9774 8.64951C52.6817 7.86644 52.2306 7.15128 51.6514 6.54705C51.0721 5.94283 50.3766 5.46203 49.6067 5.13357C48.8367 4.80512 48.0083 4.6358 47.1713 4.6358C46.3342 4.6358 45.5058 4.80512 44.7359 5.13357C43.966 5.46203 43.2705 5.94283 42.6912 6.54705C42.1119 7.15128 41.6609 7.86644 41.3651 8.64951C41.0694 9.43258 40.9352 10.2674 40.9704 11.1037V17.3128H43.4894V11.1037C43.5156 10.1413 43.9164 9.22726 44.6063 8.55589C45.2963 7.88452 46.221 7.50888 47.1837 7.50888C48.1464 7.50888 49.0711 7.88452 49.761 8.55589C50.451 9.22726 50.8517 10.1413 50.878 11.1037V17.3128H53.3942V11.123H53.3722Z" fill="#FFE700" />
                    <path d="M19.8599 4.89455C18.8776 4.894 17.9092 5.12653 17.0342 5.57303C16.1592 6.01953 15.4027 6.66725 14.8267 7.46299C14.2507 8.25873 13.8717 9.17977 13.7209 10.1504C13.5701 11.1211 13.6518 12.1137 13.9592 13.0467C14.2666 13.9797 14.7909 14.8264 15.4892 15.5173C16.1875 16.2083 17.0397 16.7237 17.9759 17.0212C18.9121 17.3187 19.9055 17.3898 20.8745 17.2288C21.8435 17.0677 22.7605 16.679 23.5501 16.0947C23.5398 16.8405 23.3037 17.5657 22.873 18.1746C22.4423 18.7835 21.8371 19.2477 21.1374 19.5058C20.4376 19.7639 19.676 19.8039 18.953 19.6206C18.23 19.4372 17.5796 19.039 17.0874 18.4786L15.2134 20.1321C16.0456 21.0742 17.1444 21.7412 18.3641 22.0449C19.5839 22.3486 20.8672 22.2745 22.0439 21.8326C23.2206 21.3906 24.2354 20.6016 24.9537 19.5701C25.672 18.5385 26.06 17.3131 26.0663 16.0561V11.0954C26.0641 9.45056 25.4093 7.87378 24.2457 6.71121C23.0821 5.54864 21.5048 4.89528 19.8599 4.89455ZM23.5501 11.1037V11.156C23.5432 12.0915 23.1658 12.9861 22.5007 13.6439C21.8355 14.3018 20.9368 14.6692 20.0013 14.6657C19.0658 14.6622 18.1698 14.2882 17.5095 13.6255C16.8492 12.9627 16.4785 12.0654 16.4785 11.1299C16.4785 10.1944 16.8492 9.29698 17.5095 8.63426C18.1698 7.97153 19.0658 7.59748 20.0013 7.59402C20.9368 7.59055 21.8355 7.95796 22.5007 8.61578C23.1658 9.27359 23.5432 10.1682 23.5501 11.1037Z" fill="#FFE700" />
                    <path d="M33.5073 4.89455C32.4842 4.89312 31.4766 5.14453 30.5741 5.62644C29.6715 6.10834 28.9021 6.8058 28.3341 7.6568C27.7661 8.5078 27.4173 9.48597 27.3185 10.5043C27.2197 11.5227 27.3742 12.5496 27.768 13.4939C28.1619 14.4382 28.783 15.2705 29.5761 15.9169C30.3692 16.5632 31.3097 17.0036 32.3141 17.1988C33.3184 17.394 34.3554 17.3379 35.3329 17.0357C36.3103 16.7335 37.198 16.1944 37.9168 15.4663L36.2385 13.5813C35.8116 14.0522 35.2703 14.4047 34.667 14.6048C34.0637 14.8048 33.419 14.8455 32.7953 14.723C32.1717 14.6004 31.5903 14.3187 31.1076 13.9052C30.6249 13.4918 30.2573 12.9606 30.0404 12.3631H39.7082V11.123C39.7111 9.47497 39.0596 7.89322 37.8969 6.72532C36.7342 5.55742 35.1553 4.89893 33.5073 4.89455ZM30.0404 9.84697C30.2986 9.13394 30.7702 8.51777 31.391 8.08229C32.0118 7.64682 32.7518 7.41319 33.5101 7.41319C34.2684 7.41319 35.0084 7.64682 35.6292 8.08229C36.25 8.51777 36.7216 9.13394 36.9798 9.84697H30.0404Z" fill="#FFE700" />
                    <path d="M60.7967 14.7994C60.1777 14.8002 59.5684 14.6455 59.0247 14.3495C58.4811 14.0535 58.0205 13.6257 57.6852 13.1054C57.3499 12.5851 57.1507 11.9888 57.1059 11.3715C57.061 10.7541 57.172 10.1353 57.4285 9.57199C57.685 9.00865 58.079 8.51878 58.5742 8.14733C59.0693 7.77588 59.6498 7.53475 60.2625 7.44608C60.8751 7.35741 61.5002 7.42404 62.0803 7.63985C62.6605 7.85566 63.1772 8.21373 63.5829 8.68121L66.0357 7.77175C65.3158 6.63573 64.2465 5.76417 62.9886 5.28817C61.7307 4.81217 60.3523 4.75746 59.0606 5.13227C57.769 5.50708 56.634 6.29114 55.8263 7.36653C55.0186 8.44192 54.5819 9.75049 54.5819 11.0954C54.5819 12.4403 55.0186 13.7489 55.8263 14.8243C56.634 15.8997 57.769 16.6837 59.0606 17.0586C60.3523 17.4334 61.7307 17.3787 62.9886 16.9027C64.2465 16.4267 65.3158 15.5551 66.0357 14.4191L63.5967 13.5041C63.251 13.9091 62.8217 14.2346 62.3384 14.4582C61.8551 14.6817 61.3292 14.7981 60.7967 14.7994Z" fill="#FFE700" />
                    <path d="M114.733 8.05837C114.598 7.94813 114.458 7.8434 114.309 7.74143C114.763 7.34846 115.13 6.86355 115.383 6.31868C115.637 5.77381 115.772 5.18135 115.78 4.58037C115.77 3.94199 115.617 3.31401 115.333 2.742C115.05 2.16998 114.642 1.66826 114.141 1.27324C113.908 1.0824 113.659 0.912695 113.397 0.766151L113.361 0.744104L113.126 0.620086L113.091 0.603551C112.911 0.515534 112.727 0.437334 112.539 0.369296L112.443 0.322445C112.369 0.294886 112.291 0.270082 112.217 0.248035L112.14 0.225987L111.892 0.1626H111.842L111.553 0.0881901H111.487L111.247 0.0523629H111.148C111.073 0.0523629 111.002 0.0523629 110.927 0.0358272H110.831L110.514 0C110.407 0 110.303 0 110.2 0H110.103C110.029 0 109.954 0 109.883 0.0165356H109.783L109.544 0.0523629H109.478L109.177 0.112994H109.128L108.882 0.17638L108.805 0.198428C108.728 0.220475 108.654 0.245279 108.579 0.272838L108.519 0.29213C108.331 0.360263 108.147 0.438461 107.967 0.526384L107.934 0.54292L107.7 0.666937L107.661 0.688985C107.4 0.836846 107.151 1.00648 106.917 1.19608C106.416 1.5911 106.008 2.09281 105.725 2.66483C105.441 3.23685 105.288 3.86482 105.278 4.50321C105.285 5.09302 105.415 5.6748 105.66 6.21145C105.905 6.7481 106.259 7.22787 106.7 7.62017C106.529 7.73592 106.363 7.85443 106.206 7.9812C105.613 8.4509 105.132 9.04685 104.799 9.72571C104.465 10.4046 104.287 11.1493 104.277 11.9057C104.289 12.6597 104.468 13.4018 104.801 14.0782C105.135 14.7545 105.615 15.3482 106.206 15.8163H106.223C106.498 16.0427 106.792 16.2447 107.102 16.4199L107.146 16.4447C107.237 16.4971 107.328 16.5439 107.422 16.5908L107.468 16.6156C107.684 16.7197 107.904 16.8117 108.13 16.8912L108.199 16.916L108.474 17.0041L108.565 17.0317L108.841 17.1061L108.907 17.1199C109.023 17.1475 109.144 17.1723 109.263 17.1943H109.334L109.61 17.2356H109.726C109.814 17.2356 109.902 17.2522 110.001 17.2577H110.114C110.238 17.2577 110.362 17.2577 110.489 17.2577C110.616 17.2577 110.737 17.2577 110.861 17.2577H110.974C111.062 17.2577 111.15 17.2577 111.25 17.2356H111.365L111.655 17.1943H111.726C111.848 17.1723 111.966 17.1475 112.082 17.1199L112.148 17.1061L112.424 17.0317L112.515 17.0041L112.79 16.916L112.859 16.8912C113.085 16.8117 113.305 16.7197 113.521 16.6156L113.567 16.5908C113.661 16.5439 113.752 16.4971 113.843 16.4447C113.858 16.4375 113.873 16.4292 113.887 16.4199C114.197 16.2447 114.491 16.0427 114.766 15.8163H114.783C115.375 15.3486 115.855 14.755 116.188 14.0786C116.522 13.4021 116.701 12.6598 116.712 11.9057C116.685 11.1583 116.494 10.426 116.152 9.76093C115.81 9.0959 115.326 8.51455 114.733 8.05837ZM108.744 3.22996C108.797 3.1776 108.852 3.12799 108.91 3.07838H108.924C108.976 3.03705 109.034 2.99571 109.092 2.95712L109.119 2.93783L109.285 2.84137C109.298 2.8324 109.313 2.825 109.329 2.81933C109.382 2.79084 109.436 2.76508 109.491 2.74216L109.549 2.71736L109.712 2.66224L109.778 2.64019C109.833 2.62365 109.888 2.61263 109.943 2.59885L110.018 2.58232L110.191 2.55751H110.263C110.346 2.55751 110.431 2.55751 110.517 2.55751C110.602 2.55751 110.685 2.55751 110.767 2.55751H110.842C110.899 2.55751 110.957 2.56578 111.015 2.58232L111.09 2.59885C111.145 2.59885 111.2 2.62365 111.252 2.64019L111.321 2.66224L111.484 2.71736L111.539 2.74216C111.596 2.76454 111.651 2.79031 111.704 2.81933L111.748 2.84137L111.914 2.93783L111.941 2.95712C111.999 2.99571 112.054 3.03705 112.109 3.07838C112.167 3.12799 112.222 3.1776 112.275 3.22996C112.456 3.40199 112.601 3.60924 112.7 3.83905C112.799 4.06886 112.85 4.31642 112.85 4.56659C112.85 4.81677 112.799 5.06432 112.7 5.29413C112.601 5.52394 112.456 5.73119 112.275 5.90322C112.222 5.95569 112.167 6.00536 112.109 6.05204L112.09 6.06858C112.039 6.11114 111.986 6.15071 111.93 6.18708L111.895 6.20913C111.842 6.24496 111.79 6.27527 111.735 6.30559L111.685 6.33039C111.633 6.35797 111.58 6.38281 111.525 6.4048L111.465 6.43236L111.308 6.48748L111.233 6.50953C111.181 6.52607 111.128 6.53709 111.073 6.55087L110.993 6.5674L110.864 6.5867H110.809C110.685 6.5867 110.561 6.5867 110.437 6.5867C110.313 6.5867 110.208 6.5867 110.095 6.5867L109.993 6.57016L109.916 6.55362C109.861 6.53984 109.808 6.52882 109.756 6.51229L109.682 6.49024L109.524 6.43512L109.461 6.40756C109.41 6.38551 109.357 6.36071 109.304 6.33315L109.254 6.30835C109.199 6.27803 109.147 6.24772 109.094 6.21189L109.059 6.18984C109.004 6.15401 108.948 6.11267 108.896 6.07134L108.88 6.0548C108.821 6.00882 108.766 5.95911 108.714 5.90598C108.533 5.73395 108.388 5.5267 108.289 5.29689C108.19 5.06708 108.139 4.81952 108.139 4.56935C108.139 4.31917 108.19 4.07162 108.289 3.84181C108.388 3.612 108.533 3.40475 108.714 3.23272L108.744 3.22996ZM112.956 13.8514C112.881 13.9258 112.804 13.9947 112.724 14.0608L112.697 14.0829C112.625 14.1407 112.548 14.1986 112.471 14.251L112.421 14.2813C112.349 14.3281 112.275 14.375 112.198 14.4163L112.126 14.4521C112.054 14.4907 111.98 14.5238 111.906 14.5569L111.817 14.5927C111.746 14.6203 111.671 14.6478 111.597 14.6699L111.495 14.7029C111.421 14.725 111.346 14.7415 111.269 14.7581C111.192 14.7746 111.197 14.7773 111.159 14.7829C111.079 14.799 110.998 14.811 110.916 14.8187H110.811C110.696 14.8187 110.577 14.8352 110.459 14.8352C110.34 14.8352 110.219 14.8352 110.103 14.8187H109.998C109.917 14.811 109.836 14.799 109.756 14.7829L109.646 14.7581C109.569 14.7415 109.494 14.725 109.422 14.7029C109.351 14.6809 109.354 14.6809 109.318 14.6699C109.282 14.6588 109.169 14.6203 109.097 14.5927L109.009 14.5569C108.935 14.5238 108.86 14.4907 108.789 14.4521L108.72 14.4163C108.643 14.375 108.565 14.3281 108.494 14.2813L108.444 14.251C108.367 14.1986 108.29 14.1407 108.218 14.0829L108.191 14.0608C108.111 13.9947 108.033 13.9258 107.959 13.8514C107.704 13.6098 107.502 13.319 107.363 12.9966C107.225 12.6741 107.153 12.3269 107.153 11.9759C107.153 11.625 107.225 11.2777 107.363 10.9553C107.502 10.6329 107.704 10.342 107.959 10.1005C108.032 10.0264 108.11 9.9565 108.191 9.89107L108.21 9.87453C108.284 9.8139 108.364 9.75878 108.444 9.70366L108.485 9.67886C108.56 9.6287 108.637 9.5827 108.717 9.54106L108.778 9.50799C108.852 9.46941 108.929 9.43634 109.006 9.40327C109.034 9.40327 109.059 9.37846 109.086 9.37019C109.161 9.33988 109.238 9.31508 109.315 9.29027L109.409 9.25996C109.486 9.23791 109.56 9.21862 109.637 9.20208L109.745 9.18004C109.825 9.16405 109.906 9.1521 109.987 9.14421H110.186C110.291 9.14421 110.395 9.14421 110.503 9.14421H110.9C110.981 9.1519 111.062 9.16386 111.142 9.18004L111.25 9.20208C111.327 9.21862 111.404 9.23791 111.478 9.25996L111.572 9.29027C111.649 9.31508 111.726 9.33988 111.801 9.37019C111.828 9.37019 111.853 9.39224 111.881 9.40327C111.958 9.43634 112.035 9.46941 112.109 9.50799L112.17 9.54106C112.25 9.5824 112.327 9.62925 112.404 9.67886L112.443 9.70366C112.523 9.75878 112.603 9.8139 112.677 9.87453L112.697 9.89107C112.778 9.95648 112.857 10.0264 112.931 10.1005C113.185 10.3423 113.387 10.6332 113.526 10.9556C113.664 11.278 113.735 11.6251 113.735 11.9759C113.735 12.3268 113.664 12.6739 113.526 12.9963C113.387 13.3187 113.185 13.6096 112.931 13.8514H112.956Z" fill="#FFE700" />
                    <path d="M68.2294 9.88831C68.2294 9.9517 68.2294 10.0123 68.2294 10.0757V12.1261C68.2294 12.1868 68.2294 12.2502 68.2294 12.3135C68.2294 12.3769 68.2294 12.4293 68.2294 12.4872V17.3045H70.7456V4.89455L68.2349 7.41623C68.2322 7.47411 68.2294 9.82768 68.2294 9.88831Z" fill="#FFE700" />
                    <path d="M31.6609 3.46697L33.5625 2.76696L35.4613 3.46697L36.5637 3.86934L37.0873 2.44452L33.8656 1.27049L33.7526 1.22364C33.6905 1.19969 33.627 1.17945 33.5625 1.16301C33.4979 1.17945 33.4344 1.19969 33.3723 1.22364L33.2593 1.27049L30.0404 2.44452L30.564 3.86934L31.6609 3.46697Z" fill="#FFE700" />
                </svg>

            </a>
            <nav class="nav">
                <ul class="menu">
                    <li><a href="<?php echo esc_url(agencia_link_pagina_agencia()); ?>">A Agência</a></li>
                    <li class="has-submenu"><button>Soluções
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_13456_4789" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="4" y="6" width="10" height="7">
                                    <path d="M13.5 6.75L9 12.375L4.5 6.75H13.5Z" fill="currentColor" />
                                </mask>
                                <g mask="url(#mask0_13456_4789)">
                                    <path d="M0 0H18V18H0V0Z" fill="currentColor" />
                                </g>
                            </svg>
                        </button>
                        <div class="dropdown">
                            <div class="dropdown__inner">
                                <?php // Uma coluna por Área, com as Soluções daquela área (em cache, ver agencia_menu_areas)
                                foreach (agencia_menu_areas() as $area_menu) : ?>
                                    <ul class="dropdown__coluna"><span class="dropdown__coluna-titulo"><?php echo esc_html($area_menu['nome']); ?></span>
                                        <div class="dropdown__coluna-content">
                                            <?php foreach ($area_menu['solucoes'] as $solucao_menu) : ?>
                                                <li><a href="<?php echo esc_url($solucao_menu['link']); ?>"><?php echo esc_html($solucao_menu['titulo']); ?></a></li>
                                            <?php endforeach; ?>
                                        </div>
                                    </ul>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                    <li class="has-submenu"><button>Modelos de Negócio <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_13456_4789" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="4" y="6" width="10" height="7">
                                    <path d="M13.5 6.75L9 12.375L4.5 6.75H13.5Z" fill="currentColor" />
                                </mask>
                                <g mask="url(#mask0_13456_4789)">
                                    <path d="M0 0H18V18H0V0Z" fill="currentColor" />
                                </g>
                            </svg></button>
                        <div class="dropdown">
                            <div class="dropdown__inner">
                                <?php foreach (agencia_menu_modelos() as $modelo_menu) : ?>
                                    <ul class="dropdown__coluna">
                                        <div class="dropdown__coluna-content">
                                            <li><a href="<?php echo esc_url($modelo_menu['link']); ?>"><?php echo esc_html($modelo_menu['titulo']); ?></a></li>
                                        </div>
                                    </ul>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('case')); ?>">Cases</a></li>
                    <li class="has-submenu"><button>Educação <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_13456_4789" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="4" y="6" width="10" height="7">
                                    <path d="M13.5 6.75L9 12.375L4.5 6.75H13.5Z" fill="currentColor" />
                                </mask>
                                <g mask="url(#mask0_13456_4789)">
                                    <path d="M0 0H18V18H0V0Z" fill="currentColor" />
                                </g>
                            </svg></button>
                        <div class="dropdown">
                            <div class="dropdown__inner">
                                <ul class="dropdown__coluna">
                                    <div class="dropdown__coluna-content">
                                        <li>Blog</li>
                                    </div>
                                </ul>
                                <ul class="dropdown__coluna">
                                    <div class="dropdown__coluna-content">
                                        <li>Materiais Ricos</li>
                                    </div>
                                </ul>
                                <ul class="dropdown__coluna">
                                    <div class="dropdown__coluna-content">
                                        <li>Podcast</li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
            <a class="btn-header" href="#">Agende uma reunião </a>
            <button class="mobile-toggle" aria-label="Abrir menu">☰ </button>
        </div>
    </header>