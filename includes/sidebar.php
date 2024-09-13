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
        <div class="col-lg-12">
          <ul class="list-unstyled mb-0">
            <?php
            $query = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory");
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <li>
                <a href="category.php?catid=<?php echo htmlentities($row['id']) ?>" class="category-link"><?php echo htmlentities($row['CategoryName']); ?></a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Side Widget -->
  <div class="card my-4 shadow-sm">
    <h5 class="card-header">Recently Uploaded</h5>
    <div class="card-body">
      <ul class="recent-uploads mb-0">
        <?php
        $query = mysqli_query($con, "SELECT tblposts.id as pid, tblposts.PostTitle as posttitle FROM tblposts ORDER BY tblposts.PostingDate DESC LIMIT 8");
        while ($row = mysqli_fetch_array($query)) {
        ?>
          <li>
            <a href="post-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="post-link"><?php echo htmlentities($row['posttitle']); ?></a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>