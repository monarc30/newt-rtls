<?php /* Smarty version 2.6.0, created on 2008-07-29 13:07:23
         compiled from filesource.tpl */ ?>
<?php ob_start(); ?>File Source for <?php echo $this->_tpl_vars['name'];  $this->_smarty_vars['capture']['tutle'] = ob_get_contents(); ob_end_clean();  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('title' => $this->_smarty_vars['capture']['tutle'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h1 align="center">Source for file <?php echo $this->_tpl_vars['name']; ?>
</h1>
<p>Documentation is available at <?php echo $this->_tpl_vars['docs']; ?>
</p>
<div class="src-code"><span class="php">
<?php echo $this->_tpl_vars['source']; ?>

</span></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>