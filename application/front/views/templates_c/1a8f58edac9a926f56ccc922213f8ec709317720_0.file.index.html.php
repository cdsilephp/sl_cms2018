<?php
/* Smarty version 3.1.33, created on 2018-11-15 13:17:25
  from '/Users/gonghuayao/Sites/sl_cms2018/application/front/views/templates/defualt/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5bed01650076e2_57655613',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a8f58edac9a926f56ccc922213f8ec709317720' => 
    array (
      0 => '/Users/gonghuayao/Sites/sl_cms2018/application/front/views/templates/defualt/index.html',
      1 => 1542259040,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bed01650076e2_57655613 (Smarty_Internal_Template $_smarty_tpl) {
?> 
<!DOCTYPE html>
<html>
<head>
   <title><?php echo $_smarty_tpl->tpl_vars['seodata']->value['t'];?>
 </title>
	<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['seodata']->value['k'];?>
" />
	<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['seodata']->value['d'];?>
" />
<meta charset="UTF-8">
<title>首页</title>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['txt']->value;?>

</body>
</html>
 <?php }
}
