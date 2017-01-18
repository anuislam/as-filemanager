$(document).ready(function(){
      $('td a#delete_file').on('click', function(e){
        e.preventDefault();
          var file = $(this).attr('href');
          var result = confirm("Want to delete?");
          if (result) {
            $.ajax({
              url: rooturl+"inc/actions.php",
              type: 'POST',
              data: {
                path: file,
                action: 'delete_file'
              },
              success: function(result){
                alert(result);
                location.reload();
              }}
            );
          }
      });
      
      $('td a#rename_file').on('click', function(e){
        e.preventDefault();
        var file = $(this).attr('href');
        var name = prompt("Targeted File: "+ file);
        if (name != '' && name != null) {
          $.ajax({
            url: rooturl+"inc/actions.php",
            type: 'POST',
            data: {
              path: file,
              realpath: rootpath,
              newname: name,
              action: 'rename_file'
            },
            success: function(result){
                if (result == 'File was renamed.') {                
                  alert(result);
                  location.reload();
                }else{
                  alert(result);
                }
            }}
          );
        }
      });

var values    = [];
var arrcount  = 0;
$('tr td input#check_box_select').on('click', function(){
  if($(this).is(':checked')) {
    values.push($(this).val());
    $(this).parent().parent().addClass('success');
  } else {
    $(this).parent().parent().removeClass('success');
    values.splice(values.indexOf($(this).val()),1);
  }
  arrcount = values.length;
  
});

$('li a#create_zip').on('click', function(){
  if (arrcount > 0) {
    var name = prompt("Please enter Zip file name.");
    if (name != '' && name != null) {
      $.ajax({
        url: rooturl+"inc/actions.php",
        type: 'POST',
        data: {
          path: 'file',
          arrfile: values,
          realpath: rootpath,
          name: name,
          action: 'creat_zip_file'
        },
        success: function(result){         
           if (result == 'successfully') {
              location.reload();
           }else{
            alert(result);
           }
        }}
      );
    }
  }else{
    alert('Please select file');
  }
  
});


$('li a#upzip_file').on('click', function(){
  if (arrcount > 0) {
    //var extlocation = prompt("Please enter extract location.");

//**********************************
// Validation zip file
//**********************************

    $.ajax({
      url: rooturl+"inc/actions.php",
      type: 'POST',
      data: {
        path: 'file',
        arrfile: values,
        action: 'zip_validation'
      },
      success: function(result){
       var data = result.split('------');
       console.log(data);
       if (data[1] == 'successfully') {
        var result = confirm(data[0]+' Want to extract ?');
          if (result) {
            var name = prompt("Please select extract location.");
            if (name != '' && name != null) {
              $.ajax({
                url: rooturl+"inc/actions.php",
                type: 'POST',
                data: {
                  path: 'file',
                  arrfile: data[2],
                  location: name,
                  action: 'zip_extract_file'
                },
                success: function(result){
                  console.log(result);
                  if (result == 'successfully') {
                    alert('Extract successfully');
                    location.reload();
                  }else{
                    alert(result);
                  }
                }}
              );
            }
          }
       }
      }}
    );

  }else{
    alert('Please select file');
  }
});

$('li a#create_new_folder').on('click', function(){
  var name = prompt("Please enter your folder.");
  if (name != '' && name != null) {
    $.ajax({
    url: rooturl+"inc/actions.php",
    type: 'POST',
    data: {
      path: 'file',
      realpath: rootpath,
      name: name,
      action: 'create_new_directory'
    },
    success: function(result){      
      if (result == 'successfully') {
        alert(result);
        location.reload();
      }else{
        alert(result);
      }
    }});
  }
});

$('li a#create_new_file').on('click', function(){
  var name = prompt("Please enter your file name.");
  if (name != '' && name != null) {
    $.ajax({
    url: rooturl+"inc/actions.php",
    type: 'POST',
    data: {
      path: 'file',
      realpath: rootpath,
      name: name,
      action: 'create_new_file'
    },
    success: function(result){      
      if (result == 'File create successfully') {
        alert(result);
        location.reload();
      }else{
        alert(result);
      }
    }});
  }
});

$('li a#recurse_copy').on('click', function(){
  if (arrcount > 0) {    
    var name = prompt("Please enter your folder name.");
    if (name != '' && name != null) {
      $.ajax({
      url: rooturl+"inc/actions.php",
      type: 'POST',
      data: {
        path: 'file',
        arrfile: values,
        copy_path: rootpath+name,
        action: 'copy_file'
      },
      success: function(result){ 
        if (result == 'successfully') {
          alert(result);
          location.reload();
        }else{
          alert(result);
        }
      }});
    }
  }else{
    alert('Please select file');
  }
});

$('li a#recurse_move').on('click', function(){
  if (arrcount > 0) {    
    var name = prompt("Please enter your folder name.");
    if (name != '' && name != null) {
      $.ajax({
      url: rooturl+"inc/actions.php",
      type: 'POST',
      data: {
        path: 'file',
        arrfile: values,
        copy_path: rootpath+name,
        action: 'move_file'
      },
      success: function(result){ 
        if (result == 'successfully') {
          alert(result);
          location.reload();
        }else{
          alert(result);
        }
      }});
    }
  }else{
    alert('Please select file');
  }
});


});
