<table class="table table-bordered table-hover">
<?php

require_once '../authentication/admin-class.php';
include_once __DIR__.'/../../../database/dbconfig2.php';

$user = new ADMIN();
if(!$user->isUserLoggedIn())
{
 $user->redirect('../../../private/admin/');
}



function get_total_row($pdoConnect)
{
  $pdoQuery = "SELECT COUNT(*) as total_rows FROM seller WHERE status = :status";
  $pdoResult = $pdoConnect->prepare($pdoQuery);
  $pdoResult->execute(array(":status" => "not_verify"));
  $row = $pdoResult->fetch(PDO::FETCH_ASSOC);
  return $row['total_rows'];
}

$total_record = get_total_row($pdoConnect);
$limit = '20';
$page = 1;
if(isset($_POST['page']))
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$query = "
SELECT * FROM seller WHERE status = :status 
";
$output = '';
if($_POST['query'] != '')
{
  $query .= '
  AND shop_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  OR email LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  OR phone_number LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  ';
}

$query .= 'ORDER BY id ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $pdoConnect->prepare($query);
$statement->execute(array(":status" => "not_verify"));
$total_data = $statement->rowCount();

$statement = $pdoConnect->prepare($filter_query);
$statement->execute(array(":status" => "not_verify"));
$total_filter_data = $statement->rowCount();

if($total_data > 0)
{
$output = '
    <div class="row-count">
      Showing ' . ($start + 1) . ' to ' . min($start + $limit, $total_data) . ' of ' . $total_record . ' entries
    </div>
    <thead>
    <th>SELLER NAME</th>
    <th>SHOP NAME</th>
    <th>SHOP ADDRESS</th>
    <th>PHONE NUMBER</th>
    <th>EMAIL</th>
    <th>ACTIONS</th>
    </thead>
';
  while($row=$statement->fetch(PDO::FETCH_ASSOC))
  {

    $user = $row['user_id'];
    $pdoQuery = "SELECT * FROM users WHERE id = :id";
    $pdoResult = $pdoConnect->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute(array(":id" => $user));
    $user_data = $pdoResult->fetch(PDO::FETCH_ASSOC);


    $output .= '
    <tr>
      <td>'.$user_data["last_name"].', '.$user_data["first_name"].' '.$user_data["middle_name"].'</td>
      <td>'.$row["shop_name"].'</td>
      <td>'.$row['street'] . ' ' . $row['barangay'] . ', ' . $row['municipality'] . ', ' . $row['province'] . ', ' . $row['region'] . ', ' . $row['postal_code'].'</td>
      <td>+63'.$row["phone_number"].'</td>
      <td>'.$row["email"].'</td>
      <td>
      <button type="button" class="btn btn-primary V"><a href="verify-account?id='.$row["id"].'" class="view"><i class="bx bx-low-vision" ></i></a></button>
      </td>        
    </tr>
    ';
  }
}
else
{
  echo '<h1>No Data Found</h1>';
}

$output .= '
</table>
<div align="center">
  <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 5)
{
  if($page < 5)
  {
    for($count = 1; $count <= 5; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 5;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
  }
}
else
{
  $page_array[] = '...';
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}

for($count = 0; $count < count($page_array); $count++)
{
  if($page == $page_array[$count])
  {
    $page_link .= '
    <li class="page-item active">
      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
    </li>
    ';

    $previous_id = $page_array[$count] - 1;
    if($previous_id > 0)
    {
      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
    }
    else
    {
      $previous_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Previous</a>
      </li>
      ';
    }
    $next_id = $page_array[$count] + 1;
    if($next_id > $total_links)
    {
      $next_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Next</a>
      </li>
        ';
    }
    else
    {
      $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
    }
  }
  else
  {
    if($page_array[$count] == '...')
    {
      $page_link .= '
      <li class="page-item disabled">
          <a class="page-link" href="#">...</a>
      </li>
      ';
    }
    else
    {
      $page_link .= '
      <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
      ';
    }
  }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>

</div>
';

echo $output;

?>

<script src="../../src/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script src="../../src/js/form.js"></script>

</table>