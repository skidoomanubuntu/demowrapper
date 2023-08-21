<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Ubuntu Core Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8"/>

    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            width:100%;
            height:100%;
            padding:0;
            margin:0;
            font-family: 'Ubuntu', sans-serif;
            font-weight: 300;
        }

        body > div {
            display:flex;
            flex-direction:row;
            height: 100%;
            width: 100%;
        }

        h1 { 
            font-weight: 300;
            font-size: 56px;margin-top:4px;
        }

        main {
            flex: 1;
            padding:0px;
            margin: 0;
            background-color:#111;
        }

        nav {
            width: 56px;
            background-color:#111;
            overflow:hidden;
            height:100%;
            color:#fff;
            display: flex;
            flex-direction: column;
            transition: all 0.2s linear;
        }


        nav:hover {
            background-color: #262626;
            width: 240px;
        }

        nav header {
            font-size: 24px;
            position: relative;
            white-space: nowrap;
            color:#363636;
        }
        nav:hover header {
            color:#ffffff;
        }

        nav header::before {
            content: url(./logo.svg);
            width: 24px;
            height: 43px;
            margin: 0 8px 0 16px;
        }
        nav header::after {
            content: 'Canonical';
            position: absolute;
            top:4px;
            left:48px;
            font-size:12px;
        }

        nav ul {
            list-style: none;
            margin: 8px 0;
            padding:0;
        }
        nav ul:not(.extras) {
            flex:1;
        }

        nav ul a {
            display: block;
            padding: 8px 16px;
            color: #fff;
            text-decoration: none;
            white-space: nowrap;
            text-indent:240px;
        }
        nav:hover ul a {
            text-indent:32px;
        }
        nav ul a svg {
            vertical-align: text-top;
            margin-right:4px;
            position:absolute;
            left:20px;
        }
        nav ul a svg path {
            fill: #ffffff;
        }
        nav ul a:hover {
            background-color: #2e2e2e;
        }

        nav ul a.selected {
            border-left: 4px solid #fff;
            background-color: #373737 !important;
            padding-left:12px;
            cursor: default;
        }
        nav ul a.selected svg path {
            fill: #A8A8A8;
        }

       
    </style>

    <!-- Scripts for translation are imported here !-->
    <?php include 'language_inc.php'?>


    <!-- This contains the automation that determines which menus are being displayed !-->
    <?php include 'entries.php'?>

