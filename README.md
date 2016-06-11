## README
###基于thinkcmf X2.1.0框架二次开发
####添加了模型管理功能: 
  - 1>模型管理，2>字段管理 （此功能从TP-Admin-3.x移植过来，并作相关修改，TP-Admin中的模型管理，字段管理等应该是从phpcms移植的功能，也可以参照phpcms框架里的模型管理，字段管理等功能）<br/>
  上面的1，2功能已经基本完成，但未测试。<br/>
  - 3>基于模型的内容管理，正在修改中，代码还未完成，还是打算从TP-Admin-3.x那里做移植。<br/>

####移植内容备注：
  - 关于上面的移植作业，有很多从TP-Admin移植过来的控件跟ThinkCFM中不一致，需要后期改良，比如TP-Admin中的cheditor（国外产品），ThinkCMF用的是Ueditor（国内百度的） ，等等。<br/>
  - 从TP-Admin移植过来的Plugins/PostField组件（用于字段管理等）样式可能跟ThinkCMF的样式不同，须要改良。<br/>
   simplewind\Core\Library\Org\Util\Form.class.php 用于字段管理。<br/>
   application\Plugins\PostField\content_form.class.php 用于内容管理。<br/>
  - 从TP-Admin移植过来的JS,CSS以及图片等，此处省略备注<br/>
