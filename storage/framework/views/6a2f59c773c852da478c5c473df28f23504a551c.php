<select name="area_id" id="select-area" required class="form-control select2">
    <?php foreach($areas as $area): ?>
        <option value="<?php echo e($area->id); ?>" <?php echo e(isset($id) && $id == $area->id ? 'selected' : ''); ?>>
            <?php echo e($area->name); ?>

        </option>
    <?php endforeach; ?>
</select>