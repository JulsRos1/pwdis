<div class="col-md-4">
  <!-- Search Widget -->
  <div class="card mb-4 shadow-sm">
    <h5 class="card-header">Search</h5>
    <div class="card-body">
      <form name="search" action="search.php" method="post">
        <div class="input-group">
          <input type="text" name="searchtitle" class="form-control" placeholder="Search for..." required>
          <div class="input-group-append">
            <button class="btn btn-secondary" type="submit">Go!</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Categories Widget -->
  <div class="card my-4 shadow-sm">
    <h5 class="card-header">Filter by Categories</h5>
    <div class="card-body">
      <div class="row">
        <?php
        $query = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory");
        $count = 0; // Counter for creating columns
        while ($row = mysqli_fetch_array($query)) {
          if ($count % 2 == 0) {
            // Start a new column for every two buttons
            echo '<div class="col-6 mb-2">';
          }
        ?>
          <a href="category.php?catid=<?php echo htmlentities($row['id']) ?>" class="btn btn-primary w-100 mb-2 categorybtn"><?php echo htmlentities($row['CategoryName']); ?></a>
        <?php
          $count++;
          if ($count % 2 == 0) {
            // Close the column after two buttons
            echo '</div>';
          }
        }
        // Close the last column if there's an odd number of buttons
        if ($count % 2 != 0) {
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>

</div>