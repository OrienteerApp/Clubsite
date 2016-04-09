<!DOCTYPE html>
<html lang=en>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# event: http://ogp.me/ns/event#">
      <?php echo $this->Html->charset(); ?>
      <title>
          <?php echo $title_for_layout; ?>
      </title>
  
    <?php echo $this->element('layout_dependencies') ?>
    <?php echo $scripts_for_layout ?>
</head>
<body>
    <?php
    echo $content_for_layout;
    echo $this->element('layout_bottom_dependencies');
    ?>
</body>
</html>

