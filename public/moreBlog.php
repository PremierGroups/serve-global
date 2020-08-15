<?php
include_once '../models/Blog.php';
if (isset($_GET['offset'])) {
    $offset = strip_tags($_GET['offset']);
    if (filter_var($offset, FILTER_VALIDATE_INT)) {?>
     
                    <?php
                    $blogObj = new Blog();
                    $blogs = $blogObj->getBlogsByLimit(6, $offset);
                    $totalBlogs = $blogObj->getTotalBlogs();
                    if (mysqli_num_rows($blogs) > 0) {
                        while ($blogRow = mysqli_fetch_array($blogs)) {
                            $date = $blogRow['dateCreated'];
                            $dateValue = strtotime($date); ?>
                            <div class="col-md-6 col-lg-4">
                            <div class="blog-entry" style=" height: 100%;width: 100%;">
                                <div class="block-20 d-flex align-items-end" style="background-image: url('<?php echo '../images/blog/'.$blogRow['coverImage']?>');">
                                <div class="meta-date text-center p-2">
                                    <span class="day"><?php echo date("d", $dateValue)?></span>
                                    <span class="mos"><?php echo date("F", $dateValue)?></span>
                                    <span class="yr"><?php echo date("y", $dateValue)?></span>
                                </div>
                                </div>
                                <div class="text bg-white p-4">
                                <h3 class="heading"><a href="#"><?php echo $blogRow['title']?></a></h3>
                                <p> <?php 
                                        $description = strip_tags( $blogRow['description']);
                                        if (strlen($description) > 3) {
                                            $descData = substr($description, 0, 3) . "..".'</p>'.'<div class="d-flex align-items-center mt-4"><p class="mb-0"><a href="#" class="btn btn-primary viewBlog" blogId="'.$blogRow['id'].'" blog-title="'.$blogRow['title'].'" blog-desc="'.$blogRow['description'].'">Read More <span class="ion-ios-arrow-round-forward"></span></a></p></div>';
                                            echo $descData; 
                                            
                                        } else {
                                            $descData = $description;
                                            echo $blogRow['description'].'</p>'; 
                                        }

                                        
                                    ?>
                                
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