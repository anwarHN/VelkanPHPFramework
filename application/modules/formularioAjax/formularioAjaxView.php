<h1>Ejemplo formulario Ajax</h1>

<?php $model->formAjax->begin(); ?>
<div class="control-group">
	<label class="control-label" for="<?php echo $model->inputId->getId(); ?>">Id:</label>
	<div class="controls">
		<?php $model->inputId->render();?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="<?php echo $model->textAreaText->getId(); ?>">Texto:</label>
	<div class="controls">
		<?php $model->textAreaText->render();?>
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="<?php echo $model->textAreaText->getId(); ?>">Texto:</label>
	<div class="controls">
		<input type="submit" value="Guardar">
	</div>
</div>

<?php $model->formAjax->end(); ?>