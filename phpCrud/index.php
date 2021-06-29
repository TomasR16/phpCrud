<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>PHP CRUD</title>
  <link rel="stylesheet" type="text/css" href="style\opmaak.css">
</head>

<body>
  <?php require_once 'procces.php'; ?>

  <?php
  if (isset($_SESSION['message'])) : ?>

    <div class="<?= $_SESSION['msg_type'] ?>">

      <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']);
      ?>

    </div>
  <?php endif ?>

  <?php
  $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(msqli_error($mysqli));
  $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
  //pre_r($result);
  // pre_r($result->fetch_assoc());
  // pre_r($result->fetch_assoc());
  ?>
  <br><br>
  <!-- alles uitprinten in de table -->
  <div class="old_ie_wrapper">
    <table class="fixed_headers">
      <thead>
        <tr>
          <th>Name</th>
          <th>Lastname</th>
          <th>Datum</th>
          <th>Action</th>
          <th>Leeftijd</th>
          <th>Leeftijd volgend jaar</th>
        </tr>
      </thead>
      <?php
      while ($row = $result->fetch_assoc()) : ?>
        <tr>
          <td><?php echo $row['voornaam']; ?></td>
          <td><?php echo $row['achternaam']; ?></td>
          <td><?php echo $row['geboortedatum']; ?></td>

          <td>
            <a href="index.php?edit=<?php echo $row['id']; ?>">edit</a>
            <a href="procces.php?delete=<?php echo $row['id']; ?>">delete</a>
          </td>

          <!-- uitrekenen van leeftijd en leeftijd volgend jaar -->
          <?php
          $geboorte = $row['geboortedatum'];
          $today = date('Y-m-d');
          $diff = date_diff(date_create($geboorte), date_create($today));
          $leeftijd = $diff->format('%y');
          echo "<td>$leeftijd</td>";
          $leeftijd++;
          echo "<td>$leeftijd</td>";
          ?>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <?php
  function pre_r($array)
  {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }
  ?>
  <br>
  <br>
  <!-- het form waar alles word ingevuld  -->
  <div class="">
    <h2 id="Header">CRUD:</h2>
    <p id="text">Create Read Update Delete. </p>
    <br>
    <form action="procces.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <label>Voornaam</label>
      <input type="text" name="name" placeholder="Voornaam" value="<?php echo $name; ?>">
      <br>
      <br>
      <label>Achternaam</label>
      <input type="text" name="lastname" placeholder="Achternaam" value="<?php echo $achternaam; ?>">
      <br>
      <br>
      <label>Geboorte-Datum</label>
      <input type="date" name="datum" value="<?php echo $datum; ?>">
      <br>
      <br>
      <?php
      if ($update == true) :
      ?>
        <button type="submit" name="update">Update</button>
      <?php else : ?>
        <button type="submit" name="save">Save</button>
      <?php endif; ?>
    </form>
  </div>
</body>

</html>