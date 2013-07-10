
<legend>Iniciar sesi&oacute;n</legend>
<?php if(isset($err)){?>
		<div class="alert alert-error">
		<?php echo $err;?>
		</div>
  <?php }?>
<?php $form=new form(array("id"=>"forma1","method"=>"get","function"=>"login"));
$form->begin();
?>
<p>Entra con usuario: velkan, contrase&ntilde;a: 123</p>
  <div class="control-group">
    <label class="control-label" for="user">Usuario:</label>
    <div class="controls">
      <?php $model->input1->render();?>
    </div>
    <label class="control-label" for="pass">Contrase&ntilde;a:</label>
    <div class="controls">
      <?php $model->input2->render();?>
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <input type="submit" class="btn" value="Acceder">
    </div>
  </div>
<?php $form->end();
unset($form);?>