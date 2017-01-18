<?php
require_once(__DIR__.'/inc/functions.php');
  $root_url = 'http://filemanager.com/';

  $dir    = $_SERVER['DOCUMENT_ROOT'].'/';
  $checkdir = '';
  $insdir = '';
if (empty($_GET) === false) {
  if (empty($_GET['file_open']) === false) {    
    $opendir = $_GET['file_open'];
    $insdir  = explode('|', $opendir);
    $nxtdir  = implode('/', $insdir);
    $dir    .= $nxtdir.'/';

     if(file_exists($dir))
    {
      $checkdir .= $opendir;
    }else{
      $dir    = '../';
    }
  }
}
  $checkdir .= (empty($checkdir) === true) ? '' : '|';

  $files = scandir($dir);
  $files = array_diff($files, array('.', '..'));
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Anu islam file manager</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      html, body{
        height: 100%;
      }
    </style>

  <script>
    var rooturl = '<?php echo $root_url ?>';
    var rootpath = '<?php echo $dir ?>';
  </script>


  </head>
  <body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#user_menu" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="user_menu">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="javascript: void(0)"><?php
          $bradecum = explode('/', $dir);
          $bradecum = implode(' &gt; ',$bradecum);
          echo $bradecum; ?></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="javascript: void(0)" id="create_new_folder">New folder</a></li>
          <li><a href="javascript: void(0)" id="create_new_file">New file</a></li>
          <li><a href="javascript: void(0)" id="recurse_copy">Copy</a></li>
          <li><a href="javascript: void(0)" id="recurse_move">Move</a></li>
          <li><a href="javascript: void(0)">Download</a></li>
          <li><a href="javascript: void(0)" id="create_zip">Zip</a></li>
          <li><a href="javascript: void(0)" id="upzip_file">Up Zip</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container" style="min-height: 100%;">
    <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th>Ck</th>
          <th>Name</th>
          <th>Size</th>
          <th>Delete</th>
          <th>Rename</th>
        </tr>
      </thead>
      <tbody>
<?php

if (empty($files) === false) {
  if (is_array($files) === true) {
    foreach ($files as $file) {
      $ftype = filetype($dir.$file);
?>

        <tr class="">
          <td><input id="check_box_select" type="checkbox" value="<?php echo $dir.$file; ?>"></td>
          <td><a href="<?php 

          if ($ftype == 'dir') {
            echo $root_url.'?file_open='.$checkdir.$file;
          }else{
            echo 'javascript: void(0)';
          } ?>"><?php echo $file; ?></a></td>

          <td><?php
            if (file_exists($dir.$file)) {
              if ($ftype == 'file') {
                echo get_file_size(filesize($dir.$file));
              }else{
                echo 'folder';
              }
              
            }
            ?></td>

          <td><a href="<?php echo $dir.$file; ?>" id="delete_file">Delete</a></td>
          <td><a href="<?php echo $dir.$file; ?>" id="rename_file">Rename</a></td>
        </tr>

<?php
    }
  }
}

?>
      </tbody>
    </table>
    </div>
  </div>

<nav class="navbar navbar-default" style="margin: 0;">
<div class="container">
  <div class="row">
    <h3 style="text-align: center;margin: 50px 0;" >Anu islam file manager</h3>
  </div>
</div>
</nav>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/JavaScript"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/JavaScript" ></script>
    <script type="text/JavaScript" src="<?php echo $root_url; ?>js/main.js" ></script>

  </body>
</html>