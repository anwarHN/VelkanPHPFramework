<!DOCTYPE html>
<html lang="<?PHP velkan::_getLanguage(); ?>">
  <head>
    <meta charset="<?php velkan::_getCharset();?>">
    
    <title><?php page::_getTitle();?></title>
    
	<?php page::_getMetas();?>
	<?php page::_getCSSFiles();?>
	<?php page::_getBootstrapCSS();?>
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
  
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
      	<div class="container">
      	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"><?php velkan::_getAppName();?></a>
          <div class="nav-collapse collapse">
            <?php velkan::widget("velkan.menu", 
											array("items"=>
												array(
													"Inicio","Clientes","Proveedores","Inventario","Facturaci&oacute;n"),
												"links"=>
												array(
													"main/","clientes/","proveedores/","inventario/","facturacion/"
												),
												"class"=>"nav"
											),
								  true
				);?>
			 <?php velkan::widget("velkan.drop_down", 
			 					array(
			 						"class"=>"nav",
			 						"float"=>"right",
			 						"display"=>user::get("name"),
			 						"displayLink"=>"#",
			 						"items"=>array(
			 									"Cerrar sessi&oacute;n"=>"logout/"
			 									)
			 					),true);
			 ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	<div class="container">
		<?php echo $content;?>
	</div>

<?php page::_getJsFiles();?>
<?php page::_getBootstrapJS();?>
<?php page::getJavaScriptOnLoad();?>
<?php page::getJavaScript();?>
</body>
</html>