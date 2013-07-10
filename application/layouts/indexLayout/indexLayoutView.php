<!DOCTYPE html>
<html lang="<?PHP velkan::_getLanguage(); ?>">
  <head>
    <meta charset="<?php velkan::_getCharset();?>">
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <title><?php page::_getTitle();?></title>
    
	<?php page::_getMetas();?>
	<?php page::_getCSSFiles();?>
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <?php page::_getBootstrapCSS();?>
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
											array(
												"items"=>array(
													"Inicio"=>"index/",
													"Iniciar sesi&oacute;n"=>"login/",
													"Controles"=>"controls/",
													"Lookup"=>"selectors/",
													"Subir archivos"=>"upload/",
													"Botones"=>"button/",
													"Captcha"=>"captcha",
													"Data view"=>"dataview/",
													"Formularios"=>array(
																"Formulario normal"=>"formExample/",
																"Formulario ajax"=>"formularioAjax/",
																"-"=>"",
																"Acciones"=>"actionsExample/"),
													"Acerca de"=>"acerca_de/"
      											),
												"class"=>"nav"
											),
								true
				);?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
	<div class="container">
		<?php htmlHelper::breadcrumbs();?>
		<?php echo $content;?>
	</div>
	<?php page::getAppendedHtml();?>
	<?php page::_getJsFiles();?>
	<?php page::_getBootstrapJS();?>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php page::getJavaScriptOnLoad();?>
	<?php page::getJavaScript();?>
</body>
</html>