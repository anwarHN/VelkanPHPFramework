<h1>Ejemplo de formulario para acciones en la base de datos</h1>
<?php 
$model->forma->begin($formAlertType,$alertMessage);
?>
<div class="control-group">
  	<label class="control-label" for="id">Id:</label>
    <div class="controls">
      <?php $model->id->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="text">Texto:</label>
    <div class="controls">
      <?php $model->text->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="textArea">Id:</label>
    <div class="controls">
      <?php $model->textArea->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Date:</label>
    <div class="controls">
      <?php $model->date->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Date Time:</label>
    <div class="controls">
      <?php $model->dateTime->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Time:</label>
    <div class="controls">
      <?php $model->time->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Select:</label>
    <div class="controls">
      <?php $model->select->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Select padre:</label>
    <div class="controls">
      <?php $model->selectD->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Select hijo 1:</label>
    <div class="controls">
      <?php $model->selectD2->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Select hijo 2:</label>
    <div class="controls">
      <?php $model->selectD3->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Radio button:</label>
    <div class="controls">
      <?php $model->option->render();?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="range1">Checkbox:</label>
    <div class="controls">
      <?php $model->checkbox->render();?>
    </div>
</div>
<?php if(!$model->isReadOnly()){?>
<div class="control-group">
    <div class="controls">
      <?php $model->button->render();?>
    </div>
</div>
<?php 
}
$model->forma->end();?>