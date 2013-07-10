<h1>Prueba de selectores</h1>
<div class="control-group">
	<div class="controls">
		<label for="<?php echo $model->lookup1->getId();?>">Selector de listas predefinidas</label>
		<?php $model->lookup1->render();?>
	</div>
	
	<div class="controls">
		<label for="<?php echo $model->lookup2->getId();?>">Selector con filtros</label>
		<?php $model->lookup2->render();?>
	</div>
</div>