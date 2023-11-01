<?php
#echo implode(' - ', $tasks) . rand(0, 9999999);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= BASE_TITLE ?></title>
  <?php registerCssFile($cssFiles); ?>

</head>

<body>
  <!-- partial:index.partial.html -->
  <div class="page">
    <div class="pageHeader">
      <div class="title">Dashboard</div>
      <div class="userPanel"><i class="fa fa-chevron-down"></i><span class="username">John Doe </span>
        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/73.jpg" width="40" height="40" />
      </div>
    </div>
    <div class="main">
      <div class="nav">
        <div class="searchbox">
          <div><i class="fa fa-search"></i>
            <input type="search" placeholder="Search" />
          </div>
        </div>
        <div class="menu">
          <div class="title">Navigation</div>
          <ul id="folders">
            <?php foreach ($folders as $folder) : ?>
              <div>
                <div class="folderContainer">
                  <li class="">
                    <i class="fa fa-folder"></i><span id="<?= $folder->id ?>"><?= $folder->name; ?></span>
                  </li>
                  <div class="folderAction">
                    <button id="<?= $folder->id ?>" class="editFolderButton"><i class="fa fa-edit"></i></button>
                    <a href="?id=<?= $folder->id ?>"><i class="fa fa-trash"></i></a>
                  </div>
                </div>
              <?php endforeach; ?>

              <li class="active"> <i class="fa fa-tasks"></i>Manage Tasks</li>
          </ul>

        </div>

        <div class="divider">
          <span class="newFolder">create new folder</span>
          <span class="newName">change folder name</span>
          <hr>
        </div>

        <div class="addFolder">
          <input type="text" placeholder="add new folder" id="addFolderName">
          <input type="submit" value="+" id="folderSub">
        </div>


        <div class="addFolder changeFolderName" id="changeFolderName">
          <input type="text" placeholder="add new folder" id="folderNewName">
          <input type="submit" value="ok" id="folderNewNameSub">
        </div>

      </div>
      <div class="view">
        <div class="viewHeader">
          <div class="title">Manage Tasks</div>
          <div class="functions">
            <div class="button active">Add New Task</div>
            <div class="button">Completed</div>
            <div class="button inverz"><i class="fa fa-trash-o"></i></div>
          </div>
        </div>
        <div class="content">
          <div class="list">
            <div class="title">Today</div>
            <ul>
              <li class="checked"><i class="fa fa-check-square-o"></i><span>Update team page</span>
                <div class="info">
                  <div class="button green">In progress</div><span>Complete by 25/04/2014</span>
                </div>
              </li>
              <li><i class="fa fa-square-o"></i><span>Design a new logo</span>
                <div class="info">
                  <div class="button">Pending</div><span>Complete by 10/04/2014</span>
                </div>
              </li>
              <li><i class="fa fa-square-o"></i><span>Find a front end developer</span>
                <div class="info"></div>
              </li>
            </ul>
          </div>
          <div class="list">
            <div class="title">Tomorrow</div>
            <ul>
              <li><i class="fa fa-square-o"></i><span>Find front end developer</span>
                <div class="info"></div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="assets/js/script.js"></script>
  <script>
    $(document).ready(function() {
      let form = $(".addFolder");
      $("#folderSub").click(function() {
        var folderName = $("#addFolderName").val();
        if (folderName.length > 2) {
          $.ajax({
            method: "POST",
            url: "process/ajaxHandler.php",
            data: {
              action: "addFolder",
              folderName: folderName
            },
            success: function(response) {
              alert(response);
              if (response == "1") {
                $('<li> <a href="#"><i class="fa fa-folder"></i>' + folderName + '</a></li>').appendTo("ul#folders");
                location.reload()
              }
            }
          });
        } else
          alert("enter the value for folder name");
      })
    })
  </script>
  <script>
    $(".editFolderButton").click(function() {
      $(".addFolder").css("display", "none");
      $("#changeFolderName").css("display", "block");
      $(".newFolder").css("display", "none");
      $(".newName").css("display", "block");
      let id = $(this).attr("id");
      let folderCurrentName = $("#" + id).text();
      $("#folderNewName").val(folderCurrentName);
      $("#folderNewNameSub").click(function() {
        let folderNewName = $("#folderNewName").val();
        if (folderNewName.length < 2) {
          alert("please set value for folder name");
        }
        $.ajax({
          method: "POST",
          url: "process/ajaxHandler.php",
          data: {
            action: "changeFolderName",
            folderID: id,
            folderNewName: folderNewName
          },
          success: function(response) {
            alert(response);
          }
        })
      })

    })
  </script>

</body>

</html>