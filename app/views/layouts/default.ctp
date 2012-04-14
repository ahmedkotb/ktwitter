<html>
<head>
    <title>Ktwitter</title>
    <?=$html->css('cake.generic');?>
    <?=$javascript->link(array('prototype'));?>
    <?=$javascript->link(array('scriptaculous'));?>
</head>
<body>
    <div id="container">
    <div id="content">
     <? $session->flash();?>
         <?=$content_for_layout;?>
     </div>
     </div>
 </body>
 </html>