</head>
<body>
    <div>
        <nav>
            <header>Core Demo</header>
            <ul>
                <script>document.write(populate_menus());</script>
            </ul>
            <ul class="extras">
                <li><a href="./">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 3.58172 12.4183 0 8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8ZM1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8ZM8.75 6.99937V12.0202H7.25V6.99937H8.75ZM9 4.44477C9 4.16862 8.77614 3.94477 8.5 3.94477H7.5C7.22386 3.94477 7 4.16862 7 4.44477V5.44477C7 5.72091 7.22386 5.94477 7.5 5.94477H8.5C8.77614 5.94477 9 5.72091 9 5.44477V4.44477Z"/>
                    </svg>
                    About</a></li>
                <li><a href="./">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.466 2.74795C12.4889 1.73131 11.2309 0.986656 9.81679 0.638826L8.5484 2.14312C8.36784 2.12643 8.18491 2.11789 7.99998 2.11789C7.81506 2.11789 7.63213 2.12643 7.45156 2.14312L6.18381 0.638672C4.76947 0.986436 3.51123 1.73116 2.53398 2.74795L3.2015 4.5971C2.99023 4.89447 2.80591 5.21233 2.6521 5.54711L0.716319 5.89296C0.523136 6.56192 0.419617 7.26891 0.419617 8.00008C0.419617 8.73129 0.523146 9.43831 0.716345 10.1073L2.6521 10.4531C2.80591 10.7878 2.99023 11.1057 3.2015 11.4031L2.53398 13.2522C3.51123 14.269 4.76947 15.0137 6.18381 15.3615L7.45156 13.857C7.63213 13.8737 7.81506 13.8823 7.99998 13.8823C8.18491 13.8823 8.36784 13.8737 8.5484 13.857L9.81679 15.3613C11.2309 15.0135 12.4889 14.2689 13.466 13.2522L12.7985 11.4031C13.0097 11.1057 13.1941 10.7878 13.3479 10.4531L15.2836 10.1073C15.4768 9.43831 15.5804 8.73129 15.5804 8.00008C15.5804 7.26891 15.4768 6.56192 15.2836 5.89296L13.3479 5.54711C13.1941 5.21233 13.0097 4.89447 12.7985 4.5971L13.466 2.74795ZM9.19026 3.70886L10.313 2.37608L10.5367 2.47218C10.8818 2.63083 11.2111 2.82162 11.5205 3.04175L11.713 3.18608L11.1211 4.82603L11.5757 5.46586L11.7267 5.69314C11.8227 5.84766 11.9089 6.00802 11.9848 6.17333L12.3122 6.88582L14.024 7.19108L14.0419 7.31121C14.0674 7.5384 14.0804 7.76825 14.0804 8.00008L14.0707 8.34627C14.0643 8.46112 14.0547 8.57538 14.0419 8.68898L14.024 8.80808L12.3122 9.11431L11.9848 9.82683L11.8633 10.071C11.7772 10.2311 11.6811 10.3859 11.5757 10.5343L11.1211 11.1741L11.713 12.8131L11.5205 12.9584C11.2111 13.1785 10.8818 13.3693 10.5367 13.528L10.313 13.6231L9.19026 12.2913L8.41031 12.3634L8.20597 12.3775L7.99998 12.3823C7.86214 12.3823 7.72529 12.376 7.58966 12.3634L6.80943 12.2913L5.68598 13.6231L5.46354 13.5281C5.11842 13.3695 4.78907 13.1787 4.47966 12.9585L4.28598 12.8131L4.87889 11.1741L4.42431 10.5343L4.27323 10.307C4.17731 10.1525 4.09108 9.99215 4.01513 9.82683L3.68777 9.11431L1.97498 8.80808L1.95807 8.68898C1.93253 8.46178 1.91962 8.23192 1.91962 8.00008L1.92926 7.65391C1.93568 7.53907 1.9453 7.42481 1.95807 7.31121L1.97498 7.19108L3.68779 6.88582L4.01513 6.17333L4.13669 5.92919C4.22278 5.76905 4.31884 5.61431 4.42431 5.46586L4.87889 4.82603L4.28598 3.18608L4.47966 3.04165C4.78907 2.8215 5.11842 2.6307 5.46354 2.47204L5.68598 2.37608L6.80943 3.70889L7.58966 3.63675L7.79399 3.62262L7.99998 3.61789C8.13782 3.61789 8.27468 3.62421 8.41031 3.63675L9.19026 3.70886ZM7.99998 5.00008C9.65684 5.00008 11 6.34323 11 8.00008C11 9.65694 9.65684 11.0001 7.99998 11.0001C6.34313 11.0001 4.99998 9.65694 4.99998 8.00008C4.99998 6.34323 6.34313 5.00008 7.99998 5.00008ZM6.49998 8.00008C6.49998 7.17165 7.17156 6.50008 7.99998 6.50008C8.82841 6.50008 9.49998 7.17165 9.49998 8.00008C9.49998 8.82851 8.82841 9.50008 7.99998 9.50008C7.17156 9.50008 6.49998 8.82851 6.49998 8.00008Z" />
                    </svg>
                    Settings</a></li>
            </ul>
        </nav>
        <main>
        </main>
            <script>load_page(links[0]['url']);</script>

    </div>








    <script>
        //only a small amount of js to handle selected tabs
        let h1 = document.querySelector('h1'); //fake page change by updating h1 text
        
        document.querySelectorAll('nav a').forEach(n => 
            n.addEventListener("click", function(e) {
                document.querySelector('nav a.selected').classList.remove('selected');
                n.classList.add('selected');
                //h1.innerText = n.innerText;
                e.stopPropagation();
                e.preventDefault();
                return false;
            })
        );


    </script>
</body>
</html>
