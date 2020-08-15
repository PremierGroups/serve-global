<?php
include_once '../models/Project.php';
if (isset($_GET['offset'])) {
    $offset = strip_tags($_GET['offset']);
    if (filter_var($offset, FILTER_VALIDATE_INT)) {?>
     
                    <?php
                    $projectObj = new Project();
                    $projects = $projectObj->getProjectsByLimit(6, $offset);
                    $totalProjects = $projectObj->getTotalProject();
                    if (mysqli_num_rows($projects) > 0) {
                        while ($projectRow = mysqli_fetch_array($projects)) {?>
                                <div class="col-md-4">
                                <div class="project mb-4 img  d-flex justify-content-center align-items-center" style="background-image: url(../images/project/<?php echo $projectRow['coverImage']?>);">
                                    <div class="overlay"></div>
                                    <a href="#" projectId="<?php echo $projectRow['id']; ?>" project-title="<?php echo $projectRow['title']; ?>" project-desc="<?php echo $projectRow['description']; ?>" class="btn-site d-flex align-items-center justify-content-center viewProject"><span class="icon-subdirectory_arrow_right"></span></a>
                                    <div class="text text-center p-4">
                                        <h3><?php echo $projectRow['title'] ?></h3>
                                        <span><?php echo $projectRow['service'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
               
<?php
    }
    }   