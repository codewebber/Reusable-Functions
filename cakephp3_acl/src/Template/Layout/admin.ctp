<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Bookmarks';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
	<?= $this->Html->script('jquery-1.12.4.min');?>
	<?= $this->Html->script('sample');?>
	<?= $this->Html->script('jquery.validate');?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar>
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href="">Bookmarker <?php echo $this->fetch('title'); ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
            <?php  $session = $this->request->session();  if(!empty($session->read('name'))) { ?>
                <li><a href="#"><?php echo $session->read('name');?></a></li>
                <li><a href="<?php echo $this->request->webroot;?>users/logout">Logout</a></li> 
            <?php }  ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
    <?php if(!empty($session->read('name'))) { ?>
    <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?php  echo $this->Html->link('List Users', array('controller' => 'Users', 'action' => 'index')); ?></li>
        <li><?php  echo $this->Html->link('New User', array('controller' => 'Users', 'action' => 'add')); ?></li>
    </ul>
</nav>
<?php } ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
