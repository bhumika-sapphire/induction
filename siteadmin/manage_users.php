<?php
include_once '../includes/startup.php';
require_once('authenticate.php');
$page = 'manage_users';
$user_setting = true;
$datatable = true;
include_once '_header.php';
?>
<style>
  .btn-info {
    min-width: 120px;
  }
</style>
<div id="page-wrapper">
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"> Manage Users</h1>
        <ol class="breadcrumb col-lg-10">
          <li> <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a> </li>
          <li class="active"> <i class="fa fa-table"></i> Manage Users</li>

        </ol>
        <a class="col-lg-2 breadcrumb" href="add_user.php">Add User</a>
      </div>
    </div>
    <!-- /.row -->
    <p style="color:#F00"><?php echo getMsg('error'); ?></p>
    <div class="row">
      <div class="col-lg-12">
        <!--<h2>List of Categories</h2>-->
        <div class="table-responsive">
          <table id="example2" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>User Details</th>
                <th>Policies Agreement</th>
                <th>Account Create Date</th>
                <th class="text-center">Is Active</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Sr. No.</th>
                <th>User Details</th>
                <th>Policies Agreement</th>
                <th>Account Create Date</th>
                <th class="text-center">Is Active</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>
              </tr>
            </tfoot>
            <tbody>


              <?php
              $sql = "SELECT * FROM user_master ORDER BY reg_date DESC";
              $exec = $conn->Execute($sql);
              $ctr = 0;
              while ($result = $exec->FetchRow()) {
                $ctr++;
              ?>
                <tr>


                  <td class="text-center"><?php echo $ctr; ?></td>
                  <td>
                    <strong>User login:</strong> <?php echo $result["user_login"]; ?><br>
                    <strong>First Name:</strong> <?php echo $result["first_name"]; ?><br>
                    <strong>Last Name:</strong> <?php echo $result["last_name"]; ?><br>
                    <strong>Phone:</strong> <?php echo $result["user_phone"]; ?><br>
                  </td>

                  <td>
                    <ul>
                      <li>IT Policy: <?php if ($result["it_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                      else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                      <li>Leave Policy: <?php if ($result["leave_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                        else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                      <li>List of Holidays: <?php if ($result["list_of_holidays_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                            else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                      <li>Travel Policy: <?php if ($result["travel_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                          else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                      <li>Increment Policy: <?php if ($result["increment_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                            else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                      <li>Productivity Rules & Regulations: <?php if ($result["productivity_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                                            else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                      <li>Office Rules: <?php if ($result["office_rules_policy"]) echo "<span class='glyphicon glyphicon-ok'></span>";
                                        else echo "<span class='glyphicon glyphicon-remove'></span>"; ?></li>
                    </ul>
                  </td>
                  <td><?php echo date("d F Y", strtotime($result["reg_date"])); ?></td>
                  <td class="text-center"><?php if ($result["is_active"]) echo "<span class='glyphicon glyphicon-ok is_activeUser'></span>";
                                          else echo "<span class='glyphicon glyphicon-remove not_activeUser'></span>"; ?></td>
                  <td class="text-center">
                    <a target="_blank" href="view_profile.php?user_id=<?php echo $result["user_id"]; ?>"><button class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Profile</button></a><br><br>
                    <a href="view_docs.php?user_id=<?php echo $result["user_id"]; ?>"><button class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Documents</button></a><br><br>
                    <a href="user_perfomance.php?user_id=<?php echo $result["user_id"]; ?>"><button class="btn btn-info"><span class="fa fa-percent" aria-hidden="true"></span>&nbsp;Performance</button></a>
                  </td>
                  <td class="text-center">
                    <a href="edit_user.php?user_id=<?php echo $result["user_id"]; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a><br><br>
                    <a onclick="return confirm('Are you sure you want to delete this user?')" href="delete_user.php?user_id=<?php echo $result["user_id"]; ?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
  <br />
</div>
<?php include '_footer.php'; ?>






<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<script>
  $(function() {
    $("#example2").DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      dom: 'Bfrtip',
      buttons: [{
          extend: 'csv',
          text: 'Export CSV',
          exportOptions: {
            columns: [1, 3, 4],
            format: {
              body: function(data, row, column, node) {
                if (column === 0) {
                  // Extract just the user login name from the cell
                  const match = data.match(/User login:<\/strong>\s*([^<]+)/i);
                  return match ? match[1].trim() : '';
                } else if (column === 2) {
                  // Extract Yes/No from glyphicon span in "Is Active"
                  if (data.includes('is_activeUser')) {
                    return 'Yes';
                  } else if (data.includes('not_activeUser')) {
                    return 'No';
                  } else {
                    return '';
                  }
                } else {
                  // For reg_date and other columns
                  return $('<div>').html(data).text().trim();
                }
              }
            }


          }
        },
        {
          extend: 'excel',
          text: 'Export Excel',
          exportOptions: {
            columns: [1, 3, 4],
            format: {
              body: function(data, row, column, node) {
                if (column === 0) {
                  // Extract just the user login name from the cell
                  const match = data.match(/User login:<\/strong>\s*([^<]+)/i);
                  return match ? match[1].trim() : '';
                } else if (column === 2) {
                  // Extract Yes/No from glyphicon span in "Is Active"
                  if (data.includes('is_activeUser')) {
                    return 'Yes';
                  } else if (data.includes('not_activeUser')) {
                    return 'No';
                  } else {
                    return '';
                  }
                } else {
                  // For reg_date and other columns
                  return $('<div>').html(data).text().trim();
                }
              }
            }


          }
        },
        {
          extend: 'pdf',
          text: 'Export PDF',
          exportOptions: {
            columns: [1, 3, 4],
            format: {
              body: function(data, row, column, node) {
                if (column === 0) {
                  // Extract just the user login name from the cell
                  const match = data.match(/User login:<\/strong>\s*([^<]+)/i);
                  return match ? match[1].trim() : '';
                } else if (column === 2) {
                  // Extract Yes/No from glyphicon span in "Is Active"
                  if (data.includes('is_activeUser')) {
                    return 'Yes';
                  } else if (data.includes('not_activeUser')) {
                    return 'No';
                  } else {
                    return '';
                  }
                } else {
                  // For reg_date and other columns
                  return $('<div>').html(data).text().trim();
                }
              }
            }


          }
        },
        {
          extend: 'print',
          text: 'Print',
          exportOptions: {
            columns: [1, 3, 4],
            format: {
              body: function(data, row, column, node) {
                if (column === 0) {
                  // Extract just the user login name from the cell
                  const match = data.match(/User login:<\/strong>\s*([^<]+)/i);
                  return match ? match[1].trim() : '';
                } else if (column === 2) {
                  // Extract Yes/No from glyphicon span in "Is Active"
                  if (data.includes('is_activeUser')) {
                    return 'Yes';
                  } else if (data.includes('not_activeUser')) {
                    return 'No';
                  } else {
                    return '';
                  }
                } else {
                  // For reg_date and other columns
                  return $('<div>').html(data).text().trim();
                }
              }
            }


          }
        } ,
         {
            text: 'Export All User Profiles',
            className: 'btn btn-success',
            action: function () {
                window.location.href = 'export_all_users.php';
            }
        }
      ]
    });
  });
</script>