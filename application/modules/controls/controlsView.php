<h1>Renderizado de controles</h1>
<div class="control-group">
  	<label class="control-label" for="range1">Rango:</label>
    <div class="controls">
      <?php $model->input3->render();?>
    </div>
    <label class="control-label" for="base">Select:</label>
    <div class="controls">
      <?php
      	$model->combo1->render();
      ?>
    </div>
    <div class="controls">
      <?php
      	$model->combo2->render();
      ?>
    </div>
    <div class="controls">
      <?php
      	$model->combo3->render();
      ?>
    </div>
    <div class="controls">
      <?php
      	$model->checkbox->render();
      ?>
    </div>
    
    <div class="controls">
      <?php
      	$model->radio->render();
      ?>
    </div>
    
     <div class="controls">
      <?php
      	$model->texta->render();
      ?>
    </div>
  </div>