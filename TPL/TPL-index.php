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
      <div class="userPanel">
        <a href="<?= siteURL('?logout=1') ?>">

          <i class="fa fa-sign-out"></i></a>

        <span class="username"><?= $user->name ?? 'unknown'; ?></span>
        <img src="<?= $user->image ?>" width="40" height="40" />
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
          <div class="title">Folders</div>
          <ul id="folders">
            <li class="<?= isset($_GET["folderID"]) && $_GET["folderID"] == 0 ? 'active' : ''; ?>"> <i class="fa fa-tasks"></i><a href="?folderID=0" id="0">All Tasks</a></li>
            <?php foreach ($folders as $folder) : ?>
              <div>
                <div class="folderContainer">
                  <li class="<?= (isset($_GET["folderID"]) && $_GET["folderID"] == $folder->id) ? 'active' : ''; ?>">
                    <i class="fa fa-folder"></i><a href="?folderID=<?= $folder->id ?>" id="<?= $folder->id ?>"><?= $folder->name; ?></a>
                  </li>
                  <div class="folderAction">
                    <button id="<?= $folder->id ?>" class="editFolderButton"><i class="fa fa-edit"></i></button>
                    <button id="<?= $folder->id ?>" class="deleteFolderButton"><i class="fa fa-trash"></i></button>

                  </div>
                </div>
              <?php endforeach; ?>
              <?php
              if (isset($_GET['folderID']) && !empty($_GET['folderID'])) {
                $folderID = $_GET['folderID'];
                if (!validFolderURl($folderID)) {
                  echo '<script>alert("URL Invalid");</script>';
                  exit;
                }
              }

              ?>

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
          <?php if (isset($_GET['folderID'])) :; ?>
            <div class="addTask title">
              <input type="text" placeholder="add new task" id="addTaskTitle">
              <input type="submit" value="+" id="AddTaskBtn">
            </div>
          <?php endif; ?>
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
              <?php
              if (sizeof($tasks) > 0) :
                foreach ($tasks as $task) :
              ?>
                  <li data-taskID="<?= $task->id; ?>" id="" class="task clickable <?= $task->is_done ? 'checked' : ''; ?>">
                    <i class="fa <?= $task->is_done ? 'fa-check-square-o' : 'fa-square-o'; ?> "></i>

                    <span><?= $task->title; ?></span>
                    <div class="info">
                      <span>created At : <?= $task->created_at; ?></span>
                      <button class="button"><a href="?deleteTask=<?= $task->id; ?>" onclick="return confirm('are u sure to delete this item?\n <?= $task->title; ?>')">delete</a></button>
                    </div>
                  </li>
                <?php endforeach;
              else :
                ?>
                <li>no task here ...</li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="list">
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="assets/js/script.js"></script>

  <!-- select and show folders -->
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
              if (response !== null) {
                let responseSplit = response.split("-");
                let folderHTML = `
                  <div class="folderContainer">
                    <li>
                      <i class="fa fa-folder"></i>
                      <a href="?folderID=${responseSplit[0]}" id="${responseSplit[0]}">${responseSplit[1]}</a>
                    </li>
                    <div class="folderAction">
                      <button id="${responseSplit[0]}" class="editFolderButton"><i class="fa fa-edit"></i></button>
                       <button id="${responseSplit[0]}" class="deleteFolderButton"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                `;
                $(folderHTML).appendTo("ul#folders");
                alert(responseSplit[1] + " folder added");
              }
            }

          });
        } else
          alert("enter the value for folder name");
      })
    })
  </script>
  <!-- update folder name -->
  <script>
    $(".editFolderButton").click(function() {
      $(".addFolder").css("display", "none");
      $("#changeFolderName").css("display", "block");
      $(".newFolder").css("display", "none");
      $(".newName").css("display", "block");
      let id = $(this).attr("id");
      let currentFolderName = $("#" + id).text();
      $("#folderNewName").val(currentFolderName);
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
            if (response == 1)
              location.reload();
          }
        })
      })

    })
  </script>
  <script>
    // delete folder
    $(".deleteFolderButton").click(function() {
      let id = $(this).attr("id");
      let deleteConfirm = confirm("really do u want delete this item ?");
      if (deleteConfirm == true) {
        $.ajax({
          method: "POST",
          url: "process/ajaxHandler.php",
          data: {
            action: "deleteFolder",
            folderID: id,
          },
          success: function(response) {
            if (response == 1) {
              location.reload();

            }
          }
        })
      }

    })
  </script>
  <!-- for tasks -->
  <script>
    // add task
    $("#AddTaskBtn").click(function() {
      $.ajax({
        method: "POST",
        url: "process/ajaxHandler.php",
        data: {
          action: "addTask",
          folderID: <?= $_GET['folderID'] ?>,
          taskTitle: $("#addTaskTitle").val()
        },
        success: function(response) {
          if (response == 1) {
            location.reload();
          }
        }
      })
    })
  </script>
  <script>
    // change task status
    $(".task").click(function() {
      let tID = $(this).attr("data-taskid");
      $.ajax({
        method: "POST",
        url: "process/ajaxHandler.php",
        data: {
          action: "switchDone",
          taskID: tID
        },
        success: function(response) {
          location.reload()
        }
      })
    })
  </script>
</body>

</html>